<?php 
namespace app\frontend\controller;
use think\Controller;
use app\service\SystemService;
use think\Request;
use app\service\WechatService;
class Base extends Controller{
	public $systemSetting;
	public $memberInfo;
	public function _initialize(){	
		$url = cookie('url');
		if(!$url){
			$url = $_SERVER["REQUEST_URI"];
			cookie('url', $url);
		}
		$this->systemSetting = SystemService::getSite();
		$this->assign('systemSetting',$this->systemSetting);
		$this->footMenu();
		$this->memberInfo = session('memberInfo','','think');
		if(!isset($this->memberInfo['id'])){
			$this->nologin();
		}	
		$this->assign('memberInfo',$this->memberInfo);
	}

	protected function footMenu(){
		define('CONTROLLER_NAME',Request::instance()->controller());
		define('MODULE_NAME',Request::instance()->module());
		define('ACTION_NAME',Request::instance()->action());
		$footMenu =  [
			[
				'name'=>'首页',
				'icon'=>'icon iconfont icon-hotnav-home',
				'action'=>'index',
				'controller'=>'Index'
			],
			[
				'name'=>'消息',
				'icon'=>'icon iconfont icon-hotnav-news',
				'action'=>'index',
				'controller'=>'Message'
			],			
			[
				'name'=>'发现',
				'icon'=>'icon iconfont icon-hotnav-find',
				'action'=>'index',
				'controller'=>'Mall'
			],
			[
				'name'=>'训练营',
				'icon'=>'icon iconfont icon-hotnav-training',
				'action'=>'index',
				'controller'=>'Camp'
			],
			[
				'name'=>'我的',
				'icon'=>'icon iconfont icon-hotnav-mine',
				'action'=>'index',
				'controller'=>'Member'
			],
		];
		$this->assign('footMenu',$footMenu);
	}

	protected function nologin(){
		$result = $this->is_weixin();
		// $this->redirect('Test/index');
		if($result){
			$WechatService = new WechatService;
			$callback = url('login/wxlogin','','', true);
			$this->redirect($WechatService -> oauthredirect($callback));
		}else{
			$memberInfo = ['id'=>-1,'member'=>'游客','hp'=>0,'level'=>0,'avatar'=>'/static/default/avatar.png','nickname'=>'游客'];
			unset($memberInfo['password']);
	    	$cookie = md5($memberInfo['id'].$memberInfo['member'].'hot');
	    	cookie('member',md5($memberInfo['id'].$memberInfo['member'].'hot'));
			$re = session('memberInfo',$memberInfo , 'think');
			$url = cookie('url');
            if($re){
                $this->redirect($url);
            }else{
            	$this->redirect('Index/index');
            }
		}
	}

	

	// 判断是否是微信浏览器
	function is_weixin() { 
	    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) { 
	        return true; 
	    } return false; 
	}
}
