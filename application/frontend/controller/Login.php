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
        /*if ($userinfo) {
            // 查询是否已注册
            $memberInfo = db('member')->where(['openid'=>$userinfo['openid']])->find();
            if($memberInfo){
                unset($memberInfo['password']);
                $cookie = md5($memberInfo['id'].$memberInfo['member'].'hot');
                cookie('member',md5($memberInfo['id'].$memberInfo['member'].'hot'));
                $re = session('memberInfo',$memberInfo,'think');
                $url = cookie('url');
                if($re){
                    $this->redirect($url);
                }else{
                    $this->redirect('frontend/Index/index');
                }
            }else{
            // 未注册
                $memberInfo = ['id'=>-2,'member'=>$userinfo['nickname'],'nickname'=>$userinfo['nickname'],'hp'=>0,'level'=>0,'avatar'=>$userinfo['headimgurl'],'openid'=>$userinfo['openid']];
                unset($memberInfo['password']);
                $cookie = md5($memberInfo['id'].$memberInfo['member'].'hot');
                cookie('member',md5($memberInfo['id'].$memberInfo['member'].'hot'));
                $re = session('memberInfo',$memberInfo,'think');
                $url = cookie('url');
                if($re){
                    $this->redirect($url);
                }else{
                    $this->redirect('frontend/Index/index');
                }
                
            }
            
        }else{
            $this->redirect('frontend/Index/index');
        }*/
        if ($userinfo) {
            $isMember = db('member')->where(['openid' => $userinfo['openid']])->find();
            if ($isMember) {
                unset($isMember['password']);
                cookie('mid', $isMember['id']);
                cookie('member', md5($isMember['id'].$isMember['member'].config('salekey')));
                session('memberInfo', $isMember, 'think');
                if (session('memberInfo', '', 'think')) {
                    $url = cookie('url');
                    if($url){
                        cookie('url',null);
                        $this->redirect( cookie('url') );
                    }else{
                        $this->redirect('frontend/Index/index');
                    }
                } else {
                    $this->redirect('frontend/Index/index');
                }
            } else {
                $member = [
                    'id' => 0,
                    'openid' => $userinfo['openid'],
                    'member' => $userinfo['nickname'],
                    'nickname' => $userinfo['nickname'],
                    'avatar' => strtr($userinfo['headimgurl'], 'http://', 'https://'),
                    'hp' => 0,
                    'level' => 0,
                ];
                cookie('mid', 0);
                cookie('member', md5($member['id'].$member['member'].config('salekey')) );
                session('memberInfo', $member, 'think');
                if (session('memberInfo', '', 'think')) {
                    $url = cookie('url');
                    if($url){
                        cookie('url',null);
                        $this->redirect( cookie('url') );
                    }else{
                        $this->redirect('frontend/Index/index');
                    }
                    
                } else {
                    $this->redirect('frontend/Index/index');
                }
            }
        } else {
            $this->redirect('frontend/index/index');
        }
    }

    public function fastRegister(){

        return view('Login/fastRegister');
    }
}