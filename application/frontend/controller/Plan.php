<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\PlanService;
class Plan extends Base{
	protected $planService;

	public function _initialize(){
		parent::_initialize();
		$this->palnService = new PlanService;
	}

    public function index() {

        return view();
    }


    public function planInfo(){
    	$id = input('id');
    	$result = $this->palnService->PlanOneById(['id'=>$id],10);
    	return view();
    }



    public function updatePlan(){
    	
    	$id = input('id');
		$palnInfo = $this->planService->PlanOneById(['id'=>$id]);
		$this->assign('planInfo',$planInfo);

    	return view();
    }

    // 分页获取数据
    public function palnList(){
    	$map = input('post.');
    	$palnList = $this->palnService->PlanListPage($map,2);
    	dump($palnList['data']);die;
    }

}