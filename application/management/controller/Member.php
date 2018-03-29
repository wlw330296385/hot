<?php 
namespace app\management\controller;
use app\management\controller\backend;

class Member extends backend{

	public function _initialize(){
		parent::_initialize();
	}

    public function memberList(){




        return view('Member/memberList');
    }
    
}