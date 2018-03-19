<?php
namespace app\admin\controller;

use app\admin\controller\base\Backend;

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

    	$this->assign('memberCount',$memberCount);
    	$this->assign('campCount',$campCount);
    	$this->assign('coachCount',$coachCount);
    	$this->assign('courtCount',$courtCount);
        return view();
    }
}
