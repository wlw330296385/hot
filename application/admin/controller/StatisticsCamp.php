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
        $camp_id = $this->campInfo['id'];
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
        $camp_id = input('param.camp_id',9);
        $monthStart = input('param.monthstart',date('Ym',strtotime('-1 month', strtotime("first day of this month"))));
        $monthEnd = input('param.monthend',date('Ym'));
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
        $financeList = [];
        // 活动订单收入 
        $income2 = db('income')->field("sum(income) as s_income,from_unixtime(create_time,'%Y%m%d') as days,sum(schedule_income) as s_schedule_income")->where(['camp_id'=>$camp_id,'type'=>2])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();
        // 训练营余额
        $finance = db('daily_camp_finance')->field("e_balance,date_str as days")->where(['camp_id'=>$camp_id])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();
        
        if($this->campInfo['rebate_type'] == 1 && $camp_id){
    
            //课时收入
            $income3 = db('income')->field("sum(income) as s_income,from_unixtime(create_time,'%Y%m%d') as days,sum(schedule_income) as s_schedule_income")->where(['camp_id'=>$camp_id,'type'=>3])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();
 
            //课时薪资和平台支出
            $schedule =  db('schedule')->field("sum(s_coach_salary+s_assistant_salary) as s_s_salary,from_unixtime(finish_settle_time,'%Y%m%d') as days,sum(cost*students*schedule_rebate) as s_s_rebate,is_settle,camp_id")->where(['camp_id'=>$camp_id,'is_settle'=>1])->where(['lesson_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();

            // 提现支出
            $output = db('output')->field("sum(output) as s_output,from_unixtime(create_time,'%Y%m%d') as days")->where(['camp_id'=>$camp_id,'type'=>-1])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();
            //赠课支出
            $output_gift = db('output')->field("sum(output) as s_output,from_unixtime(create_time,'%Y%m%d') as days")->where(['camp_id'=>$camp_id,'type'=>1])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();

            //月份
            for ($i=$monthStart; $i <= $monthEnd; $i++) { 
                $list3[$i]  = ['s_income'=>0,'s_schedule_income'=>0];
                $list2[$i]  = ['s_income'=>0];
                $list_1[$i] = ['s_output'=>0];
                $list1[$i]  = ['s_output'=>0];
                $list4[$i]  = ['s_s_rebate'=>0,'s_s_salary'=>0];
                $financeList[$i] = ['e_balance'=>0];
            }

            // 课时收入
            foreach ($list3 as $key => &$value) {
                foreach ($income3 as $k => $val) {
                    if($key == $val['days']){
                        $value = $val;
                    }
                }
            }  

            // 活动收入
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

            //赠课支出
            foreach ($list1 as $key => &$value) {
                foreach ($output_gift as $k => $val) {
                    if($key == $val['days']){
                        $value = $val;
                    }
                }
            }

             //课时薪资和平台支出
            foreach ($list4 as $key => &$value) {
                foreach ($schedule as $k => $val) {
                    if($key == $val['days']){
                        $value = $val;
                    }
                }
            }

            // 课程订单收入
            foreach ($financeList as $key => &$value) {
                foreach ($finance as $k => $val) {
                    if($key == $val['days']){
                        $value = $val;
                    }
                }
            }
            $this->assign('list4',$list4);//课时收入
            $this->assign('financeList',$financeList);//每日余额
            $this->assign('list3',$list3);//课时收入
            $this->assign('list2',$list2);//活动收入
            $this->assign('list_1',$list_1);//提现   
            $this->assign('list1',$list1);//赠课
            return view('StatisticsCamp/campBill');
        }elseif ($this->campInfo['rebate_type'] == 1 && !$camp_id) {
     
            $this->assign('list4',$list4);//课时收入
            $this->assign('financeList',$financeList);//每日余额
            $this->assign('list3',$list3);//课时收入
            $this->assign('list2',$list2);//活动收入
            $this->assign('list_1',$list_1);//提现   
            $this->assign('list1',$list1);//赠课
            return view('StatisticsCamp/campBill');
        }elseif ($this->campInfo['rebate_type'] == 2 && $camp_id) {
            $list1 = []; $list2 = []; $list3 = []; $list4 = []; $list_1 = []; $list_income1 = []; $list_income2 = [];
            // 课程订单收入
            $income1 = db('income')->field("sum(income) as s_income,from_unixtime(create_time,'%Y%m%d') as days,camp_id")->where(['camp_id'=>$camp_id,'type'=>1])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();
            // 赠课支出
            $output1 = db('output')->field("sum(output) as s_output,from_unixtime(create_time,'%Y%m%d') as days,camp_id")->where(['camp_id'=>$camp_id,'type'=>1])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();
            // 课时退费
            $output2 = db('output')->field("sum(output) as s_output,from_unixtime(create_time,'%Y%m%d') as days,camp_id")->where(['camp_id'=>$camp_id,'type'=>2])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();
            // 提现
            $output_1 = db('output')->field("sum(output) as s_output,from_unixtime(create_time,'%Y%m%d') as days,camp_id")->where(['camp_id'=>$camp_id,'type'=>-1])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();
            // 课时教练支出
            $output3 = db('output')->field("sum(output.output) as s_output,output.camp_id,from_unixtime(output.create_time,'%Y%m%d') as days,sum(schedule.schedule_income) as s_schedule_income")->join('schedule','schedule.id=output.f_id')->where(['output.camp_id'=>$camp_id,'output.type'=>3])->where(['output.create_time'=>['between',[$month_start,$month_end]]])->where('output.delete_time',null)->group('days')->order('output.id desc')->select();
             // 训练营余额
            $finance = db('daily_camp_finance')->field("e_balance,date_str as days")->where(['camp_id'=>$camp_id])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();
            //平台分成
            $output4 = db('output')->field("sum(output) as s_output,from_unixtime(create_time,'%Y%m%d') as days,camp_id")->where(['camp_id'=>$camp_id,'type'=>4])->where(['create_time'=>['between',[$month_start,$month_end]]])->where('delete_time',null)->group('days')->select();

            //初始变量
            for ($i=$monthStart; $i <= $monthEnd; $i++) { 
                $list1[$i]  = $list2[$i] = $list3[$i] = $list4[$i] = $list_1[$i] = ['s_output'=>0.00,'s_schedule_income'=>0,'camp_id'=>0,'s_income'=>0];
                $list_income1[$i] = $list_income2[$i] = ['s_income'=>0.00];
                $financeList[$i] = ['e_balance'=>0];
            }

            // 赠课支出
            foreach ($list1 as $key => &$value) {
                foreach ($output1 as $k => $val) {
                    if($key == $val['days']){
                        $value = $val;
                    }
                }
            } 

            // 课时退费
            foreach ($list2 as $key => &$value) {
                foreach ($output2 as $k => $val) {
                    if($key == $val['days']){
                        $value = $val;
                    }
                }
            } 

            // 课时教练支出
            foreach ($list3 as $key => &$value) {
                foreach ($output3 as $k => $val) {
                    if($key == $val['days']){
                        $value = $val;
                    }
                }
            } 

            //平台分成
            foreach ($list4 as $key => &$value) {
                foreach ($output4 as $k => $val) {
                    if($key == $val['days']){
                        $value = $val;
                    }
                }
            }  

            // 提现
            foreach ($list_1 as $key => &$value) {
                foreach ($output_1 as $k => $val) {
                    if($key == $val['days']){
                        $value = $val;
                    }
                }
            } 

            // 课程订单收入
            foreach ($list_income1 as $key => &$value) {
                foreach ($income1 as $k => $val) {
                    if($key == $val['days']){
                        $value = $val;
                    }
                }
            } 
            // 活动收入
            foreach ($list_income2 as $key => &$value) {
                foreach ($income2 as $k => $val) {
                    if($key == $val['days']){
                        $value = $val;
                    }
                }
            }

            // 每日余额
            foreach ($financeList as $key => &$value) {
                foreach ($finance as $k => $val) {
                    if($key == $val['days']){
                        $value = $val;
                    }
                }
            }

            $this->assign('list1',$list1);
            $this->assign('financeList',$financeList);//每日余额
            $this->assign('list2',$list2);
            $this->assign('list3',$list3);
            $this->assign('list4',$list4);
            $this->assign('list_1',$list_1);
            $this->assign('list_income1',$list_income1);//课时收入
            $this->assign('list_income2',$list_income2);//活动收入
            return view('StatisticsCamp/orgzBill');
        }elseif ($this->campInfo['rebate_type'] == 2 && !$camp_id) {

            $this->assign('list1',$list1);
            $this->assign('financeList',$financeList);//每日余额
            $this->assign('list2',$list2);
            $this->assign('list3',$list3);
            $this->assign('list4',$list4);
            $this->assign('list_1',$list_1);
            $this->assign('list_income1',$income1);
            $this->assign('list_income2',$income1);
            return view('StatisticsCamp/orgzBill');
        }
    }

    //收益统计
    public function campIncome(){
        $camp_id = $this->campInfo['id'];
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

            $totalLessonList = db('income')->field("sum(income) as s_income,count('id') as c_id,sum(students) as s_total,goods,goods_id,camp,price,f_id,camp_id")
            ->where(['camp_id'=>$camp_id,'type'=>3])
            ->where('delete_time',null)
            ->find();

            

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
        $camp_id = $this->campInfo['id'];
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

    // 赠课购买列表
    public function campGift(){
        $camp_id = $this->campInfo['id'];
        $lesson_id = input('param.lesson_id');
        $list = db('schedule_giftbuy')
        ->field('schedule_giftbuy.create_time,schedule_giftbuy.lesson_id,schedule_giftbuy.member,lesson.lesson,lesson.cost,lesson.total_giftschedule,lesson.resi_giftschedule,schedule_giftbuy.camp_id')
        ->join('lesson','lesson.id = schedule_giftbuy.lesson_id')
        ->where(['schedule_giftbuy.camp_id'=>$camp_id])
        ->where('schedule_giftbuy.delete_time',null)
        ->group('schedule_giftbuy.lesson_id')
        ->order('schedule_giftbuy.id asc')
        ->select();
        $this->assign('list',$list);
        return view('StatisticsCamp/campGift');
    }

    // 赠课详情
    public function campGiftInfo(){
        $camp_id = $this->campInfo['id'];
        $lesson_id= input('param.lesson_id');
        $ScheduleGiftrecord = new \app\model\ScheduleGiftrecord;
        if($lesson_id){
            $map = ['schedule_giftrecord.lesson_id'=>$lesson_id];
        }else{
            $map = ['schedule_giftrecord.camp_id'=>$camp_id];
        }
        
        $list = db('schedule_giftrecord')
        ->field('schedule_giftrecord.*,lesson.cost')
        ->join('lesson','lesson.id = schedule_giftrecord.lesson_id')
        ->where($map)
        ->where('schedule_giftrecord.delete_time',null)
        ->order('schedule_giftrecord.create_time desc')
        ->select();
        $lessonList = db('lesson')->where(['camp_id'=>$camp_id])->select();
        $this->assign('list',$list);
        $this->assign('lessonList',$lessonList);
        $this->assign('lesson_id',$lesson_id);
        return view('StatisticsCamp/campGiftInfo');
    }


    public function campGiftbuy(){
        $camp_id = $this->campInfo['id'];
        $lesson_id= input('param.lesson_id');
        $ScheduleGiftrecord = new \app\model\ScheduleGiftrecord;
        if($lesson_id){
            $map = ['schedule_giftbuy.lesson_id'=>$lesson_id];
        }else{
            $map = ['schedule_giftbuy.camp_id'=>$camp_id];
        }
        
        $list = db('schedule_giftbuy')
        ->field('schedule_giftbuy.*,lesson.cost')
        ->join('lesson','lesson.id = schedule_giftbuy.lesson_id')
        ->where($map)
        ->where('schedule_giftbuy.delete_time',null)
        ->order('schedule_giftbuy.create_time desc')
        ->select();
        $lessonList = db('lesson')->where(['camp_id'=>$camp_id])->select();
        $this->assign('list',$list);
        $this->assign('lessonList',$lessonList);
        $this->assign('lesson_id',$lesson_id);
        return view('StatisticsCamp/campGiftbuy');
    }


    // 附加支出
    public function campOutput(){
        $camp_id = $this->campInfo['id'];
        $campInfo = db('camp')->where(['id'=>$camp_id])->find();
        if(isPost()){
            $data = input('post.');
            $data['type'] = -2;
            $data['create_time'] = time();
            $data['system_remarks'] = "admin_id:$this->admin['id']";
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
        $camp_id = $this->campInfo['id'];
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


    // 课时详情
    public function lessonSchedule(){
        $lesson_id = input('param.lesson_id');
        $monthStart = input('param.monthstart',date('Ymd',strtotime('-1 month', strtotime("first day of this month"))));
        $monthEnd = input('param.monthend',date('Ymd'));
        $month_start = strtotime($monthStart);
        $month_end = strtotime($monthEnd)+86399;
        $camp_id = input('param.camp_id');
        $keyword = input('param.keyword');
        $member_id = input('param.member_id');
        if($camp_id){
            $map['salary_in.camp_id'] = $camp_id;
        }
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
            ->field('salary_in.*,schedule.student_str,schedule.coach,schedule.assistant,schedule.cost,schedule.coach_salary,schedule.assistant_salary,schedule.salary_base,schedule.schedule_rebate,schedule.schedule_income,schedule.lesson_time,schedule.students,schedule.rebate_type')
            ->where($map)
            ->join('schedule','schedule.id = salary_in.schedule_id')
            ->where(['salary_in.create_time'=>['between',[$month_start,$month_end]]])
            ->order('schedule.id desc')
            ->select();
        }else{
            $scheduleList = [];
        }
        
        
        $this->assign('scheduleList',$scheduleList);
        return view('StatisticsCamp/lessonSchedule');
    }


    public function excelLessonSchedule(){
        $lesson_id = input('param.lesson_id');
        $monthStart = input('param.monthstart',date('Ymd',strtotime('-1 month', strtotime("first day of this month"))));
        $monthEnd = input('param.monthend',date('Ymd'));
        $month_start = strtotime($monthStart);
        $month_end = strtotime($monthEnd)+86399;
        $camp_id = input('param.camp_id');
        $keyword = input('param.keyword');
        $member_id = input('param.member_id');
        if($camp_id){
            $map['salary_in.camp_id'] = $camp_id;
        }
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
            ->field('
                from_unixtime(schedule.lesson_time,"%Y-%m-%d %H:%i:%s") as l_t,
                salary_in.lesson,
                schedule.grade,
                schedule.students,
                schedule.student_str,
                salary_in.realname,
                (schedule.cost*schedule.students) as s_cost,
                (salary_in.push_salary+salary_in.salary) as s_salary,
                (schedule.cost*schedule.students*schedule.schedule_rebate) as rebate,
                (schedule.cost*schedule.students*(1-schedule.schedule_rebate)- schedule.s_coach_salary - schedule.s_assistant_salary) as camp_income,
                schedule.can_settle_date
                ')
            ->where($map)
            ->join('schedule','schedule.id = salary_in.schedule_id')
            ->where(['salary_in.create_time'=>['between',[$month_start,$month_end]]])
            ->order('schedule.id desc')
            ->select();
            foreach ($scheduleList as $key => $value) {
                $list = unserialize($value['student_str']);
                $student_str = '';
                foreach ($list as $k => $val) {
                    $student_str.=$val['student'].',';
                }
                $scheduleList[$key]['student_str'] = $student_str;
            }
            $xlsName  = "课时结算表";
            $xlsCell = [
                ['l_t','上课时间'],
                ['lesson','课程'],
                ['grade','班级'],
                ['students','学生人数'],
                ['student_str','学生'],
                ['realname','教练'],
                ['s_cost','课时总价'],
                ['s_salary','教练工资'],
                ['rebate','平台分成'],
                ['camp_income','训练营收入'],
                ['can_settle_date','结算日期'],
            ];
            $xlsData  = $scheduleList;
            exportExcel($xlsName,$xlsCell,$xlsData);
        }else{
            $this->error('数据为空,不生成excle');
        }
    }

    //课时统计
    public function campScheduleStatistics(){
        $camp_id = $this->campInfo['id'];
        $monthStart = input('param.monthstart',date('Ymd',strtotime('-1 month', strtotime("first day of this month"))));
        $monthEnd = input('param.monthend',date('Ymd'));
        $month_start = strtotime($monthStart);
        $month_end = strtotime($monthEnd)+86399;
        //总购买课时
        $totalBuy = db('bill')
        ->where(['camp_id'=>$camp_id,'goods_type'=>1,'is_pay'=>1])
        // ->where(['create_time'=>['between',[$month_start,$month_end]]])
        ->where('delete_time',null)
        ->sum('total');
        // 总赠送课时
        $totalGift = db('schedule_gift_student')
        ->where(['camp_id'=>$camp_id,'status'=>1])
        // ->where(['create_time'=>['between',[$month_start,$month_end]]])
        ->where('delete_time',null)
        ->sum('gift_schedule');
        //总已上课时
        $totalSchedule = db('schedule_member')
        ->where(['camp_id'=>$camp_id,'status'=>1,'type'=>1])
        // ->where(['schedule_time'=>['between',[$month_start,$month_end]]])
        ->where('delete_time',null)
        ->count('id');

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
            // dump($bill_2);die;
            if($bill_2){
                $totalRefundSchedule = $bill_2['s_totalRefund'];
            }else{
                $$totalRefundSchedule = 0;
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
        $this->assign('totalBuy',$totalBuy?$totalBuy:0);
        $this->assign('totalGift',$totalGift?$totalGift:0);
        $this->assign('totalSchedule',$totalSchedule?$totalSchedule:0);
        $this->assign('totalRefundSchedule',$totalRefundSchedule?$totalRefundSchedule:0);
        return view('StatisticsCamp/campScheduleStatistics');
    }

    // 训练营订单列表
    public function campBillList(){
        $camp_id = $this->campInfo['id'];
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
        $list = db('bill')->where($map)->where('delete_time',null)->select();
        //查询条件：camp_id，goods_type，monthstart，monthend
        // dump($list);
        $this->assign('list',$list);
        return $this->fetch('StatisticsCamp/campBillList');
    }
    // 训练营提现列表
    public function campWithdraw(){
        $camp_id = $this->campInfo['id'];
        $monthStart = input('param.monthstart',date('Ymd',strtotime('-1 month', strtotime("first day of this month"))));
        $monthEnd = input('param.monthend',date('Ymd'));
        $month_start = strtotime($monthStart);
        $month_end = strtotime($monthEnd)+86399;
        //查询条件：camp_id，monthstart，monthend
        $list = db('camp_withdraw')
            ->where(['camp_id'=>$camp_id])
            ->where(['create_time'=>['between',[$month_start,$month_end]]])
            ->where('delete_time',null)->select();
            // echo db('camp_withdraw')->getlastsql();
            // dump($list);
        $this->assign('list',$list);
        return $this->fetch('StatisticsCamp/campWithdraw');
    }
    // 训练营工资列表月表（列出对应训练营所有的教练员当月的工资）
    public function campCoachSalaryMth(){
        $camp_id = $this->campInfo['id'];
        $monthStart = input('param.monthstart',date('Ymd',strtotime('-1 month', strtotime("first day of this month"))));
        $monthEnd = input('param.monthend',date('Ymd'));
        $month_start = strtotime($monthStart);
        $month_end = strtotime($monthEnd)+86399;
        //查询条件：camp_id，monthstart，monthend
        $list = db('salary_in')
            ->field('sum(salary) as s_salary,sum(push_salary) as s_push_salary,count(id) as s_id,member,realname,member_id,camp_id,camp')
            ->where(['camp_id'=>$camp_id,'type'=>1])
            ->where(['create_time'=>['between',[$month_start,$month_end]]])
            ->where('delete_time',null)
            ->group('member_id')
            ->select();
        $this->assign('list',$list);
        return $this->fetch('StatisticsCamp/campCoachSalaryMth');
    }
    // 训练营工资列表（列出对应训练营下指定教练员当月的工资）
    public function campCoachSalary(){
        $camp_id = $this->campInfo['id'];
        $member_id = input('member_id',0);
        $monthStart = input('param.monthstart',date('Ymd',strtotime('-1 month', strtotime("first day of this month"))));
        $monthEnd = input('param.monthend',date('Ymd'));
        $month_start = strtotime($monthStart);
        $month_end = strtotime($monthEnd)+86399;
        $list = db('salary_in')
            ->join('schedule','schedule.id=salary_in.schedule_id')
            ->where(['salary_in.camp_id'=>$camp_id,'type'=>1,'member_id'=>$member_id])
            ->where(['salary_in.create_time'=>['between',[$month_start,$month_end]]])
            ->where('salary_in.delete_time',null)
            ->order('salary_in.id desc')
            ->select();
        // echo db('salary_in')->getlastsql();
        // dump($list);
        $this->assign('list',$list);

        //查询条件：camp_id，member_id，monthstart，monthend
        return $this->fetch('StatisticsCamp/campCoachSalary');
    }


    // 训练营工资列表（列出对应训练营下指定教练员当月的工资）
    public function campIndex(){

        //查询条件：camp_id，member_id，monthstart，monthend
        $campInfo = $this->campInfo;
        $Time = new \think\helper\Time;
        $campInfo = db('camp')->where(['id'=>$campInfo['id']])->find();


        if($campInfo['rebate_type'] == 2){//营业额版
            // 一个月的收益
            $monthIncome = db('income')->where(['camp_id'=>$campInfo['id']])->where('type','not in',[3,4])->whereTime('create_time','m')->where('delete_time',null)->sum('income');
            $monthOutput1 = db('output')->where(['camp_id'=>$campInfo['id']])->where('type',
                'not in',[1,3,-1,4])->whereTime('create_time','m')->where('delete_time',null)->sum('output');
            $monthOutput1 = $monthOutput1?$monthOutput1:0;
            $monthIncome = $monthIncome?$monthIncome:0;
            $monthIncome = $monthIncome - $monthOutput1;

            // 年收益
            $yearIncome = db('income')->where(['camp_id'=>$campInfo['id']])->where('type','not in',[3,4])->whereTime('create_time','y')->where('delete_time',null)->sum('income');
            $yearOutput1 = db('output')->where(['camp_id'=>$campInfo['id']])->where('type',
                'not in',[1,3,-1,4])->whereTime('create_time','y')->where('delete_time',null)->sum('output');

            $yearOutput1 = $yearOutput1?$yearOutput1:0;
            $yearIncome = $yearIncome?$yearIncome:0;
            $yearIncome = $yearIncome - $yearOutput1;
            // 总收益
            $totalIncome = db('income')->where(['camp_id'=>$campInfo['id']])->where('type','not in',[3,4])->where('delete_time',null)->sum('income');
            
            // 总支出
            $totalOuput = db('output')->where(['camp_id'=>$campInfo['id']])->where('type',
                'not in',[1,3,-1,4])->where('delete_time',null)->sum('output');
       
            $totalOuput = $totalOuput?$totalOuput:0;
            $totalIncome = $totalIncome?$totalIncome:0;
            $totalIncome = $totalIncome - $totalOuput;

        }else{//课时版
            // 一个月的收益
            $monthIncome = db('income')->where(['camp_id'=>$campInfo['id'],'type'=>3])->whereTime('schedule_time','m')->where('delete_time',null)->sum('income');

            // 一年的总收益
            $yearIncome = db('income')->where(['camp_id'=>$campInfo['id'],'type'=>3])->whereTime('schedule_time','y')->where('delete_time',null)->sum('income');

            // 总收益
            $totalIncome = db('income')->where(['camp_id'=>$campInfo['id'],'type'=>3])->where('delete_time',null)->sum('income');
        }   
        



        // 赠课总人数
        $totalGift = db('schedule_giftrecord')->where(['camp_id'=>$campInfo['id']])->where('delete_time',null)->sum('student_num');
        
        
        //总已上课量
        $totalSchedule = 0;
        $totalScheduleList = db('schedule')->where(['camp_id'=>$campInfo['id']])->where('delete_time',null)->select();
        $totalSchedule = count($totalScheduleList);
        // 上课总人次
        $totalStudents = 0;
        foreach ($totalScheduleList as $key => $value) {
            $totalStudents+=$value['students'];
        }
        //本月已上课量
        $monthSchedule = 0;
        $monthScheduleList = db('schedule')->where(['camp_id'=>$campInfo['id']])->whereTime('lesson_time','m')->where('delete_time',null)->select();
        $monthSchedule = count($monthScheduleList);
        // 本月上课总人次
        $monthStudents = 0;
        foreach ($monthScheduleList as $key => $value) {
            $monthStudents+=$value['students'];
        }

        //本年已上课量
        $yearSchedule = 0;
        $yearScheduleList = db('schedule')->where(['camp_id'=>$campInfo['id']])->whereTime('lesson_time','y')->where('delete_time',null)->select();
        $yearSchedule = count($yearScheduleList);
        // 本n年上课总人次
        $yearStudents = 0;
        foreach ($yearScheduleList as $key => $value) {
            $yearStudents+=$value['students'];
        }

        // 总营业额
        $totalBill = db('bill')->where(['camp_id'=>$campInfo['id'],'is_pay'=>1])->sum('balance_pay');
        //本月营业额
        $monthBill = db('bill')->where(['camp_id'=>$campInfo['id'],'is_pay'=>1])->whereTime('pay_time','m')->sum('balance_pay');
        //本年营业额
        $yearBill = db('bill')->where(['camp_id'=>$campInfo['id'],'is_pay'=>1])->whereTime('pay_time','y')->sum('balance_pay');

        // 月在学会员
        $monthCampStudents = db('monthly_students')->where(['camp_id'=>$campInfo['id']])->limit(2)->select();
        //年教学会员
        $y = date('Y',time());
        $y1 = $y*100+1;
        $yearCampStudents = db('monthly_students')->where(['camp_id'=>$campInfo['id'],'date_str'=>$y1])->find();
        // 本月新增会员
        $monthNewStudents = 0;
        $yearNewStudents = 0;
        //本月离营学员
        $monthofflineStudents = 0;
        $yearofflineStudents = 0;
        //在学会员
        $onlineStudents = 0;
        if (count($monthCampStudents) >1) {
            $monthNewStudents = $monthCampStudents[0]['online_students'] - $monthCampStudents[1]['online_students'];
            $monthofflineStudents = $monthCampStudents[0]['offline_students'] - $monthCampStudents[1]['offline_students'];
            if($yearCampStudents){
                $yearNewStudents = $monthCampStudents[0]['online_students'] - $yearCampStudents['online_students'];
                $yearofflineStudents = $monthCampStudents[0]['offline_students'] - $yearCampStudents['offline_students'];
            }
            $onlineStudents = $monthCampStudents[0]['onlesson_students'];
        }elseif (count($monthCampStudents) == 1){
            $monthNewStudents = $yearNewStudents = $monthCampStudents[0]['online_students'];
            $monthofflineStudents = $yearofflineStudents = $monthCampStudents[0]['offline_students'];
            $onlineStudents = $monthCampStudents[0]['onlesson_students'];
        }
        
        //历史学员
        $totalStudent = db('camp_member')->where(['camp_id'=>$campInfo['id'],'type'=>1])->count();
        




        // 月营业额总量曲线图
        $billList = db('bill')->field("sum(balance_pay) as s_balance_pay,from_unixtime(create_time,'%Y%m%d') as days,goods_type")->where(['camp_id'=>$campInfo['id'],'is_pay'=>1])->whereTime('create_time','m')->group('days')->select();
        $month = $Time::month();
        $lessonBill = [];
        $eventBill = [];

        $dateStart = date('Ymd',$month[0]);
        $dateEnd = date('Ymd',$month[1]);
        for ($i=$dateStart; $i <= $dateEnd ; $i++) { 
            $lessonBill[] = 0;
            $eventBill[] = 0;
        }

        foreach ($billList as $key => $value) {
            $kk = $value['days'] - $dateStart;
            if($value['goods_type'] == 1){
                
                // echo "$kk------{$value['days']}---{$value['s_balance_pay']}<br/>";
                $lessonBill[$kk] = $value['s_balance_pay'];

            }elseif ($value['goods_type'] == 2) {
                $eventBill[$kk] = $value['s_balance_pay'];
            }
        }



        // 教学点分布
        $gradeCourt = db('grade')->field('sum(students) as s_students,court')->where(['status'=>1,'camp_id'=>$campInfo['id']])->group('court_id')->select();
        $gradeCourtData = [];
        foreach ($gradeCourt as $key => $value) {
            $gradeCourtData['legend'][] = $value['court'];
            $gradeCourtData['series'][] = ['value'=>$value['s_students'],'name'=>$value['court']];
        }


        // 课程购买饼图
        $lessonBuy = db('bill')->field("sum(total) as s_total,goods,goods_id")->where(['camp_id'=>$campInfo['id'],'is_pay'=>1,'goods_type'=>1])->group('goods_id')->select();
        $lessonBuyData = [];
        foreach ($lessonBuy as $key => $value) {
            $lessonBuyData['legend'][] = $value['goods'];
            $lessonBuyData['series'][] = ['value'=>$value['s_total'],'name'=>$value['goods']];
        }

        // 年营业额折线图
        $billMonthList = db('bill')->field("sum(balance_pay) as s_balance_pay,from_unixtime(create_time,'%Y%m') as month,goods_type")->where(['camp_id'=>$campInfo['id'],'is_pay'=>1])->whereTime('create_time','y')->group('month')->select();
        $month = $Time::year();
        $lessonBillYear = [];
        $eventBillYear = [];

        $dateStartMonth = date('Ym',$month[0]);
        $dateEndMonth = date('Ym',$month[1]);
        for ($i=$dateStartMonth; $i <= $dateEndMonth ; $i++) { 
            $lessonBillYear[] = 0;
            $eventBillYear[] = 0;
        }

        foreach ($billMonthList as $key => $value) {
            $kk = $value['month'] - $dateStartMonth;
            if($value['goods_type'] == 1){
                $lessonBillYear[$kk] = $value['s_balance_pay'];

            }elseif ($value['goods_type'] == 2) {
                $eventBillYear[$kk] = $value['s_balance_pay'];
            }
        }



        // 学员总人数折线图(年)  
        $year = $Time::year();
        $yearStart = date('Ym',$year[0]);
        $yearEnd = date('Ym',$year[1]);
        $monthlyStudentsData = [0,0,0,0,0,0,0,0,0,0,0,0];
        $monthly_students = db('monthly_students')->where(['camp_id'=>$campInfo['id'],'date_str'=>['between',[$yearStart,$yearEnd]]])->column('online_students');
        foreach ($monthly_students as $key => $value) {
            $monthlyStudentsData[$key] = $value;
        }


        $monthlyCourtStudentsData = [];
        $monthly_court_students = db('monthly_court_students')->where(['camp_id'=>$campInfo['id'],'date_str'=>['between',[$yearStart,$yearEnd]]])->select();
        foreach ($monthly_court_students as $key => $value) {
            $monthlyCourtStudentsData[$key] = $value;
        }


        $this->assign('monthlyCourtStudentsData',json_encode($monthlyCourtStudentsData));
        $this->assign('monthlyStudentsData',json_encode($monthlyStudentsData));
        $this->assign('lessonBuyData',json_encode($lessonBuyData,true));
        $this->assign('gradeCourtData',json_encode($gradeCourtData,true));
        $this->assign('lessonBillYear',json_encode($lessonBillYear));
        $this->assign('eventBillYear',json_encode($eventBillYear));
        $this->assign('lessonBill',json_encode($lessonBill));
        $this->assign('eventBill',json_encode($eventBill));

        $this->assign('monthBill',$monthBill?$monthBill:0);
        $this->assign('yearBill',$yearBill?$yearBill:0);
        $this->assign('totalBill',$totalBill?$totalBill:0);

        $this->assign('monthIncome',$monthIncome?$monthIncome:0);
        $this->assign('yearIncome',$yearIncome?$yearIncome:0);   
        $this->assign('totalIncome',$totalIncome?$totalIncome:0);

        $this->assign('totalGift',$totalGift?$totalGift:0);

        $this->assign('totalStudents',$totalStudents?$totalStudents:0);
        $this->assign('totalStudent',$totalStudent?$totalStudent:0);
        $this->assign('monthStudents',$monthStudents?$monthStudents:0);
        $this->assign('monthSchedule',$monthSchedule?$monthSchedule:0);
        $this->assign('totalSchedule',$totalSchedule?$totalSchedule:0);
        $this->assign('yearStudents',$yearStudents?$yearStudents:0);
        $this->assign('yearSchedule',$yearSchedule?$yearSchedule:0);


        $this->assign('monthNewStudents',$monthNewStudents?$monthNewStudents:0);
        $this->assign('monthofflineStudents',$monthofflineStudents?$monthofflineStudents:0);
        $this->assign('onlineStudents',$onlineStudents?$onlineStudents:0);

        $this->assign('yearNewStudents',$yearNewStudents?$yearNewStudents:0);
        $this->assign('yearofflineStudents',$yearofflineStudents?$yearofflineStudents:0);
        return $this->fetch('StatisticsCamp/campIndex');
    }
}