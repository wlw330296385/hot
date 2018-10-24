<?php 
namespace app\management\controller;
use app\management\controller\Camp;
use app\service\CampService;
use app\service\StudentService;
use think\Db;
class Student extends Camp{
	public $StudentService;
	public function _initialize(){
		parent::_initialize();
		$this->StudentService = new StudentService;
	}

    public function StudentInfo(){
    	$student_id = input('param.student_id');
		$camp_id = $this->camp_member['camp_id'];
        $type = input('param.type')?input('param.type'):1;
        // 学生信息
        $studentInfo = $this->StudentService->getStudentInfo(['id'=>$student_id]);

        
        $campInfo = db('camp')->where(['id'=>$camp_id])->find();
        

        // 学员-课程课量
        $schedulenum = db('lesson_member')->whereNull('delete_time')
            ->where([
                'camp_id' => $camp_id,
                'student_id' => $student_id,
                'type' => $type,
            ])->field("sum(rest_schedule) as s_rest_schedule, sum(total_schedule) as s_total_scheulde")->find();
        //未结算课量
        $unsettle = 0;
        $unsettle = db('schedule_member')->where(['user_id'=>$student_id,'type'=>1,'status'=>-1,'camp_id'=>$camp_id,'is_school'=>-1])->count();

        if (!$schedulenum) {
            $restSchedule = 0;
            $totalSchedule = 0;
        } else {
            $restSchedule = $schedulenum['s_rest_schedule'];
            $totalSchedule = $schedulenum['s_total_scheulde'];
        }
        $restSchedule = $restSchedule - $unsettle;
        // 非校园课课时总数
        $finishedSchedule = db('schedule_member')
                            ->where([
                                    'user_id'=>$student_id,
                                    'camp_id'=>$camp_id,
                                    'status'=>1,
                                    'type' =>1,
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


        $this->assign('restSchedule',$restSchedule);
        $this->assign('totalSchedule',$totalSchedule);
        $this->assign('campInfo',$campInfo);
        $this->assign('studentInfo',$studentInfo);

        $this->assign('notPayBill',$notPayBill);
        $this->assign('payBill',$payBill);
        $this->assign('repayBill',$repayBill);
        $this->assign('unsettle',$unsettle);
        $this->assign('studentBillList',$studentBillList);
        $this->assign('totalBill',$totalBill);
        $this->assign('camp_id', $camp_id);
        $this->assign('finishedSchedule', $finishedSchedule);//schoolSchedule
        return view('Student/studentInfo');
    }


    public function StudentList(){

    	$type = input('param.type');
    	$status = input('param.status');
    	$keyword = input('param.keyword');
    	$camp_id = $this->camp_member['camp_id'];
    	$map['camp_id'] = $camp_id;
    	if ($type) {
    		$map['type'] = $type;
    	}
    	if($status){
    		$map['status'] = $status;
    	}
    	if($keyword){
    		$map['lesson|student'] = ['like',"%$keyword%"];
    	}
    	$studentList = db('lesson_member')->where($map)->paginate(20)->each(function($item,$e){
            dump($item['lesson']);die;
        });
        
    	$this->assign('studentList',$studentList);
        return view('Student/studentList');
    }
    
}