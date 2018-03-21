<?php 
namespace app\admin\controller;
use app\admin\controller\base\Backend;

class StatisticsCoach extends Backend{

	public function _initialize(){
		parent::_initialize();
	}

    public function demo(){
        return view('StatisticsCoach/demo');
    }
    // 资金账目
    public function coachBill(){
        $member_id = input('param.member_id');   
        $monthStart = input('param.monthstart',date('Ymd',strtotime('-1 month', strtotime("first day of this month"))));
        $monthEnd = input('param.monthend',date('Ymd'));
        $month_start = strtotime($monthStart);
        $month_end = strtotime($monthEnd)+86399;
        $salaryin = [];
        $list1 = [];
        $list2 = [];
        $s_rebate = 0;
        $yearmonth = input('param.yearmonth',(date('Ym')-1));
        if($member_id){
            $map['create_time'] = ['between',[$month_start,$month_end]];
            $map['member_id'] = $member_id;
            $salaryinList = db('salary_in')->field("*,sum(salary) as s_salary,sum(push_salary) as s_push_salary,from_unixtime(create_time,'%Y%m%d') as days")->where($map)->group('days')->order('days')->select();
   
            
            for ($i=$monthStart; $i <= $monthEnd; $i++) { 
                $list1[$i] = ['s_salary'=>0,'s_push_salary'=>0];
                $list2[$i] = ['s_salary'=>0];
            }

            foreach ($list1 as $key => &$value) {
                foreach ($salaryinList as $k => $val) {
                    if($key == $val['days']){
                        $value = $val;
                    }
                }
            }

            $salaryoutList = db('salary_out')->field("*,sum(salary) as s_salary,from_unixtime(create_time,'%Y%m%d') as days")->where($map)->group('days')->order('days')->select();

            foreach ($list2 as $key => &$value) {
                foreach ($salaryoutList as $k => $val) {
                    if($key == $val['days']){
                        $value = $val;
                    }
                }
            }

            $s_rebate = db('rebate')->where(['member_id'=>$member_id,'datemonth'=>$yearmonth])->sum('salary');
            
        }
        // dump($list2);
        // dump($list1);die;
        $this->assign('list2',$list2);
        $this->assign('list1',$list1);
        $this->assign('s_rebate',$s_rebate);
        return view('StatisticsCoach/coachBill');
    }


    // 收益统计
    public function coachIncome(){
        $member_id = input('member_id');
        $c_id = 0;
        $s_salary = 0;
        $s_students = 0;
        $s_push_salary = 0;
        $s_rebate = 0;
        $salaryinList = [];
        $rebateList = [];
        if($member_id){
            $yearmonth = input('param.yearmonth',(date('Ym')-1));
            $monthStart = input('param.monthstart',date('Ymd',strtotime('-1 month', strtotime("first day of this month"))));
            $monthEnd = input('param.monthend',date('Ymd'));
            $month_start = strtotime($monthStart);
            $month_end = strtotime($monthEnd)+86399;
            $salaryinList = db('salary_in')->field('*,sum(salary) as s_salary,sum(push_salary) as s_push_salary,sum(students) as s_students,count(id) as c_id')->where(['member_id'=>$member_id,'schedule_time'=>['between',[$month_start,$month_end]]])->group('lesson_id')->select();
            foreach ($salaryinList as $key => $value) {
                $c_id += $value['c_id'];
                $s_salary = $value['s_salary'];
                $s_students = $value['s_students'];
                $s_push_salary = $value['s_push_salary']; 
            }

            $rebateList = db('rebate')->where(['member_id'=>$member_id,'datemonth'=>$yearmonth])->select();
            
            foreach ($rebateList as $key => $value) {
                $s_rebate += $value['salary'];
            }
        }
        
        $this->assign('c_id',$c_id);
        $this->assign('s_salary',$s_salary);
        $this->assign('s_students',$s_students);
        $this->assign('s_push_salary',$s_push_salary);
        $this->assign('salaryinList',$salaryinList);
        $this->assign('rebateList',$rebateList);
        $this->assign('s_rebate',$s_rebate);
        return view('StatisticsCoach/coachIncome');
    }


    // 课时统计
    public function coachSchedule(){
        $map = input('param.');
        $map = ['lesson_id'=>13,'coach_id'=>7];
        $scheduleList = db('schedule')->where($map)->select();

        foreach ($scheduleList as $key => &$value) {
            $value['studentList'] = unserialize($value['student_str']); 
            $value['lessonTime'] = date('Y-m-d',$value['lesson_time']);
        }
        // dump($scheduleList);
        $this->assign('scheduleList',$scheduleList);
        return view('StatisticsCoach/coachSchedule');
    }

    // 个人（教练）工资列表（列出教练员当月的工资）//准哥写的，待丽文检查
    public function coachSalary(){
        $member_id = input('member_id',0);
        $monthStart = input('param.monthstart',date('Ymd',strtotime('-1 month', strtotime("first day of this month"))));
        $monthEnd = input('param.monthend',date('Ymd'));
        $month_start = strtotime($monthStart);
        $month_end = strtotime($monthEnd)+86399;
        $list = db('salary_in')
            ->join('schedule','schedule.id=salary_in.schedule_id')
            ->where(['type'=>1,'member_id'=>$member_id])
            ->where(['salary_in.schedule_time'=>['between',[$month_start,$month_end]]])
            ->where('salary_in.delete_time',null)
            ->order('salary_in.id desc')
            ->select();
        // echo db('salary_in')->getlastsql();
        // dump($list);
        $this->assign('list',$list);

        return $this->fetch('StatisticsCoach/coachSalary');
    }

    // 个人（教练）提现列表  //准哥写的，待丽文检查
    public function coachWithdraw(){
        $member_id = input('member_id',0);
        $monthStart = input('param.monthstart',date('Ymd',strtotime('-1 month', strtotime("first day of this month"))));
        $monthEnd = input('param.monthend',date('Ymd'));
        $month_start = strtotime($monthStart);
        $month_end = strtotime($monthEnd)+86399;
        //查询条件：member_id，monthstart，monthend
        $list = db('salary_out')
            ->where(['member_id'=>$member_id,'status'=>1])
            ->where(['pay_time'=>['between',[$month_start,$month_end]]])
            ->where('delete_time',null)->select();

        $this->assign('list',$list);

        return $this->fetch('StatisticsCoach/coachWithdraw');
    }
    
}