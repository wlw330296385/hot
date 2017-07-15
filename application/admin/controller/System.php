<?php
// 系统设置
namespace app\admin\controller;
use app\admin\controller\base\Backend;

class System extends Backend {
    public function index(){
        $breadcrumb = ['title' => '系统设置'];

        $site = db('setting')->where('id', 1)->find();


        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('site', $site);
        return view();
    }
}