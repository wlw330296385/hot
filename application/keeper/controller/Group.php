<?php 
namespace app\keeper\controller;
use app\keeper\controller\Base;
use app\service\BannerService;
class Group extends Base{
	
	public function _initialize(){
		parent::_initialize();
	}

    public function index() {
        return view('Group/index');
    }

    public function groupInfo() {
        return view('Group/groupInfo');
    }


}