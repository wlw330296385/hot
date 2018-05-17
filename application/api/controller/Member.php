<?php

namespace app\api\controller;

use app\api\controller\Base;
use app\service\FollowService;
use app\service\MatchDataService;
use app\service\MatchService;
use app\service\MemberService;
use app\service\ScheduleMemberService;
use app\service\TeamService;
use app\service\WechatService;
use think\Exception;

class Member extends Base{
	private $SalaryOut;
    private $MemberService;

    public function _initialize()
    {
        parent::_initialize();
        $this->MemberService = new MemberService;
        $this->SalaryOut = new SalaryOut;
    }

    public function index()
    {


    }
    public function getMemberInfoApi(){
        try{
            $map = input('post.');
            $result = $this->MemberService->getMemberInfo($map);
            if($result){
               return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
               return json(['code'=>100,'msg'=>'不存在该用户']);
            }
        }catch(Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }


    // 提现申请
    public function withdrawApi(){
    	try{
    		$data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            // 余额
            if($memberInfo['balance']<$data['money']){
                return json(['code'=>200,'msg'=>'余额不足']);die;
            }
         	$result = $this->SalaryOut->saveSalaryOut($data);
         	return json($result);
    	}catch (Exception $e){
    		return json(['code'=>200,'msg'=>$e->getMessage()]);
    	}

    }


    // 编辑个人资料
    public function updateMemberApi()
    {
        try {
            $member_id = $this->memberInfo['id'];
            $data = input('post.');
            // 打球时间为空处理
            $data['yearsexp'] = empty($data['yearsexp']) ? null : $data['yearsexp'];
            // 更新member数据
            $result = $this->MemberService->updateMemberInfo($data, ['id'=>$member_id]);
            if ($result['code'] == 200) {
                // 性别发生更新：教练、裁判更新
                if ( $data['sex'] != $this->memberInfo['sex'] ) {
                    $coachS = new \app\service\CoachService();
                    $coach = $coachS->coachInfo(['member_id' => $member_id]);
                    if ($coach) {
                        $coachS->updateCoach([
                            'sex' => $data['sex']
                        ], $coach['id']);
                    }
                }
                // 更新member数据成功 同步更新会员所在球队的球员信息
                $teamS = new TeamService();
                $teamS->saveTeamMember([
                    'age' => $result['data']['age'],
                    'birthday' => $result['data']['birthday'],
                    'height' => $result['data']['height'],
                    'weight' => $result['data']['weight'],
                    'yearsexp' => $result['data']['yearsexp']
                ], ['member_id' => $result['data']['id'], 'status' => 1]);
            }
            return json($result);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }


    // 注销登录
    public function logout()
    {
        try {

            $member = [
                'id' => 0,
                'openid' => '',
                'member' => '游客',
                'nickname' => '游客',
                'avatar' => config('default_image.member_avatar'),
                'hp' => 0,
                'level' => 0,
                'telephone' => '',
                'email' => '',
                'realname' => '',
                'province' => '',
                'city' => '',
                'area' => '',
                'location' => '',
                'sex' => 0,
                'height' => 0,
                'weight' => 0,
                'charater' => '',
                'shoe_code' => 0,
                'birthday' => '0000-00-00',
                'create_time' => 0,
                'pid' => 0,
                'hp' => 0,
                'cert_id' => 0,
                'score' => 0,
                'flow' => 0,
                'balance' => 0,
                'remarks' => 0,
                'hot_id' => 00000000,
                'age' => 0,
                'fans' => 0
            ];
            cookie('mid', null);
            cookie('member', $member);
            cookie('openid', null);
            cookie('homeurl', null);
            cookie('url', null);
            cookie('module', null);
            cookie('visit_history', null);
            cookie('o_id', null);
            cookie('o_type', null);
            $result = session('memberInfo', $member, 'think');
            return json(['code' => 200, 'msg' => '注销成功']);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 更换微信 生成二维码
    public function changewxqrcode()
    {
        try {
            $member = $this->memberInfo;
            //dump($member);
            if (!$member) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            $wechatS = new WechatService();
            $guid = sha1(get_code(12));
            $url = $wechatS->oauthredirect(url('frontend/wechat/bindwx', ['memberid' => $member['id'], 'guid' => $guid], '', true));
            //dump($url);
            $qrcode = buildqrcode($url);
            $sseurl = url('frontend/wechat/bindwxsse', ['guid' => $guid], '', true);
            $response = [
                'url' => $url,
                'qrcode' => $qrcode,
                'sseurl' => $sseurl
            ];
            return json(['code' => 200, 'data' => $response]);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 更换微信 修改操作
    public function changewx()
    {
        try {
            $memberid = input('post.memberid');
            $newopenid = input('post.newopenid');
            $guid = input('post.guid');

            if (!$newopenid || !$guid) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }

            // 查询会员数据
            $memberS = new MemberService();
            $member = $memberS->getMemberInfo(['id' => $memberid]);
            if (!$member) {
                return json(['code' => 100, 'msg' => '会员信息' . __lang('MSG_401')]);
            }

            if ($member['openid'] == $newopenid) {
                return json(['code' => 100, 'msg' => '请使用新的微信号进行绑定']);
            }

            $newwx = cache('userinfo_' . $newopenid);
            if (!$newwx) {
                return json(['code' => 100, 'msg' => '信息过期,请重新扫码']);
            }

            // 新微信号 已有会员数据 清理微信openid
            $ismember = $memberS->getMemberInfo(['openid' => $newopenid]);
            if ($ismember) {
//                return json(['code' => 100, 'msg' => '更换的微信号已是会员,不能更换']);
                $cleanmemberopenid = db('member')->update([
                    'id' => $ismember['id'],
                    'openid' => '',
                    'update_time' => time()
                ]);
                if (!$cleanmemberopenid) {
                    return json(['code' => 100, 'msg' => '新微信号的会员解绑'.__lang('MSG_400')]);
                }
            }

            // 更换微信号绑定
            $updateMember = db('member')->update([
                'id' => $member['id'],
                'openid' => $newwx['openid'],
                'nickname' => $newwx['nickname'],
                'avatar' => str_replace("http://", "https://", $newwx['headimgurl']),
                'update_time' => time()
            ]);

            if (!$updateMember) {
                return json(['code' => 100, 'msg' => '修改微信绑定'.__lang('MSG_400')]);
            } else {
                // 设置新会员信息 session cookie
                $newmember = $memberS->getMemberInfo(['id' => $memberid]);
                cookie('mid', $newmember['id']);
                cookie('member', md5($newmember['id'].$newmember['member'].config('salekey')) );
                session('memberInfo', $newmember, 'think');

                cache('memberchangewx_'.$guid, $newmember);
                return json(['code' => 200, 'msg' => '修改微信绑定'.__lang('MSG_200')]);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
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
                    'age' => 0
                ];
//                cookie('mid', 0);
                cookie('member', md5($member['id'].$member['member'].config('salekey')) );
                session('memberInfo', $member, 'think');
                $this->memberInfo = $member;
                return json(['code' => 100, 'msg' => -1, 'data' => $member]);
            }
        }
    }


    // 修改密码
    public function updatePasswordApi(){
        try{
            $data = input('post.');
            if(!isset($data['newpassword']{5}) || isset($data['newpassword']{16})){
                return json(['code'=>100,'msg'=>'长度须6~16之间']);
            }
            $password = passwd($data['password']);
            $newpassword = passwd($data['newpassword']);
            $repassword = passwd($data['repassword']);
            
            if($newpassword<>$repassword){
                return json(['code'=>100,'msg'=>'两次密码不一样']);
            }
            $memberInfo = $this->MemberService->getMemberInfo(['id'=>$this->memberInfo['id']]);
            if($password<>$memberInfo['password']){
                return json(['code'=>100,'msg'=>'原密码错误']);
            }

            $result = $this->MemberService->updateMemberInfo(['password'=>$newpassword],['id'=>$this->memberInfo['id']]);
            return json($result);
        }catch (Exception $e){
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 忘记密码
    public function forgetPassword(){
        try{
            $code = mt_rand(100000, 999999);
            $content = ['code'=>$code, 'comName' => '篮球管家'];
            $smsApi = new \app\api\controller\Sms;
            $result = $smsApi->sendSmsCodeApi($content,$this->memberInfo['telephone'],'T170317001882','[忘记密码]'); 
            if($result['code']==200){
                $res = db('member')->where(['id'=>$this->memberInfo['id']])->update(['password'=>passwd($code)]);
                if($res){
                    return json(['code'=>200,'msg'=>'密码已重置,请注意收到的手机短信']);
                }else{
                    return json(['code'=>100,'msg'=>'密码重置失败']);
                }
                
            }else{
                return json($result); 
            }
              
        }catch(Exception $e){
            return json(['code' => 100, 'msg' => $e->getMessage()]);  
        }
    }

    // 清理模板缓存
    public function clearTempAhce(){
        $Cache = new \think\Cache;
        $Cache::clear();
        return json(['code' => 200, 'msg' => '清理成功']);
    }

    // 获取会员列表
    public function getmemberlist() {
        try {
            // 输入变量做查询条件
            $map = input('param.');
            // 关键字搜索:member、telephone
            $keyword = input('keyword');
            if (input('?param.keyword')) {
                unset($map['keyword']);
                // 关键字内容
                if ($keyword != null) {
                    if (!empty($keyword) || !ctype_space($keyword)) {
                        $map['member|telephone'] = ['like', "%$keyword%"];
                    }
                }
            }
            // 关键字null情况处理
            if ($keyword == null) {
                unset($map['keyword']);
            }

            if (input('?param.page')) {
                unset($map['page']);
            }
            $memberS = new MemberService();
            $result = $memberS->getMemberList($map);
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_000')];
            }
            return json($response);
        } catch(Exception $e){
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }
    
    // 获取会员列表（分页）
    public function getmemberlistpage() {
        try {
            // 输入变量做查询条件
            $map = input('param.');
            // 关键字搜索:member、telephone
            $keyword = input('keyword');
            if (input('?param.keyword')) {
                unset($map['keyword']);
                // 关键字内容
                if ($keyword != null) {
                    if (!empty($keyword) || !ctype_space($keyword)) {
                        $map['member|telephone'] = ['like', "%$keyword%"];
                    }
                }
            }
            // 关键字null情况处理
            if ($keyword == null) {
                unset($map['keyword']);
            }
            if (input('?param.page')) {
                unset($map['page']);
            }
            $memberS = new MemberService();
            $result = $memberS->getMemberPaginator($map);
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_000')];
            }
            return json($response);
        } catch(Exception $e){
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 获取会员信息（带有运动指数）
    public function getmembersportindex() {
        try {
            $memberId = input('param.member_id', $this->memberInfo['id']);
            $memberS = new MemberService();
            // 获取会员信息
            $result = $memberS->getMemberInfo(['id' => $memberId]);
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
            unset($result['password']);
            // 会员粉丝数
            $followS = new FollowService();
            $result['fans'] = $followS->getfansnum($result['id'], 1);
            // 体质指数（体重身高都有值）：体质指数（BMI）=体重（kg）÷身高^2（m）
            if ($result['weight'] && $result['height']) {
                $height = $result['height']/100;
                $result['bmi'] = round($result['weight']/(pow($height, 2)), 1);
            }
            // 参加球队数
            $teamS = new TeamService();
            $result['team_num'] = $teamS->getTeamMemberCount(['member_id' => $result['id'], 'status' => 1]);

            // 获取年（默认当前年）
            $year = input('param.year', date('Y'));
            $when = getStartAndEndUnixTimestamp($year);

            // 球员效率
            $mapMatchData['member_id'] = $result['id'];
            $mapMatchData['status'] = 1;
            $mapMatchData['match_time'] = ['between',
                [ $when['start'], $when['end'] ]
            ];
            $efficiency = 0;
            $matchDataS = new MatchDataService();
            // 比赛次数
            $matchNumber = $matchDataS->getMatchStaticCount($mapMatchData);
            // 获取比赛技术统计数据总和
            $sumdata = $matchDataS->getMatchStaticSum($mapMatchData);
            if ($matchNumber) {
                $efficiency = (($sumdata['pts']+$sumdata['reb']+$sumdata['ast']+$sumdata['stl']+$sumdata['blk']) - (($sumdata['fga']+$sumdata['threepfga'])-($sumdata['fg']+$sumdata['threepfg'])) - ($sumdata['fta']-$sumdata['ft']) - $sumdata['turnover']) / $matchNumber ;
            }
            $result['efficiency'] = round($efficiency, 1);

            // 运动数：参加课时数+比赛数+运动打卡（打卡功能未有）
            // 参加课时数（审课产生的课时-会员关系数据）
            $scheduleMemberS = new ScheduleMemberService();
            $scheduleNum = $scheduleMemberS->countMembers([
                'member_id' => $result['id'],
                'status' => 1,
                'schedule_time' => ['between',
                    [ $when['start'], $when['end'] ]
                ]
            ]);
            $result['schedule_num'] = $scheduleNum;
            // 参加比赛数(有效，出席比赛）
            $matchS = new MatchService();
            $matchNum = $matchS->getMatchRecordMemberCount([
                'member_id' => $result['id'],
                'status' => 1,
                'is_checkin' => 1,
                'match_time' => ['between',
                    [ $when['start'], $when['end'] ]
                ]
            ]);
            $result['match_num'] = $matchNum;
            $result['exercise'] = $scheduleNum+$matchNum;
            // 返回结果
            $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            return json($response);
        } catch(Exception $e){
            return json(['code' => 100, 'msg' => __lang('MSG_000')]);
        }
    }
}