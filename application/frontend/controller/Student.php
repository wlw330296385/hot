<?php 
namespace app\frontend\controller;
use app\service\CampService;
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
	
		// 学生信息
		$studentInfo = $this->studentService->getStudentInfo(['id'=>$student_id]);
		if($studentInfo['member_id'] <> ($this->memberInfo['id'])){
			// 获取当前用户身份
	        $power = db('camp_member')->where(['camp_id'=>$camp_id,'member_id'=>$this->memberInfo['id'],'status'=>1])->value('type');
	        // 如果是教练身份,并且排除学生自己
	        if(!$power){
	        	$this->error('您没有权限查看该学生的信息');
	        }
	        if($power < 3 && $power<>1){ 
	            
	            $coach_id = db('coach')->where(['member_id'=>$this->memberInfo['id']])->value('id');
	            if(!$coach_id){
	            	$this->error('只有教练可以查看学生信息');
	            }
	            $map = function ($query) use ($coach_id){
	                $query->where(['grade.coach_id'=>$coach_id])->whereOr('grade.assistant_id','like',"%\"$coach_id\"%");
	            };
	            $gradeIDS = db('grade')->where($map)->column('id');
	            $is_power = db('grade_member')
	            			->where(['student_id'=>$student_id])
	            			->where('grade_id','in',$gradeIDS)
	            			->value('grade_id');
	            if(!$is_power){
	            	$this->error('它不是您的学生,不可查看该学生信息');
	            }
	        }
		}
        
		$campInfo = db('camp')->where(['id'=>$camp_id])->find();
		
		//学生的班级	
		$studentGradeList = Db::view('grade_member')
							->view('grade','*','grade.id=grade_member.grade_id')
							->where([
								'grade_member.student_id'=>$student_id,
								'grade_member.camp_id'=>$camp_id,
								'grade_member.status'=>1
							])
							->order('grade_member.id desc')
							->select();
		// 学员-课程课量
        $schedulenum = db('lesson_member')->whereNull('delete_time')
            ->where([
                'camp_id' => $camp_id,
                'student_id' => $student_id,
                'type' => $type,
                //'status' => 1
            ])->field("sum(rest_schedule) as s_rest_schedule, sum(total_schedule) as s_total_scheulde")->find();
        //dump($schedulenum);
        if (!$schedulenum) {
            $restSchedule = 0;
            $totalSchedule = 0;
        } else {
            $restSchedule = $schedulenum['s_rest_schedule'];
            $totalSchedule = $schedulenum['s_total_scheulde'];
        }

		// 学生课量
		// $studentScheduleList = Db::view('schedule_member','*')
		// 						->view('schedule','students,leave','schedule.id=schedule_member.schedule_id')
		// 						->where([
		// 						    'schedule.status' => 1,
		// 							'schedule_member.user_id'=>$student_id,
		// 							'schedule_member.status'=>1,
		// 						])
  //                               ->whereNull('schedule.delete_time')
  //                               ->whereNull('schedule_member.delete_time')
		// 						->order('schedule_member.id desc')
		// 						->select();	
		// 非校园课课时总数
		$finishedSchedule = db('schedule_member')
							->where([
									'user_id'=>$student_id,
									// 'status'=>1,
									// 'type' =>1,
									'is_school'=>-1
								])
							->count();
		$finishedSchedule?$finishedSchedule:0;	
						
		// 学生订单
		$billService = new \app\service\BillService;
		$studentBillList = $billService->getBillList(['student_id'=>$student_id,'camp_id'=>$camp_id,'expire'=>0]);
		$totalBill = count($studentBillList);
		// 未付款订单
		$notPayBill = $billService->billCount(['student_id'=>$student_id,'camp_id'=>$camp_id,'is_pay'=>0,'status'=>0,'expire'=>['gt',time()]]);
		//退款订单 
		$repayBill = $billService->billCount(['student_id'=>$student_id,'camp_id'=>$camp_id,'is_pay'=>1,'status'=>-2,'expire'=>0]);
		$payBill = $totalBill;


		// 学员自己可操作区显示
        $studentcando = ($this->memberInfo['id'] == $studentInfo['member_id']) ? 1 : 0;
		$this->assign('restSchedule',$restSchedule);
        $this->assign('totalSchedule',$totalSchedule);
		$this->assign('campInfo',$campInfo);
		$this->assign('studentInfo',$studentInfo);
		$this->assign('studentGradeList',$studentGradeList);
		$this->assign('notPayBill',$notPayBill);
		$this->assign('payBill',$payBill);
		$this->assign('repayBill',$repayBill);
		// $this->assign('studentScheduleList',$studentScheduleList);
		$this->assign('studentBillList',$studentBillList);
		$this->assign('totalBill',$totalBill);
		$this->assign('studentcando', $studentcando);
		$this->assign('camp_id', $camp_id);
		$this->assign('finishedSchedule', $finishedSchedule);//schoolSchedule
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

        // 获取会员在训练营角色
        $power = $this->CampService->isPower($camp_id,$this->memberInfo['id']);
        if($power <2){
            $this->error('权限不足');
        }

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
		$student_id = input('param.student_id');
		$studentInfo = $this->studentService->getStudentInfo(['id'=>$student_id]);
		if(!$studentInfo){
			$this->error('找不到该学生数据');
		}
		if($studentInfo['member_id']<>$this->memberInfo['id']){
			$this->error('您没有权限编辑学生资料');
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


	public function tipStudentListOfCamp(){
		$camp_id = input('param.camp_id');
		
        // 获取会员在训练营角色
        $power = $this->CampService->isPower($camp_id,$this->memberInfo['id']);
        if($power <2){
            $this->error('权限不足');
        }
        $this->assign('camp_id',$camp_id);
        // 获取训练营角色、教练权限等级
        $campPower = getCampPower($camp_id, $this->memberInfo['id']);
        $campMemberLevel = 0;
        if ($campPower==2) {
            $campMemberLevel = getCampMemberLevel($camp_id, $this->memberInfo['id']);
        }
        $this->assign('campMemberLevel', $campMemberLevel);
		return view('Student/tipStudentListOfCamp');
	}
		
}