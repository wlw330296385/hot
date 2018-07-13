<?php 
namespace app\keeper\controller;
use app\keeper\controller\Base;



// 计划
class Plan extends Base{
	public function _initialize(){
		parent::_initialize();
	}
	// 计划首页
    public function index() {
    	
        return view('Plan/index');
    }


    //计划详情
    public function sportPlanInfo(){
    	$sport_plan_id = input('param.sport_plan_id');

    	$sportPlanInfo = [];



    	$this->assign('sportPlanInfo',$sportPlanInfo);
    	return view('Plan/sportPlanInfo');
    }


	
	// 计划历程列表
	public function sportPlanScheduleList() {


        return view('Plan/sportPlanScheduleList');
    }

    

}