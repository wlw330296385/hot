<?php 
namespace app\keeper\controller;
use app\keeper\controller\Base;
use app\service\MemberService;
use app\service\WechatService;
use app\service\BannerService;
use app\service\TeamService;
use app\service\MatchService;
use app\model\MatchRecord;
use app\model\TeamEvent;
use think\Db;
use think\Cookie;

class Index extends Base{
	protected $LessonService;
	public function _initialize(){
		parent::_initialize();
        Cookie::set('steward_type', 2);
        $module = request()->module();
        $homeurl = url($module.'/index/index');
        Cookie::set('module', $module);
        Cookie::set('homeurl', $homeurl);
	}

    public function index() {

        //$bannerList = db('banner')->where(['organization_type'=>0,'status'=>1, 'steward_type' => 2])->order('ord asc')->limit(3)->select();
        // 球队管家banner
        $bannerService = new BannerService();
        $bannerList = $bannerService->bannerList([
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

        // 获取所在球队列表 获取距离现在最近的一条 球队活动/比赛
        $teamS = new TeamService();
        $matchS = new MatchService();
        $memberInTeam = $teamS->myTeamAll($this->memberInfo["id"]);
        $lastMatchRecord = "";
        $lastEvent = "";
        $myTeamId = 0;
        $teamIds = [];
        if ($memberInTeam) {
            foreach ($memberInTeam as $team) {
                array_push($teamIds, $team['team_id']);
            }
            $map['team_id'] = ['in', $teamIds];
            $map['status'] = 1;
            $teamEventModel = new TeamEvent();
            $lastEvent = $teamEventModel->field('*, abs(unix_timestamp(now()) - `start_time`) AS diff') -> where($map)->order('diff asc')->find();
            if (!empty($lastEvent)) {
                $lastEvent = $lastEvent -> toArray();
                $lastEvent['memberlist'] = $teamS->teamEventMembers(['event_id' => $lastEvent['id'], 'status' => ['>', 0]]);
                $lastEvent['start_time_ts'] = strtotime($lastEvent['start_time']);
            }

            unset($map);
            $map['match_record.home_team_id|match_record.away_team_id'] = ['in', $teamIds];

            // 比赛场次 和里面统一
            $matchs = db('match')->join('match_record','match.id = match_record.match_id')
            ->where($map)
            ->where("`match_org_id` = 0 OR `is_record` = 1")
            ->where("match.delete_time IS NULL")
            ->order("match_record.match_time desc")
            ->count();

            $matchRecordModel = new MatchRecord();
            $lastMatchRecord = $matchRecordModel->field('*, abs(unix_timestamp(now()) - `match_time`) AS diff') -> where($map)->order('diff asc')->find();

            if (!empty($lastMatchRecord)) {
                $lastMatchRecord = $lastMatchRecord -> toArray();
                foreach($teamIds as $tempId) {
                    if ( $tempId == $lastMatchRecord["home_team_id"] ) {
                        $myTeamId = $tempId;break;
                    } else if ($tempId == $lastMatchRecord["away_team_id"]) {
                        $myTeamId = $tempId;break;
                    }
                }
                $lastMatchRecord['reg_number'] = $matchS->getMatchRecordMemberCount([
                    'match_record_id' => $lastMatchRecord['id'],
                    'team_id' => $myTeamId,
                    'status' => ['>', 0],
                    'team_member_id' => ['>', 0]
                ]);
                $lastMatchRecord['max'] = $teamS->getTeamMemberCount(['team_id' => $myTeamId, 'status' => 1]);
                $lastMatchRecord['match_time_ts'] = strtotime($lastMatchRecord['match_time']);
            }

        }

        // 统计
        $totalPunch = db('punch')->where(['member_id'=>$this->memberInfo['id']])->count();
        $fans = db('follow')->where(['follow_id'=>$this->memberInfo['id'],'type'=>1,'status'=>1])->count();
        $teams = count($teamIds);
        
        $matchs = empty($matchs) ? 0 : $matchs;

        $matchDiff = empty($lastMatchRecord["diff"]) ? 0 : $lastMatchRecord["diff"];
        $eventDiff = empty($lastEvent["diff"]) ? 0 : $lastEvent["diff"];
        if ($matchDiff < $eventDiff) {
            $uiQueue = array('match', 'event');
        } else {
            $uiQueue = array('event', 'match');
        }

        $this->assign('totalPunch',$totalPunch);
    	$this->assign('bannerList',$bannerList);
        $this->assign('fans',$fans);
        $this->assign('teams',$teams);
        $this->assign('myTeamId',$myTeamId);
        $this->assign('matchs',$matchs);
        $this->assign('ArticleList',$ArticleList);
        $this->assign('bonusInfo',$bonusInfo);
        $this->assign('lastEvent',$lastEvent);
        $this->assign('lastMatchRecord',$lastMatchRecord);
        $this->assign('uiQueue',$uiQueue);
        return view('Index/index');
    }

    // 微信授权回调
    public function wxindex() {
        $WechatS = new WechatService;
        $memberS = new MemberService();
        $userinfo = $WechatS->oauthUserinfo();
        if ($userinfo) {
            cache('userinfo_'.$userinfo['openid'], $userinfo);
            $avatar = str_replace("http://", "https://", $userinfo['headimgurl']);
            //$avatar = $memberS->downwxavatar($userinfo);

            //$dbMember = db('member');
            $isMember = $memberS->getMemberInfo(['openid' => $userinfo['openid']]);
            if ($isMember) {
                unset($isMember['password']);
                cookie('mid', $isMember['id']);
                cookie('openid', $isMember['openid']);
                cookie('member', md5($isMember['id'].$isMember['member'].config('salekey')));
                session('memberInfo', $isMember, 'think');
                $this->redirect('keeper/Index/index');
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
                    'hot_coin'=>0,
                    'age' => 0,
                    'fans' => 0
                ];
                cookie('mid', 0);
                cookie('openid', $userinfo['openid']);
                cookie('member', md5($member['id'].$member['member'].config('salekey')) );
                session('memberInfo', $member, 'think');
                $this->redirect('keeper/Index/index');
            }
        } else {
            $this->redirect('keeper/index/index');
        }
    }

     // 最近赛事列表
     public function lateLyMatchList() {
        $team_id = input('team_id');
        $teamS = new TeamService();
        $teamInfo = $teamS->getTeam(['id' => $team_id]);
        $this->assign('team_id', $team_id);
        $this->assign('teamInfo', $teamInfo);
        return view('Index/lateLyMatchList');
    }

    // 最近活动列表
    public function lateLyEventList() {
        $team_id = input('team_id');
        $teamS = new TeamService();
        $teamInfo = $teamS->getTeam(['id' => $team_id]);
        $this->assign('team_id', $team_id);
        $this->assign('teamInfo', $teamInfo);
        return view('Index/lateLyEventList');
    }
}
