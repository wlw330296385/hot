<?php 
namespace app\frontend\controller;
use think\Controller;

class Base extends Controller{

	public $memberInfo;

	public function _initialize(){
		$this->memberInfo = session('memberInfo');
		if(!$this->memberInfo){
			$this->wxlogin();
		} 
		$this->assign('memberInfo',$this->memberInfo);
	}



	protected function wxlogin(){
		$member =new \app\service\MemberService;
    	$memberInfo = $member->getMemberInfo(1);
    	$cookie = md5($memberInfo['id'].$memberInfo['create_time'].'hot');
    	cookie('member',$memberInfo['id']);
    	$this->memberInfo = $memberInfo;
        session('memberInfo',$memberInfo);
	}
}
