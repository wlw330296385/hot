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
use think\Validate;

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
                       db('coach')->update(['id' => $coach['id'], 'sex' => $data['sex']]);
                    }
                    $refereeS = new \app\service\RefereeService();
                    $referee = $refereeS->getRefereeInfo(['member_id' => $member_id]);
                    if ($referee) {
                        db('referee')->update(['id' => $referee['id'], 'sex' => $data['sex']]);
                    }
                }
                // 更新member数据成功 同步更新会员所在球队的球员信息
                $memberS = new MemberService();
                $memberS->saveTeamMember([
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
            $memberS = new MemberService();
            $result['team_num'] = $memberS->getTeamMemberCount(['member_id' => $result['id'], 'status' => 1]);

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

    // 创建会员学球意向登记
    public function createstudyinterion() {
        $data = input('post.');
        $data['member_id'] = $this->memberInfo['id'];
        $data['member'] = $this->memberInfo['member'];
        $data['status'] = 1;
        // 数据验证器
        $validate = validate('StudyInterionVal');
        if ( !$validate->check($data) ) {
            return json(['code' => 100, 'msg' => $validate->getError()]);
        }
        $memberS = new MemberService();
        try {
            $result = $memberS->savestudyinterion($data);
        } catch (Exception $e) {
            trace('error:'.$e->getMessage(),'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        return json($result);
    }

    // 创建会员荣誉
    public function creatememberhonor() {
        // 接收请求变量
        $data = input('post.');
        $data['member_id'] = $this->memberInfo['id'];
        $data['member'] = $this->memberInfo['member'];
        $data['member_avatar'] = $this->memberInfo['avatar'];
        // 验证器
        $validate = validate('MemberHonorVal');
        if (!$validate->scene('add')->check($data)) {
            return json(['code' => 100, 'msg' => $validate->getError()]);
        }
        // 时间格式转换
        $data['honor_time'] = strtotime($data['honor_time']);
        $data['status'] = 1;

        // 插入数据
        $memberS = new MemberService();
        try {
            $result = $memberS->saveMemberHonor($data);
        } catch (Exception $e) {
            trace('error:'.$e->getMessage(),'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        return json($result);
    }

    // 编辑会员荣誉
    public function updatememberhonor() {
        // 接收请求变量
        $data = input('post.');
        $data['member_id'] = $this->memberInfo['id'];
        $data['member'] = $this->memberInfo['member'];
        $data['member_avatar'] = $this->memberInfo['avatar'];
        // 验证器
        $validate = validate('MemberHonorVal');
        if (!$validate->scene('edit')->check($data)) {
            return json(['code' => 100, 'msg' => $validate->getError()]);
        }
        // 查询数据
        $memberS = new MemberService();
        $memberHonor = $memberS->getMemberHonor(['id' => $data['id']]);
        // 无符合数据
        if (!$memberHonor) {
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
        if ($memberHonor['member_id'] != $this->memberInfo['id']) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        // 时间格式转换
        $data['honor_time'] = strtotime($data['honor_time']);

        try {
            $result = $memberS->saveMemberHonor($data);
        } catch (Exception $e) {
            trace('error:'.$e->getMessage(),'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        return json($result);
    }

    // 删除会员荣誉
    public function deletememberhonor() {
        $id = input('post.id');
        // 查询数据
        $memberS = new MemberService();
        $memberHonor = $memberS->getMemberHonor(['id' => $id]);
        // 无符合数据
        if (!$memberHonor) {
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
        if ($memberHonor['member_id'] != $this->memberInfo['id']) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        try {
            $result = $memberS->delMemberHonor($memberHonor['id']);
            if ($result) {
                // 删除相关的会员评论点赞数据
                db('member_comment')
                    ->where([
                        'comment_type' => 2,
                        'commented_id' => $memberHonor['id']
                    ])->delete();
            }
        } catch (Exception $e) {
            trace('error:'.$e->getMessage(),'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        if (!$result) {
            return json(['code' => 100, 'msg' => __lang('MSG_000')]);
        } else {
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
        }
    }

    // 会员荣誉列表
    public function getmemberhonorlist() {
        try {
            $data = input('param.');
            $page = input('param.page');
            if (input('?page')) {
                unset($data['page']);
            }
            // 查询数据
            $memberS = new MemberService();
            $result = $memberS->getMemberHonorList($data, $page);
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            } else {
                return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
            }
        } catch (Exception $e) {
            trace('error:'.$e->getMessage(),'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
    }

    // 会员荣誉列表(页码）
    public function getmemberhonorpage() {
        try {
            $data = input('param.');
            $page = input('param.page');
            if (input('?page')) {
                unset($data['page']);
            }
            // 查询数据
            $memberS = new MemberService();
            $result = $memberS->getMemberHonorPaginator($data);
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            } else {
                return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
            }
        } catch (Exception $e) {
            trace('error:'.$e->getMessage(),'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
    }

    // 会员的个人荣誉与球队荣誉总和列表
    public function getmemberandteamhonorlist() {
        try {
            $data = input('param.');
            $page = input('param.page');
            if (input('?page')) {
                unset($data['page']);
            }
            // 默认查询正常状态的数据
            $data['status'] = input('param.status', 1);
            // 查询条件组合end
            // 获取会员荣誉数据
            $memberS = new MemberService();
            $memberHonors = $memberS->getMemberHonorAll($data);
            // 获取会员球队荣誉数据
            $teamS = new TeamService();
            $memberTeamHonors = $teamS->getTeamHonorMemberAll($data);
            // 合并到一个新数组
            $list = array_merge($memberHonors, $memberTeamHonors);
            if (!$list) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
            // 数组以honor_time倒序排序
            array_multisort( array_column($list, 'honor_time'), SORT_DESC, $list );
            $limit = 10;
            $list = page_array($limit, $page, $list);
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $list]);
        } catch (Exception $e) {
            trace('error:'.$e->getMessage(),'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
    }



    // 会员业务评论列表
    public function membercommentlist()
    {
        try {
            // 判断必传参数
            // 评论类型
            $comment_type = input('post.comment_type');
            if (!$comment_type ) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            // 组合传参作查询条件
            $map = input('param.');
            // 页码参数
            $page = input('page', 1);
            unset($map['page']);
            $memberS = new MemberService();
            // 返回结果
            $result = $memberS->getCommentList($map, $page);
            if ($result) {
                // 评论列表数据删除按钮标识：
                foreach ($result as $k => $val) {
                    $result[$k]['can_delete'] = 0;
                    // 评论发布者可删自己的评论记录，
                    if ( $this->memberInfo['id'] == $val['member_id'] ) {
                        $result[$k]['can_delete'] = 1;
                    }
                }
                // 返回点赞数
                $thumbupsCount = $memberS->getCommentThumbsCount($map);
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result, 'thumbsup_count' => $thumbupsCount];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 会员业务评论列表（有页码）
    public function membercommentpage()
    {
        try {
            // 判断必传参数
            // 评论类型
            $comment_type = input('param.comment_type');
            if (!$comment_type) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            // 组合传参作查询条件
            $page = input('page', 1);
            $map = input('post.');
            $memberS = new MemberService();
            // 返回结果
            $result = $memberS->getCommentPaginator($map);
            if ($result) {
                // 评论列表数据删除按钮标识：
                foreach ($result['data'] as $k => $val) {
                    $result['data'][$k]['can_delete'] = 0;
                    // 评论发布者可删自己的评论记录，
                    if ( $this->memberInfo['id'] == $val['member_id'] ) {
                        $result['data'][$k]['can_delete'] = 1;
                    }
                }
                // 返回点赞数
                $thumbupsCount = $memberS->getCommentThumbsCount($map);
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result, 'thumbsup_count' => $thumbupsCount];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 发布会员业务评论
    public function addmembercomment()
    {
        try {
            // 检测会员登录
            if ( $this->memberInfo['id'] === 0) {
                return json(['code' => 100, 'msg' => '请先登录或注册会员']);
            }
            // 将接收参数作提交数据
            $data = input('post.');
            // 验证数据
            $validate = new Validate([
                'comment_type' => 'require|number',
                'commented' => 'require',
                'commented_id' => 'require|number',
                'commented_member_id' => 'require|number'
            ]);
            if (!$validate->check($data)) {
                return json(['code' => 100, 'msg' => __lang('MSG_402').':'.$validate->getError()]);
            }

            $memberS = new MemberService();
            // 查询会员有无评论记录
            $map = [
                'comment_type' => $data['comment_type'],
                'commented_id' => $data['commented_id'],
                'member_id' => $this->memberInfo['id'],
            ];
            $hasCommented = $memberS->getCommentInfo($map);
            if ($hasCommented) {
                // 只能发表一次文字评论
                if (!is_null($hasCommented['comment'])) {
                    return json(['code' => 100, 'msg' => '只能发表一次评论']);
                } else {
                    $data['id'] = $hasCommented['id'];
                }
            }
            // 防止有传入thumbup参数 过滤掉
            if (isset($data['thumbup'])) {
                unset($data['thumbup']);
            }
            // 被评论实体所属会员信息补充
            $commentedMemberInfo = $memberS->getMemberInfo(['id' => $data['commented_member_id']]);
            if (!$commentedMemberInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404').'所属会员信息']);
            }
            $data['commented_member'] = $commentedMemberInfo['member'];
            $data['commented_member_avatar'] = $commentedMemberInfo['avatar'];
            // 发布评论会员信息
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['member_avatar'] = $this->memberInfo['avatar'];
            // 发表文字评论时间
            $data['comment_time'] = time();
            $res = $memberS->saveComment($data);
            return json($res);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 删除会员业务评论
    public function delmembercomment() {
        $id  = input('post.id');
        if (!$id) {
            return json(['code' => 100, 'msg' => __lang('MSG_402')]);
        }
        // 查询评论数据
        $memberS = new MemberService();
        $comment = $memberS->getCommentInfo(['id' => $id]);
        if (!$comment) {
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
        // 可删除数据标识
        $canDel = 0;
        // 评论发布者可删自己的评论记录，
        if ($comment['member_id'] == $this->memberInfo['id']) {
            $canDel = 1;
        }
        // 无权限删除
        if (!$canDel) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        try {
            $res = $memberS->delComment($comment['id']);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        if ($res) {
            return json(['code' => 200, 'msg' => __lang('MSG_200')]);
        } else {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
    }

    // 会员业务点赞
    public function dianzan()
    {
        try {
            // 检测会员登录
            if ( $this->memberInfo['id'] === 0) {
                return json(['code' => 100, 'msg' => '请先登录或注册会员']);
            }
            // 将接收参数作提交数据
            $data = input('post.');
            // 判断必传参数
            // 验证数据
            $validate = new Validate([
                'comment_type' => 'require|number',
                'commented' => 'require',
                'commented_id' => 'require|number',
                'commented_member_id' => 'require|number'
            ]);
            if (!$validate->check($data)) {
                return json(['code' => 100, 'msg' => __lang('MSG_402').':'.$validate->getError()]);
            }
            $memberS = new MemberService();
            // 查询会员有无评论记录
            $map = [
                'comment_type' => $data['comment_type'],
                'commented_id' => $data['commented_id'],
                'member_id' => $this->memberInfo['id'],
            ];
            $hasCommented = $memberS->getCommentInfo($map);
            // 有评论记录就更新记录的thumbsup字段
            if ($hasCommented) {
                $data['id'] = $hasCommented['id'];
            }
            // 防止有传入comment参数 过滤掉
            if (isset($data['comment'])) {
                unset($data['comment']);
            }
            // 被评论实体所属会员信息补充
            $commentedMemberInfo = $memberS->getMemberInfo(['id' => $data['commented_member_id']]);
            if (!$commentedMemberInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404').'所属会员信息']);
            }
            $data['commented_member'] = $commentedMemberInfo['member'];
            $data['commented_member_avatar'] = $commentedMemberInfo['avatar'];
            // 发布评论会员信息
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['member_avatar'] = $this->memberInfo['avatar'];
            $data['thumbsup'] = ($hasCommented && ($hasCommented['thumbsup'] == 1)) ? 0 : 1;
            $result = $memberS->saveComment($data);
            if ($result['code'] == 200) {
                // 返回最新的点赞数统计
                $thumbsupCount = $memberS->getCommentThumbsCount([
                    'comment_type' => $data['comment_type'],
                    'commented_id' => $data['commented_id'],
                ]);
                $result['thumbsup_count'] = $thumbsupCount;
            }
            return json($result);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 获取会员相关业务当前点赞信息
    public function isthumbup()
    {
        try {
            // 判断必传参数
            // 评论类型
            $comment_type = input('param.comment_type');
            // 被评论实体id
            $commented_id = input('param.commented_id');
            if (!$comment_type || !$commented_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            $memberS = new MemberService();
            // 查询会员有无评论记录
            $map = [
                'comment_type' => $comment_type,
                'commented_id' => $commented_id,
                'member_id' => $this->memberInfo['id'],
            ];
            $commentInfo = $memberS->getCommentInfo($map);
            // 点赞字段值
            $thumbsup = ($commentInfo) ? $commentInfo['thumbsup'] : 0;
            // 点赞数统计
            $thumbupCount = $memberS->getCommentThumbsCount([
                'comment_type' => $comment_type,
                'commented_id' => $commented_id,
            ]);
            return json(['code' => 200, 'msg' => __lang('MSG_200'), 'thumbsup' => $thumbsup, 'thumbsup_count' => $thumbupCount]);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

}