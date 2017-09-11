<?php 
namespace app\frontend\controller;
use think\Controller;
use app\service\SystemService;
use think\Request;
class Base extends Controller{
	public $systemSetting;
	public $memberInfo;
	public function _initialize(){	
		$paramData = input('param.');
		if(empty($paramData['pid'])){
			$paramData = ['pid'=>0];
		}
		cookie('param', $paramData);
		$this->systemSetting = SystemService::getSite();
		$this->assign('systemSetting',$this->systemSetting);
		$this->footMenu();
		$this->memberInfo = session('memberInfo','' , 'think');
		if(!$this->memberInfo){
			$this->memberInfo = ['id'=>-1,'member'=>'游客','hp'=>0,'level'=>0,'avatar'=>'/static/default/avatar.png'];
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
}
