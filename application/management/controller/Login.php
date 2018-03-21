<?php 
namespace app\management\controller;
use think\Controller;
use app\management\service\AuthService;
/**
* 用户登录模块
*/
class Login extends Controller
{
	
	function __construct()
	{
		# code...
	}

	public function login(){
		if (cookie('member_id')) {
            $this->error('你已经登录，无需重复登录', url('Index/index'));
        }
		if(request()->isPost()){
			$username = input('post.username');

			$password = input('post.password');

			$keeplogin = input('post.keeplogin',3600);
			$map = function($query) use ($password,$username){
				$query -> where(function ($query2)  use ($password,$username){
    					$query2->where('telephone', $username)->whereor('member', $username);
					}	
				)->where('password',$password);
			}

			$AuthService = new AuthService;
			$result = $AuthService ->login($map,$keeplogin);

			if($result){
				$this->success('登陆成功', url('Index/index'));
			}else{
				$this->error('账号密码错误', url('Index/index'));
			}
		}

		// return view('Login/login');
	}



}