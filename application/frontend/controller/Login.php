<?php 
namespace app\frontend\controller;
use think\Controller;
use app\service\WechatService;
class Login extends Controller{
	
    public function index() {

        return view('Login/index');
    }

    public function login(){
        
    	return view('Login/login');
    }
    public function registerSuccess(){

    	return view('Login/registerSuccess');
    }
    public function loginSuccess(){
    	return view('Login/loginSuccess');
    }


    public function register(){
        $referer = input('param.referer');
        $pid = input('param.pid');
        $this->assign('pid',$pid);
        $this->assign('referer',$referer);
        return view('Login/register');
    }

    // 微信用户授权
    public function wxlogin() {
        session('memberInfo', null,'think');
        $WechatS = new WechatService();
        $userinfo = $WechatS->oauthUserinfo();
        //dump( $userinfo );
        if ($userinfo) {
            session('memberInfo.id', 0);
            session('memberInfo.openid', $userinfo['openid'], 'think');
            session('memberInfo.nickname', $userinfo['nickname'], 'think');
            session('memberInfo.avatar', $userinfo['headimgurl'], 'think');
        }
        //dump( session('memberInfo', '', 'think') );
        $this->redirect('frontend/Index/index');
    }
}