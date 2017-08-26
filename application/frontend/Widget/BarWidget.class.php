<?php 
namespace app\frontend\Widget;
use Think\Controller;

class BarWidget extends Controller{
	public function menu_footer(){
		$menu = [
			[
				'name'=>'首页',
				'icon'=>'icon-home',
				'action'=>'index',
				'controller'=>'Index'
			],
			[
				'name'=>'消息',
				'icon'=>'icon-msg',
				'action'=>'index',
				'controller'=>'Message'
			],			
			[
				'name'=>'发现',
				'icon'=>'icon-daka',
				'action'=>'index',
				'controller'=>'index'
			],
			[
				'name'=>'训练营',
				'icon'=>'icon-club',
				'action'=>'index',
				'controller'=>'Mamp'
			],
			[
				'name'=>'我的',
				'icon'=>'icon-user',
				'action'=>'index',
				'controller'=>'Member'
			],
		];
		$this->assign('menu',$menu);
		$this->display('Widget:footer');
	}
}