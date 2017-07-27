<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;

class Index extends Base{
	public function _initialize(){
		parent::_initialize();
	}

    public function index() {
    	dump(session('memberInfo'));
    	dump($this->memberInfo);die;
        return view();
    }
}
