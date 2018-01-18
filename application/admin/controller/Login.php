<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Validate;
use app\service\AuthService;
use think\Cache;
class Login extends Controller
{
    public function __construct()
    {
        $this->Auth = new AuthService();
    }

    public function index() {
        if ( $this->Auth->islogin() ) {
            $this->error('你已经登录，无需重复登录', url('Index/index'));
        }
        if ( Request::instance()->isPost() ) {
            $cache_tag  = strtolower('_sidebar_menus_'.session('admin.id'));
            Cache::rm($cache_tag); 
            session('admin', null);
            cookie('keeplogin', null);
            //dump( Request::instance()->post() );
            $username = input('username/s');
            $password = input('password');
            $keeplogin = input('keeplogin');
            $token = input('__token__');

            $rule = [
                'username'  => 'require',
                'password'  => 'require',
                '__token__' => 'token',
            ];
            $data = [
                'username'  => $username,
                'password'  => $password,
                '__token__' => $token,
            ];
            $validate = new Validate($rule);
            $result = $validate->check($data);
            if (!$result)
            {
                $this->error($validate->getError());
                return;
            }

            $result = $this->Auth->login($username, $password, $keeplogin ? 86400 : 0);
            if ($result === true) {
                $this->Auth->record('控制台 登录 成功');
                $this->success('登录成功', url('Index/index'));
            } else {
                $this->Auth->record('控制台 登录 失败');
                $this->error('用户名或密码错误');
            }
        }

        if ( $this->Auth->autologin() ) {
            $this->redirect('Index/index');
        }
        return view('index');
    }

    public function logout() {
        // $cache_tag  = strtolower('_sidebar_menus_'.session('admin.id'));
        // Cache::rm($cache_tag); 
        // $group_id = session('admin.group_id');
        // Cache::rm('group_id_menu_auth_'.$group_id); 
        Cache::clear(); 
        session('admin', null);
        cookie('keeplogin', null);
        $this->success('退出成功', url('Login/index'));
    }

    public function clearCache(){
        cookie('keeplogin', null);
        Cache::clear(); 
        $this->success('清空成功');
    }
}