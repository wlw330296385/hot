<?php 
namespace app\admin\controller;
use app\admin\controller\base\Backend;
// 按课时结算的训练营财务页面
class StatisticsCamp extends Backend{

	public function _initialize(){
		parent::_initialize();
	}

    // 课时列表
    public function campSchedule() {
        // 教练列表
        $coachlist = db('coach')->where(['status' => 1])->whereNull('delete_time')->select();
        // 课程列表
        $lessonlist = db('lesson')->whereNull('delete_time')->select();
        // 统计数字项初始化
        $sumSalaryin = 0;
        $sumSchedule = 0;
        $sumScheduleStudent = 0;
        $sumScheduleGift=0;
        // 搜索筛选
        $map = [];
        // 选择训练营
        $camp_id = input('camp_id');
        if ($camp_id) {
            $map['camp_id']=$camp_id;
        }
        // 选择教练
        $coach_member_id = input('coach_member_id');
        if ($coach_member_id) {
            $map['member_id'] = $coach_member_id;
        }
        // 选择课程
        $lesson_id = input('lesson_id');
        if ($lesson_id) {
            $map['lesson_id'] = $lesson_id;
        }

        // 课时月份
        $schedule_date = input('schedule_date');
        $curschedule_date = date('Y-m');
        $startTime = 0;
        $endTime = 0;
        if ($schedule_date) {
            $dateArr2 = explode('-', $schedule_date);
            $when2 = getStartAndEndUnixTimestamp($dateArr2[0], $dateArr2[1]);
            $start2 = $when2['start'];
            $end2 = $when2['end'];
            $map['schedule_time'] = ['between', [$start2, $end2]];
            $curschedule_date = $schedule_date;
            $startTime = $when2['start'];
            $endTime = $when2['end'];
        }

        // 收入列表（分页）
        $SalaryIn = new \app\model\SalaryIn;
        $salaryInList = $SalaryIn::with('schedule')->where($map)->order('schedule_time desc')->paginate(15, false, ['query' => request()->param()])->each(function($item, $key) {
            $item['lesson'] = db('lesson')->where(['id' => $item['lesson_id']])->find();
            $scheduleStudentStr = unserialize($item['schedule']['student_str']);
            $item['schedule']['studentlist'] = $scheduleStudentStr;
            if (!empty($scheduleStudentStr)) {
                $item['schedule']['num_student'] = count( $scheduleStudentStr ) ;
            } else {
                $item['schedule']['num_student'] = 0;
            }
            return $item;
        });

        
        $this->assign('list', $salaryInList);
        $this->assign('page', $salaryInList->render());
        $this->assign('coachlist', $coachlist);
        $this->assign('lessonlist', $lessonlist);
        $this->assign('camp_id', $camp_id);
        $this->assign('coach_member_id', $coach_member_id);
        $this->assign('lesson_id', $lesson_id);
        $this->assign('curschedule_date', $curschedule_date);
        $this->assign('sumSalaryin', $sumSalaryin);
        $this->assign('sumSchedule', $sumSchedule);
        $this->assign('sumScheduleStudent', $sumScheduleStudent);
        $this->assign('sumScheduleGift', $sumScheduleGift);
        return $this->fetch('StatisticsCamp/campSchedule');
    }

    
    public function campBill(){

        $camp_id = input('param.camp_id',9);
        $monthStart = input('param.monthstart',date('Ymd',strtotime('-1 month', strtotime("first day of this month"))));
        $monthEnd = input('param.monthend',date('Ymd'));
        $month_start = strtotime($monthStart);
        $month_end = strtotime($monthEnd);
        $income = [];
        $list3 = [];//课时收入
        $list2 = [];//活动收入 
        $list_1 = [];//提现  
        $list1 = [];//赠课
        $list4 = [];//教练工资和平台支出;
        // 活动订单收入 
        $income2 = db('income')->field("sum('income') as s_income,from_unixtime(create_time,'%Y%m%d') as days,sum('schedule_income') as s_schedule_income")->where(['camp_id'=>$camp_id,'type'=>2])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();
        //课时收入
        $income3 = db('income')->field("sum('income') as s_income,from_unixtime(create_time,'%Y%m%d') as days,sum('schedule_income') as s_schedule_income")->where(['camp_id'=>$camp_id,'type'=>3])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();
        // 提现支出
        $output = db('output')->field("sum('output') as s_output,from_unixtime(create_time,'%Y%m%d') as days")->where(['camp_id'=>$camp_id,'type'=>-1])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();
        //赠课支出
        $output_gift = db('output')->field("sum('output') as s_output,from_unixtime(create_time,'%Y%m%d') as days")->where(['camp_id'=>$camp_id,'type'=>1])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();
        //课时薪资
        $schedule =  db('schedule')->field("sum((coach_salary+assistant_salary+salary_base)*students) as s_s_salary,from_unixtime(finish_settle_time,'%Y%m%d') as days,sum(cost*students*schedule_rebate) as s_s_rebate,is_settle,camp_id")->where(['camp_id'=>$camp_id,'is_settle'=>1])->where(['finish_settle_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();
        // echo db('schedule')->getlastsql();die;
        // dump($schedule);die;
        for ($i=$monthStart; $i <= $monthEnd; $i++) { 
            $list3[$i]  = ['s_income'=>0,'s_schedule_income'=>0];
            $list2[$i]  = ['s_income'=>0];
            $list_1[$i] = ['s_output'=>0];
            $list1[$i]  = ['s_output'=>0];
            $list4[$i]  = ['s_s_rebate'=>0,'s_s_salary'=>0];
        }
        foreach ($list3 as $key => &$value) {
            foreach ($income3 as $k => $val) {
                if($key == $val['days']){
                    $value = $val;
                }
            }
        }  
        foreach ($list2 as $key => &$value) {
            foreach ($income2 as $k => $val) {
                if($key == $val['days']){
                    $value = $val;
                }
            }
        }  

        foreach ($list_1 as $key => &$value) {
            foreach ($output as $k => $val) {
                if($key == $val['days']){
                    $value = $val;
                }
            }
        }

        foreach ($list1 as $key => &$value) {
            foreach ($output_gift as $k => $val) {
                if($key == $val['days']){
                    $value = $val;
                }
            }
        }
        foreach ($list4 as $key => &$value) {
            foreach ($schedule as $k => $val) {
                if($key == $val['days']){
                    $value = $val;
                }
            }
        }
        // dump($list4);die;
        $this->assign('list4',$list4);//课时收入
        $this->assign('list3',$list3);//课时收入
        $this->assign('list2',$list2);//活动收入
        $this->assign('list_1',$list_1);//提现   
        $this->assign('list1',$list1);//赠课
        return view('StatisticsCamp/campBill');
    }
}