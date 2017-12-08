<?php
namespace app\service;
use app\model\Plan;
use app\common\validate\PlanVal;
use think\Db;
class PlanService {

    public $Plan;
    public function __construct()
    {
        $this->Plan = new Plan();
    }

    public function getPlanList($map=[],$page = 1,$paginate = 10, $order='') {
        $res = $this->Plan->where($map)->whereOr(['type'=>0])->order($order)->page($page,$paginate)->select();
         if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return $res;
        }
    }

    public function getPlanListByPage( $map=[], $order='',$paginate=10){
        $res = $this->Plan->where($map)->whereOr(['type'=>0])->order($order)->paginate($paginate);
        if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return $res;
        }
    }




    /**
     * 更新资源
     */
    public function updatePlan($data,$id) {
        $validate = validate('PlanVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        
        $res = $this->Plan->save($data,$id);
        if($res === false){
            return ['msg'=>$this->Plan->getError(),'code'=>100];
        }else{
            return ['data'=>$res,'msg'=>__lang('MSG_200'),'code'=>200];
        }
    }

    public function SoftDeletePlan($id) {
        $res = $this->Plan->destroy($id);
        return $res;
    }

    /**
     * 创建资源
     */
    public function createPlan($data){
        $validate = validate('PlanVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        // dump($data);die;
        $res = $this->Plan->save($data);
        if($res === false){
            return ['msg'=>$this->Plan->getError(),'code'=>100];
        }else{
            return ['data'=>$this->Plan->id,'msg'=>__lang('MSG_200'),'code'=>200];
        }
    }

    public function getPlanInfo($map){
        $result = $this->Plan->where($map)->find();
        if($result){
            $res = $result->toArray();
            return $res;
        }else{
            return $result;
        }
    }
}