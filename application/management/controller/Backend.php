<?php 
namespace app\management\controller;
use app\management\controller\Base;

/**
* 基本层
*/
class Backend extends Base
{
	public $power;
	function _initialize()
	{
		parent::_initialize();

		//获取权限和菜单
		// $power = cache("power_{$this->memberInfo['id']}");
		$power = 1;
		if($power){
			$this->power = $power;
		}else{
			$this->error('权限不足','Login/login');
		}
		// 获取面包屑
		$_location = $this->checkAuth($power);
		if(!$_location){
			$this->error('权限不足,不可访问此页面');
		}
		
		$menuList = cache("menuList_{$this->memberInfo['id']}");
		$this->assign('_sidebar_menus',$menuList);
		$this->assign('_location',$_location);
	}



 	private	function checkAuth($power){
 		return [0=>['title'=>'开发者1','url_value'=>111],0=>['title'=>'开发者2','url_value'=>111]];
 		$c = request()->controller();
 		$a = request()->action();
 		$url_value = strtolower("$c/$a");
 		$powerList = cache("powerList_{$this->memberInfo['id']}"); 
 		foreach ($powerList as $key => $value) {
 			if($url_value == strtolower($value['url_value'])){
 				//获取面包屑地址
 				$_location = [];
 				$_location[1] = $value;
 				foreach ($powerList as $k => $val) {
 					if($val['id'] == $vallue['pid']){
 						$_location[0] = $val;
 					}
 				}
 				return $_location;
 			}
 		}
		return true;
	}



	//获取面包屑地址
	private function getLocation(){
		$powerList = cache("powerList_{$this->memberInfo['id']}"); 
		$c = request()->controller();
 		$a = request()->action();
 		$url_value = strtolower("$c/$a");

	}
}