<?php 
namespace app\management\controller;
use think\Controller;
use app\management\service\AuthService;
use think\Cache;
use think\Session;
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
				$query -> where('member|telephone','=',$username)->where('password',passwd($password));
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
					$this->error("账号密码错误次数太多");
				}
				
			}
		}

		return view('Login/login');
	}


	public function test(){
		$l = db('grade_category')->select();
		// $c = channelLevel($l,0,'id');
		$d = getTree($l);
		// dump($c);
		// dump($d);
	}

	public function logout() {
        // $cache_tag  = strtolower('_sidebar_menus_'.session('admin.id'));
        // Cache::rm($cache_tag); 
        // $group_id = session('admin.group_id');
        // Cache::rm('group_id_menu_auth_'.$group_id); 
        // Cache::clear(); 
        Session::delete('memberInfo');
        cookie('member_id', null);
        //$this->success('退出成功', url('Login/index'));
        $this->redirect('Login/login');
    }

    public function clearCache(){
        // cookie('member_id', null);
        Cache::clear(); 
        // Session::delete('memberInfo');
        // Session::delete('camp_member');
        $this->success('清空成功');
    }

}