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

    public function PlanList($map=[], $order='') {
        $res = $this->Plan->where($map)->order($order)->select()->toArray();
        return $res;
    }

    public function PlanListPage( $map=[],$paginate=0, $order=''){
        $res = $this->Plan->where($map)->order($order)->paginate($paginate)->toArray();
        return $res;
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
    public function UpdatePlan($data) {
        $res = $this->Plan->validate('PlanVal')->update($data);
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
    public function createPlan($request){
        // 一个人只能创建一个训练营
        $is_create = $this->Plan->where(['member_id'=>$request['member_id'],'status'=>['NEQ',1]])->find();
        if($is_create){
            return ['msg'=>'一个用户只能创建一个训练营','code'=>'200'];
        }
        $res = $this->Plan->validate('PlanVal')->save($request);
        if($res === false){
            return ['msg'=>$this->Plan->getError(),'code'=>'200'];
        }else{
            $data = ['Plan' =>$request['Plan'],'Plan_id'=>$res,'type'=>3,'realname'=>$request['realname'],'member_id'=>$request['member_id']];
            $result = Db::name('grade_member')->insert($data);
            if(!$result){
                Plan::destroy($res);
                return ['msg'=>Db::name('grade_member')->getError(),'code'=>'200'];
            }
            return ['data'=>$res,'msg'=>__lang('MSG_100_SUCCESS'),'code'=>'100'];
        }
    }
}