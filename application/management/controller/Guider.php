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
		$CampMember = new \app\model\CampMember;
		$campList = $CampMember->where(['member_id'=>$this->memberInfo['id'],'status'=>1,'type'=>['gt',2]])->select();
		if(request()->isPost()){
			$key = input('post.key');
			$camp = $campList[$key];
			cache('camp',$camp['camp']);
			cache('camp_id',$camp['camp_id']);
			if($camp['type'] == '营主'){
				cache("power_{$this->memberInfo['id']}",4);
			}else{
				cache("power_{$this->memberInfo['id']}",3);
			}
			header(url('Index/index'));
		}
		if($campList){
			$campList = $campList->toArray();
		}else{
			$campList = [];
		}
		$this->assign('campList',$campList);
		return view('Guider/choose');	
	}
}