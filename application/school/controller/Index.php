<?php 
namespace app\school\controller;
use app\school\controller\Base;
use app\service\BannerService;
use app\service\MemberService;
use app\service\WechatService;
use think\Cookie;

class Index extends Base{
	protected $LessonService;
	public function _initialize(){
		parent::_initialize();
		Cookie::set('steward_type', 1);
        $module = request()->module();
        $homeurl = url($module.'/index/index');
        Cookie::set('module', $module);
        Cookie::set('homeurl', $homeurl);
	}

    public function index() {

	    $o_id = input('o_id', 0);
	    $o_type = input('o_type', 0);
        $this->o_id = $o_id;
        $this->o_type = $o_type;
        cookie('o_id', $o_id);
        cookie('o_type', $o_type);
        //$bannerList = db('banner')->where(['organization_id'=>0,'organization_type'=>0,'status'=>1,'steward_type' => 1])->order('ord asc')->limit(3)->select();
        // 培训管家banner
        $bannerService = new BannerService();
        $bannerList = $bannerService->bannerList([
            'organization_id'=>0,
            'organization_type'=>0,
            'status'=>1,
            'steward_type' => cookie('steward_type')
        ], 'ord desc', 3);
  
    	// 热门文章
        $ArticleService= new \app\service\ArticleService;
    	$ArticleList = $ArticleService->getArticleList([],1,'hot DESC',4);
    	//红包
        $bonus_type = input('param.bonus_type',1);
        //平台礼包
        $BonusService = new \app\admin\service\BonusService;
        $bonusInfo = $BonusService->getBonusInfo(['bonus_type'=>1,'status'=>1]);

        $couponList = [];
        $item_coupon_ids = [];
        if($bonusInfo){
            $res = $bonusInfo->toArray();
            $ItemCoupon = new \app\model\ItemCoupon;
            $couponList = $ItemCoupon->where(['target_type'=>-1,'target_id'=>$bonusInfo['id'],'status'=>1])->select();
            foreach ($couponList as $key => $value) {
                $item_coupon_ids[] = $value['id'];
            }
            $this->assign('item_coupon_ids',json_encode($item_coupon_ids));
            $this->assign('couponList',$couponList);
            
            // return $this->fetch('Widget:bonus');
            // return $this->fetch('Widget/Bonus');
        }
        //平台礼包结束
        $this->assign('bonusInfo',$bonusInfo);
    	$this->assign('bannerList',$bannerList);
    	$this->assign('ArticleList',$ArticleList);
        return view('Index/index');
    }

    // 机构版首页
    public function indexOfCamp(){
	    // 重定义homeurl
        cookie('homeurl', request()->url());
        // banner图
        $bannerList = db('banner')->where([
            'organization_id'=>$this->o_id,
            'organization_type'=>$this->o_type,
            'status'=>1,
            'steward_type' => cookie('steward_type')
        ])->order('ord asc')->limit(3)->select();

        // 如果banner不够三张
        if( count($bannerList)<2 ){
            $res = db('banner')->where([
                'organization_id'=>0,
                'organization_type'=>0,
                'status'=>1,
                'steward_type' => cookie('steward_type')
            ])->order('ord asc')->limit((3-count($bannerList)))->select();
            $bannerList = array_merge($bannerList,$res);
        }
        $this->assign('bannerList',$bannerList);
        return view('Index/indexOfCamp');
    }



    // 校园版版首页
    public function indexOfSchool(){
        // 重定义homeurl
        cookie('homeurl', request()->url());
        // banner图
        $bannerList = db('banner')->where([
            'organization_id'=>$this->o_id,
            'organization_type'=>$this->o_type,
            'status'=>1,
            'steward_type' => cookie('steward_type')
        ])->order('ord asc')->limit(3)->select();

        // 如果banner不够三张
        if( count($bannerList)<2 ){
            $res = db('banner')->where([
                'organization_id'=>0,
                'organization_type'=>0,
                'status'=>1,
                'steward_type' => cookie('steward_type')
            ])->order('ord asc')->limit((3-count($bannerList)))->select();
            $bannerList = array_merge($bannerList,$res);
        }
        $this->assign('bannerList',$bannerList);
        return view('Index/indexOfSchool');
    }



    // 微信授权回调
    public function wxindex() {
        $o_id = input('o_id', 0);
        $o_type = input('o_type', 0);
        $this->o_id = $o_id;
        $this->o_type = $o_type;
        cookie('o_id', $o_id);
        cookie('o_type', $o_type);

        $WechatS = new WechatService;
        $memberS = new MemberService();
        $userinfo = $WechatS->oauthUserinfo();
        if ($userinfo) {
            cache('userinfo_'.$userinfo['openid'], $userinfo);
            $avatar = str_replace("http://", "https://", $userinfo['headimgurl']);
            //$avatar = $memberS->downwxavatar($userinfo);
            
            $isMember = $memberS->getMemberInfo(['openid' => $userinfo['openid']]);
            if ($isMember) {
                unset($isMember['password']);
                cookie('mid', $isMember['id']);
                cookie('openid', $isMember['openid']);
                cookie('member', md5($isMember['id'].$isMember['member'].config('salekey')));
                session('memberInfo', $isMember, 'think');
                $this->redirect('schoole/Index/index',['o_id'=>0,'o_type'=>0]);
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
                $this->redirect('school/Index/index',['o_id'=>0,'o_type'=>0]);
            }
        } else {
            $this->redirect('school/index/index',['o_id'=>0,'o_type'=>0]);
        }
    }


    // 最近训练
    public function lastLyScheduleList(){
        return view('Index/lastLyScheduleList');
    }
    // 最近比赛
    public function lastLyMatchList(){
        return view('Index/lastLyMatchList');
    }
    // 最近活动
    public function lastLyEventList(){
        return view('Index/lastLyEventList');
    }
    // 训练营最近活动
    public function lastLyCampEventList(){
        return view('Index/lastLyCampEventList');
    }

}