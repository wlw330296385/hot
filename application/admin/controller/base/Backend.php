<?php
// admin模块 控制器基类
namespace app\admin\controller\base;

use think\Controller;
use app\service\Auth;

class Backend extends Controller {
    public function _initialize() {
        if ( !Auth::islogin() ) {
            $this->error('请登录后操作', url('Login/index'));
        }

        $this->breadcrumb = [ 'ptitle' => '' , 'title' => '控制台' ];

        $this->assign('admin', session('admin') );
    }
}