<?php 
namespace app\frontend\controller;
use think\Controller;
use app\service\WechatService;
use think\Cookie;

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
            $isMember = db('member')->where(['openid' => $userinfo['openid']])->find();
            if ($isMember) {
                unset($isMember['password']);
                cookie('mid', $isMember['id']);
                cookie('member', md5($isMember['id'].$isMember['member'].config('salekey')));
                session('memberInfo', $isMember, 'think');
                if (session('memberInfo', '', 'think')) {
                    if( Cookie::has('url') ){
                        $url = cookie('url');
                        cookie('url',null);
                        $this->redirect( $url );
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
                    'avatar' => str_replace("http://", "https://", $userinfo['headimgurl']),
                    'hp' => 0,
                    'level' => 0,
                    'telephone' =>'',
                    'email' =>'',
                    'realname'  =>'',
                    'province'  =>'',
                    'city'  =>'',
                    'area'  =>'',
                    'location'  =>'',
                    'sex'   =>0,
                    'height'    =>0,
                    'weight'    =>0,
                    'charater'  =>'',
                    'shoe_code' =>0,
                    'birthday'  =>'0000-00-00',
                    'create_time'=>0,
                    'pid'   =>0,
                    'hp'    =>0,
                    'cert_id'   =>0,
                    'score' =>0,
                    'flow'  =>0,
                    'balance'   =>0,
                    'remarks'   =>0,
                    'hot_id'=>00000000,
                ];
                cookie('mid', 0);
                cookie('member', md5($member['id'].$member['member'].config('salekey')) );
                session('memberInfo', $member, 'think');
                if (session('memberInfo', '', 'think')) {
                    if( Cookie::has('url') ){
                        $url = cookie('url');
                        cookie('url',null);
                        $this->redirect( $url );
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
        $WechatS = new WechatService;
        $userinfo = $WechatS->oauthUserinfo();
        if ($userinfo) {
            $member = [
                'openid' => $userinfo['openid'],
                'nickname' => $userinfo['nickname'],
                'avatar' => str_replace("http://", "https://", $userinfo['headimgurl']),
            ];
            cookie('mid', 0);
            //cookie('member', md5($member['id'].$member['member'].config('salekey')) );
            session('memberInfo', $member, 'think');
        }
//        dump( cookie('url') );
//        dump( session('memberInfo') );
        return view('Login/fastRegister');
    }
}