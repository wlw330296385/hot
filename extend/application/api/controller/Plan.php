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
            $planList = $this->PlanService->PlanListPage($map,10);
            return json($planList);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }

    }
}