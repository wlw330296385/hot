<?php 
namespace app\management\controller;
use app\management\controller\Camp;

class Member extends Camp{

	public function _initialize(){
		parent::_initialize();
	}

    public function memberList(){




        return view('Member/memberList');
    }
    
}