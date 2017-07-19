<?php
namespace app\api\controller;
use app\service\Wechat;
// use think\controller\Rest;
class Base{

	public $memberInfo;

    public function _initialize() {
        
    	$is_login = cookie('member');

    	if($is_login!=md5($this->memberInfo['id'].$this->memberInfo['create_time'].'hot')){
    		$this->checklogin();
    	}
    }











    public function checklogin(){
    	$member =new \app\service\MemberService;
    	$memberInfo = $member::getMemberInfo(1);
    	$cookie = md5($memberInfo['id'].$memberInfo['create_time'].'hot');
    	cookie('member',$memberInfo['id']);
    	$this->memberInfo = $memberInfo;
    }
}