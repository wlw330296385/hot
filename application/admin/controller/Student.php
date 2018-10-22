<?php 
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\service\CampService;
use app\service\StudentService;
use think\Db;
class Student extends Backend{
    public $StudentService;
    public function _initialize(){
        parent::_initialize();
        $this->StudentService = new StudentService;
    }

    public function StudentInfo(){
        $student_id = input('param.student_id');
        $camp_id = $this->campInfo['id'];
        $type = input('param.type')?input('param.type'):1;
    
        // 学生信息
        $studentInfo = $this->StudentService->getStudentInfo(['id'=>$student_id]);        
        $campInfo = $this->campInfo;
        
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
            ])->field("sum(rest_schedule) as rest_schedule, sum(total_schedule) as total_scheulde")->select();
        //dump($schedulenum);
        if (!$schedulenum) {
            $restSchedule = 0;
            $totalScheule = 0;
        } else {
            $restSchedule = $schedulenum[0]['rest_schedule'];
            $totalScheule = $schedulenum[0]['total_scheulde'];
        }

        // 学生课量
        $studentScheduleList = Db::view('schedule_member','*')
                                ->view('schedule','students,leave','schedule.id=schedule_member.schedule_id')
                                ->where([
                                    'schedule.status' => 1,
                                    'schedule_member.user_id'=>$student_id,
                                    'schedule_member.status'=>1,
                                ])
                                ->whereNull('schedule.delete_time')
                                ->whereNull('schedule_member.delete_time')
                                ->order('schedule_member.id desc')
                                ->select(); 

        // 学生订单
        $billService = new \app\service\BillService;
        $studentBillList = $billService->getBillList(['student_id'=>$student_id,'camp_id'=>$camp_id,'expire'=>0]);
        $totalBill = count($studentBillList);
        // 未付款订单
        $notPayBill = $billService->billCount(['student_id'=>$student_id,'camp_id'=>$camp_id,'is_pay'=>0,'status'=>0,'expire'=>0]);
        //退款订单 
        $repayBill = $billService->billCount(['student_id'=>$student_id,'camp_id'=>$camp_id,'is_pay'=>1,'status'=>-2,'expire'=>0]);
        $payBill = $totalBill - $notPayBill;


        // 学员自己可操作区显示
        $studentcando = 0;
        $this->assign('restSchedule',$restSchedule);
        $this->assign('totalScheule',$totalScheule);
        $this->assign('studentInfo',$studentInfo);
        $this->assign('studentGradeList',$studentGradeList);
        $this->assign('notPayBill',$notPayBill);
        $this->assign('payBill',$payBill);
        $this->assign('repayBill',$repayBill);
        $this->assign('studentScheduleList',$studentScheduleList);
        $this->assign('studentBillList',$studentBillList);
        $this->assign('totalBill',$totalBill);
        $this->assign('studentcando', $studentcando);
        $this->assign('camp_id', $camp_id);
        return view('Student/studentInfo');
    }


    public function StudentList(){

        $type = input('param.type');
        $status = input('param.status');
        $keyword = input('param.keyword');
        $camp_id = $this->campInfo['id'];
        $map['lesson_member.camp_id'] = $camp_id;
        $map['bill.is_pay'] = 1;
        $map['bill.goods_type'] = 1;
        if ($type) {
            $map['lesson_member.type'] = $type;
        }
        if($status){
            $map['lesson_member.status'] = $status;
        }
        if($keyword){
            $map['lesson_member.lesson|lesson_member.student'] = ['like',"%$keyword%"];
        }
        $studentList = db('lesson_member')->field('lesson_member.*,sum(bill.balance_pay) as s_balance_pay')->join('bill','bill.student_id = lesson_member.student_id and lesson_member.lesson_id = bill.goods_id','left')->where($map)->order('lesson_member.id desc')->group('bill.student_id')->select();
        $campList = db('camp')->select();
        $this->assign('campList',$campList);
        $this->assign('studentList',$studentList);
        return view('Student/studentList');
    }
    
}