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
        $sql = db('crontab_record')->order('create_time desc')->select(false);
        $crontabList = Db::query("select * from ($sql) as a group by crontab");
    	$this->assign('memberCount',$memberCount);
    	$this->assign('campCount',$campCount);
        $this->assign('crontabList',$crontabList);
    	$this->assign('coachCount',$coachCount);
    	$this->assign('courtCount',$courtCount);
        return view();
    }
}
