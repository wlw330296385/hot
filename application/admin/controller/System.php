<?php
// 系统设置
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\service\SystemService;
use app\service\AuthService;

class System extends Backend {
    public function index(){
        if ( request()->isPost() ) {
            $this->System = new SystemService();
            $this->Auth = new AuthService();
            $request = input('post.');
            $response = $this->System->setSite($request);
            if ($response) {
                $this->Auth->record('系统设置 修改 成功');
                $this->success(__lang('MSG_100_SUCCESS'));
            } else {
                $this->Auth->record('系统设置 修改 失败');
                $this->error(__lang('MSG_200_ERROR'));
            }
        }

        $breadcrumb = ['title' => '系统设置'];
        $this->assign( 'breadcrumb', $breadcrumb );
        return view();
    }
}