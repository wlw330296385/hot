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




    public function planListApi(){
        try{
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1;
            $planList = $this->PlanService->PlanListPage($map,$page);
            return json($planList);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }

    }


    public function createPlan(){
        try{
            $data = input('post.');
            $data['member'] = $this->memberInfo['member'];
            $data['member_id'] = $this->memberInfo['id'];
            $data['type'] = 1;
            dump($data);
            $planList = $this->PlanService->createPlan($data);
            return json($planList);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function updatePlan(){
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