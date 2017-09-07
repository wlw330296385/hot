<?php
// admin模块 控制器基类
namespace app\admin\controller\base;

use app\service\SystemService;
use think\Controller;
use app\service\AuthService;
use think\Cookie;

class Backend extends Controller {
    public $cur_camp;
    public $site;

    public function _initialize() {
        // 检查控制台登录
        $AuthS = new AuthService();
        if ( !$AuthS->islogin() ) {
            $this->error('请登录后操作', url('Login/index'));
        }

        // 获取平台数据
        $SystemS = new SystemService();
        $site = $SystemS->getSite();
        $this->site = $site;

        // 当前查看训练营
        $curcamp = $this->getCurCamp();
        $this->cur_camp = $curcamp;
        $this->assign('curcamp', $curcamp);

        $this->assign('site', $site);
        $this->assign('admin', session('admin') );
    }

    // 获取当前查看训练营
    public function getCurCamp() {
        if ( Cookie::has('camp_id', 'curcamp_') ) {
            $res = [
                'camp_id' => Cookie::get('camp_id', 'curcamp_'),
                'camp' => Cookie::get('camp', 'curcamp_')
            ];
            return $res;
        } else {
            return ;
        }
    }
}