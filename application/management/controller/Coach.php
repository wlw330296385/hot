<?php 
namespace app\management\controller;
use app\management\controller\Backend;
// 按课时结算的训练营财务页面
class Coach extends Backend{
	public $camp_member;
	public function _initialize(){
		parent::_initialize();
        $this->camp_member = session('camp_mmeber');
	}
}