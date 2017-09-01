<?php 
namespace app\frontend\controller;
use app\service\StudentService;
use app\frontend\controller\Base;
use think\Db;
/**
* 学生控制器
*/
class Student extends Base
{
	protected $studentService;
	function _initialize()
	{	
		parent::_initialize();
		$this->studentService = new StudentService;
	}

	public function index(){


		return view();
	}

	public function studentInfoOfCamp(){
		$student_id = input('param.student_id');
		$camp_id = input('param.camp_id');
		$type = input('param.type')?input('param.type'):1;
		$campInfo = db('camp')->where(['id'=>$camp_id])->find();
		// 学生信息
		$studentInfo = $this->studentService->getStudentInfo(['id'=>$student_id]);
		//学生的班级
		// $studentGradeList = $this->studentService->getStudentGradeList(['student_id'=>$student_id,'camp_id'=>$camp_id,'type'=>1,'status'=>1]);	
		$studentGradeList = Db::view('grade_member','grade_id')
							->view('grade','*','grade.id=grade_member.grade_id')
							->where(['grade_member.student_id'=>$student_id,'grade_member.camp_id'=>$camp_id,'grade_member.type'=>$type,'grade_member.status'=>1])
							->select();
		// 学生课量
		// $studentScheduleList = $this->studentService->getStudentScheduleList(['user_id'=>$student_id,'camp_id'=>$camp_id,'type'=>0]);
		$studentScheduleList = Db::view('schedule_member','*')
								->view('schedule','students,leave','schedule.id=schedule_member.schedule_id')
								->where(['schedule_member.user_id'=>$student_id,'schedule_member.type'=>$type,'schedule_member.status'=>1])	
								->select();				
		// 学生订单
		$billService = new \app\service\BillService;
		$studentBillList = $billService->getBillList(['student_id'=>$student_id,'camp_id'=>$camp_id,'status'=>1]);
		$totalBill = count($studentBillList);
		// 未付款订单
		$notPayBill = $billService->billCount(['student_id'=>$student_id,'camp_id'=>$camp_id,'is_pay'=>0,'status'=>1]);
		//退款订单 
		$repayBill = $billService->billCount(['student_id'=>$student_id,'camp_id'=>$camp_id,'is_pay'=>['lt',0],'status'=>1]);
		$payBill = $totalBill - $notPayBill;
		// 剩余课时
		$restSchedule = db('grade_member')->where(['student_id'=>$student_id,'type'=>$type,'camp_id'=>$camp_id,'status'=>1])->sum('rest_schedule');
		// 历史课时
		$totalSchedule = db('bill')->where(['camp_id'=>$camp_id,'student_id'=>$student_id])->sum('total');
		//全部课时
		$allSchedule = Db::view('grade_member','lesson_id')
						->view('bill','*','grade_member.lesson_id=bill.lesson_id')
						->where(['grade_member.student_id'=>$student_id,'grade_member.camp_id'=>$camp_id,'grade_member.type'=>$type,'grade_member.status'=>1])
						->sum('total');

		
		$this->assign('restSchedule',$restSchedule);
		$this->assign('totalSchedule',$totalSchedule);
		$this->assign('allSchedule',$allSchedule);
		$this->assign('campInfo',$campInfo);
		$this->assign('studentInfo',$studentInfo);
		$this->assign('studentGradeList',$studentGradeList);
		// dump($studentBillList);die;
		$this->assign('notPayBill',$notPayBill);
		$this->assign('payBill',$payBill);
		$this->assign('repayBill',$repayBill);
		$this->assign('studentScheduleList',$studentScheduleList);
		$this->assign('studentBillList',$studentBillList);
		$this->assign('totalBill',$totalBill);
		return view();
	}

	// 获取教练的学生列表
	public function studentListOfCoach(){
		$map = input('post.');
		$studenList = $this->studentService->getStudentListOfCoach($map);
		$this->assign('studenList',$studenList);
		// dump($studentInfo);die;
		return view();
	}

	// 获取训练营学生列表
	public function studentListOfCamp(){
		$camp_id = input('param.camp_id');
		$type = input('param.type')?input('param.type'):1;
		$studenList = Db::view('grade_member','student_id,grade,grade_id,camp_id,lesson,lesson_id')
					->view('student','*','student.id=grade_member.student_id')
					->where(['grade_member.camp_id'=>$camp_id,'grade_member.type'=>$type,'grade_member.status'=>1])
					->limit(20)
					->select();				
		$this->assign('studenList',$studenList);	
		if($type==1){
			$studenListOffLine = Db::view('grade_member','student_id,grade,grade_id,camp_id,lesson,lesson_id')
					->view('student','*','student.id=grade_member.student_id')
					->where(['grade_member.camp_id'=>$camp_id,'grade_member.type'=>4,'grade_member.status'=>1])
					->limit(20)
					->select();
			$this->assign('studenListOffLine',$studenListOffLine);
			return view();
		}
		return view('expStudentListOfCamp');
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
	
	public function studentInfo(){
		$member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
		$student_id = input('param.student_id');
		// 学生信息
		$studentInfo = $this->studentService->getStudentInfo(['id'=>$student_id]);
		$this->assign('studentInfo',$studentInfo);
		return view();
	}
		
}