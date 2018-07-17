<?php
// admin模块 控制器基类
namespace app\admin\controller\base;


use app\service\SystemService;
use app\admin\controller\base\Base;
use think\Cookie;
use app\admin\model\AdminMenu as MenuModel;
class Backend extends Base {
    public $cur_camp;
    public $site;
    public $admin;
    public function _initialize() {
        parent::_initialize();
        // 获取平台数据
        $SystemS = new SystemService();
        $site = $SystemS->getSite();
        $this->site = $site;
        $this->assign('site', $site);
        $this->assign('admin', session('admin') );
        if(config('develop_mode') == 0){
            //存储权限节点
            // dump($_SESSION);
            $this->AuthService->adminGroup();
            
            // dump(cache('group_id_menu_auth_1'));
            //检查权限
            if (!$this->AuthService->checkAuth()) $this->error('权限不足！');
            // 获取面包屑导航
            $_location =  MenuModel::getLocation('', true);
            if(!$_location){
                $this->error('请先添加菜单');
            }
            $this->assign('_location',$_location);
            // dump($_location);

        }else{
            $this->assign('_location',[0=>['title'=>'开发者模式'],1=>['title'=>'不验证权限']]);
        }
        // 获取侧边栏菜单
        $sidebar_menu = MenuModel::getSidebarMenu();


        $this->assign('_sidebar_menus', $sidebar_menu);
        
    }

}