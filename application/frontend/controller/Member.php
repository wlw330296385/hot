<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\MemberService;
use app\service\StudentService;
class Member extends Base{

	public function _initialize(){

		parent::_initialize();
	}

    public function index() {

        return view();
    }


    public function memberInfo(){

    	return view();
    }


    public function photoAlbum(){
    	return view();
    }

    //学员个人档案
    public function studentPersonArchives(){
    	return view();
    }
}