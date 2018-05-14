<?php 
namespace app\keeper\controller;
use app\keeper\controller\Base;
use app\service\BannerService;
class Punch extends Base{
	
	public function _initialize(){
		parent::_initialize();
	}

    public function index() {

        return view('Punch/index');
    }



}