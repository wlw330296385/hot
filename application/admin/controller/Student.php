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
        $studentInfo = $this->studentService->getStudentInfo(['id'=>$student_id]);
        //权限判断
        if($studentInfo['member_id'] <> ($this->memberInfo['id'])){
            // 先判断family    
            $isFamily = db('family')->where(['to_member_id'=>$this->memberInfo['id'],'member_id'=>$studentInfo['member_id'],'status'=>1])->find();
        
            if(!$isFamily){
                // 获取当前用户身份
                $power = db('camp_member')->where(['camp_id'=>$camp_id,'member_id'=>$this->memberInfo['id'],'status'=>1])->value('type');
                // 如果是教练身份,并且排除学生自己
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
                                ->where(['camp_id'=>$camp_id])
                                ->value('grade_id');
                    if(!$is_power){
                        $this->error('它不是您的学生,不可查看该学生信息');
                    }
                }
                
            }
        }
        
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


        // 学员自己可操作区显示
        $studentcando = ($this->memberInfo['id'] == $studentInfo['member_id']) ? 1 : 0;
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
        $this->assign('studentcando', $studentcando);
        $this->assign('camp_id', $camp_id);
        $this->assign('finishedSchedule', $finishedSchedule);//schoolSchedule
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
        $studentList = db('lesson_member')->field('lesson_member.*,sum(bill.balance_pay) as s_balance_pay')->join('bill','bill.student_id = lesson_member.student_id and lesson_member.lesson_id = bill.goods_id','left')->where($map)->order('lesson_member.id desc')->group('bill.student_id')->paginate(20,true);
        $campList = db('camp')->select();
        $this->assign('campList',$campList);
        $this->assign('studentList',$studentList);
        return view('Student/studentList');
    }
    
}