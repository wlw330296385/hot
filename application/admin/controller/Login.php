<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Validate;
use app\service\Auth;

class Login extends Controller
{
    public function index() {
        if ( Auth::islogin() ) {
            $this->error('你已经登录，无需重复登录', url('Index/index'));
        }
        if ( Request::instance()->isPost() ) {
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

            $result = Auth::login($username, $password, $keeplogin ? 86400 : 0);
            if ($result === true) {
                $this->success('登录成功', url('Index/index'));
            } else {
                $this->error('用户名或密码错误');
            }
        }

        if ( Auth::autologin() ) {
            $this->redirect('Index/index');
        }
        return view('index');
    }

    public function logout() {
        session('admin', null);
        cookie('keeplogin', null);
        $this->success('退出成功', url('Login/index'));
    }
}