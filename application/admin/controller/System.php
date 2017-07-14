<?php
// 系统设置
namespace app\admin\controller;
use app\admin\controller\base\Backend;

class System extends Backend {
    public function index(){
        $breadcrumb = ['title' => '系统设置'];

        $data = db('setting')->where('id', 1)->find();
        dump($data);

        $this->assign( 'breadcrumb', $breadcrumb );
        return view();
    }
}