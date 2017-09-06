<?php
namespace app\admin\controller;

use app\admin\controller\base\Backend;

class Index extends Backend {
    public function index() {
        $breadcrumb = [ 'ptitle' => '' , 'title' => '控制台' ];
        $this->assign( 'breadcrumb', $breadcrumb );
        return view();
    }
}
