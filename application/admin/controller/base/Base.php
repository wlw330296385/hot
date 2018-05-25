<?php
// admin模块 控制器基类
namespace app\admin\controller\base;


use think\Controller;
use app\service\AuthService;
class Base extends Controller {
    public $site;
    public $AuthService;
    public $admin;
    public function _initialize() {
        $this->AuthService = new AuthService;
        // 检查控制台登录
        if ( !$this->AuthService->islogin() ) {
            //$this->error('请登录后操作', url('Login/index'));
            $this->redirect('Login/index');
        }else{
            $this->admin = session('admin');
            $this->assign('admin',$this->admin);
        }
    }

    protected function record($do){
        $this->AuthService->record($do);
    }
}