<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;

class Message extends Base{
	
	public function _initialize(){
		parent::_initialize();
	}

    public function index() {
  
        return view();
    }
}