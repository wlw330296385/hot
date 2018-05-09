<?php
// 联赛api
namespace app\api\controller;
use app\service\CertService;
use app\service\LeagueService;
use app\service\MatchService;
use app\service\MessageService;
use app\service\TeamService;
use think\Exception;

class League extends Base
{
    // 新建联赛组织
    public function creatematchorg() {
        // 检测会员登录
        if ($this->memberInfo['id'] === 0 ) {
            return json(['code' => 100, 'msg' => '请先登录或注册会员']);
        }
        // 提交参数
        $data = input('post.');
        $data['creater_member_id'] = $this->memberInfo['id'];
        $data['creater_member'] = $this->memberInfo['member'];
        $data['member_id'] = $this->memberInfo['id'];
        $data['member'] = $this->memberInfo['member'];
        // 验证数据
        $validate = validate('MatchOrgVal');
        if (!$validate->scene('message')->check($data)) {
            return ['code' => 100, 'msg' => $validate->getError()];
        }
        // 联系电话默认会员电话
        if ( !array_key_exists('contact_tel', $data) || empty($data['contact_tel']) ) {
            $data['contact_tel'] = $this->memberInfo['telephone'];
        }
        // 保存数据
        $leagueService = new LeagueService();
        try {
            $res = $leagueService->createMatchOrg($data);
            // 创建联赛组织成功
            if ($res['code'] == 200) {
                $matchOrgId = $res['data'];
                // 保存联赛组织-会员关系数据
                $leagueService->saveMatchOrgMember([
                    'match_org_id' => $matchOrgId,
                    'match_org' => $data['name'],
                    'match_org_logo' => $data['logo'],
                    'member_id' => $this->memberInfo['id'],
                    'member' => $this->memberInfo['member'],
                    'member_avatar' => $this->memberInfo['avatar'],
                    'status' => 1
                ]);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        return json($res);
    }

    // 修改联系组织
    public function editmatchorg() {
        // 提交参数
        $data = input('post.');
        // 获取联赛组织信息
        $id = input('post.id', 0, 'intval');
        if (!$id) {
            return json(['code' => 100, 'msg' => __lang('MSG_402')]);
        }
        $leagueService = new LeagueService();
        $matchOrgInfo = $leagueService->getMatchOrg(['id' => $id]);
        if (!$matchOrgInfo) {
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
        // 检测会员登录
        if ($this->memberInfo['id'] === 0 ) {
            return json(['code' => 100, 'msg' => '请先登录或注册会员']);
        }
        // 操作会员发生更新
        if ($this->memberInfo['id'] != $matchOrgInfo['member_id']) {
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
        }

        try {
            // 保存证件信息
            $certS = new CertService();
            // 营业执照
            if ( input('?post.cert') ) {
                $cert1 = $certS->saveCert([
                    'photo_positive' => $data['cert'],
                    'member_id' => 0,
                    'match_org_id' => $id,
                    'cert_type' => 4
                ]);
                if ($cert1['code'] != 200) {
                    return ['code' => 100, 'msg' => '营业执照保存失败,请重试'];
                }
            }
            // 法人
            if ( input('?post.fr_idno') || input('?post.fr_idcard') ) {
                $cert2 = $certS->saveCert([
                    'match_org_id' => $id,
                    'member_id' => 0,
                    'cert_type' => 1,
                    'cert_no' => input('post.fr_idno'),
                    'photo_positive' => input('post.fr_idcard')
                ]);
                if ($cert2['code'] != 200) {
                    return ['code' => 100, 'msg' => '法人信息保存失败,请重试'];
                }
            }
            // 创建人
            if ( input('?post.cjz_idno') || input('?post.cjz_idcard') ) {
                $cert3 = $certS->saveCert([
                    'member_id' => $this->memberInfo['id'],
                    'cert_type' => 1,
                    'cert_no' => input('post.cjz_idno'),
                    'photo_positive' => input('post.cjz_idcard')
                ]);
                if ($cert3['code'] != 200) {
                    return ['code' => 100, 'msg' => '创建人信息保存失败'];
                }
            }
            // 其他证明
            if ( input('?post.other_cert') ) {
                $cert4 = $certS->saveCert([
                    'match_org_id' => $id,
                    'member_id' => 0,
                    'cert_type' => 0,
                    'photo_positive' => input('post.other_cert')
                ]);
                if ($cert4['code'] != 200) {
                    return ['code' => 100, 'msg' => '其他证明保存失败'];
                }
            }

            // 更新联赛组织数据
            $resUpdateMatchOrg = $leagueService->updateMatchOrg($data);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        return json($resUpdateMatchOrg);
    }

    // 创建联赛信息
    public function creatematch() {
        // 接收输入变量
        $data = input('post.');
        $data['member_id'] = $this->memberInfo['id'];
        $data['member'] = $this->memberInfo['member'];
        $data['member_avatar'] = $this->memberInfo['avatar'];
        // 数据验证
        $validate = validate('MatchVal');
        if ( !$validate->scene('league_add')->check($data) ) {
            return json(['code' => 100, 'msg' => $validate->getError()]);
        }
        // 时间格式转换
        $data['start_time'] = strtotime($data['start_time']);
        $data['end_time'] = strtotime($data['end_time']);
        $data['reg_start_time'] = strtotime($data['reg_start_time']);
        $data['reg_end_time'] = strtotime($data['reg_end_time']);
        // 时间字段严谨性校验
        $newTime = time();
        if ($data['start_time'] <= $newTime) {
            return json(['code' => 100, 'msg' => '联赛开始时间不能大于当前时间']);
        }
        if ($data['end_time'] <= $newTime) {
            return json(['code' => 100, 'msg' => '联赛结束时间不能大于当前时间']);
        }
        if ($data['reg_start_time'] <= $newTime) {
            return json(['code' => 100, 'msg' => '报名开始时间不能大于当前时间']);
        }
        if ($data['reg_end_time'] <= $newTime) {
            return json(['code' => 100, 'msg' => '报名结束时间不能大于当前时间']);
        }
        if ($data['start_time'] >= $data['end_time']) {
            return json(['code' => 100, 'msg' => '联赛开始时间不能大于联赛结束时间']);
        }
        if ($data['reg_start_time'] >= $data['reg_end_time']) {
            return json(['code' => 100, 'msg' => '报名开始时间不能大于报名结束时间']);
        }
        // 报名时间不能大于比赛开始时间
        if ($data['reg_start_time'] >= $data['start_time'] || $data['reg_end_time'] >= $data['start_time']) {
            return json(['code' => 100, 'msg' => '报名时间不能大于联赛开始时间']);
        }

        // 创建联赛 status=0 待审核
        $data['status'] = 0;
        $matchS = new MatchService();
        $leagueS = new LeagueService();
        try {
            // 保存联赛信息
            $res = $matchS->saveMatch($data, 'league_add');
            if ($res['code'] == 200) {
                $matchId = $res['data'];
                // 保存联赛-工作人员关系数据
                $leagueS->saveMatchMember([
                    'match_id' => $matchId,
                    'match' => $data['name'],
                    'match_logo' => $data['logo'],
                    'member_id' => $this->memberInfo['id'],
                    'member' => $this->memberInfo['member'],
                    'member_avatar' => $this->memberInfo['avatar'],
                    'type' => 10,
                    'status' => 1
                ]);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        return json($res);
    }

    // 编辑联赛信息
    public function updatematch() {
        // 检测会员登录
        if ($this->memberInfo['id'] === 0 ) {
            return json(['code' => 100, 'msg' => '请先登录或注册会员']);
        }
        // 接收输入变量
        $data = input('post.');
        // 数据验证
        $validate = validate('MatchVal');
        if ( !$validate->scene('league_edit')->check($data) ) {
            return json(['code' => 100, 'msg' => $validate->getError()]);
        }
        // 时间格式转换
        $data['start_time'] = strtotime($data['start_time']);
        $data['end_time'] = strtotime($data['end_time']);
        $data['reg_start_time'] = strtotime($data['reg_start_time']);
        $data['reg_end_time'] = strtotime($data['reg_end_time']);
        // 时间字段严谨性校验
        $newTime = time();
        if ($data['start_time'] <= $newTime) {
            return json(['code' => 100, 'msg' => '联赛开始时间不能大于当前时间']);
        }
        if ($data['end_time'] <= $newTime) {
            return json(['code' => 100, 'msg' => '联赛结束时间不能大于当前时间']);
        }
        if ($data['reg_start_time'] <= $newTime) {
            return json(['code' => 100, 'msg' => '报名开始时间不能大于当前时间']);
        }
        if ($data['reg_end_time'] <= $newTime) {
            return json(['code' => 100, 'msg' => '报名结束时间不能大于当前时间']);
        }
        if ($data['start_time'] >= $data['end_time']) {
            return json(['code' => 100, 'msg' => '联赛开始时间不能大于联赛结束时间']);
        }
        if ($data['reg_start_time'] >= $data['reg_end_time']) {
            return json(['code' => 100, 'msg' => '报名开始时间不能大于报名结束时间']);
        }
        // 报名时间不能大于比赛开始时间
        if ($data['reg_start_time'] >= $data['start_time'] || $data['reg_end_time'] >= $data['start_time']) {
            return json(['code' => 100, 'msg' => '报名时间不能大于联赛开始时间']);
        }

        $matchS = new MatchService();
        try {
            // 保存联赛信息
            $res = $matchS->saveMatch($data);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        return json($res);
    }

    // 平台展示联赛列表
    public function platformleaguelist() {
        try {
            $data = input('param.');
            $page = input('page', 1);
            // 查询有联赛组织的比赛 作为联赛记录
            if ( !array_key_exists('match_org_id', $data) ) {
                $data['match_org_id'] = ['gt', 0];
            }
            // 默认查询所有分类记录
            if ( array_key_exists('type', $data) && empty($data['type']) ) {
                unset($data['type']);
            }
            // 默认查询city下所有记录
            if ( array_key_exists('area', $data) && empty($data['area']) ) {
                unset($data['area']);
            }
            // 搜索关键字(联赛名)
            $keyword = input('keyword');
            if ( $keyword == null ) {
                unset($data['keyword']);
            }
            if ( !empty($keyword) ) {
                $data['name'] = ['like', "%$keyword%"];
                unset($data['keyword']);
            }

            // 审核通过
            $data['status'] = 1;
            if (input('?page')) {
                unset($data['page']);
            }
            // 查询条件组合end
            // 获取联赛列表
            $matchS = new MatchService();
            $leagueS = new LeagueService();
            $result = $matchS->matchList($data, $page);
            if (!$result) {
                $response = ['code' => 100, 'msg' => __lang('MSG_000')];
            } else {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 平台展示联赛列表（页码）
    public function platformleaguepage() {
        try {
            $data = input('param.');
            // 查询有联赛组织的比赛 作为联赛记录
            if ( !array_key_exists('match_org_id', $data) ) {
                $data['match_org_id'] = ['gt', 0];
            }
            // 默认查询所有分类记录
            if ( array_key_exists('type', $data) && empty($data['type']) ) {
                unset($data['type']);
            }
            // 默认查询city下所有记录
            if ( array_key_exists('area', $data) && empty($data['area']) ) {
                unset($data['area']);
            }
            // 搜索关键字(联赛名)
            $keyword = input('keyword');
            if ( $keyword == null ) {
                unset($data['keyword']);
            }
            if ( !empty($keyword) ) {
                $data['name'] = ['like', "%$keyword%"];
                unset($data['keyword']);
            }

            // 审核通过
            $data['status'] = 1;
            if (input('?page')) {
                unset($data['page']);
            }
            // 查询条件组合end
            // 获取联赛列表
            $matchS = new MatchService();
            $leagueS = new LeagueService();
            $result = $matchS->matchListPaginator($data);
            if (!$result) {
                $response = ['code' => 100, 'msg' => __lang('MSG_000')];
            } else {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 联赛球队列表
    public function leagueteamlist() {
        try {
            $data = input('param.');
            $page = input('param.page', 1);
            // 参数league_id -> match_id
            if (input('param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }

            // 搜索关键字(联赛名)
            $keyword = input('keyword');
            if ( $keyword == null ) {
                unset($data['keyword']);
            }
            if ( !empty($keyword) ) {
                $data['team'] = ['like', "%$keyword%"];
            }
            unset($data['keyword']);
            if (input('?page')) {
                unset($data['page']);
            }
            // 查询条件组合end

            // 获取参加联赛的球队列表
            $leagueS = new LeagueService();
            $result = $leagueS->getMatchTeamWithTeamList($data, $page);
            if (!$result) {
                $response = ['code' => 100, 'msg' => __lang('MSG_000')];
            } else {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 联赛球队列表（页码）
    public function leagueteampage() {
        try {
            $data = input('param.');
            $page = input('param.page', 1);
            // 参数league_id -> match_id
            if (input('param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }

            // 搜索关键字(联赛名)
            $keyword = input('keyword');
            if ( $keyword == null ) {
                unset($data['keyword']);
            }
            if ( !empty($keyword) ) {
                $data['team'] = ['like', "%$keyword%"];
            }
            unset($data['keyword']);
            if (input('?page')) {
                unset($data['page']);
            }
            // 查询条件组合end

            // 获取参加联赛的球队列表
            $leagueS = new LeagueService();
            $result = $leagueS->getMatchTeamWithTeamPaginator($data);
            if (!$result) {
                $response = ['code' => 100, 'msg' => __lang('MSG_000')];
            } else {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队申请参加联赛
    public function signupleague() {
        // 接收post参数
        $data = input('post.');
        // 比传参数验证 team_id league_id
        if ( !array_key_exists('team_id', $data) ) {
            return json(['code' => 100, 'msg' => __lang('MSG_402').',传入team_id']);
        }
        if ( !array_key_exists('league_id', $data) ) {
            return json(['code' => 100, 'msg' => __lang('MSG_402').',传入league_id']);
        }
        // 检查会员登录
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        // 检查会员所在球队信息
        // 根据team_id获取球队信息
        $teamService = new TeamService();
        $team = $teamService->getTeam(['id' => $data['team_id']]);
        if (!$team) {
            return json(['code' => 100, 'msg' => '球队'.__lang('MSG_404')]);
        }
        $teamMember = $teamService->getTeamMemberInfo(['team_id' => $team['id'], 'member_id' => $this->memberInfo['id']]);
        if (!$teamMember || $teamMember['status_num'] != 1) {
            return json(['code' => 100, 'msg' => '您不是该球队的成员']);
        }
        // 根据league_id获取联赛信息
        $leagueService = new LeagueService();
        $league = $leagueService->getMatchWithOrg([
            'id' => $data['league_id'],
            'match_org_id' => ['gt', 0]
        ]);
        if (!$league || $league['status_num'] != 1) {
            return json(['code' => 100, 'msg' => '联赛'.__lang('MSG_404')]);
        }
        // 检查球队有无联赛-球队数据
        $matchTeam = $leagueService->getMatchTeamInfo(['match_id' => $league['id'], 'team_id' => $team['id']]);
        if ($matchTeam) {
            return json(['code' => 100, 'msg' => '您的球队已经报名联赛，无须再次操作']);
        }
        // 检查球队有无申请报名联赛数据
        $matchService = new MatchService();
        $matchApply = $matchService->getMatchApply([
            'match_id' => $league['id'],
            'team_id' => $teamMember['team_id']
        ]);
        // 有申请联赛数据并已同意 提示已报名
        if ($matchApply) {
            return json(['code' => 100, 'msg' => '您的球队已经报名联赛，无须再次操作']);
        }
        // 保存球队-联赛报名申请数据
        $dataMatchApply = [
            'match_id' => $league['id'],
            'match' => $league['name'],
            'team_id' => $teamMember['team_id'],
            'team' => $teamMember['team'],
            'telephone' => empty($teamMember['telephone']) ? $this->memberInfo['telephone'] : $teamMember['telephone'],
            'contact' => $teamMember['name'],
            'member_id' => $this->memberInfo['id'],
            'member' => $this->memberInfo['member'],
            'member_avatar' => $this->memberInfo['avatar'],
            'status' => 1
        ];
        try {
            $res = $matchService->saveMatchApply($dataMatchApply);
        if ($res['code'] == 200) {
            // 发送消息通知给联赛组织管理员
            // 获取联赛组织人员列表
            $matchOrgMembers = $leagueService->getMatchOrgMembers(['match_org_id' => $league['match_org_id']]);
            $memberIds = [];
            if (!empty($matchOrgMembers)) {
                foreach ($matchOrgMembers as $k => $val) {
                    $memberIds[$k]['id'] = $val['member_id'];
                }
            }
            $message = [
                'title' => '您好，球队'.$team['name'].'申请报名联赛'.$league['name'],
                'content' => '您好，球队'.$team['name'].'申请报名联赛'.$league['name'],
                'url' => url('keeper/match/teamlistofleague', ['league_id' => $league['id']], '', true),
                'keyword1' => '球队报名参加联赛',
                'keyword2' => $teamMember['name'],
                'keyword3' => date('Y-m-d H:i', time()),
                'remark' => '点击进入查看更多',
                'steward_type' => 2
            ];
            $messageS = new MessageService();
            $messageS->sendMessageToMembers($memberIds, $message, config('wxTemplateID.checkPend'));
        }
        } catch (Exception $e) {
            trace($e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        // 返回结果
        return json($res);
    }

    // 回复联赛报名球队申请
    public function replyleaguesignupteam() {
        // post参数
        $data = input('post.');
        // 比传参数验证 apply_id status(状态)
        if ( !array_key_exists('apply_id', $data) ) {
            return json(['code' => 100, 'msg' => __lang('MSG_402').',传入apply_id']);
        }
        if ( !array_key_exists('status', $data) || !in_array($data['status'], [2, 3]) ) {
            return json(['code' => 100, 'msg' => __lang('MSG_402').',传入正确status']);
        }
        // 检查会员登录信息
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        // 查询联赛球队申请数据
        $matchService = new MatchService();
        $matchApply = $matchService->getMatchApplyDetail([
            'id' => $data['apply_id']
        ]);
        if (!$matchApply) {
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
        // 已同意的申请提示
        if ($matchApply['status'] == 2) {
            return json(['code' => 100, 'msg' => '此申请已同意了，无需再次操作']);
        }
        // 当前会员有无联赛组织人员关系（操作权限）
        $leagueService = new LeagueService();
        $matchOrgMember = $leagueService->getMatchOrgMember([
            'match_org_id' => $matchApply['match']['match_org_id'],
            'member_id' => $this->memberInfo['id']
        ]);
        if (!$matchOrgMember) {
            return json(['code' => 100, 'msg' => __lang('MSG_403').'您不是联赛组织人员']);
        }
        // 同意status=2/拒绝status=3：更新申请状态,回复消息推送
        $statusStr = '';
        if ($data['status'] == 3) {
            // 拒绝
            $statusStr = '已拒绝';
        } else {
            // 同意
            $statusStr = '已同意';
            // 检查联赛球队数是否达到联赛最大球队数
            if ($matchApply['match']['teams_max'] && $matchApply['match']['teams_count'] == $matchApply['match']['teams_max']) {
                return json(['code' => 100, 'msg' => '该联赛球队数量已达到联赛设定球队数上限，不能再通过球队报名了']);
            }
        }
        // 回复理由
        $reply = ( !empty($data['reply']) ) ? '回复说明：'.$data['reply'] : '';
        // 组合推送消息内容
        $message = [
            'title' => '联赛报名申请通知',
            'content' => '球队 ' . $matchApply['team']['name'] . '报名参加联赛 ' . $matchApply['match']['name'].'申请。申请结果：'.$statusStr,
            'url' => url('keeper/message/index', '', '', true),
            'keyword1' => '球队 ' . $matchApply['team']['name'] . '报名参加联赛 ' . $matchApply['match']['name'].'申请',
            'keyword2' => $statusStr,
            'remark' => '点击登录平台查看更多信息',
            'team_id' => $matchApply['team_id'],
            'steward_type' => 2
        ];
        try {
            // 更新match_apply
            $result = $matchService->saveMatchApply([
                'id' => $matchApply['id'],
                'status' => $data['status'],
                'reply' => $reply,
                'remarks' => $statusStr
            ]);

            if ($result['code'] == 200) {
                // 同意操作
                if ($data['status'] == 2) {
                    // 保存联赛球队数据
                    $dataMatchTeam = [
                        'match_id' => $matchApply['match_id'],
                        'match' => $matchApply['match']['name'],
                        'team_id' => $matchApply['team_id'],
                        'team' => $matchApply['team']['name'],
                        'team_logo' => $matchApply['team']['logo']
                    ];
                    $leagueService->saveMatchTeam($dataMatchTeam);
                    // 联赛球队数+1
                    db('match')->where('id', $matchApply['match_id'])->setInc('teams_count', 1);
                    // 发送消息推送
                    $messageS = new MessageService();
                    $messageS->sendMessageToMember($matchApply['member_id'], $message, config('wxTemplateID.applyResult'));
                    // 球队公告
                    $teamS = new TeamService();
                    $teamS->saveTeamMessage($message);
                }
            }
        } catch (Exception $e) {
            trace($e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        return json($result);
    }

    // 联赛报名球队列表
    public function leaguesignupteamlist() {
        try {
            $data = input('param.');
            $page = input('page');
            // 参数league_id -> match_id
            if (input('param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }
            if (input('?page')) {
                unset($data['page']);
            }

            $matchService = new MatchService();
            $result = $matchService->getMatchApplyWithTeamList($data, $page);
            // 返回结果
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            trace($e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
    }

    // 联赛报名球队列表（页码）
    public function leaguesignupteampage() {
        try {
            $data = input('param.');
            // 参数league_id -> match_id
            if (input('param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }
            if (input('?page')) {
                unset($data['page']);
            }

            $matchService = new MatchService();
            $result = $matchService->getMatchApplyWithTeamPaginator($data);
            // 返回结果
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            trace($e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
    }
}