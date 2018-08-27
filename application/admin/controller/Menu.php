<?php 
namespace app\admin\controller;
use app\admin\controller\base\Backend;
// use app\admin\model\AdminMenu;
class Menu extends Backend{
	public $MenuModel;
	public function _initialize(){
		parent::_initialize();
		// $this->MenuModel = new AdminMenu;
	}


	public function menuList(){
		$list = db('admin_menu')->select();
		$menuList = getTree($list);
		
		$this->assign('menuList', $menuList);
		return view('Menu/menuList');
	}

	public function createMenu(){

		if(request()->isPost()){
			$data = input('post.');
			
			$AdminMenu = new \app\admin\model\AdminMenu;
			$result = $AdminMenu->save($data);

			if($result){
				$this->success('操作成功');
			}else{
				$this->error('操作失败');
			}
		}
	}


	public function updateMenu(){
		$id = input('param.id');
		$data = input('post.');
		$AdminMenu = new \app\admin\model\AdminMenu;
		$result = $AdminMenu->save($data,['id'=>$id]);

		if($result){
			$this->success('操作成功');
		}else{
			$this->error('操作失败');
		}
	}


	// 编辑部门列表
	public function adminGroupList(){
		$AdminGroup = new \app\admin\model\AdminGroup;
		if(request()->isPost()){
			$data = input('post.');
			$result = $AdminGroup->save($data,['id'=>$data['id']]);
			if($result){
			$this->success('操作成功');
		}else{
			$this->error('操作失败');
		}
		}else{
			
			$adminGroupListP = $AdminGroup->select();
			$list_arr = $adminGroupListP->toArray();

			$list = getTree($list_arr);


			$this->assign('list',$list);
			return view('Menu/adminGroupList');
		}
		
	}

	// 编辑部门权限
	public function editAdminGroupP(){

	}




}