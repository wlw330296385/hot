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
        // 每日定时任务列表
        // $sql = db('crontab_record')->order('create_time desc')->select(false);//不支持mariaDB
        // $crontabList = Db::query("select * from ($sql) as a group by crontab");//不支持mariaDB
        // $sql = "select * from crontab_record where id in(select max(id) from crontab_record group by crontab) order by create_time";
        // $crontabList =  Db::query($sql);//在mysql上效率太差,但是mariaDB就还好
        $crontabList = [];
        // 未处理异常数
        $exceptionCount = db('log_exception')->where(['status'=>0])->where('delete_time',null)->count();

    	$this->assign('memberCount',$memberCount);
    	$this->assign('campCount',$campCount);
        $this->assign('crontabList',$crontabList);
    	$this->assign('coachCount1',$coachCount1);
        $this->assign('coachCount2',$coachCount2);
        $this->assign('courtCount',$courtCount);

        $this->assign('lessonCount',$lessonCount);
        $this->assign('eventCount',$eventCount);
    	$this->assign('gradeCount',$gradeCount);
        $this->assign('studentCount',$studentCount);
        $this->assign('scheduleCount',$scheduleCount);
        $this->assign('refereeCount',$refereeCount);

        $this->assign('exceptionCount',$exceptionCount);
        return view();
    }
}
