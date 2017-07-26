<?php 
namespace app\api\controller;
use think\Request;
use app\api\controller\Base;
use app\service\CoachService;
class Coach extends Base{
	public $coachService;
	public function _initialize(){
		parent::_initialize();
		$this->coachService = new CoachService;
	}

	// 获取学生资料的班级
	public function index(){
		echo 1;
		$list = 1;
	}

	// 获取教练列表
	public function getCoachList(){
		$data = Request::instance()->param();
		$result = $this->coachService->getCoahListOfCamp($data);
		return json($result);
	}

	public function getCoachInfo(){
		$data = Request::instance()->param();
		$result = $this->coachService->getCoachInfo($data);
		return json($result);
	}
}