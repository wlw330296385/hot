<?php
namespace app\admin\controller;

use app\admin\controller\base\Backend;
use app\admin\controller\base\Base;
use util\Tree;
class Test extends Base {
    public function index() {
	   	$menu = db('admin_menu')->select();
	   	// dump($menu);
	   	$menuList = Tree::toLayer($menu);
	   	dump($menuList);
    }
}
