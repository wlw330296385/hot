<?php
// admin模块 控制器基类
namespace app\admin\controller\base;

use app\model\Camp;
use app\service\SystemService;
use app\admin\controller\base\Base;
use app\service\AuthService;
use think\Controller;
use think\Cookie;

class Backend extends Controller {
    public $cur_camp;
    public $site;
    public $AuthService;
    public $admin;
    /*public function _initialize() {
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

    }*/

    public function _initialize() {
        // 检查控制台登录
        $this->AuthService = new AuthService();
        if ( !$this->AuthService->islogin() ) {
            $this->error('请登录后操作', url('Login/index'));
        }else{
            $this->admin = session('admin');
        }


        // 获取平台数据
        $SystemS = new SystemService();
        $site = $SystemS->getSite();
        $this->site = $site;

        // 当前查看训练营
        $curcamp = $this->getCurCamp();
        $this->cur_camp = $curcamp;
        $this->assign('curcamp', $curcamp);
        // 列出所选训练营
        $campM = new Camp();
        $camplist = $campM->where(['status' => 1])->order('id desc')->select()->toArray();
        $this->assign('site', $site);
        $this->assign('admin', session('admin') );
        $this->assign('camplist', $camplist);
    }

    // 获取当前查看训练营
    public function getCurCamp() {
        if ( Cookie::has('camp_id', 'curcamp_') ) {
            $res = [
                'camp_id' => Cookie::get('camp_id', 'curcamp_'),
                'camp' => Cookie::get('camp', 'curcamp_')
            ];
            return $res;
        }
    }

    protected function record($do){
        $authS = new AuthService();
        $authS->record($do);
    }

}