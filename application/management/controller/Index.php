<?php 
namespace app\management\controller;
use app\management\controller\Backend;


/**
* 引导页
*/
class Index extends Backend
{
	
	function _initialize()
	{
		parent::_initialize();
	}

	public function index(){
		return view('Index/index');
	}

	
}