<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;

class Find extends Base{
	
	public function _initialize(){
		parent::_initialize();
	}

    public function index() {
  
        return view('Find/index');
    }


    public function test1() {
  
        return view('Find/test1');
    }

    public function test2() {
  
        return view('Find/test2');
    }

    public function test3() {
  
        return view('Find/test3');
    }

    public function test4() {
  
        return view('Find/test4');
    }

    public function test5() {
  
        return view('Find/test5');
    }

}