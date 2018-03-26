<?php
namespace app\service;
use app\model\Camp;
use app\common\validate\CampVal;
use app\model\CampCancell;
use think\Db;
use app\common\validate\CampCommentVal;
use app\model\CampMember;
class CampService {

    public $Camp;
    public $CampMember;
    public function __construct()
    {
        $this->CampMember = new CampMember;
        $this->Camp = new Camp;
    }

    public function getCampList($map=[],$page = 1,$paginate = 10,$order='') {
        $res = $this->Camp->where($map)->order($order)->page($page,$paginate)->select();
        if($res){
            $result = $res->toArray();
            foreach ($result as $k => $val) {
                if ($val['star'] > 0) {
                    $result[$k]['star'] = ceil($val['star']/$val['star_num']);   
                }
                $result[$k]['fans_num'] = getfansnum($val['id'], 2);
            }
            return $result;
        }else{
            return $res;
        }
    }

    public function getCampListByPage( $map=[],$paginate=10, $order=''){
        $res = $this->Camp->where($map)->order($order)->paginate($paginate)->each(function($item,$key){
            if ($item['star'] > 0) {
                $item['star'] = ceil($item['star']/$item['star_num']);
            }
            //$item['fans_num'] = getfansnum($item['id'], 2);
            return $item;
        });
        
        if($res){
            $result = $res->toArray();
            foreach ($result['data'] as $k => $val) {
                $result['data'][$k]['fans_num'] = getfansnum($val['id'], 2);
            }
            return $result;
        }else{
            return $res;
        }
        
    }


