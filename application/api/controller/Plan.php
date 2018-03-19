<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\PlanService;
class Plan extends Base{
	protected $planService;

	public function _initialize(){
		parent::_initialize();
		$this->PlanService = new PlanService;
	}

    public function index() {


    }


    public function planListNoPageApi(){
        try{
            $map = input('post.');
            $PlanModel = new \app\model\Plan;
            $result = $PlanModel->where($map)->select();
            if($result){
                $res = $result->toArray();
            }else{
                $res = [];
            }
            if($res){
                return json(['code'=>200,'data'=>$res,'msg'=>'ok']);
            }else{
                return json(['code'=>100,'msg'=>'没有教案']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }

    } 

    public function planListApi(){
        try{
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1;
            $result = $this->PlanService->getPlanList($map,$page);
            return json(['code'=>200,'data'=>$result,'msg'=>'ok']);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }

    }


    public function getPlanListByPageApi(){
        try{
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1;
            $result = $this->PlanService->getPlanListByPage($map,$page);
            return json(['code'=>200,'data'=>$result,'msg'=>'ok']);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    public function createPlanApi(){
        try{
            $data = input('post.');
            $data['member'] = $this->memberInfo['member'];
            $data['member_id'] = $this->memberInfo['id'];
            $data['type'] = 1;
            $planList = $this->PlanService->createPlan($data);
            return json($planList);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function updatePlanApi(){
        try{
            $plan_id = input('param.plan_id');
            $data = input('post.');
            $data['member'] = $this->memberInfo['member'];
            $data['member_id'] = $this->memberInfo['id'];
            $data['type'] = 1;

            $planList = $this->PlanService->updatePlan($data,$plan_id);
            return json($planList);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}