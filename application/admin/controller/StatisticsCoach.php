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
        $member_id = input('param.member_id',19);
            
        $monthStart = input('param.monthstart',date('Ymd',strtotime('-1 month', strtotime("first day of this month"))));
        $monthEnd = input('param.monthend',date('Ymd'));
        $camp_id = $this->cur_camp['camp_id'];
        $map['camp_id'] = $camp_id;
        $salaryinList = db('salary_in')->field("*,sum(salary) as s_salary,sum(push_salary) as s_push_salary,from_unixtime(create_time,'%Y%m%d') as days")->where(['member_id'=>$member_id])->group('days')->order('days')->select();
        // dump($salaryinList);die;
        $salaryin = [];
        $list1 = [];
        $list2 = [];
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

        $salaryoutList = db('salary_out')->field("*,sum(salary) as s_salary,from_unixtime(create_time,'%Y%m%d') as days")->where(['member_id'=>$member_id])->group('days')->order('days')->select();

        foreach ($list2 as $key => &$value) {
            foreach ($salaryoutList as $k => $val) {
                if($key == $val['days']){
                    $value = $val;
                }
            }
        }
        // dump($list1);die;
        $this->assign('list2',$list2);
        $this->assign('list1',$list1);
        return view('StatisticsCoach/coachBill');
    }


    // 收益统计
    public function coachIncome(){
        $member_id = input('member_id',19);
        $monthStart = input('param.monthstart',date('Ymd',strtotime('-1 month', strtotime("first day of this month"))));
        $monthEnd = input('param.monthend',date('Ymd'));
        $salaryinList = db('salary_in')->field('*,sum(salary) as s_salary,sum(push_salary) as s_push_salary,sum(students) as s_students,count(id) as c_id')->where(['member_id'=>$member_id])->group('lesson_id')->select();
        $c_id = 0;
        $s_salary = 0;
        $s_students = 0;
        $s_push_salary = 0;
        foreach ($salaryinList as $key => $value) {
            $c_id += $value['c_id'];
            $s_salary = $value['s_salary'];
            $s_students = $value['s_students'];
            $s_push_salary = $value['s_push_salary']; 
        }

        $rebateList = db('rebate')->where(['member_id'=>2])->select();
        $s_rebate = 0;
        foreach ($rebateList as $key => $value) {
            $s_rebate += $value['salary'];
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

    
}