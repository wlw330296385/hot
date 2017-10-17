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


		return view('Student/index');
	}

	public function studentInfoOfCamp(){
		$student_id = input('param.student_id');
		$camp_id = input('param.camp_id');
		$type = input('param.type')?input('param.type'):1;
		$campInfo = db('camp')->where(['id'=>$camp_id])->find();
		// 学生信息
		$studentInfo = $this->studentService->getStudentInfo(['id'=>$student_id]);
		//学生的班级	
		$studentGradeList = Db::view('grade_member','grade_id,rest_schedule')
							->view('grade','*','grade.id=grade_member.grade_id')
							->where([
								'grade_member.student_id'=>$student_id,
								'grade_member.camp_id'=>$camp_id,
								'grade_member.type'=>$type,
								'grade_member.status'=>1
							])
							->order('grade_member.id desc')
							->select();
		// 剩余课量
		$restSchedule = 0;
		foreach ($studentGradeList as $key => $value) {
								$restSchedule+=$value['rest_schedule'];
							}					
		// 学生课量
		$studentScheduleList = Db::view('schedule_member','*')
								->view('schedule','students,leave','schedule.id=schedule_member.schedule_id')
								->where([
									'schedule_member.user_id'=>$student_id,
									// 'schedule_member.type'=>$type,
									'schedule_member.status'=>1
								])	
								->order('schedule_member.id desc')
								->select();	
				
		// 学生订单
		$billService = new \app\service\BillService;
		$studentBillList = $billService->getBillList(['student_id'=>$student_id,'camp_id'=>$camp_id]);
		$totalBill = count($studentBillList);
		// 未付款订单
		$notPayBill = $billService->billCount(['student_id'=>$student_id,'camp_id'=>$camp_id,'is_pay'=>0,'status'=>1]);
		//退款订单 
		$repayBill = $billService->billCount(['student_id'=>$student_id,'camp_id'=>$camp_id,'is_pay'=>['lt',0],'status'=>1]);
		$payBill = $totalBill - $notPayBill;
		// 历史课时
		$totalSchedule = db('bill')->where(['camp_id'=>$camp_id,'student_id'=>$student_id])->sum('total');

		$this->assign('totalSchedule',$totalSchedule);
		$this->assign('restSchedule',$restSchedule);
		$this->assign('campInfo',$campInfo);
		$this->assign('studentInfo',$studentInfo);
		$this->assign('studentGradeList',$studentGradeList);
		$this->assign('notPayBill',$notPayBill);
		$this->assign('payBill',$payBill);
		$this->assign('repayBill',$repayBill);
		$this->assign('studentScheduleList',$studentScheduleList);
		$this->assign('studentBillList',$studentBillList);
		$this->assign('totalBill',$totalBill);
		return view('Student/studentInfoOfCamp');
	}

	// 获取教练的学生列表
	public function studentListOfCoach(){
		$map = input('post.');
		$studenList = $this->studentService->getStudentListOfCoach($map);
		$this->assign('studenList',$studenList);
		// dump($studentInfo);die;
		return view('Student/studentListOfCoach');
	}

	// 获取训练营学生列表
	public function studentListOfCamp(){
		$camp_id = input('param.camp_id');
		$type = input('param.type')?input('param.type'):1;
					
        $this->assign('camp_id',$camp_id);
		if($type==1){
			return view('Student/studentListOfCamp');
		}else{
			return view('Student/expStudentListOfCamp');
		}
		
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
		return view('Student/updateStudent');
	}
	
	public function studentInfo(){
		$member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
		$student_id = input('param.student_id');
		// 学生信息
		$studentInfo = $this->studentService->getStudentInfo(['id'=>$student_id]);
		$this->assign('studentInfo',$studentInfo);
		return view('Student/studentInfo');
	}
		
}