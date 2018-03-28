<?php
// admin模块 控制器基类
namespace app\admin\controller\base;

use app\service\SystemService;
use think\Controller;
use app\service\AuthService;
use think\Cookie;
use app\model\Camp;
class Base extends Controller {
    public $cur_camp;
    public $site;
    public $AuthService;
    public $admin;
    public function _initialize() {
        $this->AuthService = new AuthService;
        // 获取平台数据
        $SystemS = new SystemService();
        $site = $SystemS->getSite();
        $this->site = $site;
        $this->cur_camp = $this->getCurCamp();
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
            $res = [
                'camp_id' => 9,
                'camp' =>'大热训练营', 
            ];
            return $res;
        }
    }

    protected function record($do){
        $this->AuthService->record($do);
    }
}