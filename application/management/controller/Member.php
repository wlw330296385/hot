<?php 
namespace app\management\controller;
use app\management\controller\Backend;

class Member extends Backend{

	public function _initialize(){
		parent::_initialize();
	}

    public function memberList(){




        return view('Member/memberList');
    }
    
}