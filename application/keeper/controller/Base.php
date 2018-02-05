<?php 
namespace app\keeper\controller;
use think\Controller;
use app\service\SystemService;
use app\service\MemberService;
use think\Cookie;
use think\Request;
use app\service\WechatService;

class Base extends Controller{
	public $systemSetting;
	public $memberInfo;
	public function _initialize(){
        $memberS = new MemberService();
	    // 从模板消息url进入 带有openid字段 保存会员登录信息
	    if ( input('?param.openid') ) {
            $member = $memberS->getMemberInfo(['openid' => input('param.openid')]);
            if ($member) {
                cookie('mid', $member['id']);
                cookie('member', md5($member['id'].$member['member'].config('salekey')) );
                session('memberInfo', $member, 'think');
            }
        }

		$url = cookie('url');
		if(!$url){
//			$url = $_SERVER["REQUEST_URI"];
//			cookie('url', $url);
            cookie('url', \request()->url(), 1800);
		}
		/*$pid = input('param.pid');
		if($pid){
			cookie('pid',$pid);
		}else{
			cookie('pid',0);
		}*/
		// 获取推荐人信息
        $pmember = [];
		if ( input('?param.pid') ) {
		    $pid = input('param.pid');
            $pmember = $memberS->getMemberInfo(['id' => $pid]);
            if ($pmember) {
                cookie('pid', $pmember['id']);
            } else {
                cookie('pid', null);
            }
        }
		$this->systemSetting = SystemService::getSite();

        if ( !Cookie::has('mid') ) {
            $this->nologin();
        }
        $this->memberInfo = session('memberInfo', '', 'think');
        $this->assign('memberInfo', $this->memberInfo);
        //提示完善信息对话框链接
        $wechatS = new WechatService();
        $fastRegisterInwx = $wechatS->oauthredirect(  url('login/fastRegister', '', '', true) );
        $fasturl = $this->is_weixin() ? $fastRegisterInwx : url('login/login');

        // 微信分享信息链接
        $shareurl = request()->url(true);
        $jsapi = $wechatS->jsapi($shareurl);

        $this->assign('shareurl', $shareurl);
        $this->assign('jsapi', $jsapi);
        $this->assign('fasturl', $fasturl);
        $this->assign('mid', cookie('mid'));
        $this->assign('systemSetting',$this->systemSetting);
        $this->assign('pmember', $pmember);
        $this->footMenu();
	}



	protected function footMenu(){
		define('CONTROLLER_NAME',Request::instance()->controller());
		define('MODULE_NAME',Request::instance()->module());
		define('ACTION_NAME',Request::instance()->action());
        $indexAction = 'index';

		$footMenu =  [
			[
				'name'=>'首页',
				'icon'=>'icon iconfont icon-nav-Home',
				'action'=>$indexAction,
				'controller'=>'Index',
                'module' => 'keeper'
			],
			[
				'name'=>'消息',
				'icon'=>'icon iconfont icon-nav-news',
				'action'=>'index',
				'controller'=>'Message',
                'module' => 'frontend'
			],			
			[
				'name'=>'发现',
				'icon'=>'icon iconfont icon-nav-Find',
				'action'=>'index',
				'controller'=>'Find',
                'module' => 'frontend'
			],
			[
				'name'=>'我的',
				'icon'=>'icon iconfont icon-nav-Camp',
				'action'=>'index',
				'controller'=>'Team',
                'module' => 'keeper'
			],
			[
				'name'=>'个人',
				'icon'=>'icon iconfont icon-nav-mine',
				'action'=>'index',
				'controller'=>'Member',
                'module' => 'frontend'
			],
		];
		$this->assign('footMenu',$footMenu);
	}

	protected function nologin(){

		// $this->redirect('Test/index');
		/*$result = $this->is_weixin();
		 * if($result){
			$WechatService = new WechatService;
			$callback = url('login/wxlogin','','', true);
			$this->redirect($WechatService -> oauthredirect($callback));
		}else{
			$memberInfo = ['id'=>-1,'member'=>'游客','hp'=>0,'level'=>0,'avatar'=>'/static/default/avatar.png','nickname'=>'游客'];
			unset($memberInfo['password']);
	    	$cookie = md5($memberInfo['id'].$memberInfo['member'].'hot');
	    	cookie('member',md5($memberInfo['id'].$memberInfo['member'].'hot'));
			$re = session('memberInfo',$memberInfo , 'think');
			$url = cookie('url');
            if($re){
                $this->redirect($url);
            }else{
            	$this->redirect('Index/index');
            }
		}*/
		if ($this->is_weixin()) {
            $wechatS = new WechatService();
            $callback = url('frontend/login/wxlogin', '', '', true);
            $this->redirect( $wechatS->oauthredirect($callback) );
        } else {
		    //echo 'other';
            Cookie::set('mid', 0);
            $member = [
                'id' => 0,
                'member' => '游客',
                'nickname' => '游客',
                'avatar' => '/static/default/avatar.png',
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
            	$url = cookie('url');
            	cookie('url',null);
                $this->redirect( $url );
            } else {
                $this->redirect('keeper/Index/index');
            }
        }
	}

	

	// 判断是否是微信浏览器
	function is_weixin() { 
	    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) { 
	        // 微信
            return true;
	    } else {
            return false;
        }
	}

    // 用户openid是否有会员信息
    public function checkopenid() {
        if (cookie('openid')) {
            $openid = cookie('openid');
            $memberS = new MemberService();
            $memberInfo = $memberS->getMemberInfo(['openid' => $openid]);
            if ($memberInfo) {
                unset($memberInfo['password']);
                cookie('mid', $memberInfo['id']);
                cookie('openid', $memberInfo['openid']);
                cookie('member', md5($memberInfo['id'].$memberInfo['member'].config('salekey')) );
                session('memberInfo', $memberInfo, 'think');
                $this->memberInfo = $memberInfo;
                return json(['code' => 200, 'msg' => 1, 'data' => $memberInfo]);
            } else {
                $userinfo = cache('userinfo_'.$openid);
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
//                cookie('mid', 0);
                cookie('openid', $userinfo['openid']);
                cookie('member', md5($member['id'].$member['member'].config('salekey')) );
                session('memberInfo', $member, 'think');
                $this->memberInfo = $member;
                return json(['code' => 200, 'msg' => -1, 'data' => $member]);
            }
        } else {
            $member = [
                'id' => 0,
                'member' => '游客',
                'nickname' => '游客',
                'avatar' => '/static/default/avatar.png',
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
//            cookie('mid', 0);
            cookie('member', md5($member['id'].$member['member'].config('salekey')) );
            session('memberInfo', $member, 'think');
            $this->memberInfo = $member;
            return json(['code' => 200, 'msg' => 0, 'data' => $member]);
        }
    }
}