<?php 
namespace app\frontend\controller;
use think\Controller;
use app\service\SystemService;
use think\Request;
class Base extends Controller{

	public $memberInfo;
	public $systemSetting;
	public function _initialize(){
		$this->memberInfo = session('memberInfo','','think');
		if(!$this->memberInfo){
			$this->nologin();
		}else{
			$re = session('memberInfo',$this->memberInfo);
			$this->assign('memberInfo',$this->memberInfo);
			$this->systemSetting = SystemService::getSite();
			$this->assign('systemSetting',$this->systemSetting);
			$this->footMenu();
		}	
	}



	protected function wxlogin($id){
		$member =new \app\service\MemberService;
    	$memberInfo = $member->getMemberInfo(['id'=>$id]);
    	unset($memberInfo['password']);
    	$this->memberInfo = $memberInfo;
    	$cookie = md5($memberInfo['id'].$memberInfo['create_time'].'hot');
    	cookie('member',md5($this->memberInfo['id'].$this->memberInfo['create_time'].'hot'));  	
        $result = session('memberInfo',$memberInfo,'think');
        if($result){
        	return true;
        }else{
        	return false;
        }      
	}


	protected function nologin(){
		$this->redirect('login/login');
	}

	protected function footMenu(){
		define('CONTROLLER_NAME',Request::instance()->controller());
		define('MODULE_NAME',Request::instance()->module());
		define('ACTION_NAME',Request::instance()->action());
		$footMenu =  [
			[
				'name'=>'首页',
				'icon'=>'mui-icon-home',
				'action'=>'index',
				'controller'=>'Index'
			],
			[
				'name'=>'消息',
				'icon'=>'mui-icon-chatbubble',
				'action'=>'index',
				'controller'=>'Message'
			],			
			[
				'name'=>'发现',
				'icon'=>'mui-icon-checkmarkempty',
				'action'=>'index',
				'controller'=>'Message'
			],
			[
				'name'=>'训练营',
				'icon'=>'mui-icon-extra-class',
				'action'=>'index',
				'controller'=>'Camp'
			],
			[
				'name'=>'我的',
				'icon'=>'mui-icon-icon-contact-filled',
				'action'=>'index',
				'controller'=>'Member'
			],
		];
		$this->assign('footMenu',$footMenu);
	}
}
