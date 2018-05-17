<?php 
namespace app\school\controller;
use app\service\CampService;
use think\Controller;
use app\service\SystemService;
use app\service\MemberService;
use think\Cookie;
use think\Request;
use app\service\WechatService;
use app\common\controller\Frontend;

class Base extends Frontend {
	public $systemSetting;
    public $o_id;
    public $o_type;
    public $steward_type;
	public function _initialize(){
        parent::_initialize(); // TODO: Change the autogenerated stub
        $sessionMember = session('memberInfo', '', 'think');
        if ( !Cookie::has('mid') || empty($sessionMember) ) {
            $this->nologin(); 
        }
        $this->footMenu();
	}



	protected function footMenu(){
        $o_id = input('param.o_id');
        $o_type = input('param.o_type');       
        if(!$o_type && !$o_id){
            $o_type = cookie('o_type');
            $o_id = cookie('o_id'); 
            $this->o_id = $o_id;
            $this->o_type = $o_type;
        }else{
            $this->o_id = $o_id;
            $this->o_type = $o_type;
            cookie('o_id',$this->o_id);
            cookie('o_type',$this->o_type);
        }
        /*define('CONTROLLER_NAME',Request::instance()->controller());
        define('MODULE_NAME',Request::instance()->module());
        define('ACTION_NAME',Request::instance()->action());*/
        $request = Request::instance();
        if($this->o_id<>0 && $this->o_type<>0){
            $indexAction = 'indexOfCamp';
        }else{
            $indexAction = 'index';
        }
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
				'action'=>'index',
				'controller'=>'Camp',
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

		// 机构版获取训练营信息
		if ($this->o_id && $this->o_type==1) {
		    $campS = new CampService();
		    $campInfo = $campS->getCampInfo(['id' => $this->o_id, 'status' => 1]);
		    $this->assign('orgCampInfo', $campInfo);
        }
        $this->assign('o_id',$this->o_id);
        $this->assign('o_type',$this->o_type);
        $this->assign('controller', $request->controller());
		$this->assign('footMenu',$footMenu);
	}

	protected function nologin(){
		if ($this->is_weixin()) {
            $wechatS = new WechatService();
            $callback = url('school/login/wxlogin', '', '', true);
            $this->redirect( $wechatS->oauthredirect($callback) );
        } else {
		    //echo 'other';
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
                'age' => 0,
                'fans' => 0
            ];
            cookie('mid', 0);
            cookie('member', md5($member['id'].$member['member'].config('salekey')) );
            session('memberInfo', $member, 'think');
            $this->memberInfo = session('memberInfo', '', 'think');
            $url = cookie('url');
            cookie('url',null);
            $this->redirect( $url );
        }
	}

}