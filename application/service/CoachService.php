<?php
namespace app\service;
use app\model\Camp;
use app\common\validate\CampVal;
use think\Db;
class CampService {

    public $Camp;
    public function __construct()
    {
        $this->Camp = new Camp();
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

    public function campListPage( $map=[],$page = 1,$paginate=10, $order=''){
        $res = $this->Camp->where($map)->order($order)->page($page,$paginate)->select();
        
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
        $res = Camp::get($id);
        if (!$res) {
            return false;
        }
        return $res->toArray();
    }

    /**
     * 更新资源
     */
    public function UpdateCamp($data,$id) {
        $validate = validate('CampVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        $res = $this->Camp->update($data,$id);
        if($res === false){
            return ['msg'=>$this->Camp->getError(),'code'=>'200'];
        }else{
            return ['data'=>$res,'msg'=>__lang('MSG_100_SUCCESS'),'code'=>'100'];
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
       /* $is_create = $this->isCreateCamp($request['member_id']);
        if($is_create){
            return ['msg'=>'一个用户只能创建一个训练营','code'=>'200'];die;
        }
        $validate = validate('CampVal');
        if(!$validate->check($request)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        $res = $this->Camp->save($request);
        if($res === false){
            return ['msg'=>$this->Camp->getError(),'code'=>'200'];
        }else{
            $data = ['camp' =>$request['camp'],'camp_id'=>$res,'type'=>3,'realname'=>$request['realname'],'member_id'=>$request['member_id']];
            $result = Db::name('camp_member')->insert($data);
            if(!$result){
                Camp::destroy($res);
                return ['msg'=>Db::name('camp_member')->getError(),'code'=>'200'];
            }
            return ['data'=>$res,'msg'=>__lang('MSG_100_SUCCESS'),'code'=>'100'];
        }*/
        //dump($request);
        $hasCreateCamp = $this->hasCreateCamp($request['member_id']);
        if ($hasCreateCamp) {
            return ['code' => 200, 'msg' => '一个会员只能创建一个训练营'];
        }
        $model = new Camp();
        $result = $model->validate('CampVal.add')->save($request);
        if (false === $result) {
            return ['code' => 200, 'msg' => $model->getError()];
        }
        $campId = $model->getLastInsID();
        $campMemberData = [
            'camp_id' => $campId,
            'camp' => $request['camp'],
            'member_id' => $request['member_id'],
            'member' => $request['realname'],
            'type' => 4,
            'status' => 0,
            'create_time' => time(),
            'update_time' => time()
        ];
        $campmemberDb = Db::name('camp_member');
        $campMemberAdd = $campmemberDb->insert($campMemberData);
        if (!$campMemberAdd) {
            Camp::destroy($campId);
            return ['code' => 200, 'msg' => $campmemberDb->getError()];
        }

        return ['code' => 100, 'msg' => __lang('MSG_200'), 'data' => $campId];
    }

    /**
     * 判断是否已拥有训练营
     */

    public function hasCreateCamp($memberid){
       if ( Camp::get(['member_id' => $memberid]) ) {
           return true;
       } else {
           return false;
       }
    }


    /**
     * 返回权限
     */
    public function isPower($camp_id,$member_id){
        $is_power = db('camp_member')
                    ->where(['member_id'=>$member_id,'camp_id'=>$camp_id])
                    // ->where(function ($query) {
                            // $query->where('type', 2)->whereor('type', 3)->whereor('type',4);})
                    ->value('type');
                    // echo db('camp_member')->getlastsql();die;
        return $is_power?$is_power:0;
    }
}