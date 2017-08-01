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
    	$id = input('id');
    	$result = $this->PlanService->PlanOneById(['id'=>$id],10);
    	return view();
    }



    public function updatePlan(){
    	
    	$id = input('id');
		$planInfo = $this->PlanService->PlanOneById(['id'=>$id]);
		$this->assign('planInfo',$planInfo);

    	return view();
    }

    // 分页获取数据
    public function planList(){
    	$map = input('post.');
    	$planList = $this->PlanService->PlanListPage($map,10);
    	dump($planList['data']);die;
    }


    public function planListApi(){
        $map = input('post.');
        $planList = $this->PlanService->PlanListPage($map,10);
        return json($planList);
    }
}