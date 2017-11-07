<?php
namespace app\service;
use app\model\Camp;
use app\common\validate\CampVal;
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
            return $result;
        }else{
            return $res;
        }
    }

    public function getCampListByPage( $map=[],$paginate=10, $order=''){
        $res = $this->Camp->where($map)->order($order)->paginate($paginate);
        
        if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return $res;
        }
        
    }


    public function getCampMemberListByPage($map=[],$paginate=10, $order=''){
         $res = $this->CampMember->with('student')->where($map)->order($order)->paginate($paginate);
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
    public function getCampInfo($id) {
        $res = $this->Camp->get($id);
        if (!$res) {
            return false;
        }
        $result = $res->toArray();
        $result['status_num'] = $res->getData('status');
        return $result;
    }

    public function getOneCamp($map) {
        $res = Camp::get($map);
        if (!$res) {
            return false;
        }
        $result = $res->toArray(); 
        $result['status_num'] = $res->getData('status');
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
     * 返回权限
     */
    public function isPower($camp_id,$member_id){
        $is_power = db('camp_member')
                    ->where(['member_id'=>$member_id,'camp_id'=>$camp_id,'status'=>1])
                    // ->where(function ($query) {
                            // $query->where('type', 2)->whereor('type', 3)->whereor('type',4);})
                    ->value('type');
        return $is_power?$is_power:0;
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
}