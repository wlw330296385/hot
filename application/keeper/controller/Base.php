<?php 
namespace app\keeper\controller;
use app\common\controller\Frontend;
use think\Controller;
use app\service\SystemService;
use app\service\MemberService;
use think\Cookie;
use think\Request;
use app\service\WechatService;

class Base extends Frontend {
	public $systemSetting;
	public $memberInfo;
    public $steward_type; // 管家版本
	public function _initialize(){
        parent::_initialize();
        $this->steward_type =2;

        if ( !Cookie::has('mid') ) {
            $this->nologin();
        }


        $this->footMenu();

	}



	protected function footMenu(){
		$request = Request::instance();
        $indexAction = 'index';
        $module = (Cookie::has('module')) ? Cookie::get('module') : $request->module();
		$footMenu =  [
			[
				'name'=>'首页',
				'icon'=>'icon iconfont icon-nav-Home',
				'action'=>$indexAction,
				'controller'=>'Index',
                'module' => $module
			],
			[
				'name'=>'消息',
				'icon'=>'icon iconfont icon-nav-news',
				'action'=>'index',
				'controller'=>'Message',
                'module' => $module
			],
			[
				'name'=>'发现',
				'icon'=>'icon iconfont icon-nav-Find',
				'action'=>'index',
				'controller'=>'Find',
                'module' => $module
			],
			[
				'name'=>'我的',
				'icon'=>'icon iconfont icon-nav-Camp',
				'action'=>'myteam',
				'controller'=>'Team',
                'module' => $module
			],
			[
				'name'=>'个人',
				'icon'=>'icon iconfont icon-nav-mine',
				'action'=>'index',
				'controller'=>'Member',
                'module' => $module
			],
		];
		$this->assign('controller', $request->controller());
		$this->assign('footMenu',$footMenu);
	}

	protected function nologin(){

		if ($this->is_weixin()) {
            $wechatS = new WechatService();
            $callback = url('keeper/login/wxlogin', '', '', true);
            $this->redirect( $wechatS->oauthredirect($callback) );
        } else {
		    //echo 'other';
            Cookie::set('mid', 0);
            $member = [
                'id' => 0,
                'member' => '游客',
                'nickname' => '游客',
                'avatar' => config('default_image.member_avatar'),
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

}
