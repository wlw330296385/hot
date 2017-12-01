<?php
namespace app\admin\controller;

use app\admin\controller\base\Base;

class Index extends Base {
    public function index() {

    	dump(cache('group_id_menu_auth_2'));
    	dump($_SESSION);die;
        $breadcrumb = [ 'ptitle' => '' , 'title' => '控制台' ];
        $this->assign( 'breadcrumb', $breadcrumb );
        return view();
    }
}
