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

        $studentList = db('lesson_member')->field('lesson_member.lesson,lesson_member.member_id,lesson_member.student,lesson_member.status,lesson_member.type,lesson_member.student_id,lesson_member.lesson,sum(lesson_member.total_schedule) as s_total_schedule,sum(lesson_member.rest_schedule) as s_rest_schedule,sum(bill.balance_pay) as s_balance_pay, sum(gift_schedule) as s_gift')->join('bill','bill.student_id = lesson_member.student_id and lesson_member.lesson_id = bill.goods_id','left')->join('schedule_gift_student','schedule_gift_student.student_id = bill.student_id and schedule_gift_student.camp_id = bill.camp_id','left')->where($map)->order('lesson_member.id desc')->group('bill.student_id')->select();

        // 初始化
        foreach ($studentList as $key => $value) {
            $studentList[$key]['s_school'] = 0;
            $studentList[$key]['s_unsettle'] = 0;
        }
        // 未结算课时
        $unsettleList = db('schedule_member')->field('count(id) as c_id,user_id as student_id')->where(['camp_id'=>$camp_id,'status'=>-1,'is_school'=>-1,'type'=>1])->group('user_id')->select();
        // 校园课时
        $schoolList = db('schedule_member')->field('count(id) as c_id,user_id as student_id')->where(['camp_id'=>$camp_id,'status'=>-1,'is_school'=>1,'type'=>1])->group('user_id')->select();
        foreach ($studentList as $key => $value) {
            foreach ($unsettleList as $k => $v) {
                if($value['student_id'] == $v['student_id']){
                    $studentList[$key]['s_unsettle'] = $v['c_id'];
                }
            }
            foreach ($schoolList as $kk => $vv) {
                if($value['student_id'] == $vv['student_id']){
                    $studentList[$key]['s_school'] = $vv['c_id'];
                }
            }   
        }
        if(request()->isPost()){
            if(empty($studentList)){
                $this->error("数据为空,不生成excel") ;
            }else{
                $xlsName  = "学生课时统计表";
                $xlsCell = [
                    ['student_id','学生ID'],
                    ['student','姓名'],
                    ['lesson','课程名称'],
                    ['s_balance_pay','总交费'],
                    ['s_gift','总赠送课时'],
                    ['s_total_schedule','总课时'],
                    ['s_rest_schedule','已上课时'],
                    ['s_school','已上公益课时'],
                    ['s_unsettle','未结算课时'],
                    ['s_rest_schedule','剩余课时'],
                    ['type','类型(仅供参考)'],
                ];
                $xlsData  = $studentList;
                exportExcel($xlsName,$xlsCell,$xlsData);
            }
        }    
        $campList = db('camp')->select();
        $this->assign('campList',$campList);
        $this->assign('studentList',$studentList);
        return view('Student/studentList');
    }
    




    public function exportExcel(){
        $camp_id = $this->campInfo['id'];
        $map['lesson_member.camp_id'] = $camp_id;
        $map['bill.is_pay'] = 1;
        $map['bill.goods_type'] = 1;
        $studentList = db('lesson_member')->field('lesson_member.lesson,lesson_member.member_id,lesson_member.student,lesson_member.status,lesson_member.type,lesson_member.student_id,lesson_member.lesson,sum(lesson_member.total_schedule) as s_total_schedule,sum(lesson_member.rest_schedule) as s_rest_schedule,sum(bill.balance_pay) as s_balance_pay, sum(gift_schedule) as s_gift')->join('bill','bill.student_id = lesson_member.student_id and lesson_member.lesson_id = bill.goods_id','left')->join('schedule_gift_student','schedule_gift_student.student_id = bill.student_id and schedule_gift_student.camp_id = bill.camp_id','left')->where($map)->order('lesson_member.id desc')->group('bill.student_id')->select();

        // 初始化
        foreach ($studentList as $key => $value) {
            $studentList[$key]['s_school'] = 0;
            $studentList[$key]['s_unsettle'] = 0;
        }
        // 未结算课时
        $unsettleList = db('schedule_member')->field('count(id) as c_id,user_id as student_id')->where(['camp_id'=>$camp_id,'status'=>-1,'is_school'=>-1,'type'=>1])->group('user_id')->select();
        // 校园课时
        $schoolList = db('schedule_member')->field('count(id) as c_id,user_id as student_id')->where(['camp_id'=>$camp_id,'status'=>-1,'is_school'=>1,'type'=>1])->group('user_id')->select();
        foreach ($studentList as $key => $value) {
            foreach ($unsettleList as $k => $v) {
                if($value['student_id'] == $v['student_id']){
                    $studentList[$key]['s_unsettle'] = $v['c_id'];
                }
            }
            foreach ($schoolList as $kk => $vv) {
                if($value['student_id'] == $vv['student_id']){
                    $studentList[$key]['s_school'] = $vv['c_id'];
                }
            }   
        }
        if(empty($studentList)){
            echo "数据为空,不生成excel";
        }else{
            $xlsName  = "学生课时统计表";
            $xlsCell = [
                ['student_id','学生ID'],
                ['stduent','姓名'],
                ['lesson','课程名称'],
                ['s_balance_pay','总交费'],
                ['s_gift','总赠送课时'],
                ['s_total_schedule','总课时'],
                ['s_rest_schedule','已上课时'],
                ['s_school','已上公益课时'],
                ['s_unsettle','未结算课时'],
                ['s_rest_schedule','剩余课时'],
                ['type','类型(仅供参考)'],
            ];
            $xlsData  = $studentList;
            exportExcel($xlsName,$xlsCell,$xlsData);
        }
    }











}