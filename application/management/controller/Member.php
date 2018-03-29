<?php 
namespace app\management\controller;
use app\management\controller\Member;

class StatisticsCoach extends Coach{

	public function _initialize(){
		parent::_initialize();
	}

    public function memberList(){
        return view('Member/memberList');
    }
    
}