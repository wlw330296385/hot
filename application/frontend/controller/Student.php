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

	public function studentInfo(){
		$id = input('student_id');
		// 学生信息
		$studentInfo = $this->studentService->getStudentInfo(['id'=>$id]);
		//学生的班级
		$studentGradeList = $this->studentService->getStudentGradeList(['student_id'=>$id,'type'=>1,'status'=>1]);	
		// 学生课量
		$studentScheduleList = $this->studentService->getStudentScheduleList(['member_id'=>$id,'type'=>0]);
		// 学生订单
		$billService = new app\service\BillService;
		$studentBillList = $billService->getBillList(['student_id'=>$student_id,'status'=>1]);
		$totalBill = count($studentBillList);
		$this->assgin('studentInfo',$studentInfo);
		$this->assign('studentGradeList',$studentGradeList);
		$this->assign('studentGradeList',$studentGradeList);
		$this->assign('studentBillList',$studentBillList);
		$this->assign('totalBill',$totalBill);
		return view();
	}

	// 获取学生列表
	public function studentList(){
		$map = input();
		$studenList = $this->studentService->getStudentListOfCoach($map);
		$this->assgin('studenList',$studenList);
		// dump($studentInfo);die;
		return view();
	}

	
	public function createStudentApi(){
		$data = input();
		$data['member'] = $this->memberInfo['member'];
		$data['member_id'] = $this->memberInfo['id'];
		$result = $this->studentService->createStudent($data);
		return json($result);
	}

	// 编辑学生资料
	public function updateStudent(){
		$student_id = input('student_id');
		$studentInfo = $this->studentService->getStudentInfo(['id'=>$student_id]);
		if(!$studentInfo){
			$studentInfo = [];
		}
		$this->assign('studentInfo',$studentInfo);
		return view();
	}
	

		
}