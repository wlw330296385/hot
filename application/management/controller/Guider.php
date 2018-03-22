<?php 
namespace app\management\controller;
use app\management\controller\Base;


/**
* 引导页
*/
class Guider extends Base
{
	
	function _initialize()
	{
		parent::_initialize();
	}



	public function choose(){
		$campList = db('camp_member')->where(['member_id'=>$this->memberInfo['id'],'status'=>1,'type'=>['gt',2]])->select();
		
		if(request()->isPost()){
			$key = input('post.key');
			$camp = $campList[$key];
			cache('camp',$camp['camp']);
			cache('camp_id',$camp['camp_id']);
			if($camp['type'] == '创建者'){
				cache("power_{$this->memberInfo['id']}",4);
				$powerList = db('member_menu')->where(['status'=>1,'power_type'=>1,'power'=>['egt',4],'module'=>'management'])->select();
				$menuList = getTree($menuList,0);
				cache("powerList_$this->memberInfo['id']",$powerList);
				cache("menuList_$this->memberInfo['id']");
			}elseif($camp['type'] == '管理员'){
				$powerList = db('member_menu')->where(['status'=>1,'power_type'=>1,'power'=>['egt',3],'module'=>'management'])->select();
				$menuList = getTree($menuList,0,);
				cache("powerList_$this->memberInfo['id']",$powerList);
				cache("menuList_$this->memberInfo['id']");
				cache("power_{$this->memberInfo['id']}",3);
			}elseif($camp['type'] == '教练'){
				$powerList = db('member_menu')->where(['status'=>1,'power_type'=>2,'power'=>['egt',2],'module'=>'management'])->select();
				$menuList = getTree($menuList,0);
				cache("powerList_$this->memberInfo['id']",$powerList);
				cache("menuList_$this->memberInfo['id']");
				cache("power_{$this->memberInfo['id']}",2);
			}
			header(url('Index/index'));
		}
		
		$this->assign('campList',$campList);
		return view('Guider/choose');	
	}
}