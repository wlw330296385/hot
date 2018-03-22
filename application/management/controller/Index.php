<?php 
namespace app\management\controller;
use app\management\controller\Backend;


/**
* 引导页
*/
class Index extends Backend
{
	
	function _initialize()
	{
		parent::_initialize();
	}

	public function index(){
		
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
		$this->assign('campList',$campList);
		return view('Index/choose');	
	}
}