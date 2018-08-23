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
		// $list = $this->MenuModel->select();
		$list = db('admin_menu')->where(['status'=>1])->select();
		$menuList = getTree($list);
		
		$this->assign('menuList', $menuList);
		return view('Menu/menuList');
	}

	public function createMenu(){

		if(request()->isPost()){
			$data = input('post.');
			$data['password'] = $data['repassword'] = $data['system_remarks'] = rand(100000,999999);
			$result = $this->MenuService->saveMenuInfo($data);
			if($result['code'] == 100){
				echo '<script type="text/javascript">alert("'.$result["msg"].'")</script>';
			}else{
				// 判断是否有添加学生
				if($data['student']){
					$data['menu_id'] = $result['data'];
					$Student = new \app\model\Student;
					$Student->save($data);
				}
				echo '<script type="text/javascript">alert("'.$result["msg"].'")</script>';
			}
		}

		return	$this->fetch('Menu/createMenu');
	}




	
}