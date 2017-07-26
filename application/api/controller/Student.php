<?php 
namespace app\api\controller;
use think\Request;
use app\api\controller\Base;
use app\service\StudentService;
class Student extends Base{
	public $studentService;
	public function _initialize(){
		parent::_initialize();
		$this->studentService = new StudentService;
	}

	// 获取学生资料的班级
	public function index(){
		echo 1;
		$list = 1;
	}

	// 获取学生列表
	public function getStudentList(){
		$data = Request::instance()->param();
		$result = $this->studentService->getStudentListOfCoach($data);
		return json($result);
	}

	//完善学生信息
	public function becomeStudent(){
		$data = Request::instance()->param();
		$result = $this->studentService->createStudent($data);
		return json($result);
	}
	
	
}