<?php 
namespace app\management\controller;
use app\management\controller\Camp;

class StatisticsCamp extends Camp{
    
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
        $camp_id = $this->camp_member['camp_id'];
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

    // 资金账目
    public function campBill(){
        $camp_id = $this->camp_member['camp_id'];
        $monthStart = input('param.monthstart');
        $monthEnd = input('param.monthend');
        $month_start = strtotime($monthStart);
        $month_end = strtotime($monthEnd)+86399;
        $income = [];
        $list3 = [];//课时收入
        $list2 = [];//活动收入 
        $list_1 = [];//提现  
        $list1 = [];//赠课
        $list4 = [];//教练工资和平台支出;
        $list_income1 = [];
        $list_income2 = [];
        // 活动订单收入 
        $income2 = db('income')->field("sum(income) as s_income,from_unixtime(schedule_time,'%Y%m%d') as days,sum(schedule_income) as s_schedule_income")->where(['camp_id'=>$camp_id,'type'=>2])->where(['schedule_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();
        if($this->campInfo['rebate_type'] == 1 && $month_end){
            //课时收入
            $income3 = db('income')->field("sum(income) as s_income,from_unixtime(schedule_time,'%Y%m%d') as days,sum(schedule_income) as s_schedule_income")->where(['camp_id'=>$camp_id,'type'=>3])->where(['schedule_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();
            // echo db('income')->getlastsql();
            // dump($income3);die;  
            //课时薪资和平台支出
            $schedule =  db('schedule')->field("sum(s_coach_salary+s_assistant_salary) as s_s_salary,from_unixtime(lesson_time,'%Y%m%d') as days,sum(cost*students*schedule_rebate) as s_s_rebate,is_settle,camp_id")->where(['camp_id'=>$camp_id,'is_settle'=>1])->where(['lesson_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();
            // echo db('schedule')->getlastsql();
            // dump($schedule);die;
            
            // 提现支出
            $output = db('output')->field("sum(output) as s_output,from_unixtime(create_time,'%Y%m%d') as days")->where(['camp_id'=>$camp_id,'type'=>-1])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();
            //赠课支出
            $output_gift = db('output')->field("sum(output) as s_output,from_unixtime(create_time,'%Y%m%d') as days")->where(['camp_id'=>$camp_id,'type'=>1])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();

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
            $this->assign('list4',$list4);//课时收入
            $this->assign('list3',$list3);//课时收入
            $this->assign('list2',$list2);//活动收入
            $this->assign('list_1',$list_1);//提现   
            $this->assign('list1',$list1);//赠课
            return view('StatisticsCamp/campBill');
        }elseif ($this->campInfo['rebate_type'] == 1 && !$month_end) {
            $this->assign('list4',$list4);//课时收入
            $this->assign('list3',$list3);//课时收入
            $this->assign('list2',$list2);//活动收入
            $this->assign('list_1',$list_1);//提现   
            $this->assign('list1',$list1);//赠课
            return view('StatisticsCamp/campBill');
        }elseif ($this->campInfo['rebate_type'] == 2 && $month_end) {

            $list1 = []; $list2 = []; $list3 = []; $list4 = []; $list_1 = []; $list_income1 = []; $list_income2 = [];
            // 课程订单收入
            $income1 = db('income')->field("sum(income) as s_income,from_unixtime(create_time,'%Y%m%d') as days,sum(schedule_income) as s_schedule_income,camp_id")->where(['camp_id'=>$camp_id,'type'=>1])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();
            // 赠课支出
            $output1 = db('output')->field("sum(output) as s_output,from_unixtime(create_time,'%Y%m%d') as days,camp_id")->where(['camp_id'=>$camp_id,'type'=>1])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();
            // 课时退费
            $output2 = db('output')->field("sum(output) as s_output,from_unixtime(create_time,'%Y%m%d') as days,camp_id")->where(['camp_id'=>$camp_id,'type'=>2])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();
            // 提现
            $output_1 = db('output')->field("sum(output) as s_output,from_unixtime(create_time,'%Y%m%d') as days,camp_id")->where(['camp_id'=>$camp_id,'type'=>-1])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();
            // 课时教练支出
            $output3 = db('output')->field("sum(output.output) as s_output,output.camp_id,from_unixtime(output.schedule_time,'%Y%m%d') as days,sum(schedule.schedule_income) as s_schedule_income")->join('schedule','schedule.id=output.f_id')->where(['output.camp_id'=>$camp_id,'output.type'=>3])->where(['output.create_time'=>['between',[$month_start,$month_end]]])->where('output.delete_time',null)->group('days')->order('output.id desc')->select();

            //平台分成
            $output4 = db('output')->field("sum(output) as s_output,from_unixtime(create_time,'%Y%m%d') as days,camp_id")->where(['camp_id'=>$camp_id,'type'=>4])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();

            
            for ($i=$monthStart; $i <= $monthEnd; $i++) { 
                $list1[$i]  = $list2[$i] = $list3[$i] = $list4[$i] = $list_1[$i] = ['s_output'=>0.00,'s_schedule_income'=>0,'camp_id'=>0];
                $list_income1[$i] = $list_income2[$i] = ['s_income'=>0.00,'camp_id'=>0];
            }
            foreach ($list1 as $key => &$value) {
                foreach ($output1 as $k => $val) {
                    if($key == $val['days']){
                        $value = $val;
                    }
                }
            } 
            foreach ($list2 as $key => &$value) {
                foreach ($output2 as $k => $val) {
                    if($key == $val['days']){
                        $value = $val;
                    }
                }
            } 
            foreach ($list3 as $key => &$value) {
                foreach ($output3 as $k => $val) {
                    if($key == $val['days']){
                        $value = $val;
                    }
                }
            } 
            foreach ($list4 as $key => &$value) {
                foreach ($output4 as $k => $val) {
                    if($key == $val['days']){
                        $value = $val;
                    }
                }
            }  
            foreach ($list_1 as $key => &$value) {
                foreach ($output_1 as $k => $val) {
                    if($key == $val['days']){
                        $value = $val;
                    }
                }
            } 
            foreach ($list_income1 as $key => &$value) {
                foreach ($income1 as $k => $val) {
                    if($key == $val['days']){
                        $value = $val;
                    }
                }
            } 
            foreach ($list_income2 as $key => &$value) {
                foreach ($income2 as $k => $val) {
                    if($key == $val['days']){
                        $value = $val;
                    }
                }
            }
            $this->assign('list1',$list1);
            $this->assign('list2',$list2);
            $this->assign('list3',$list3);
            $this->assign('list4',$list4);
            $this->assign('list_1',$list_1);
            $this->assign('list_income1',$list_income1);
            $this->assign('list_income2',$list_income2);
            return view('StatisticsCamp/orgzBill');
        }elseif ($this->campInfo['rebate_type'] == 1 && !$month_end) {

            $this->assign('list1',$list1);
            $this->assign('list2',$list2);
            $this->assign('list3',$list3);
            $this->assign('list4',$list4);
            $this->assign('list_1',$list_1);
            $this->assign('list_income1',$list_income1);
            $this->assign('list_income2',$list_income2);
            return view('StatisticsCamp/orgzBill');
        }
    }

    //收益统计
    public function campIncome(){
        $camp_id = $this->camp_member['camp_id'];
        $monthStart = input('param.monthstart',date('Ymd',strtotime('-1 month', strtotime("first day of this month"))));
        $monthEnd = input('param.monthend',date('Ymd'));
        $month_start = strtotime($monthStart);
        $month_end = strtotime($monthEnd)+86399;
        $income = [];
        $list2 = [];//活动收入
        $list3 = [];//课时收入
        $income2 = db('income')->field("sum(income) as s_income,count('id') as c_id,sum(total) as s_total,goods_id,goods,camp,price,f_id,camp_id")
        ->where(['camp_id'=>$camp_id,'type'=>2])
        ->where(['create_time'=>['between',[$month_start,$month_end]]])
        ->where('delete_time',null)
        ->group('goods_id')->select();
        $list2 = $income2;
        // $totalEventList = db('income')->field("sum(income) as s_income,count('id') as c_id,sum(total) as s_total,goods,goods_id,camp,price,f_id,camp_id")
        //     ->where(['camp_id'=>$camp_id,'type'=>2])
        //     ->where('delete_time',null)
        //     ->find();
            // dump($totalEventList);
        if($this->campInfo['rebate_type'] == 1){
            $income3 = db('income')->field("sum(income) as s_income,sum(schedule_income) as s_schedule_income,count('id') as c_id,sum(students) as s_students,lesson,goods,camp,camp_id,lesson_id")
            ->where(['camp_id'=>$camp_id,'type'=>3])
            ->where(['schedule_time'=>['between',[$month_start,$month_end]]])
            ->where('delete_time',null)
            ->group('lesson_id')->select(); 

            // $totalLessonList = db('income')->field("sum(income) as s_income,count('id') as c_id,sum(students) as s_total,goods,goods_id,camp,price,f_id,camp_id")
            // ->where(['camp_id'=>$camp_id,'type'=>3])
            // ->where('delete_time',null)
            // ->find();

            

            $list3 = $income3;
            $this->assign('list2',$list2);
            $this->assign('list3',$list3);
            // $this->assign('totalEventList',$totalEventList);
            // $this->assign('totalLessonList',$totalLessonList);
            return view('StatisticsCamp/campIncome'); 
        }else{
            $income1 = db('income')->field("sum(income) as s_income,count('id') as c_id,sum(total) as s_total,goods,goods_id,camp,price,f_id,camp_id")
            ->where(['camp_id'=>$camp_id,'type'=>1])
            ->where(['create_time'=>['between',[$month_start,$month_end]]])
            ->where('delete_time',null)
            ->group('lesson_id')->select();

            // $totalLessonList = db('income')->field("sum(income) as s_income,count('id') as c_id,sum(total) as s_total,goods,goods_id,camp,price,f_id,camp_id")
            // ->where(['camp_id'=>$camp_id,'type'=>1])
            // ->where('delete_time',null)
            // ->find();

            $list1 = $income1;
            // $this->assign('totalEventList',$totalEventList);
            // $this->assign('totalLessonList',$totalLessonList);
            $this->assign('list2',$list2);
            $this->assign('list1',$list1);
            return view('StatisticsCamp/orgzIncome');
        }
        

        
    }

    // 图表统计
    public function campChart(){


        return view('StatisticsCamp/campChart');
    }

    // 营业额统计
    public function campTurnover(){
        $camp_id = $this->camp_member['camp_id'];
        $monthStart = input('param.monthstart',date('Ymd',strtotime('-1 month', strtotime("first day of this month"))));
        $monthEnd = input('param.monthend',date('Ymd'));
        $month_start = strtotime($monthStart);
        $month_end = strtotime($monthEnd)+86399;
        // 单独提取订单记录
        $lessonBill = db('bill')
        ->field("count(id) as c_id,sum(balance_pay) as total_pay,goods,goods_id,id")
        ->where(['camp_id'=>$camp_id,'goods_type'=>1,'is_pay'=>1])
        ->where(['create_time'=>['between',[$month_start,$month_end]]])
        ->where('delete_time',null)
        ->group('goods_id')->select();

        $eventBill = db('bill')
        ->field("count('id') as c_id,sum(balance_pay) as total_pay,goods,goods_id,id")
        ->where(['camp_id'=>$camp_id,'goods_type'=>2,'is_pay'=>1])
        ->where(['create_time'=>['between',[$month_start,$month_end]]])
        ->where('delete_time',null)
        ->group('goods_id')->select();
        
        // $totalEvent = 0;
        // $totalLesson = 0;
        // $totalEvent = 0;
        // $totalLesson = 0;
        // $totalEvent = db('bill')
        // ->where(['camp_id'=>$camp_id,'goods_type'=>2,'is_pay'=>1])
        // ->where('delete_time',null)
        // ->sum('balance_pay');
        // $totalLesson = db('bill')
        // ->where(['camp_id'=>$camp_id,'goods_type'=>1,'is_pay'=>1])
        // ->where('delete_time',null)
        // ->sum('balance_pay');



        // $this->assign('totalEvent',$totalEvent?$totalEvent:0);
        // $this->assign('totalLesson',$totalLesson?$totalLesson:0);
        $this->assign('lessonBill',$lessonBill);
        $this->assign('eventBill',$eventBill);
        return view('StatisticsCamp/campTurnover');
    }

    // 赠课统计
    public function campGift(){
        $camp_id = $this->camp_member['camp_id'];
        $monthStart = input('param.monthstart',date('Ymd',strtotime('-1 month', strtotime("first day of this month"))));
        $monthEnd = input('param.monthend',date('Ymd'));
        $month_start = strtotime($monthStart);
        $month_end = strtotime($monthEnd)+86399;
        $list = db('schedule_gift_student')
        ->field("*,from_unixtime(create_time,'%Y%m%d') as days")
        ->where(['camp_id'=>$camp_id])
        ->where(['create_time'=>['between',[$month_start,$month_end]]])
        ->where('delete_time',null)
        ->select();
        // dump($list);
        $this->assign('list',$list);
        return view('StatisticsCamp/campGift');
    }

    // 附加支出
    public function campOutput(){
        $camp_id = $this->camp_member['camp_id'];
        $campInfo = db('camp')->where(['id'=>$camp_id])->find();
        if(isPost()){
            $data = input('post.');
            $data['type'] = -2;
            $data['create_time'] = time();
            $data['system_remarks'] = "management_id:$this->management['id']";
            $result = db('output')->insert($data);
            if($result){
                $this->success('操作成功');
            }else{
                $this->success('操作失败');
            }
        }

        return $this->fetch('StatisticsCamp/campOutput');
    }

    // 每月报表
    public function campStatistics(){
        $camp_id = $this->camp_member['camp_id'];
        $monthStart = input('param.monthstart',date('Ymd',strtotime('-1 month', strtotime("first day of this month"))));
        $monthEnd = input('param.monthend',date('Ymd'));
        $month_start = strtotime($monthStart);
        $month_end = strtotime($monthEnd)+86399;
        if($this->campInfo['rebate_type'] == 1){
            //总活动订单收入 
            $income2 = db('income')->where(['camp_id'=>$camp_id,'type'=>2])->where(['schedule_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->sum('income');
            //总课时收入
            $income3 = db('income')->where(['camp_id'=>$camp_id,'type'=>3])->where(['schedule_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->sum('income');
            //总提现支出
            $output = db('output')->where(['camp_id'=>$camp_id,'type'=>-1])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->sum('output');
            //总赠课支出
            $output_gift = db('output')->where(['camp_id'=>$camp_id,'type'=>1])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->sum('output');
            //课时薪资
            $schedule =  db('schedule')->field("sum((coach_salary+assistant_salary+salary_base)*students) as s_s_salary,sum(cost*students*schedule_rebate) as s_s_rebate,is_settle,camp_id")->where(['camp_id'=>$camp_id,'is_settle'=>1])->where(['lesson_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->find();
            //其他支出
            $other_output = db('output')->where(['camp_id'=>$camp_id,'type'=>-2])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->sum('output');  
            $this->assign('income2',$income2?$income2:0);
            $this->assign('income3',$income3?$income3:0);
            $this->assign('output',$output?$output:0);
            $this->assign('output_gift',$output_gift?$output_gift:0);
            $this->assign('schedule',$schedule);
            $this->assign('other_output',$other_output?$other_output:0);
            return view('StatisticsCamp/campStatistics');          
        }else{
            //课程订单收入
            $income3 = db('income')->where(['camp_id'=>$camp_id,'type'=>1])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->sum('income');
            //活动订单收入 
            $income2 = db('income')->where(['camp_id'=>$camp_id,'type'=>2])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->sum('income');
            //提现支出
            $output = db('output')->where(['camp_id'=>$camp_id,'type'=>-1])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->sum('output');
            //赠课支出
            $output_gift = db('output')->where(['camp_id'=>$camp_id,'type'=>1])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->sum('output');
            // 教练工资支出
            $schedule = db('output')->where(['camp_id'=>$camp_id,'type'=>3])->where(['schedule_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->sum('output');
            //退费支出
            $output2 = db('output')->where(['camp_id'=>$camp_id,'type'=>-2])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->sum('output');
            // 平台分成
            $output4 =  db('output')->where(['camp_id'=>$camp_id,'type'=>4])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->sum('output');
            //其他支出
            $other_output = db('output')->where(['camp_id'=>$camp_id,'type'=>-2])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->sum('output');
            $this->assign('income2',$income2?$income2:0);
            $this->assign('income3',$income3?$income3:0);
            $this->assign('output',$output?$output:0);
            $this->assign('output_gift',$output_gift?$output_gift:0);
            $this->assign('schedule',$schedule?$schedule:0);
            $this->assign('output4',$output4?$output4:0);
            $this->assign('output2',$output2?$output2:0);
            $this->assign('other_output',$other_output?$other_output:0);

            return view('StatisticsCamp/orgzStatistics');       
        }

        


        
    }


    // 课时结算表
    public function lessonSchedule(){
        $lesson_id = input('param.lesson_id');
        $monthStart = input('param.monthstart',date('Ymd',strtotime('-1 month', strtotime("first day of this month"))));
        $monthEnd = input('param.monthend',date('Ymd'));
        $month_start = strtotime($monthStart);
        $month_end = strtotime($monthEnd)+86399;
        $camp_id = input('param.camp_id');
        $keyword = input('param.keyword');
        $member_id = input('param.member_id');
        $map['salary_in.camp_id'] = $this->camp_member['camp_id'];
        if($keyword){
            $map['salary_in.lesson'] = ['like'=>"%$keyword%"];
        }
        if($member_id){
            $map['salary_in.member_id'] = $member_id;
        }
        if($lesson_id){
            $map['salary_in.lesson_id'] = $lesson_id;
        }
        if(isset($map)){
            $scheduleList = db('salary_in')
            ->field('salary_in.*,schedule.student_str,schedule.coach,schedule.assistant,schedule.cost,schedule.coach_salary,schedule.assistant_salary,schedule.salary_base,schedule.schedule_rebate,schedule.schedule_income,schedule.lesson_time,schedule.students,schedule.can_settle_date')
            ->where($map)
            ->join('schedule','schedule.id = salary_in.schedule_id')
            ->where(['salary_in.schedule_time'=>['between',[$month_start,$month_end]]])
            ->group('schedule_id')
            ->select();

        }else{
            $scheduleList = [];
        }
        
        $this->assign('scheduleList',$scheduleList);

        return view('StatisticsCamp/lessonSchedule');
    }

    //课时统计
    public function campScheduleStatistics(){
        $camp_id = $this->camp_member['camp_id'];
        $monthStart = input('param.monthstart',date('Ymd',strtotime('-1 month', strtotime("first day of this month"))));
        $monthEnd = input('param.monthend',date('Ymd'));
        $month_start = strtotime($monthStart);
        $month_end = strtotime($monthEnd)+86399;
        // //总购买课时
        // $totalBuy = db('bill')
        // ->where(['camp_id'=>$camp_id,'goods_type'=>1,'is_pay'=>1])
        // // ->where(['create_time'=>['between',[$month_start,$month_end]]])
        // ->where('delete_time',null)
        // ->sum('total');
        // // 总赠送课时
        // $totalGift = db('schedule_gift_student')
        // ->where(['camp_id'=>$camp_id,'status'=>1])
        // // ->where(['create_time'=>['between',[$month_start,$month_end]]])
        // ->where('delete_time',null)
        // ->sum('gift_schedule');
        // //总已上课时
        // $totalSchedule = db('schedule_member')
        // ->where(['camp_id'=>$camp_id,'status'=>1,'type'=>1])
        // // ->where(['schedule_time'=>['between',[$month_start,$month_end]]])
        // ->where('delete_time',null)
        // ->count('id');

        $lessonList = db('lesson')->where(['camp_id'=>$camp_id])->select();
        $refundScheduleList = [];
        $totalRefundSchedule = 0;
        foreach ($lessonList as $key => $val) {
            //总退费课时
            $bill_2 = db('bill')
            ->field('sum(refundamount/price) as s_totalRefund')
            ->where(['camp_id'=>$camp_id,'goods_type'=>1,'is_pay'=>1,'status'=>-2,'goods_id'=>$val['id']])
            ->where(['create_time'=>['between',[$month_start,$month_end]]])
            ->where('delete_time',null)
            ->group('goods_id')
            ->find();
            if($bill_2){
                $refundScheduleList[$val['lesson']] = ['s_totalRefund'=>number_format($bill_2['s_totalRefund'],0)];
                $totalRefundSchedule = $bill_2['s_totalRefund'];
            }else{
                $$totalRefundSchedule = 0;
                $refundScheduleList[$val['lesson']] = ['s_totalRefund'=>0];
            }
            // 课时列表
            $bill1 = db('bill')
            ->field("sum(total) as s_total,goods,price")
            ->where(['camp_id'=>$camp_id,'goods_type'=>1,'is_pay'=>1,'goods_id'=>$val['id']])
            ->where(['create_time'=>['between',[$month_start,$month_end]]])
            ->where('delete_time',null)
            ->group('goods_id')
            ->find();
            if($bill1){
                $buyList[$val['lesson']] = $bill1;
            }else{
                $buyList[$val['lesson']] = ['s_total'=>0,'goods'=>$val['lesson'],'price'=>$val['cost']];
            }
            
            //赠送列表
            $list1 = db('schedule_gift_student')
            ->field("sum(gift_schedule) as s_gift_schedule,lesson,lesson_id")
            ->where(['camp_id'=>$camp_id,'status'=>1,'lesson_id'=>$val['id']])
            ->where(['create_time'=>['between',[$month_start,$month_end]]])
            ->where('delete_time',null)
            ->group('lesson_id')
            ->find();
            if($list1){
                $giftList[$val['lesson']] = $list1;
            }else{
                $giftList[$val['lesson']] = ['s_gift_schedule'=>0,'lesson'=>$val['lesson'],'lesson_id'=>$val['id']];
            }
            //已上课时列表
            $schedule1 = db('schedule')
            ->field("sum(students) as s_students,lesson_id,lesson")
            ->where(['camp_id'=>$camp_id,'is_settle'=>1,'lesson_id'=>$val['id']])
            ->where(['lesson_time'=>['between',[$month_start,$month_end]]])
            ->where('delete_time',null)
            ->group('lesson_id')
            ->find();
            if($schedule1){
                $totalScheduleList[$val['lesson']] = $schedule1;
            }else{
                $totalScheduleList[$val['lesson']] = ['s_students'=>0,'lesson'=>$val['lesson'],'lesson_id'=>$val['id']];
            }
        }
        
        // dump($buyList);die;

        $this->assign('giftList',$giftList);
        $this->assign('buyList',$buyList);
        $this->assign('totalScheduleList',$totalScheduleList);
        $this->assign('refundScheduleList',$refundScheduleList);
        // $this->assign('totalBuy',$totalBuy?$totalBuy:0);
        // $this->assign('totalGift',$totalGift?$totalGift:0);
        // $this->assign('totalSchedule',$totalSchedule?$totalSchedule:0);
        // $this->assign('totalRefundSchedule',$totalRefundSchedule?$totalRefundSchedule:0);
        return view('StatisticsCamp/campScheduleStatistics');
    }

    // 训练营订单列表
    public function campBillList(){
        $camp_id = $this->camp_member['camp_id'];
        $monthStart = input('param.monthstart',date('Ymd',strtotime('-1 month', strtotime("first day of this month"))));
        $monthEnd = input('param.monthend',date('Ymd'));
        $month_start = strtotime($monthStart);
        $month_end = strtotime($monthEnd)+86399;
        $goods_type = input('param.goods_type',1);
         $status = input('param.status');
        $keyword = input('param.keyword');
        $map = ['camp_id'=>$camp_id,'goods_type'=>$goods_type,'create_time'=>['between',[$month_start,$month_end]]];
        if($keyword){
            $map['member|student|goods'] = ['like',"%$keyword%"];
        }
        if($status){
            $map['status'] = $status;
        }
        $Bill = new \app\management\model\Bill;
        $list = $Bill->where($map)->where('delete_time',null)->select();
        $this->assign('list',$list);
        return $this->fetch('StatisticsCamp/campBillList');
    }
    // 训练营提现列表
    public function campWithdraw(){
        $camp_id = $this->camp_member['camp_id'];
        $monthStart = input('param.monthstart',date('Ymd',strtotime('-1 month', strtotime("first day of this month"))));
        $monthEnd = input('param.monthend',date('Ymd'));
        $month_start = strtotime($monthStart);
        $month_end = strtotime($monthEnd)+86399;
        //查询条件：camp_id，monthstart，monthend
        $list = db('output')
            ->where(['camp'=>$camp_id,'type'=>-1])
            ->where(['create_time'=>['between',[$month_start,$month_end]]])
            ->where('delete_time',null)->select();

        $this->assign('list',$list);
        return $this->fetch('StatisticsCamp/campWithdraw');
    }
    // 训练营工资列表月表（列出对应训练营所有的教练员当月的工资）
    public function campCoachSalaryMth(){
        $camp_id = $this->camp_member['camp_id'];
        $monthStart = input('param.monthstart',date('Ymd',strtotime('-1 month', strtotime("first day of this month"))));
        $monthEnd = input('param.monthend',date('Ymd'));
        $month_start = strtotime($monthStart);
        $month_end = strtotime($monthEnd)+86399;
        //查询条件：camp_id，monthstart，monthend
        $list = db('salary_in')
            ->field('sum(salary) as s_salary,sum(push_salary) as s_push_salary,count(id) as s_id,member,realname,member_id,camp_id,camp')
            ->where(['camp_id'=>$camp_id,'type'=>1])
            ->where(['schedule_time'=>['between',[$month_start,$month_end]]])
            ->where('delete_time',null)
            ->group('member_id')
            ->select();
        $this->assign('list',$list);
        return $this->fetch('StatisticsCamp/campCoachSalaryMth');
    }
    // 训练营工资列表（列出对应训练营下指定教练员当月的工资）
    public function campCoachSalary(){
        $camp_id = $this->camp_member['camp_id'];
        $member_id = input('member_id',0);
        $monthStart = input('param.monthstart',date('Ymd',strtotime('-1 month', strtotime("first day of this month"))));
        $monthEnd = input('param.monthend',date('Ymd'));
        $month_start = strtotime($monthStart);
        $month_end = strtotime($monthEnd)+86399;
        $list = db('salary_in')
            ->join('schedule','schedule.id=salary_in.schedule_id')
            ->where(['salary_in.camp_id'=>$camp_id,'type'=>1,'member_id'=>$member_id])
            ->where(['salary_in.schedule_time'=>['between',[$month_start,$month_end]]])
            ->where('salary_in.delete_time',null)
            ->order('salary_in.id desc')
            ->select();
        // echo db('salary_in')->getlastsql();
        // dump($list);
        $this->assign('list',$list);

        //查询条件：camp_id，member_id，monthstart，monthend
        return $this->fetch('StatisticsCamp/campCoachSalary');
    }


    // 退费列表
    public function refundList(){
        $camp_id = $this->camp_member['camp_id'];
        $map = ['camp_id'=>$camp_id];

        $Refund = new \app\model\Refund;
        $refundList = $Refund->with('bill')->where($map)->select();

        if($refundList){
            $refundList = $refundList->toArray();
        }else{
            $refundList = [];
        }  

        $this->assign('refundList',$refundList);
        return $this->fetch('StatisticsCamp/refundList');
    }

    // 退费处理
    public function refundDeal(){
        $refund_id = input('param.refund_id');
        if(request()->isPost()){
            $refund = input('param.refund');
            $remarks = input('param.remarks');
            $refund_type = input('param.refund_type');
            $status = input('param.status');
            
            $Refund = new \app\model\Refund;
            $refundInfo = $Refund->where(['id'=>$refund_id])->find();
            if($refundInfo){
                $this->error('传参错误');
            }
            $refundamount = $refundInfo['refundamount'];
            if($refundamount <= $refund){
                $this->error('打款金额不可大于退款金额');
            }
            if($this->campInfo['rebate_type'] == 1){
                $refund_fee = ($refundamount - $refund)*$this->campInfo['schedule_rebate'];
                $output = $refundamount - $refund - $refund_fee;
            }else{
                $refund_fee = 0;
                $output = 0;
            }
            

            $BillService = new \app\service\BillService;
            if($status > 1){
            
                $refundData = [
                    'refund'=>$refund,
                    'refund_fee'=>$refund_fee,
                    'remarks'=>$remarks,
                    'refund_type'=>$refund_type,
                    'process'=>$this->memberInfo['member'],
                    'process_id'=>$this->memberInfo['id'],
                    'process_time'=>time(),
                    'status'=>$status,
                    'agree_time'=>time()
                ]; 
                
                $res = $BillService->updateBill(['action'=>3,'output'=>$output],['id'=>$refundInfo['bill_id']],$refundData);
                if($res['code'] == 100){
                    $this->error($res['msg']);
                }
            }elseif ($status == -1) {
                $refundData = [
                    'refund'=>0,
                    'refund_fee'=>0,
                    'remarks'=>$remarks,
                    'refund_type'=>$refund_type,
                    'process'=>$this->memberInfo['member'],
                    'process_id'=>$this->memberInfo['id'],
                    'process_time'=>time(),
                    'status'=>$status,
                    'reject_time'=>time()
                ]; 
                
                $res = $BillService->updateBill(['action'=>4,'output'=>0],['id'=>$refundInfo['bill_id']],$refundData);
                if($res['code'] == 100){
                    $this->error($res['msg']);
                }
            }else{
                $this->error('传参错误');
            }
            if ($status == 3) {
                if($this->campInfo['rebate_type'] == 1){
                    $this->error('训练营为[课时版结算],不可以操作打款');
                }
                //训练营营业额支出
                db('output')->insert([
                    'output'        => $output,
                    'camp_id'       => $refundInfo['camp_id'],
                    'camp'          => $refundInfo['camp'],
                    'member_id'     => $refundInfo['member_id'],
                    'member'        => $refundInfo['member'],
                    'type'          => 2,
                    'e_balance'     =>($this->campInfo['balance'] - $output),
                    's_balance'     =>$this->campInfo['balance'],
                    'f_id'          =>$refundInfo['id'],
                    'create_time'   => time(),
                    'update_time'   => time(),
                ]);
                // 减少训练营营业额
                db('camp')->where(['id'=>$refundInfo['camp_id']])->dec('balance',$output)->update();
                $Refund->where(['id'=>$refund_id])->save(['status'=>3]);
            }
            $this->success('操作成功');    
        }else{
            $Refund = new \app\model\Refund;
            $refundInfo = $Refund
                        ->with('bill')
                        ->where(['id'=>$refund_id])
                        ->find();    
            $this->assign('refundInfo',$refundInfo);

            return $this->fetch('StatisticsCamp/refundDeal');
        }
        
    }
}