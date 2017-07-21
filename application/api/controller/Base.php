<?php
namespace app\api\controller;
use app\service\Wechat;
use think\Controller;
// use think\controller\Rest;
use app\service\TokenService;
class Base extends Controller{

	public $memberInfo;

    public function _initialize() {  	
        $this->gettoken();
        $is_login = cookie('member');
        $this->memberInfo = session('memberInfo');
    	if(($is_login!=md5($this->memberInfo['id'].$this->memberInfo['create_time'].'hot'))||!$is_login){
    		$this->checklogin();
    	}

        
    }







    // token 限制
    public function gettoken(){

        $TokenService =new TokenService;
        $visits = $TokenService->visitTimes();
        if(!$visits){
            // $this->error('非法操作');
            $this->checklogin();
        }       
    }


    public function checklogin(){

    	$member =new \app\service\MemberService;
    	$memberInfo = $member->getMemberInfo(1);
    	$cookie = md5($memberInfo['id'].$memberInfo['create_time'].'hot');
    	cookie('member',$memberInfo['id']);
    	$this->memberInfo = $memberInfo;
        session('memberInfo',$memberInfo);
    }
}