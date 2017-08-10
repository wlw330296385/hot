<?php 
namespace app\frontend\controller;
use think\Controller;
use app\service\SystemService;
class Base extends Controller{

	public $memberInfo;
	public $systemSetting;
	public function _initialize(){
		$this->memberInfo = session('memberInfo','','think');
		if(!$this->memberInfo){
			$this->wxlogin();
		} 
		$re = session('memberInfo',$this->memberInfo);
		$this->assign('memberInfo',$this->memberInfo);
		$this->systemSetting = SystemService::getSite();
		$this->assign('systemSetting',$this->systemSetting);
	}



	protected function wxlogin(){
		$member =new \app\service\MemberService;
    	$memberInfo = $member->getMemberInfo(1);
    	unset($memberInfo['password']);
    	$this->memberInfo = $memberInfo;
    	$cookie = md5($memberInfo['id'].$memberInfo['create_time'].'hot');
    	cookie('member',md5($this->memberInfo['id'].$this->memberInfo['create_time'].'hot'));
    	
        session('memberInfo',$memberInfo,'think');
	}
}
