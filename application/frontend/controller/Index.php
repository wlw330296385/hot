<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;

class Index extends Base{

    public function index() {
        $breadcrumb = [ 'ptitle' => '' , 'title' => '控制台' ];
        $this->assign( 'breadcrumb', $breadcrumb );
        return view();
    }
}
