<?php 
namespace app\frontend\Widget;
use Think\Controller;

class Widget extends Controller{
	public function menu_footer(){
		$menu = [
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
				'controller'=>'index'
			],
			[
				'name'=>'训练营',
				'icon'=>'mui-icon-extra-class',
				'action'=>'index',
				'controller'=>'Mamp'
			],
			[
				'name'=>'我的',
				'icon'=>'mui-icon-icon-contact-filled',
				'action'=>'index',
				'controller'=>'Member'
			],
		];
		$this->assign('menu',$menu);
		$this->display('Widget:footer');
	}
}
