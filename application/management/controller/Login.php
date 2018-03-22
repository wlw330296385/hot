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
            $this->error('你已经登录，无需重复登录', url('Guider/choose'));
        }
		if(request()->isPost()){
			$username = input('post.username');

			$password = input('post.password');

			$keeplogin = input('post.keeplogin',3600);
			$map = function($query) use ($password,$username){
				$query -> where('member|telephone','=',$username)->where('password',$password);
			};
			$AuthService = new AuthService;
			$result = $AuthService ->login($map,$keeplogin);
			if($result){
				$this->success('登陆成功,请选择你的身份', url('Guider/choose'));
			}else{
				$lock = cache('lock');
				if($lock<6){
					$num = $lock++;
					cache('lock',$num);
					// $this->error("账号密码错误,错误6次需要更改密码,已错{$lock}次");
					$this->error("账号密码错误");
				}else{
					$this->error("账号密码错误次数太多,已被锁定");
				}
				
			}
		}

		// return view('Login/login');
	}



}