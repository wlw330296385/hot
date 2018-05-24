<?php 
namespace app\keeper\controller;
use app\keeper\controller\Base;
use app\service\BannerService;
class Group extends Base{
	
	public function _initialize(){
		parent::_initialize();
	}

    // 群组列表
    public function index() {
        
        return view('Group/index');
    }

    // 群组详情
    public function groupInfo() {

        return view('Group/groupInfo');
    }

    // 创建群组
    public function createGroup() {

        return view('Group/createGroup');
    }

    // 编辑群组
    public function groupEdit() {

        return view('Group/groupEdit');
    }

    
    // 创建奖金池
    public function createPool() {
        return view('Group/createPool');
    }

    // 奖金池详情
    public function poolInfo() {
        return view('Group/poolInfo');
    }

    // 编辑奖金池
    public function poolEdit() {
        return view('Group/poolEdit');
    }


}