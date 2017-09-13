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

    // 微信用户授权回调
    public function wxlogin() {
        $WechatS = new WechatService;
        $userinfo = $WechatS->oauthUserinfo();  
        if ($userinfo) {
            // 查询是否已注册
            $memberInfo = db('member')->where(['openid'=>$userinfo['openid']])->find();
            if($memberInfo){
                $re = session('memberInfo',$memberInfo,'think');
                $url = cookie('url');
                if($re){
                    $this->redirect($url);
                }else{
                    $this->redirect('frontend/Index/index');
                }
            }else{
            // 未注册
                $data = ['id'=>-1,'member'=>$userinfo['nickname'],'nickname'=>$userinfo['nickname'],'hp'=>0,'level'=>0,'avatar'=>$userinfo['headimgurl'],'openid'=>$userinfo['openid']];
                $re = session('memberInfo',$data,'think');
                $url = cookie('url');
                if($re){
                    $this->redirect($url);
                }else{
                    $this->redirect('frontend/Index/index');
                }
                
            }
            
        }else{
            $this->redirect('frontend/Index/index');
        }
        
    }

    public function fastRegister(){

        return view('Login/fastRegister');
    }
}