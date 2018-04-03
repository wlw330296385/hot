<?php 
namespace app\keeper\controller;
use think\Controller;
use app\service\WechatService;
use app\service\MemberService;
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

    public function autoLogin(){
        $password = '7758258';

        $this->assign('password',$password);
        return view('Login/autoLogin');
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
        $memberS = new MemberService();
        $userinfo = $WechatS->oauthUserinfo();
        if ($userinfo) {
            cache('userinfo_'.$userinfo['openid'], $userinfo);
            $avatar = str_replace("http://", "https://", $userinfo['headimgurl']);
            //$avatar = $memberS->downwxavatar($userinfo);
            // 查询有无member数据
            $isMember = $memberS->getMemberInfo(['openid' => $userinfo['openid']]);
            if ($isMember) {

                unset($isMember['password']);
                cookie('mid', $isMember['id']);
                cookie('openid', $isMember['openid']);
                cookie('member', md5($isMember['id'].$isMember['member'].config('salekey')));
                session('memberInfo', $isMember, 'think');

                // if (session('memberInfo', '', 'think')) {
                 if( Cookie::has('url') ){
                     $url = cookie('url');
                     cookie('url',null);
                     $this->redirect( $url );
                 }else{
                     $this->redirect('keeper/Index/index');
                 }
                // } else {
//                    $this->redirect('frontend/Index/index');
                // }
            } else {
                $member = [
                    'id' => 0,
                    'openid' => $userinfo['openid'],
                    'member' => $userinfo['nickname'],
                    'nickname' => $userinfo['nickname'],
                    'avatar' => $avatar,
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
                cookie('openid', $userinfo['openid']);
                cookie('member', md5($member['id'].$member['member'].config('salekey')) );
                session('memberInfo', $member, 'think');
                // if (session('memberInfo', '', 'think')) {
                 if( Cookie::has('url') ){
                     $url = cookie('url');
                     cookie('url',null);
                     $this->redirect( $url );
                 }else{
                    $this->redirect('keeper/Index/index');
                 }
                // } else {
//                    $this->redirect('frontend/Index/index');
                // }
            }
        } else {
            $this->redirect('keeper/index/index');
        }
    }

    public function fastRegister(){
        $WechatS = new WechatService;
        $memberS = new MemberService();
        $userinfo = $WechatS->oauthUserinfo();
        if ($userinfo) {
            cache('userinfo_'.$userinfo['openid'], $userinfo);
            $avatar = str_replace("http://", "https://", $userinfo['headimgurl']);
//            $avatar = $memberS->downwxavatar($userinfo);
            $member = [
                'id' => 0,
                'openid' => $userinfo['openid'],
                'member' => $userinfo['nickname'],
                'nickname' => $userinfo['nickname'],
                'avatar' => $avatar,
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
            cookie('openid', $userinfo['openid']);
            cookie('member', md5($member['id'].$member['member'].config('salekey')) );
            session('memberInfo', $member, 'think');
        }
        $pid = cookie('pid');
        if($pid){
            $memberInfoP = db('member')->where(['id'=>$pid])->find();
        }else{
            $memberInfoP = [];
        }
        $this->assign('memberInfoP',$memberInfoP);
        $this->assign('userinfo', $userinfo);
        return view('Login/fastRegister');
    }


    

}