<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;

class Camp extends Base{

	public function _initialize(){
		parent::_initialize();
	}


    public function index() {
    	$a = input();
    	$b = ['b'=>123];
    	$c = array_merge($a,$b);
    	dump($c);
        return view();
    }




}
