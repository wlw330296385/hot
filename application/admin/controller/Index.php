<?php
namespace app\admin\controller;

use app\admin\controller\base\Backend;

class Index extends Backend {
	public function _initialize(){
		parent::_initialize();
	}
    public function index() {

        return view();
    }
}
