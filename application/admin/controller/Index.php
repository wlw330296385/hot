<?php
namespace app\admin\controller;

use app\admin\controller\base\Backend;
use think\Db;
class Index extends Backend {
	public function _initialize(){
		parent::_initialize();
	}
    public function index() {

    	// 平台注册量

    	$memberCount = db('member')->where('delete_time',null)->count();
    	$campCount = db('camp')->where('delete_time',null)->count();
    	$coachCount1 = db('coach')->where(['status'=>1])->where('delete_time',null)->count();
        $coachCount2 = db('coach')->where(['status'=>['<>',1]])->where('delete_time',null)->count();
    	$courtCount = db('court')->where('delete_time',null)->count();

        $lessonCount = db('lesson')->where(['status'=>1])->where('delete_time',null)->count();
        $eventCount = db('event')->where(['status'=>1])->where('delete_time',null)->count();
        $gradeCount = db('grade')->where(['status'=>1])->where('delete_time',null)->count();
        $studentCount = db('student')->where(['status'=>1])->where('delete_time',null)->count();
        $scheduleCount = db('schedule')->where(['status'=>1])->where('delete_time',null)->count();
        $refereeCount = db('referee')->where(['status'=>1])->where('delete_time',null)->count();
        

        // 教学点分布
        $gradeCourt = db('grade')->field('sum(students) as s_students,court')->where(['status'=>1])->group('court_id')->select();
        $gradeCourtData = [];
        foreach ($gradeCourt as $key => $value) {
            $gradeCourtData['legend'][] = $value['court'];
            $gradeCourtData['series'][] = ['value'=>$value['s_students'],'name'=>$value['court']];
        }


        // 课程购买饼图
        $lessonBuy = db('bill')->field("sum(total) as s_total,goods,goods_id")->where(['is_pay'=>1,'goods_type'=>1])->group('goods_id')->select();
        $lessonBuyData = [];
        foreach ($lessonBuy as $key => $value) {
            $lessonBuyData['legend'][] = $value['goods'];
            $lessonBuyData['series'][] = ['value'=>$value['s_total'],'name'=>$value['goods']];
        }

        //平台收入
        $incomeList = db('sys_income')->field("sum(income) as s_income,from_unixtime(create_time,'%Y年%m月') as months")->group('months')->order('months')->select();
        $monthI = [];
        $dataI = [];
        foreach ($incomeList as $key => $value) {
            $monthI[] = $value['months'];
            $dataI[] = $value['s_income'];
        }    
        //平台支出
        $outputList = db('sys_output')->field("sum(output) as s_income,from_unixtime(create_time,'%Y年%m月') as months")->group('months')->order('months')->select();
        $monthO = [];
        $dataO = [];
        foreach ($outputList as $key => $value) {
            $monthO[] = $value['months'];
            $dataO[] = $value['s_income'];
        } 

        // 平台总营收
        $totalIncome = db('sys_income')->sum('income');

        //平台总支出
        $totalOutput = db('sys_output')->sum('output');


        //平台总订单
        $totalBill = db('bill')->where(['is_pay'=>1])->sum('balance_pay');

        //总课时
        $totalSchedule = db('schedule')->where('delete_time',null)->count();

        //总上课人次
        $totalScheduleStudent = db('schedule')->where('delete_time',null)->sum('students');

        //总提现
        $totalWithdraw1 = db('camp_withdraw')->where(['status'=>['egt',2]])->sum('withdraw');
        $totalWithdraw2 = db('salary_out')->where(['status'=>['egt',1]])->sum('salary');

    	$this->assign('memberCount',$memberCount);
    	$this->assign('campCount',$campCount);
    	$this->assign('coachCount1',$coachCount1);
        $this->assign('coachCount2',$coachCount2);
        $this->assign('courtCount',$courtCount);
        $this->assign('lessonCount',$lessonCount);
        $this->assign('eventCount',$eventCount);
    	$this->assign('gradeCount',$gradeCount);
        $this->assign('studentCount',$studentCount);
        $this->assign('scheduleCount',$scheduleCount);
        $this->assign('refereeCount',$refereeCount);


        // 图表数据
        $this->assign('lessonBuyData',json_encode($lessonBuyData,true));
        $this->assign('gradeCourtData',json_encode($gradeCourtData,true));
        $this->assign('monthI',json_encode($monthI,true));
        $this->assign('dataI',json_encode($dataI,true));
        $this->assign('monthO',json_encode($monthO,true));
        $this->assign('dataO',json_encode($dataO,true));
        $this->assign('totalIncome',$totalIncome);
        $this->assign('totalOutput',$totalOutput);
        $this->assign('totalSchedule',$totalSchedule);
        $this->assign('totalScheduleStudent',$totalScheduleStudent);
        $this->assign('totalBill',$totalBill);
        $this->assign('totalWithdraw',$totalWithdraw1+$totalWithdraw2);


        return view();
    }


    public function index2(){
        // 每日定时任务列表
        // $sql = db('crontab_record')->order('create_time desc')->select(false);//不支持mariaDB
        // $crontabList = Db::query("select * from ($sql) as a group by crontab");//不支持mariaDB
        $sql = "select * from crontab_record where id in(select max(id) from crontab_record group by crontab) order by create_time";
        $crontabList =  Db::query($sql);//在mysql上效率太差,但是mariaDB就还好
        // $crontabList = [];
        // 未处理异常数
        $exceptionCount = db('log_exception')->where(['status'=>0])->where('delete_time',null)->count();

        $this->assign('exceptionCount',$exceptionCount);
        $this->assign('crontabList',$crontabList);

    }
}
