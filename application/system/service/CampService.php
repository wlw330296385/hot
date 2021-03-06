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
        $res = $this->Camp->get($id);

        if (!$res) return false;
        
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
        $is_create = $this->isCreateCamp($request['member_id']);
        if($is_create){
            return ['msg'=>'一个用户只能创建一个训练营','code'=>'200'];die;
        }
        $validate = validate('CampVal');
        if(!$validate->check($$request)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        $res = $this->Camp->save($request);
        if($res === false){
            return ['msg'=>$this->Camp->getError(),'code'=>'200'];
        }else{
            $data = ['camp' =>$request['camp'],'camp_id'=>$res,'type'=>3,'realname'=>$request['realname'],'member_id'=>$request['member_id']];
            $result = Db::name('grade_member')->insert($data);
            if(!$result){
                Camp::destroy($res);
                return ['msg'=>Db::name('grade_member')->getError(),'code'=>'200'];
            }
            return ['data'=>$res,'msg'=>__lang('MSG_100_SUCCESS'),'code'=>'100'];
        }
    }

    /**
     * 判断是否已拥有训练营
     */

    public function isCreateCamp($member_id){
        $is_create = $this->Camp->where(['member_id'=>$member_id,'status'=>['NEQ',1]])->find();
        if($is_create){
            return $is_create['id'];
        }else{
            return false;
        }
    }


    /**
     * 是否有2,3,4权限管理训练营
     */
    public function isPower234($camp_id,$member_id){
        $is_power = db('grade_member')
                    ->where(['member_id'=>$member_id,'camp_id'=>$camp_id,'status'=>1])
                    ->where(function ($query) {
                            $query->where('type', 2)->whereor('type', 3)->whereor('type',4);})
                    ->select();
        return $is_power?$is_power:0;
    }
}