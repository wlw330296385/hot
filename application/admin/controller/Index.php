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
    	$site = $this->site;
    	$memberCount = db('member')->where('delete_time',null)->count();
    	$campCount = db('camp')->where('delete_time',null)->count();
    	$coachCount = db('coach')->where('delete_time',null)->count();
    	$courtCount = db('court')->where('delete_time',null)->count();


        // 每日定时任务列表
        // $sql = db('crontab_record')->order('create_time desc')->select(false);//不支持mariaDB
        // $crontabList = Db::query("select * from ($sql) as a group by crontab");//不支持mariaDB
        // $sql = "select * from crontab_record where id in(select max(create_time) from crontab_record group by crontab) order by create_time";
        // $crontabList =  Db::query($sql);//在mysql上效率太差,但是mariaDB就还好
        dump(Db::getlastsql());
    	$this->assign('memberCount',$memberCount);
    	$this->assign('campCount',$campCount);
        $this->assign('crontabList',$crontabList);
    	$this->assign('coachCount',$coachCount);
    	$this->assign('courtCount',$courtCount);
        return view();
    }
}
