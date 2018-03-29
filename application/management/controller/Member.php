<?php 
namespace app\management\controller;
use app\management\controller\Base;

class Member extends Base{

	public function _initialize(){
		parent::_initialize();
	}

    public function memberList(){

    	

    	
        return view('Member/memberList');
    }
    
}