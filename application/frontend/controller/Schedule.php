<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\ScheduleService;

/**
* 课时表类
*/
class Schedule extends Base
{
	
	protected $scheduleService;

	function __construct()
	{
		$this->scheduleService = new ScheduleService;
	}

	public function index(){

	}

	// 课时详情
	public function schedule(){
		$id = input('id');
		$scheduleInfo = $this->scheduleService->getScheduleInfo(['id'=>$id]);
		$this->view();
	}

}