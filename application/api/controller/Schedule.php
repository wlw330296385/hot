<?php
namespace app\api\controller;
use app\api\controller\Base;
use think\Request;
use app\service\ScheduleService;
class Schedule extends Base{

	protected $scheduleService;

	public function _initialize() {   
        parent::_initialize();  
        $this->scheduleService = new ScheduleService;
    }	


    public function getScheduleList(){
    	$result = $this->scheduleService->getScheduleList();
    	return json($result);
    }


    // 发布课时
    public function pubSchedule(){
    	$data = Request::instance()->param();
    	$result = $this->scheduleServic->pubSchedule($data);
    	return json($result);
    }

  	// 查询课时
  	public function getScheduleInfo(){
  		$map = Request::instance()->param();
  		$result = $this->scheduleServic->getScheduleInfo($map); 
  		return json($result);
  	}
}