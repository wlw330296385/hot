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
		$list = db('admin_menu')->order('sort asc')->select();
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

	// 编辑/添加部门权限
	public function editAdminGroupP(){
		$AdminGroup = new \app\admin\model\AdminGroup;
		$ag_id = input('param.ag_id');
		if(request()->isPost()){
			$data = input('post.');
			if($ag_id){
				//判断职位权限是否与当前权限有差集;
				$sebsetList = db('admin_group')->where(['pid'=>$ag_id])->select();
				$power = json_decode($data['menu_auth']);//当前的权限;
				foreach ($sebsetList as $key => $value) {
					$array_diff = array_intersect($power,json_decode($value['menu_auth']));
					$AdminGroup->save(['menu_auth'=>$array_diff,'id'=>$value['id']]);
				}
				$result = $AdminGroup->save($data,['id'=>$ag_id]);

			}else{
				$result = $AdminGroup->save($data);
			}

			if($result){
				$this->success('操作成功');
			}else{
				$this->error('操作失败');
			}
		}else{
			$ag_id = input('param.ag_id');
			// 权限菜单
			$list = db('admin_menu')->select();
			$menuList = getTree($list);
			$this->assign('menuList', $menuList);
			// 已有权限
			$power = [];
			if($ag_id){
				$info = db('admin_group')->where(['id'=>$ag_id])->find();

				$power = json_decode($info['menu_auth']);
				$powerP = db('admin_menu')->column('id');

				$this->assign('info',$info);
				$this->assign('power',$power);
				$this->assign('powerP',$powerP);
				return view('Menu/editAdminGroupP');
			}else{

				$this->assign('power',$power);
				return view('Menu/addAdminGroupP');
			}
			
			
		}
	}



	// 编辑职位权限
	public function editAdminGroup(){
		$AdminGroup = new \app\admin\model\AdminGroup;
		$ag_id = input('param.ag_id');
		if(request()->isPost()){
			$data = input('post.');
			dump($data);

			if($ag_id){
				$result = $AdminGroup->save($data,['id'=>$ag_id]);
				echo $AdminGroup->getlastsql();die;
			}else{
				$result = $AdminGroup->save($data);
			}

			if($result){
				$this->success('操作成功');
			}else{
				$this->error('操作失败');
			}


		}else{
			if($ag_id){
				$info = db('admin_group')->where(['id'=>$ag_id])->find();
				$infoP = db('admin_group')->where(['id'=>$info['pid']])->find();
				$power = json_decode($info['menu_auth']);

				$powerP = json_decode($infoP['menu_auth']);
				$menu = db('admin_menu')->where(['id'=>['in',$powerP]])->select();
				$menuList = getTree($menu);

				// dump($power);dump($powerP);die;
				$this->assign('info',$info);
				$this->assign('power',$power);
				$this->assign('infoP',$infoP);
				$this->assign('powerP',$powerP);
				$this->assign('menuList',$menuList);
				return view('Menu/editAdminGroup');
			}else{
				$ag_pid = input('param.ag_pid');
				$infoP = db('admin_group')->where(['id'=>$ag_pid])->find();

				$powerP = json_decode($infoP['menu_auth']);
				$menu = db('admin_menu')->where(['id'=>['in',$powerP]])->select();
				$menuList = getTree($menu);

				$this->assign('infoP',$infoP);
				$this->assign('powerP',$powerP);
				$this->assign('menuList',$menuList);
				return view('Menu/addAdminGroup');
			}
		}
		
	}
}