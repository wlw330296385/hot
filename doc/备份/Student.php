<?php

namespace app\api\controller;

use app\api\controller\Base;
use think\Request;
use app\service\StudentService;


class Student extends Base{
	public $studentServive;

	public function _initialize(){
		parent::_initialize();
		$this->studentServive = new StudentServive();
	}

		
		
}