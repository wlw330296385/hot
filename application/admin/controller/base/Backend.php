<?php
// admin模块 控制器基类
namespace app\admin\controller\base;

use app\model\Camp;
use app\service\SystemService;
use app\admin\controller\base\Base;
use app\service\AuthService;
use think\Cookie;

class Backend extends Base {
    public $cur_camp;
    public $site;
    public $AuthService;
    public $admin;
    public function _initialize() {
        parent::_initialize();
        // 检查控制台登录
        $this->AuthService = new AuthService();
        if ( !$this->AuthService->islogin() ) {
            $this->error('请登录后操作', url('Login/index'));
        }else{
            $this->admin = session('admin');
        }

        //存储权限节点
        $this->AuthService->adminGroup();

        //检查权限
        if (!$this->AuthService->checkAuth()) $this->error('权限不足！');

    }

}