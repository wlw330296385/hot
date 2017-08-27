<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\PlanService;
class Plan extends Base{
	protected $planService;

	public function _initialize(){
		parent::_initialize();
		$this->PlanService = new PlanService;
	}

    public function index() {

        return view();
    }


    public function planInfo(){
    	$plan_id = input('param.plan_id');
    	$result = $this->PlanService->PlanOneById(['id'=>$plan_id]);

        $this->assign('planInfo',$result);
    	return view();
    }


    //编辑项目
    public function updatePlan(){
    	
    	$plan_id = input('param.plan_id');
        $result = $this->PlanService->PlanOneById(['id'=>$plan_id]);

        $this->assign('planInfo',$result);

    	return view();
    }

    // 分页获取数据
    public function planList(){
    	$camp_id = input('param.camp_id');
    	$planListOfCamp = $this->PlanService->PlanListPage(['camp_id'=>$camp_id,'type'=>1]);
    	$planListOfSys = $this->PlanService->PlanListPage(['type'=>0]);
        $this->assign('planListOfCamp',$planListOfCamp);
        $this->assign('planListOfSys',$planListOfSys);
        return view();
    }


    public function planListApi(){
        $map = input('post.');
        $planList = $this->PlanService->PlanListPage($map,10);
        return json($planList);
    }
}