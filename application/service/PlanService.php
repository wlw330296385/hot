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

    public function PlanListPage( $map=[],$page = 1,$paginate=10, $order=''){
        $res = $this->Plan->where($map)->whereOr(['type'=>0])->order($order)->page($page,$paginate)->select();
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
    public function PlanOneById($id) {
        $res = $this->Plan->get($id)->toArray();
        if (!$res) return false;
        
        return $res;
    }

    /**
     * 更新资源
     */
    public function updatePlan($data,$id) {
        $validate = validate('PlanVal');
        if($data['exercise_ids']){
            $arrSeri = explode(',', $data['exercise_ids']);
            $data['exercise_id'] = serialize($arrSeri);
        }

        if($data['exercises']){
            $arrSeri = explode(',', $data['exercises']);
            $data['exercise'] = serialize($arrSeri);
        }
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        
        $res = $this->Plan->save($data,$id);
        if($res === false){
            return ['msg'=>$this->Plan->getError(),'code'=>'200'];
        }else{
            return ['data'=>$res,'msg'=>__lang('MSG_100_SUCCESS'),'code'=>'100'];
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
        if($data['exercise_ids']){
            $arrSeri = explode(',', $data['exercise_ids']);
            $data['exercise_id'] = serialize($arrSeri);
        }

        if($data['exercises']){
            $arrSeri = explode(',', $data['exercises']);
            $data['exercise'] = serialize($arrSeri);
        }
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        
        $res = $this->Plan->save($data);
        if($res === false){
            return ['msg'=>$this->Plan->getError(),'code'=>'200'];
        }else{
            return ['data'=>$res,'msg'=>__lang('MSG_100_SUCCESS'),'code'=>'100'];
        }
    }

    public function getPlanInfo($map){
        $result = $this->Plan->where($map)->find();
        if($result){
            $res = $result->toArray();
            if($res['exercise_id']){
                $res['exercise_ids'] = implode(',', unserialize($res['exercise_id']));
                
            }
            if($res['exercise']){
                $res['exercises'] = implode(',', unserialize($res['exercise']));
            }
            return $res;
        }else{
            return $result;
        }
    }
}