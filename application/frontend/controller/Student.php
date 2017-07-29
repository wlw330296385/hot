<?php 
namespace app\frontend\controller;
use app\service\StudentService;
use app\frontend\controller\Base;

/**
* 学生控制器
*/
class Student extends Base
{
	protected $studentService;
	function __construct()
	{
		$this->studentService = new StudentService;
	}

	public function index(){
		return view();
	}

	public function student(){
		$id = input('id');
		$studentInfo = $this->studentService->getStudentInfo(['id'=>$id]);
		dump($studentInfo);die;
		return view();
	}

	// 获取学生列表
	public function studentList(){
		$map = input();
		$studenList = $this->studentService->getStudentListOfCoach($map);
		dump($studenList);die;
	}
}