    public function getCampMemberListByPage($map=[],$paginate=10, $order=''){
         $res = $this->CampMember->where($map)->order($order)->paginate($paginate);
        if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return $res;
        }
    }


    /**
     * 读取资源
     */
    public function getCampInfo($map) {
        $res = $this->Camp->find($map);
        if (!$res) {
            return false;
        }
        $result = $res->toArray();
        $result['status_num'] = $res->getData('status');
        $result['fans_num'] = getfansnum($result['id'], 2);
        return $result;
    }

    public function getOneCamp($map) {
        $res = Camp::get($map);
        if (!$res) {
            return false;
        }
        $result = $res->toArray(); 
        $result['status_num'] = $res->getData('status');
        $result['fans_num'] = getfansnum($result['id'], 2);
        return $result;
    }

    /**
     * 更新资源
     */
    public function updateCamp($request) {
        $model = new Camp();
        $result = $model->validate('CampVal.edit')->isUpdate(true)->save($request);
        if (false === $result) {
            return ['code' => 100, 'msg' => $model->getError()];
        } else {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $request['id']];
        }

    }

    public function SoftDeleteCamp($id) {
        $res = $this->Camp->destroy($id);
        return $res;
    }

    /**
     * 创建资源
     */
    public function createCamp($request){
        // 一个人只能创建一个训练营
        if ( $this->hasCreateCamp($request['member_id']) ){
            return [ 'msg' => '一个会员只能创建一个训练营', 'code' => 100 ];
        }
        $model = new Camp;
        $result = $model->validate('CampVal.add')->save($request);
        if ( false === $result ) {
            return ['code' => 100, 'msg' => $model->getError()];
        }
        // 保存camp_member 关联记录
        //dump($model->getLastInsID());
        $lastInsId = $model->getLastInsID();
        $campMemberDb = Db::name('camp_member');
        $campMemberData = [
            'camp' => $request['camp'],
            'camp_id' => $lastInsId,
            'member' => $request['realname'],
            'member_id' => $request['member_id'],
            'remarks' => '创建训练营',
            'type' => 4,
            'status' => 1,
            'create_time' => time(),
            'update_time' => time()
        ];
        $addCampMember = $campMemberDb->insert($campMemberData);
        if (!$addCampMember) {
            Camp::destroy($lastInsId);
            return ['msg' => __lang('MSG_403'), 'code' => 100];
        }
        return [ 'code' => 200, 'msg' => __lang('MSG_200'), 'data' => $lastInsId ];
    }

    /**
     * 判断是否已创建训练营
     */

    public function hasCreateCamp($member_id){
        $res = Camp::get(['member_id' => $member_id]);
        if ($res) {
            return $res->toArray();
        } else {
            return false;
        }
    }

    /**
     * 获取会员在训练营角色
     */
    public function isPower($camp_id,$member_id){
        $is_power = db('camp_member')
                    ->where(['member_id'=>$member_id,'camp_id'=>$camp_id,'status'=>1])
                    ->whereNull('delete_time')
                    ->value('type');
        return $is_power?$is_power:0;
    }

    /** 获取会员在训练营角色权限等级
     * @param $camp_id
     * @param $member_id
     * @return int
     */
    public function getCampMemberLevel($camp_id, $member_id) {
        $level = db('camp_member')
            ->where(['member_id'=>$member_id,'camp_id'=>$camp_id,'status'=>1])
            ->whereNull('delete_time')
            ->value('level');
        return $level ? $level : 0;
    }

    // 获取训练营资质证明
    public function getCampCert($campid) {
        $certlist = db('cert')->where(['camp_id' => $campid])->select();
        $campCert = [
            'cert' => '',
            'fr' => ['cert_no' => '', 'photo_positive' => ''],
            'cjz' => ['cert_no' => '', 'photo_positive' => ''],
            'other' => ''
        ];
        if ($certlist) {
            foreach ($certlist as $val) {
                switch ( $val['cert_type'] ) {
                    case 1: {
                        if ($val['member_id']) {
                            $campCert['cjz']['cert_no'] = $val['cert_no'];
                            $campCert['cjz']['photo_positive'] = $val['photo_positive'];
                        } else {
                            $campCert['fr']['cert_no'] = $val['cert_no'];
                            $campCert['fr']['photo_positive'] = $val['photo_positive'];
                        }
                        break;
                    }
                    case 4: {
                        $campCert['cert'] = $val['photo_positive'];
                        break;
                    }
                    default: {
                        $campCert['other'] = $val['photo_positive'];
                    }
                }
            }
        }
        return $campCert;
    }

  

    // 获取训练营评论列表
    public function getCampCommentListByPage($map,$paginate = 10){
        $CampCommentModel = new \app\model\CampComment;
        $result = $CampCommentModel->where($map)->paginate($paginate);
        if($result){
            return $result->toArray();
        }else{
            return $result;
        }
    }

    // 评论训练营
    public function createCampComment($data){
        $CampCommentModel = new \app\model\CampComment;
        $validate = validate('CampCommentVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        $result = $CampCommentModel->save($data);
        if($result){
            return ['msg' => "评论成功", 'code' => 200];
        }else{
            return ['msg' =>"评论失败", 'code' => 100];
        }
    }


    public function getCampMemberInfo($map){
        $CampMemberModel = new CampMember;
        $isMember = $this->CampService->where($map)->find();
        return $isMember;
    }

    // 训练营审核状态 1:正常 0：未审核
    public function getCampcheck($camp_id) {
        $camp = Camp::get($camp_id);
        return $camp->getData('status');
    }

    // 2017-10-28 修改训练营状态
    public function updateCampStatus($camp_id, $status) {
        $model = new Camp();
        $res = $model->where('id', $camp_id)->setField('status', $status);
        return $res;
    }

    // 获取训练营下在营教练列表
    public function getCoachList($camp_id) {
        $map['camp_id'] = $camp_id;
        $map['camp_member.status'] = 1;
        $map['camp_member.type'] = ['in', '2,4'];
        $list = Db::view('camp_member')
            ->view('coach', '*', 'coach.member_id=camp_member.member_id')
            ->where($map)
            ->order('camp_member.id desc')
            ->select();
        return $list;
    }

    /** 保存训练营注销申请数据
     * @param $data 保存的数据
     * @param $where 更新数据条件
     * @return array
     */
    public function saveCampCancell($data=[], $where=[]) {
        $model = new CampCancell();
        // 带更新条件更新数据
        if (!empty($where)) {
            $res = $model->allowField(true)->isUpdate(true)->save($data, $where);
            if ($res || ($res===0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
        //显式更新数据
        if (isset($data['id'])) {
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res || ($res===0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
        // 插入数据
        $res = $model->allowField(true)->save($data);
        if ($res) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
        } else {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }

    }

    // 获取训练营注销申请数据
    public function getCampCancellByCampId($camp_id) {
        $model = new CampCancell();
        $res = $model->where(['camp_id' => $camp_id])->find();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        $result['status_text'] = $res->status_text;
        return $result;
    }
}