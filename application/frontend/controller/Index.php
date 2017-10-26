<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\LessonService;
use app\service\WechatService;
class Index extends Base{
	protected $LessonService;
	public function _initialize(){
		parent::_initialize();
		$this->LessonService = new LessonService;
	}

    public function index() {
        $page = input('param.page')?input('param.page'):1;
    	$bannerList = unserialize($this->systemSetting['banner']); 
    	// 热门课程
    	// $hotLessonList = $this->LessonService->getLessonList([],$page,'hot ASC',4);
    	//推荐课程
    	// $sortLessonList = $this->LessonService->getLessonList([],$page,'sort ASC',4);
    	$this->assign('bannerList',$bannerList);
    	// $this->assign('hotLessonList',$hotLessonList);
    	// $this->assign('sortLessonList',$sortLessonList);
        return view('Index/index');
    }

    // 微信用户授权回调
    public function wxindex() {
        $WechatS = new WechatService;
        $userinfo = $WechatS->oauthUserinfo();
        if ($userinfo) {
            cache('userinfo_'.$userinfo['openid'], $userinfo);
            $isMember = db('member')->where(['openid' => $userinfo['openid']])->find();
            if ($isMember) {
                unset($isMember['password']);
                cookie('mid', $isMember['id']);
                cookie('openid', $isMember['openid']);
                cookie('member', md5($isMember['id'].$isMember['member'].config('salekey')));
                session('memberInfo', $isMember, 'think');
                $this->redirect('frontend/Index/index');
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
                cookie('openid', $userinfo['openid']);
                cookie('member', md5($member['id'].$member['member'].config('salekey')) );
                session('memberInfo', $member, 'think');
                $this->redirect('frontend/Index/index');
            }
        } else {
            $this->redirect('frontend/index/index');
        }
    }
}
