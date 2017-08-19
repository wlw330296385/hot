<?php
// admin模块 控制器基类
namespace app\admin\controller\base;

use app\service\SystemService;
use think\Controller;
use app\service\AuthService;

class Backend extends Controller {
    public function _initialize() {
        $this->Auth = new AuthService();
        $this->System = new SystemService();
        if ( !$this->Auth->islogin() ) {
            $this->error('请登录后操作', url('Login/index'));
        }
        $site = $this->System->getSite();
        $this->assign('site', $site);
        $this->assign('admin', session('admin'));
    }
}