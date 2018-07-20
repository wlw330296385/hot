<?php
// 联赛api
namespace app\api\controller;

use app\service\ArticleService;
use app\service\CertService;
use app\service\LeagueService;
use app\service\MatchService;
use app\service\MemberService;
use app\service\MessageService;
use app\service\RefereeService;
use app\service\TeamService;
use think\Db;
use think\Exception;

class League extends Base
{
    // 新建联赛组织
    public function creatematchorg()
    {
        // 检测会员登录
        if ($this->memberInfo['id'] === 0) {
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
        if (!array_key_exists('contact_tel', $data) || empty($data['contact_tel'])) {
            $data['contact_tel'] = $this->memberInfo['telephone'];
        }
        // 保存数据
        $leagueService = new LeagueService();
        try {
            $res = $leagueService->createMatchOrg($data);
            // 创建联赛组织成功
            if ($res['code'] == 200) {
                $matchOrgId = $res['data'];
                // 保存联赛组织-会员关系数据 type=10负责人
                $leagueService->saveMatchOrgMember([
                    'match_org_id' => $matchOrgId,
                    'match_org' => $data['name'],
                    'match_org_logo' => $data['logo'],
                    'member_id' => $this->memberInfo['id'],
                    'member' => $this->memberInfo['member'],
                    'member_avatar' => $this->memberInfo['avatar'],
                    'realname' => $this->memberInfo['realname'],
                    'type' => 10,
                    'status' => 1
                ]);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        return json($res);
    }

    // 修改联系组织
    public function editmatchorg()
    {
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
        if ($this->memberInfo['id'] === 0) {
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
            if (input('?post.cert')) {
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
            if (input('?post.fr_idno') || input('?post.fr_idcard')) {
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
            if (input('?post.cjz_idno') || input('?post.cjz_idcard')) {
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
            if (input('?post.other_cert')) {
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
    public function creatematch()
    {
        // 接收输入变量
        $data = input('post.');
        $data['member_id'] = $this->memberInfo['id'];
        $data['member'] = $this->memberInfo['member'];
        $data['member_avatar'] = $this->memberInfo['avatar'];
        // 数据验证
        $validate = validate('MatchVal');
        if (!$validate->scene('league_add')->check($data)) {
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
        // 球队成员下限（默认根据赛制）
        if (!$data['min_teammembers']) {
            switch ( $data['format'] ) {
                case '3v3':
                    $data['min_teammembers'] = 3;
                    break;
                case '5v5':
                    $data['min_teammembers'] = 5;
                    break;
            }
        }
        // 球队成员上限（默认20）
        if ( !$data['max_teammembers'] ) {
            $data['max_teammembers'] = 20;
        }
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
                    'realname' => $this->memberInfo['realname'],
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
    public function updatematch()
    {
        // 检测会员登录
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => '请先登录或注册会员']);
        }
        // 接收输入变量
        $data = input('post.');
        // 数据验证
        $validate = validate('MatchVal');
        if (!$validate->scene('league_edit')->check($data)) {
            return json(['code' => 100, 'msg' => $validate->getError()]);
        }
        // 获取联赛信息
        $matchS = new MatchService();
        $league = $matchS->getMatch(['id' => $data['id']]);
        if (!$league) {
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
        // 时间格式转换
        $data['start_time'] = strtotime($data['start_time']);
        $data['end_time'] = strtotime($data['end_time']);
        $data['reg_start_time'] = strtotime($data['reg_start_time']);
        $data['reg_end_time'] = strtotime($data['reg_end_time']);
        // 时间字段严谨性校验
        $newTime = time();
        if ($data['start_time'] != strtotime($league['start_time']) && $data['start_time'] <= $newTime) {
            return json(['code' => 100, 'msg' => '联赛开始时间不能大于当前时间']);
        }
        if ($data['end_time'] != strtotime($league['end_time']) && $data['end_time'] <= $newTime) {
            return json(['code' => 100, 'msg' => '联赛结束时间不能大于当前时间']);
        }
        if ($data['reg_start_time'] != strtotime($league['reg_start_time']) && $data['reg_start_time'] <= $newTime) {
            return json(['code' => 100, 'msg' => '报名开始时间不能大于当前时间']);
        }
        if ($data['reg_end_time'] != strtotime($league['reg_end_time']) && $data['reg_end_time'] <= $newTime) {
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

        try {
            // 保存联赛信息
            $res = $matchS->saveMatch($data);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        return json($res);
    }

    // 平台展示联赛列表
    public function platformleaguelist()
    {
        try {
            $data = input('param.');
            $page = input('page', 1);
            // 查询有联赛组织的比赛 作为联赛记录
            if (!array_key_exists('match_org_id', $data)) {
                $data['match_org_id'] = ['gt', 0];
            }
            // 默认查询所有分类记录
            if (array_key_exists('type', $data) && empty($data['type'])) {
                unset($data['type']);
            }
            // 默认查询city下所有记录
            if (array_key_exists('area', $data) && empty($data['area'])) {
                unset($data['area']);
            }
            // 搜索关键字(联赛名)
            $keyword = input('keyword');
            if ($keyword == null) {
                unset($data['keyword']);
            }
            if (!empty($keyword)) {
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
    public function platformleaguepage()
    {
        try {
            $data = input('param.');
            // 查询有联赛组织的比赛 作为联赛记录
            if (!array_key_exists('match_org_id', $data)) {
                $data['match_org_id'] = ['gt', 0];
            }
            // 默认查询所有分类记录
            if (array_key_exists('type', $data) && empty($data['type'])) {
                unset($data['type']);
            }
            // 默认查询city下所有记录
            if (array_key_exists('area', $data) && empty($data['area'])) {
                unset($data['area']);
            }
            // 搜索关键字(联赛名)
            $keyword = input('keyword');
            if ($keyword == null) {
                unset($data['keyword']);
            }
            if (!empty($keyword)) {
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
    public function leagueteamlist()
    {
        try {
            $data = input('param.');
            $page = input('param.page', 1);
            // 参数league_id -> match_id
            if (input('?param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }

            // 搜索关键字(联赛名)
            $keyword = input('keyword');
            if ($keyword == null) {
                unset($data['keyword']);
            }
            if (!empty($keyword)) {
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
    public function leagueteampage()
    {
        try {
            $data = input('param.');
            $page = input('param.page', 1);
            // 参数league_id -> match_id
            if (input('?param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }

            // 搜索关键字(联赛名)
            $keyword = input('keyword');
            if ($keyword == null) {
                unset($data['keyword']);
            }
            if (!empty($keyword)) {
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
    public function signupleague()
    {
        // 接收post参数
        $data = input('post.');
        // 比传参数验证 team_id league_id
        if (!array_key_exists('team_id', $data)) {
            return json(['code' => 100, 'msg' => __lang('MSG_402') . ',传入team_id']);
        }
        if (!array_key_exists('league_id', $data)) {
            return json(['code' => 100, 'msg' => __lang('MSG_402') . ',传入league_id']);
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
            return json(['code' => 100, 'msg' => '球队' . __lang('MSG_404')]);
        }
        $teamMember = $teamService->getTeamMemberInfo(['team_id' => $team['id'], 'member_id' => $this->memberInfo['id']]);
        if (!$teamMember || $teamMember['status_num'] != 1) {
            return json(['code' => 100, 'msg' => '您不是该球队的成员']);
        }
        // 根据league_id获取联赛信息
        $leagueService = new LeagueService();
        $league = $leagueService->getLeaugeInfoWithOrg([
            'id' => $data['league_id'],
            'match_org_id' => ['gt', 0]
        ]);
        if (!$league || $league['status_num'] != 1) {
            return json(['code' => 100, 'msg' => '联赛' . __lang('MSG_404')]);
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
            'is_league' => 1,
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
                    'title' => '您好，球队' . $team['name'] . '申请报名联赛' . $league['name'],
                    'content' => '您好，球队' . $team['name'] . '申请报名联赛' . $league['name'],
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
    public function replyleaguesignupteam()
    {
        // post参数
        $data = input('post.');
        // 比传参数验证 apply_id status(状态)
        if (!array_key_exists('apply_id', $data)) {
            return json(['code' => 100, 'msg' => __lang('MSG_402') . ',传入apply_id']);
        }
        if (!array_key_exists('status', $data) || !in_array($data['status'], [2, 3])) {
            return json(['code' => 100, 'msg' => __lang('MSG_402') . ',传入正确status']);
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
        $leagueService = new LeagueService();
        // 当前会员有无操作权限（查询联赛工作人员）
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        $power = $leagueService->getMatchMemberType([
            'match_id' => $matchApply['match_id'],
            'member_id' => $this->memberInfo['id'],
            'status' => 1
        ]);
        if (!$power) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
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
        $reply = (!empty($data['reply'])) ? '回复说明：' . $data['reply'] : '';
        // 组合推送消息内容
        $message = [
            'title' => '联赛报名申请通知',
            'content' => '球队 ' . $matchApply['team']['name'] . '报名参加联赛 ' . $matchApply['match']['name'] . '申请。申请结果：' . $statusStr,
            'url' => url('keeper/message/index', '', '', true),
            'keyword1' => '球队 ' . $matchApply['team']['name'] . '报名参加联赛 ' . $matchApply['match']['name'] . '申请',
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
                    // 查询球队的参赛球员数据
                    $matchTeamMembers = $leagueService->getmatchteammembers([
                        'match_apply_id' => $matchApply['id'],
                        'match_id' => $matchApply['match_id'],
                        'team_id' => $matchApply['team_id']
                    ]);
                    // 保存联赛球队数据
                    $dataMatchTeam = [
                        'match_id' => $matchApply['match_id'],
                        'match' => $matchApply['match']['name'],
                        'team_id' => $matchApply['team_id'],
                        'team' => $matchApply['team']['name'],
                        'team_logo' => $matchApply['team']['logo']
                    ];
                    // 组合联赛球队球员信息字段
                    if ($matchTeamMembers) {
                        $dataMatchTeam['members_num'] = count($matchTeamMembers);
                        $members = [];
                        foreach ($matchTeamMembers as $k => $val) {
                            $members[$k]['id'] = $val['id'];
                            $members[$k]['name'] = $val['name'];
                            $members[$k]['member_id'] = $val['member_id'];
                            $members[$k]['member'] = $val['member'];
                            $members[$k]['avatar'] = $val['avatar'];
                        }
                        $dataMatchTeam['members'] = json_encode($members, JSON_UNESCAPED_UNICODE);
                    }
                    $matchTeamId = $leagueService->saveMatchTeam($dataMatchTeam);
                    // 更新参赛球员数据
                    if ($matchTeamMembers) {
                        $leagueService->saveMatchTeamMember([
                            'match_team_id' => $matchTeamId['data']
                        ], [
                            'match_apply_id' => $matchApply['id'],
                            'match_id' => $matchApply['match_id'],
                            'team_id' => $matchApply['team_id']
                        ]);
                    }
                    // 联赛球队数+1
                    db('match')->where('id', $matchApply['match_id'])->setInc('teams_count', 1);
                    // 发送消息推送
                    $messageS = new MessageService();
                    $messageS->sendMessageToMember($matchApply['member_id'], $message, config('wxTemplateID.applyResult'));
                    // 球队公告
                    $teamS = new TeamService();
                    $teamS->saveTeamMessage($message);
                    // 通过报名球队数达到联赛球队最大数 更新联赛报名状态
                    $matchTeamCount = $leagueService->getMatchTeamCount(['match_id' => $matchApply['match_id']]);
                    if ( $matchTeamCount == $matchApply['match']['teams_max'] ) {
                        db('match')->where('id', $matchApply['match_id'])->update(['apply_status' => 2]);
                    }
                }
            }
        } catch (Exception $e) {
            trace($e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        return json($result);
    }

    // 通知报名联赛的球队完善信息
    public function noticeteamcompleteplayer()
    {
        // post参数
        $data = input('post.');
        // 比传参数验证 apply_id
        if (!array_key_exists('apply_id', $data)) {
            return json(['code' => 100, 'msg' => __lang('MSG_402') . ',传入apply_id']);
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
        // 当前会员有无联赛工作人员数据（操作权限）
        $leagueService = new LeagueService();
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        $power = $leagueService->getMatchMemberType([
            'match_id' => $matchApply['match_id'],
            'member_id' => $this->memberInfo['id'],
            'status' => 1
        ]);
        if (!$power) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        // 组合推送消息内容
        $message = [
            'title' => '报名联赛信息完善通知',
            'content' => '您好，您的球队 ' . $matchApply['team']['name'] . '未按要求提交参赛球员名单，请及时完善信息 ',
            'url' => url('keeper/match/completeplayerbyteam', ['match_id' => $matchApply['match_id'], 'team_id' => $matchApply['team_id']], '', true),
            'keyword1' => '您好，您的球队 ' . $matchApply['team']['name'] . '未按要求提交参赛球员名单，请及时完善信息 ',
            'keyword2' => '完善参赛球员名单',
            'remark' => '点击登录平台查看更多信息',
            'team_id' => $matchApply['team_id'],
            'steward_type' => 2
        ];
        try {
            // 发送消息推送
            $messageS = new MessageService();
            $messageS->sendMessageToMember($matchApply['member_id'], $message, config('wxTemplateID.applyResult'));
            // 球队公告
            $teamS = new TeamService();
            $teamS->saveTeamMessage($message);
        } catch (Exception $e) {
            trace($e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        return json(['code' => 200, 'msg' => __lang('MSG_200')]);
    }

    // 联赛报名球队列表
    public function leaguesignupteamlist()
    {
        try {
            $data = input('param.');
            $page = input('page');
            // 参数league_id -> match_id
            if (input('?param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }
            // 不列出status=2（已同意）的数据
            $data['status'] = ['neq', 2];
            $data['is_league'] = 1;
            if (input('?page')) {
                unset($data['page']);
            }
            $leagueService = new LeagueService();
            $matchService = new MatchService();
            $result = $matchService->getMatchApplyWithTeamList($data, $page);
            // 返回结果
            if (!$result) {
                $response = ['code' => 100, 'msg' => __lang('MSG_000')];
                return json($response);
            }
            // 遍历获取报名球队登记参赛球员数
            foreach ($result as $key => $value) {
                $matchTeamInfo = $leagueService->getMatchTeamInfoSimple([ 'match_id' => $value['match_id'], 'team_id' => $value['team_id'] ]);
                $result[$key]['checkin_member_num'] = ($matchTeamInfo) ? $matchTeamInfo['members_num'] : 0;
            }
            $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            return json($response);
        } catch (Exception $e) {
            trace($e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_401')]);
        }
    }

    // 联赛报名球队列表（页码）
    public function leaguesignupteampage()
    {
        try {
            $data = input('param.');
            // 参数league_id -> match_id
            if (input('?param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }
            // 不列出status=2（已同意）的数据
            $data['status'] = ['neq', 2];
            $data['is_league'] = 1;
            if (input('?page')) {
                unset($data['page']);
            }
            $leagueService = new LeagueService();
            $matchService = new MatchService();
            $result = $matchService->getMatchApplyWithTeamPaginator($data);
            // 返回结果
            if (!$result) {
                $response = ['code' => 100, 'msg' => __lang('MSG_000')];
                return json($response);
            }
            // 遍历获取报名球队登记参赛球员数
            foreach ($result['data'] as $key => $value) {
                $matchTeamInfo = $leagueService->getMatchTeamInfoSimple([ 'match_id' => $value['match_id'], 'team_id' => $value['team_id'] ]);
                $result['data'][$key]['checkin_member_num'] = ($matchTeamInfo) ? $matchTeamInfo['members_num'] : 0;
            }
            $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            return json($response);
        } catch (Exception $e) {
            trace($e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_401')]);
        }
    }

    // 创建联赛分组
    public function addleaguegroup()
    {
        $data = input('post.');
        // 数据验证
        if (!array_key_exists('match_id', $data)) {
            return json(['code' => 100, 'msg' => __lang('MSG_402') . '传入match_id']);
        }
        if (!array_key_exists('name', $data)) {
            return json(['code' => 100, 'msg' => __lang('MSG_402') . '传入name']);
        }
        $leagueS = new LeagueService();
        $matchS = new MatchService();
        // 查询联赛数据
        $match = $matchS->getMatch(['id' => $data['match_id']]);
        if (!$match) {
            return json(['code' => 100, 'msg' => __lang('MSG_404') . '请选择其他联赛']);
        }
        // 当前会员有无操作权限（查询联赛工作人员）
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        $power = $leagueS->getMatchMemberType([
            'match_id' => $data['match_id'],
            'member_id' => $this->memberInfo['id'],
            'status' => 1
        ]);
        if (!$power) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        // 查询分组名是否已存在
        $checkMatchGroup = $leagueS->getMatchGroup([
            'match_id' => $data['match_id'],
            'name' => $data['name']
        ]);
        if ($checkMatchGroup) {
            return json(['code' => 100, 'msg' => '分组名不能重复，请输入其他分组名']);
        }
        try {
            $data['match'] = $match['name'];
            $data['status'] = 1;
            $result = $leagueS->saveMatchGroup($data);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        if ($result) {
            return json(['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $result]);
        } else {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
    }

    // 编辑联赛分组
    public function updateleaguegroup()
    {
        $data = input('post.');
        // 数据验证
        if (!array_key_exists('id', $data)) {
            // match_group id
            return json(['code' => 100, 'msg' => __lang('MSG_402') . '传入id']);
        }
        if (!array_key_exists('match_id', $data)) {
            return json(['code' => 100, 'msg' => __lang('MSG_402') . '传入match_id']);
        }
        if (!array_key_exists('name', $data)) {
            return json(['code' => 100, 'msg' => __lang('MSG_402') . '传入name']);
        }
        $leagueS = new LeagueService();
        $matchS = new MatchService();
        // 查询联赛数据
        $match = $matchS->getMatch(['id' => $data['match_id']]);
        if (!$match) {
            return json(['code' => 100, 'msg' => __lang('MSG_404') . '请选择其他联赛']);
        }
        // 获取分组信息
        $matchGroup = $leagueS->getMatchGroup(['id' => $data['id']]);
        if (!$matchGroup) {
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
        // 当前会员有无操作权限（查询联赛工作人员）
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        $power = $leagueS->getMatchMemberType([
            'match_id' => $data['match_id'],
            'member_id' => $this->memberInfo['id'],
            'status' => 1
        ]);
        if (!$power) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        // 查询分组名是否已存在
        $checkMatchGroup = $leagueS->getMatchGroup([
            'match_id' => $data['match_id'],
            'name' => $data['name']
        ]);
        if ($checkMatchGroup) {
            return json(['code' => 100, 'msg' => '分组名不能重复，请输入其他分组名']);
        }
        try {
            $result = $leagueS->saveMatchGroup($data);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        if ($result) {
            return json(['code' => 200, 'msg' => __lang('MSG_200')]);
        } else {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
    }

    // 联赛分组列表
    public function leaguegrouplist()
    {
        try {
            $data = input('param.');
            $page = input('page');
            // 参数league_id -> match_id
            if (input('?param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }
            if (input('?page')) {
                unset($data['page']);
            }

            $leagueService = new LeagueService();
            $result = $leagueService->getMatchGroupList($data, $page);
            // 返回结果
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_000')];
            }
            return json($response);
        } catch (Exception $e) {
            trace($e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_401')]);
        }
    }

    // 联赛分组列表（页码）
    public function leaguegrouppage()
    {
        try {
            $data = input('param.');
            // 参数league_id -> match_id
            if (input('?param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }
            if (input('?page')) {
                unset($data['page']);
            }
            // 获取数据
            $leagueService = new LeagueService();
            $result = $leagueService->getMatchGroupPaginator($data);
            // 返回结果
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_000')];
            }
            return json($response);
        } catch (Exception $e) {
            trace($e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_401')]);
        }
    }

    // 联赛分组包含组内球队列表（不分页）
    public function leaguegroupwithteams()
    {
        try {
            $data = input('param.');
            // 参数league_id -> match_id
            if (input('?param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }
            // 获取分组列表数据
            $leagueService = new LeagueService();
            $result = $leagueService->getMatchGroups($data);
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
            foreach ($result as $k => $val) {
                // 遍历获取分组下球队列表数据
                $groupTeams = $leagueService->getMatchGroupTeams(['group_id' => $val['id']]);
                if ($groupTeams) {
                    foreach ($groupTeams as $k1 => $val1) {
                        $matchteam = $leagueService->getMatchTeamInfoSimple(['team_id' => $val1['team_id']]);
                        $groupTeams[$k1]['team'] = $matchteam;
                    }
                }
                $result[$k]['group_teams'] = $groupTeams;
            }
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
        } catch (Exception $e) {
            trace($e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_401')]);
        }
    }

    // 联赛分组包含组内球队列表
    public function leaguegroupwithteamslist()
    {
        try {
            $data = input('param.');
            //页数
            $page = input('page');
            // 参数league_id -> match_id
            if (input('?param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }
            if (input('?page')) {
                unset($data['page']);
            }
            // 获取分组列表数据
            $leagueService = new LeagueService();
            $result = $leagueService->getMatchGroupList($data, $page);
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
            foreach ($result as $k => $val) {
                // 遍历获取分组下球队列表数据
                $groupTeams = $leagueService->getMatchGroupTeams(['group_id' => $val['id']]);
                if ($groupTeams) {
                    foreach ($groupTeams as $k1 => $val1) {
                        $matchteam = $leagueService->getMatchTeamInfoSimple(['team_id' => $val1['team_id']]);
                        $groupTeams[$k1]['team'] = $matchteam;
                    }
                }
                $result[$k]['group_teams'] = $groupTeams;
            }
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
        } catch (Exception $e) {
            trace($e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_401')]);
        }
    }

    // 联赛分组包含组内球队列表（页码）
    public function leaguegroupwithteamspage()
    {
        try {
            $data = input('param.');
            // 参数league_id -> match_id
            if (input('?param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }
            if (input('?page')) {
                unset($data['page']);
            }
            // 获取数据
            $leagueService = new LeagueService();
            $result = $leagueService->getMatchGroupPaginator($data);
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
            foreach ($result['data'] as $k => $val) {
                // 遍历获取分组下球队列表数据
                $groupTeams = $leagueService->getMatchGroupTeams(['group_id' => $val['id']]);
                if ($groupTeams) {
                    foreach ($groupTeams as $k1 => $val1) {
                        $matchteam = $leagueService->getMatchTeamInfoSimple(['team_id' => $val1['team_id']]);
                        $groupTeams[$k1]['team'] = $matchteam;
                    }
                }
                $result['data'][$k]['group_teams'] = $groupTeams;
            }
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
        } catch (Exception $e) {
            trace($e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_401')]);
        }
    }

    // 保存联赛球队分组数据
    public function saveleaguegroup()
    {
        // 接收请求变量
        $data = input('post.');
        // 数据验证
        if (!array_key_exists('league_id', $data)) {
            return json(['code' => 100, 'msg' => __lang('MSG_402') . '传入league_id']);
        }

        $leagueS = new LeagueService();
        $matchS = new MatchService();
        // 查询联赛数据
        $match = $matchS->getMatch(['id' => $data['league_id']]);
        if (!$match) {
            return json(['code' => 100, 'msg' => __lang('MSG_404') . '请选择其他联赛']);
        }
        // 当前会员有无操作权限（查询联赛工作人员）
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        $power = $leagueS->getMatchMemberType([
            'match_id' => $data['league_id'],
            'member_id' => $this->memberInfo['id'],
            'status' => 1
        ]);
        // 需要联赛管理员以上
        if (!$power || $power < 9) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        // 检查分组数据有效性
        if (!array_key_exists('groupList', $data)) {
            return json(['code' => 100, 'msg' => __lang('MSG_402') . 'groupList分组球队名单']);
        }
        if (empty($data['groupList']) && $data['groupList'] == "[]") {
            return json(['code' => 100, 'msg' => __lang('MSG_402') . 'groupList分组球队名单']);
        }
        // 事务处理：检查联赛有无球队分组数据 若有数据先物理删除原有数据
        Db::startTrans();
        try {
            $matchGroups = $leagueS->getMatchGroups(['match_id' => $match['id']]);
            $matchGroupTeams = $leagueS->getMatchGroupTeams(['match_id' => $match['id']]);
            if ($matchGroups) {
                $leagueS->deleteMatchGroup(['match_id' => $match['id']], true);
            }
            if ($matchGroupTeams) {
                $leagueS->deleteMatchGroupTeam(['match_id' => $match['id']], true);
            }
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
        }
        // 解析post提交的球队分组数据
        $dataGroups = json_decode($data['groupList'], true);
        if (is_null($dataGroups)) {
            return json(['code' => 100, 'msg' => '数据不合法']);
        }
        try {
            foreach ($dataGroups as $k => $group) {
                //dump($group);
                // 保存分组数据
                $groupData = [
                    'match_id' => $match['id'],
                    'match' => $match['name'],
                    'name' => $group['groupName']
                ];
                $groupId = $leagueS->saveMatchGroup($groupData);
                // 保存分组球队数据
                foreach ($group['groupTeam'] as $j => $team) {
                    //dump($team);
                    $groupTeamData = [
                        'match_id' => $match['id'],
                        'match' => $match['name'],
                        'match_logo' => $match['logo'],
                        'team_id' => $team['team_id'],
                        'team' => $team['team'],
                        'team_logo' => $team['team_logo'],
                        'group_id' => $groupId,
                        'group_name' => $group['groupName'],
                        'group_number' => $j + 1,
                        'status' => 1,
                        'win_num' => 0,
                        'lost_num' => 0,
                        'points' => 0
                    ];
                    $groupTeamId = $leagueS->saveMatchGroupTeam($groupTeamData);
                }
            }
        } catch (Exception $e) {
            trace('error:' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        if ($groupTeamId) {
            return json(['code' => 200, 'msg' => __lang('MSG_200')]);
        } else {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
    }

    // 获取联赛球队成员列表（无分页）
    public function getmatchteammembers()
    {
        try {
            $data = input('param.');
            // 参数league_id -> match_id
            if (input('?param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }
            // 获取分组列表数据
            $leagueService = new LeagueService();
            $result = $leagueService->getMatchTeamMembers($data);
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
        } catch (Exception $e) {
            trace($e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_401')]);
        }
    }

    // 获取联赛球队成员列表
    public function getmatchteammemberlist()
    {
        try {
            $data = input('param.');
            $page = input('param.page');
            // 参数league_id -> match_id
            if (input('?param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }
            if (input('?param.page')) {
                unset($data['page']);
            }

            $leagueService = new LeagueService();
            $result = $leagueService->getMatchTeamMemberList($data, $page);
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
        } catch (Exception $e) {
            trace($e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_401')]);
        }
    }

    // 获取联赛球队成员列表（页码）
    public function getmatchteammemberpage()
    {
        try {
            $data = input('param.');
            $page = input('param.page');
            // 参数league_id -> match_id
            if (input('?param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }
            if (input('?param.page')) {
                unset($data['page']);
            }

            $leagueService = new LeagueService();
            $result = $leagueService->getMatchTeamMemberPaginator($data);
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
        } catch (Exception $e) {
            trace($e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_401')]);
        }
    }

    // 球队提交参赛成员名单
    public function savematchteammemberfromteam()
    {
        $data = $this->request->post();
        // 验证器
        $validate = validate('MatchTeamMemberVal');
        if (!$validate->check($data)) {
            return json(['code' => 100, 'msg' => $validate->getError()]);
        }
        // 正常球员数据
        if (!array_key_exists('TeamMemberData', $data) || $data['TeamMemberData'] == '[]') {
            return json(['code' => 100, 'msg' => '请选择参赛球员']);
        }
        $normalTeamMembers = json_decode($data['TeamMemberData'], true);
        if (array_key_exists('TeamMemberDataDel', $data) && $data['TeamMemberDataDel'] != '[]') {
            $delTeamMembers = json_decode($data['TeamMemberDataDel'], true);
        }
        $leagueS = new LeagueService();

        // 检查球员有无在联赛登记在其他球队数据
        foreach ($normalTeamMembers as $k => $val) {
            $checkMatchTeamMember = $leagueS->getMatchTeamMember([
                'match_id' => $data['match_id'],
                'team_id' => ['neq', $data['team_id']],
                'member_id' => $val['member_id'],
                'name' => $val['name']
            ]);
            if ($checkMatchTeamMember) {
                return json(['code' => 100, 'msg' => $val['name'] . '已登记在其他球队参加此联赛']);
                continue;
            }
        }

        // 组合match_team_member进表数据
        try {
            // 删除数据更新
            if (isset($delTeamMembers)) {
                foreach ($delTeamMembers as $k => $val) {
                    // 查询match_team_member有无原数据
                    $matchTeamMember = $leagueS->getMatchTeamMember([
                        'match_id' => $data['match_id'],
                        'team_id' => $data['team_id'],
                        'team_member_id' => $val['team_member_id']
                    ]);
                    if (isset($data['match_team_id'])) {
                        $delTeamMembers[$k]['match_team_id'] = $data['match_team_id'];
                    }
                    $delTeamMembers[$k]['match_apply_id'] = $data['match_apply_id'];
                    if ($matchTeamMember) {
                        $leagueS->delMatchTeamMember($matchTeamMember['id'], true);
                    }
                }
            }
            // 正常数据保存数据
            foreach ($normalTeamMembers as $k => $val) {
                // 查询match_team_member有无原数据
                $matchTeamMember = $leagueS->getMatchTeamMember([
                    'match_id' => $data['match_id'],
                    'team_id' => $data['team_id'],
                    'team_member_id' => $val['team_member_id']
                ]);
                if ($matchTeamMember) {
                    $normalTeamMembers[$k]['id'] = $matchTeamMember['id'];
                }
                if (isset($data['match_team_id'])) {
                    $normalTeamMembers[$k]['match_team_id'] = $data['match_team_id'];
                }
                $normalTeamMembers[$k]['match_apply_id'] = $data['match_apply_id'];
                $normalTeamMembers[$k]['match_id'] = $data['match_id'];
                $normalTeamMembers[$k]['match'] = $data['match'];
                $normalTeamMembers[$k]['team_id'] = $data['team_id'];
                $normalTeamMembers[$k]['team'] = $data['team'];
                $normalTeamMembers[$k]['team_logo'] = $data['team_logo'];
                $normalTeamMembers[$k]['status'] = 1;
            }
            $result = $leagueS->saveAllMatchTeamMember($normalTeamMembers);
        } catch (Exception $e) {
            trace('error:' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        // 返回响应结果
        if ($result === false) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        } else {
            return json(['code' => 200, 'msg' => __lang('MSG_200')]);
        }
    }

    // 设置章程
    public function setregulation()
    {
        // 接收请求变量
        $data = $this->request->post();
        $leagueS = new LeagueService();
        $matchS = new MatchService();
        // 查询联赛数据
        $match = $matchS->getMatch(['id' => $data['id']]);
        if (!$match) {
            return json(['code' => 100, 'msg' => __lang('MSG_404') . '请选择其他联赛']);
        }
        // 验证会员有无操作权限
        // 当前会员有无操作权限（查询联赛工作人员）
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        $power = $leagueS->getMatchMemberType([
            'match_id' => $data['id'],
            'member_id' => $this->memberInfo['id'],
            'status' => 1
        ]);
        if (!$power) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        try {
            $result = $matchS->saveMatch($data);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        return json($result);
    }

    // 获取联赛组织-人员列表
    public function getmatchorgmemberlist()
    {
        try {
            $data = input('param.');
            $page = input('param.page', 1);
            if (input('?param.page')) {
                unset($data['page']);
            }
            $orderby = ['type' => 'desc', 'id' => 'desc'];
            $leagueS = new LeagueService();
            $result = $leagueS->getMatchOrgMemberList($data, $page, $orderby);

            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            } else {
                return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
    }

    // 获取联赛组织-人员列表(页码)
    public function getmatchorgmemberpage()
    {
        try {
            $data = input('param.');
            $page = input('param.page', 1);
            if (input('?param.page')) {
                unset($data['page']);
            }
            $leagueS = new LeagueService();
            $orderby = ['type' => 'desc', 'id' => 'desc'];
            $result = $leagueS->getMatchOrgMemberPaginator($data, $orderby);
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            } else {
                return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
    }

    // 检查会员有无联赛组织人员数据
    public function checkmatchorgmember()
    {
        try {
            $data = input('param.');
            if (!array_key_exists('match_org_id', $data)) {
                return json(['code' => 100, 'msg' => '缺少match_org_id']);
            }
            if (!array_key_exists('member_id', $data)) {
                return json(['code' => 100, 'msg' => '缺少member_id']);
            }
            // 查询联赛组织人员数据
            $leagueService = new LeagueService();
            $matchorgmember = $leagueService->getMatchOrgMember([
                'match_org_id' => $data['match_org_id'],
                'member_id' => $data['member_id']
            ]);
            if ($matchorgmember) {
                if ($matchorgmember['status'] == 1) {
                    // 会员已是正式联赛组织人员
                    return json(['code' => 200, 'msg' => '会员已是正式联赛组织人员']);
                } else if ($matchorgmember['status'] == 0) {
                    // 有数据，不是正式数据
                    return json(['code' => 200, 'msg' => '已邀请会员']);
                }
            } else {
                // 没有联赛组织人员数据
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
        } catch (Exception $e) {
            trace('error:' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
    }

    // 向会员邀请加入联赛组织
    public function invitematchorgmebmer()
    {
        // 接收请求变量
        $data = input('post.');
        if (!array_key_exists('match_org_id', $data)) {
            return json(['code' => 100, 'msg' => '缺少match_org_id']);
        }
        if (!array_key_exists('member_id', $data)) {
            return json(['code' => 100, 'msg' => '缺少member_id']);
        }
        $leagueService = new LeagueService();
        // 查询联赛组织数据
        $matchOrg = $leagueService->getMatchOrg(['id' => $data['match_org_id']]);
        if (!$matchOrg || $matchOrg['status'] != 1) {
            return json(['code' => 100, 'msg' => '联赛组织不存在或未通过审核']);
        }
        // 获取受邀请会员的详细信息
        $memberService = new MemberService();
        $member = $memberService->getMemberInfo(['id' => $data['member_id']]);
        if (!$member) {
            return json(['code' => 100, 'msg' => __lang('MSG_404') . '会员']);
        }
        // 检查当前会员联赛组织人员身份
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_000')]);
        }
        $checkMatchOrgMember = $leagueService->getMatchOrgMember([
            'match_org_id' => $data['match_org_id'],
            'member_id' => $this->memberInfo['id']
        ]);
        if (!$checkMatchOrgMember || $checkMatchOrgMember['status'] != 1) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        // 邀请的会员有无联赛组织人员数据
        $matchOrgMember = $leagueService->getMatchOrgMember([
            'match_org_id' => $data['match_org_id'],
            'member_id' => $data['member_id']
        ]);
        if ($matchOrgMember && $matchOrgMember['status'] == 1) {
            // 会员已是正式联赛组织人员
            return json(['code' => 200, 'msg' => '会员已是正式联赛组织人员']);
        }
        // 邀请的会员有无(apply)邀请数据记录
        $matchOrgMemberApply = $leagueService->getApplyByLeague([
            'organization_type' => 5,
            'organization_id' => $data['match_org_id'],
            'type' => 3,
            'member_id' => $data['member_id'],
            'apply_type' => 2
        ]);
        // apply数据
        $dataApply = [
            'member' => $member['member'],
            'member_id' => $member['id'],
            'member_avatar' => $member['avatar'],
            'organization_type' => 5,
            'organization' => $matchOrg['name'],
            'organization_id' => $matchOrg['id'],
            'organization_image' => $matchOrg['logo'],
            'type' => 3, // 管理员
            'inviter' => $this->memberInfo['member'],
            'inviter_id' => $this->memberInfo['id'],
            'inviter_avatar' => $this->memberInfo['avatar'],
            'apply_type' => 2,
            'isread' => 0,
            'status' => 1
        ];
        if ($matchOrgMemberApply) {
            //return json(['code' => 100, 'msg' => '有邀请记录', 'data' => $matchOrgMemberApply]);
            $dataApply['id'] = $matchOrgMemberApply['id'];
        }
        try {
            // 保存apply数据（status=1）
            $applyId = $leagueService->saveApplyByLeague($dataApply);
            // 保存联赛组织人员数据
            // $orgMemberId = $leagueService->saveMatchOrgMember($dataMatchOrgMember);
        } catch (Exception $e) {
            trace('error:' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_401')]);
        }
        if ($applyId['code'] != 200) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        } else {
            // 发送消息给受邀会员
            $messageS = new MessageService();
            $message = [
                'title' => '联赛组织-' . $matchOrg['name'] . '邀请你加入',
                'content' => '联赛组织-' . $matchOrg['name'] . '邀请你加入',
                'url' => url('keeper/match/orginvitation', ['id' => $applyId['data']], '', true),
                'keyword1' => '邀请加入联赛组织',
                'keyword2' => $this->memberInfo['member'],
                'keyword3' => date('Y-m- H:i', time()),
                'remark' => '点击查看详情',
                'steward_type' => 2,
            ];
            $messageS->sendMessageToMember($member['id'], $message, config('wxTemplateID.checkPend'));
            return json($applyId);
        }
    }

    // 会员回复联赛组织邀请
    public function replymatchorginvitation()
    {
        $data = input('post.');
        // 比传参数验证 apply_id status(状态)
        if (!array_key_exists('apply_id', $data)) {
            return json(['code' => 100, 'msg' => __lang('MSG_402') . ',传入apply_id']);
        }
        if (!array_key_exists('status', $data) || !in_array($data['status'], [2, 3])) {
            return json(['code' => 100, 'msg' => __lang('MSG_402') . ',传入正确status']);
        }
        // 检查会员登录信息
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        // 获取联赛组织邀请数据
        $leagueS = new LeagueService();
        $apply = $leagueS->getApplyByLeague([
            'id' => $data['apply_id'],
            'organization_type' => 5,
            'apply_type' => 2
        ]);
        if (!$apply) {
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
        if ($apply['member_id'] != $this->memberInfo['id']) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        // 同意status=2/拒绝status=3：更新申请状态,回复消息推送
        $status = $data['status'];
        $statusStr = '';
        if ($status == 3) {
            // 拒绝
            $statusStr = '已拒绝';
        } else {
            // 同意
            $statusStr = '已同意';
        }
        // 回复理由
        $reply = (!empty($data['reply'])) ? '回复说明：' . $data['reply'] : '';
        // 组合推送消息内容
        $message = [
            'title' => '联赛组织邀请会员回复',
            'content' => '您的联赛组织' . $apply['organization'] . '邀请会员' . $apply['member'] . '加入回复结果：' . $statusStr,
            'url' => url('keeper/match/adminlistoforganization', ['org_id' => $apply['organization_id']], '', true),
            'keyword1' => '您的联赛组织' . $apply['organization'] . '邀请会员' . $apply['member'] . '加入回复结果：' . $statusStr,
            'keyword2' => $statusStr,
            'remark' => '点击登录平台查看更多信息',
            'steward_type' => 2
        ];
        try {
            // 更新apply数据
            $resultUpdateApply = $leagueS->saveApplyByLeague([
                'id' => $apply['id'],
                'status' => $status,
                'reply' => $reply,
                'remarks' => $statusStr
            ]);
            // 同意，更新联赛组织人员数据
            if ($status == 2) {
                // 组合联赛组织人员数据 （status=1）
                $matchOrg = $leagueS->getMatchOrg(['id' => $apply['organization_id']]);
                // 获取会员联赛组织人员数据
                $orgMember = $leagueS->getMatchOrgMember([
                    'match_org_id' => $apply['organization_id'],
                    'member_id' => $this->memberInfo['id']
                ]);
                $dataMatchOrgMember = [
                    'match_org_id' => $matchOrg['id'],
                    'match_org' => $matchOrg['name'],
                    'match_org_logo' => $matchOrg['logo'],
                    'member_id' => $this->memberInfo['id'],
                    'member' => $this->memberInfo['member'],
                    'member_avatar' => $this->memberInfo['avatar'],
                    'realname' => $this->memberInfo['realname'],
                    'type' => 9,
                    'status' => 1
                ];
                if ($orgMember) {
                    $dataMatchOrgMember['id'] = $orgMember['id'];
                }
                $resultUpdateOrgMember = $leagueS->saveMatchOrgMember($dataMatchOrgMember);
            }
            // 发送消息推送
            $messageS = new MessageService();
            $messageS->sendMessageToMember($apply['inviter_id'], $message, config('wxTemplateID.applyResult'));
        } catch (Exception $e) {
            trace('error' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        return json($resultUpdateApply);
    }

    // 删除联赛组织人员
    public function delmatchorgmember()
    {
        $id = input('id', 0, 'intval');
        if (!$id) {
            return json(['code' => 100, 'msg' => __lang('MSG_402')]);
        }
        // 查询联赛组织人员数据
        $leagueS = new LeagueService();
        $matchorgmember = $leagueS->getMatchOrgMember(['id' => $id]);
        if (!$matchorgmember) {
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
        // 检查当前会员登录信息
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        // 检查当前会员操作权限（联赛组织人员数据）
        $orgmemberpower = $leagueS->getMatchOrgMember([
            'match_org_id' => $matchorgmember['match_org_id'],
            'member_id' => $this->memberInfo['id']
        ]);
        // 非负责人不能操作
        if (!$orgmemberpower || $orgmemberpower['type_num'] != 10) {
            return json(['code' => 100, 'msg' => __lang('MSG_402')]);
        }
        // 不能删除负责人
        if (!$matchorgmember['type_num'] == 10) {
            return json(['code' => 100, 'msg' => '不能删除负责人']);
        }

        try {
            // 删除联赛组织人员
            $resultDelete = $leagueS->delMatchOrgMember($matchorgmember['id']);
        } catch (Exception $e) {
            trace('error:' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        if (!$resultDelete) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        // 给该会员发送被删除联赛组织消息推送
        try {
            $messageContent = [
                'title' => '联赛组织人员被移出通知',
                'content' => '您已被移出联赛组织' . $matchorgmember['match_org'],
                'url' => url('keeper/message/index', '', '', true),
                'keyword1' => '您已被移出联赛组织' . $matchorgmember['match_org'],
                'keyword2' => '被移出联赛组织',
                'remark' => '点击登录平台查看更多信息',
                'steward_type' => 2
            ];
            $messageS = new MessageService();
            $messageS->sendMessageToMember($matchorgmember['member_id'], $messageContent, config('wxTemplateID.informationChange'));
        } catch (Exception $e) {
            trace('error:' . $e->getMessage(), 'error');
        }
        return json(['code' => 200, 'msg' => __lang('MSG_200')]);
    }

    // 联赛工作人员列表
    public function getmatchmemberlist()
    {
        try {
            $data = input('param.');
            $page = input('page', 1);
            // 参数league_id -> match_id
            if (input('?param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }
            if (input('?page')) {
                unset($data['page']);
            }
            $orderby = ['status' => 'desc', 'type' => 'desc', 'id' => 'desc'];
            $leagueS = new LeagueService();
            $result = $leagueS->getMatchMemberList($data, $page, $orderby);
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            } else {
                return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
            }
        } catch (Exception $e) {
            trace($e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
    }

    // 联赛工作人员列表(页码)
    public function getmatchmemberpage()
    {
        try {
            $data = input('param.');
            // 参数league_id -> match_id
            if (input('?param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }
            if (input('?page')) {
                unset($data['page']);
            }
            $orderby = ['status' => 'desc', 'type' => 'desc', 'id' => 'desc'];
            $leagueS = new LeagueService();
            $result = $leagueS->getMatchMemberPaginator($data, $orderby);
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            } else {
                return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
            }
        } catch (Exception $e) {
            trace($e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
    }

    // 检查会员有无联赛工作人员数据
    public function checkmatchmember()
    {
        try {
            $data = input('param.');
            if (!array_key_exists('match_id', $data)) {
                return json(['code' => 100, 'msg' => '缺少match_id']);
            }
            if (!array_key_exists('member_id', $data)) {
                return json(['code' => 100, 'msg' => '缺少member_id']);
            }
            // 查询联赛组织人员数据
            $leagueService = new LeagueService();
            $matchorgmember = $leagueService->getMatchMember([
                'match_id' => $data['match_id'],
                'member_id' => $data['member_id']
            ]);
            if ($matchorgmember) {
                if ($matchorgmember['status'] == 1) {
                    // 会员已是正式联赛工作人员
                    return json(['code' => 200, 'msg' => '会员已是正式联赛工作人员']);
                } else if ($matchorgmember['status'] == 0) {
                    // 有数据，不是正式数据
                    return json(['code' => 200, 'msg' => '已邀请会员']);
                }
            } else {
                // 没有联赛组织人员数据
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
        } catch (Exception $e) {
            trace('error:' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
    }

    // 邀请会员 联赛工作人员
    public function invitematchmebmer()
    {
        // 接收请求变量
        $data = input('post.');
        if (!array_key_exists('match_id', $data)) {
            return json(['code' => 100, 'msg' => '缺少match_id']);
        }
        if (!array_key_exists('member_id', $data)) {
            return json(['code' => 100, 'msg' => '缺少member_id']);
        }
        $leagueService = new LeagueService();
        // 查询联赛数据
        $match = $leagueService->getLeaugeInfoWithOrg(['id' => $data['match_id']]);
        if (!$match || $match['status_num'] != 1) {
            return json(['code' => 100, 'msg' => '联赛不存在或未通过审核']);
        }
        // 获取受邀请会员的详细信息
        $memberService = new MemberService();
        $member = $memberService->getMemberInfo(['id' => $data['member_id']]);
        if (!$member) {
            return json(['code' => 100, 'msg' => __lang('MSG_404') . '会员']);
        }
        // 检查当前会员联赛组织人员身份
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_000')]);
        }
        $checkMatchOrgMember = $leagueService->getMatchOrgMember([
            'match_org_id' => $match['match_org_id'],
            'member_id' => $this->memberInfo['id']
        ]);
        if (!$checkMatchOrgMember || $checkMatchOrgMember['status'] != 1) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        // 若是邀请裁判员 检查该会员有无裁判员资质
        if ($data['type'] == 7) {
            $refereeS = new RefereeService();
            $memberIsReferee = $refereeS->getRefereeInfo(['member_id' => $member['id']]);
            if (!$memberIsReferee || $memberIsReferee['status_num'] != 1) {
                return json(['code' => 100, 'msg' => '该会员没有裁判员资质，请选择其他会员']);
            }
        }
        // 邀请的会员有无联赛工作人员数据
        $matchMember = $leagueService->getMatchMember([
            'match_id' => $match['id'],
            'member_id' => $data['member_id']
        ]);
        if ($matchMember && $matchMember['status'] == 1) {
            // 会员已是正式联赛工作人员
            return json(['code' => 200, 'msg' => '会员已是正式联赛工作人员']);
        }
        // apply表type字段内容
        $applyType = 0;
        switch ($data['type']) {
            case 9:
                $applyType = 3;
                break;  // 管理员
            case 8:
                $applyType = 8;
                break;  // 记分员
            case 7:
                $applyType = 6;
                break;  // 裁判员
            default:
                $applyType = 1;
        }
        // 邀请的会员有无(apply)邀请数据记录
        $matchMemberApply = $leagueService->getApplyByLeague([
            'organization_type' => 4,
            'organization_id' => $match['id'],
            'member_id' => $data['member_id'],
            'apply_type' => 2
        ]);
        // apply数据
        $dataApply = [
            'member' => $member['member'],
            'member_id' => $member['id'],
            'member_avatar' => $member['avatar'],
            'organization_type' => 4,
            'organization' => $match['name'],
            'organization_id' => $match['id'],
            'organization_image' => $match['logo'],
            'type' => $applyType,
            'inviter' => $this->memberInfo['member'],
            'inviter_id' => $this->memberInfo['id'],
            'inviter_avatar' => $this->memberInfo['avatar'],
            'apply_type' => 2,
            'isread' => 0,
            'status' => 1
        ];
        if ($matchMemberApply) {
            //return json(['code' => 100, 'msg' => '有邀请记录', 'data' => $matchOrgMemberApply]);
            $dataApply['id'] = $matchMemberApply['id'];
        }
        // 工作人员角色文案
        $typesArr = $leagueService->getMatchMemberTypes();
        $typeStr = $typesArr[$data['type']];
        try {
            // 保存apply数据（status=1）
            $applyId = $leagueService->saveApplyByLeague($dataApply);
        } catch (Exception $e) {
            trace('error:' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        if ($applyId['code'] != 200) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        // 发送消息给受邀会员
        $messageS = new MessageService();
        $message = [
            'title' => '联赛-' . $match['name'] . '邀请你担任' . $typeStr,
            'content' => '联赛-' . $match['name'] . '邀请你担任' . $typeStr,
            'url' => url('keeper/match/workerinvitation', ['id' => $applyId['data']], '', true),
            'keyword1' => '联赛邀请担任' . $typeStr,
            'keyword2' => $this->memberInfo['member'],
            'keyword3' => date('Y-m- H:i', time()),
            'remark' => '点击查看详情',
            'steward_type' => 2,
        ];
        try {
            $messageS->sendMessageToMember($member['id'], $message, config('wxTemplateID.checkPend'));
        } catch (Exception $e) {
            trace('error:' . $e->getMessage());
        }
        return json($applyId);
    }

    // 会员回复联赛工作人员邀请
    public function replymatchworkerinvitation()
    {
        $data = input('post.');
        // 比传参数验证 apply_id status(状态)
        if (!array_key_exists('apply_id', $data)) {
            return json(['code' => 100, 'msg' => __lang('MSG_402') . ',传入apply_id']);
        }
        if (!array_key_exists('status', $data) || !in_array($data['status'], [2, 3])) {
            return json(['code' => 100, 'msg' => __lang('MSG_402') . ',传入正确status']);
        }
        // 检查会员登录信息
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        // 获取联赛工作人员邀请数据
        $leagueS = new LeagueService();
        $apply = $leagueS->getApplyByLeague([
            'id' => $data['apply_id'],
            'organization_type' => 4,
            'apply_type' => 2
        ]);
        if (!$apply) {
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
        if ($apply['member_id'] != $this->memberInfo['id']) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        // apply（申请表）职位文案
        $applyTypeStr = '';
        // 工作人员（type字段）内容值
        $matchMemberType = 0;
        switch ($apply['type']) {
            case 3:
                $applyTypeStr = '管理员';
                $matchMemberType = 9;
                break;  // 管理员
            case 8:
                $applyTypeStr = '记分员';
                $matchMemberType = 8;
                break;  // 记分员
            case 6:
                $applyTypeStr = '裁判员';
                $matchMemberType = 7;
                break;  // 裁判员
            default:
                $applyTypeStr = '工作人员';
        }
        // 同意status=2/拒绝status=3：更新申请状态,回复消息推送
        $status = $data['status'];
        $statusStr = '';
        if ($status == 3) {
            // 拒绝
            $statusStr = '已拒绝';
        } else {
            // 同意
            $statusStr = '已同意';
        }
        // 回复理由
        $reply = (!empty($data['reply'])) ? '回复说明：' . $data['reply'] : '';
        // 组合推送消息内容
        $message = [
            'title' => '联赛工作人员邀请会员回复结果',
            'content' => '您的联赛' . $apply['organization'] . '邀请会员' . $apply['member'] . '担任' . $applyTypeStr . '回复结果：' . $statusStr,
            'url' => url('keeper/message/index', '', '', true),
            'keyword1' => '您的联赛' . $apply['organization'] . '邀请会员' . $apply['member'] . '担任' . $applyTypeStr . '回复结果：' . $statusStr,
            'keyword2' => $statusStr,
            'remark' => '点击登录平台查看更多信息',
            'steward_type' => 2
        ];

        try {
            // 更新apply数据
            $resultUpdateApply = $leagueS->saveApplyByLeague([
                'id' => $apply['id'],
                'status' => $status,
                'reply' => $reply,
                'remarks' => $statusStr
            ]);
            // 同意，保存联赛组织人员数据
            if ($status == 2) {
                // 获取联赛信息
                $match = $leagueS->getLeaugeInfoWithOrg(['id' => $apply['organization_id']]);
                // 保存联赛工作人员数据
                $dataMatchMember = [
                    'match_id' => $match['id'],
                    'match' => $match['name'],
                    'match_logo' => $match['logo'],
                    'member_id' => $this->memberInfo['id'],
                    'member' => $this->memberInfo['member'],
                    'member_avatar' => $this->memberInfo['avatar'],
                    'realname' => $this->memberInfo['realname'],
                    'type' => $matchMemberType,
                    'status' => 1
                ];
                // 获取联赛工作人员数据
                $matchMember = $leagueS->getMatchMember([
                    'match_id' => $apply['organization_id'],
                    'member_id' => $this->memberInfo['id']
                ]);
                if ($matchMember) {
                    $dataMatchMember['id'] = $matchMember['id'];
                }
                $leagueS->saveMatchMember($dataMatchMember);
            }
            // 向邀请人 发送邀请回复 消息推送
            $messageS = new MessageService();
            $messageS->sendMessageToMember($apply['inviter_id'], $message, config('wxTemplateID.applyResult'));
        } catch (Exception $e) {
            trace('error' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        return json($resultUpdateApply);
    }

    // 会员申请联赛工作人员
    public function applyleagueworker()
    {
        // 接收请求变量
        $data = input('post.');
        if (!array_key_exists('match_id', $data)) {
            return json(['code' => 100, 'msg' => '缺少match_id']);
        }
        if (!array_key_exists('member_id', $data)) {
            return json(['code' => 100, 'msg' => '缺少member_id']);
        }
        $leagueService = new LeagueService();
        // 查询联赛数据
        $match = $leagueService->getLeaugeInfoWithOrg(['id' => $data['match_id']]);
        if (!$match || $match['status_num'] != 1) {
            return json(['code' => 100, 'msg' => '联赛不存在或未通过审核']);
        }
        // 检查当前会员登录信息
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        // 若是申请裁判员 检查会员有无裁判员资质
        if ($data['type'] == 7) {
            $refereeS = new RefereeService();
            $memberIsReferee = $refereeS->getRefereeInfo(['member_id' => $this->memberInfo['id']]);
            if (!$memberIsReferee || $memberIsReferee['status_num'] != 1) {
                return json(['code' => 100, 'msg' => '您还没有裁判员资质，请先注册成为裁判员']);
            }
        }
        // 查询会员有无联赛人员数据
        $matchmember = $leagueService->getMatchMember([
            'match_id' => $data['match_id'],
            'member_id' => $this->memberInfo['id']
        ]);
        if ($matchmember && $matchmember['status'] == 1) {
            return json(['code' => 100, 'msg' => '您已是联赛工作人员了，不需再次申请']);
        }
        // 检查会员有无联赛人员申请数据
        $matchMemberApply = $leagueService->getApplyByLeague([
            'organization_type' => 4,
            'organization_id' => $match['id'],
            'member_id' => $data['member_id'],
            'apply_type' => 1
        ]);
        // apply表type字段内容
        $applyType = 0;
        switch ($data['type']) {
            case 9:
                $applyType = 3;
                break;  // 管理员
            case 8:
                $applyType = 8;
                break;  // 记分员
            case 7:
                $applyType = 6;
                break;  // 裁判员
            default:
                $applyType = 1;
        }
        // apply数据
        $dataApply = [
            'member' => $this->memberInfo['member'],
            'member_id' => $this->memberInfo['id'],
            'member_avatar' => $this->memberInfo['avatar'],
            'organization_type' => 4,
            'organization' => $match['name'],
            'organization_id' => $match['id'],
            'organization_image' => $match['logo'],
            'type' => $applyType,
            'apply_type' => 1,
            'isread' => 0,
            'status' => 1
        ];
        if ($matchMemberApply) {
            $dataApply['id'] = $matchMemberApply['id'];
        }
        // 工作人员角色文案
        $typesArr = $leagueService->getMatchMemberTypes();
        $typeStr = $typesArr[$data['type']];

        try {
            // 保存apply数据（status=1）
            $applyId = $leagueService->saveApplyByLeague($dataApply);
        } catch (Exception $e) {
            trace('error:' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }

        if ($applyId['code'] != 200) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        // 发送消息给联赛组织人员
        // 获取联赛组织人员
        $orgmembers = $leagueService->getMatchOrgMembers([
            'match_org_id' => $match['match_org_id'],
            'status' => 1
        ]);
        $memberIdsReviceMessage = [];
        foreach ($orgmembers as $val) {
            $memberIdsReviceMessage[]['id'] = $val['member_id'];
        }
        $messageS = new MessageService();
        $message = [
            'title' => '会员' . $this->memberInfo['member'] . '申请担任联赛' . $match['name'] . $typeStr,
            'content' => '会员' . $this->memberInfo['member'] . '申请担任联赛' . $match['name'] . $typeStr,
            'url' => url('keeper/match/workerapplyinfo', ['apply_id' => $applyId['data']], '', true),
            'keyword1' => '会员申请联赛担任' . $typeStr,
            'keyword2' => $this->memberInfo['member'],
            'keyword3' => date('Y-m- H:i', time()),
            'remark' => '点击查看详情',
            'steward_type' => 2,
        ];
        $messageS->sendMessageToMembers($memberIdsReviceMessage, $message, config('wxTemplateID.checkPend'));
        return json($applyId);
    }

    // 回复联赛工作人员申请
    public function replymatchworkerapply()
    {
        $data = input('post.');
        // 比传参数验证 apply_id status(状态)
        if (!array_key_exists('apply_id', $data)) {
            return json(['code' => 100, 'msg' => __lang('MSG_402') . ',传入apply_id']);
        }
        if (!array_key_exists('status', $data) || !in_array($data['status'], [2, 3])) {
            return json(['code' => 100, 'msg' => __lang('MSG_402') . ',传入正确status']);
        }
        // 获取联赛工作人员申请数据
        $leagueS = new LeagueService();
        $apply = $leagueS->getApplyByLeague([
            'id' => $data['apply_id'],
            'organization_type' => 4,
            'apply_type' => 1
        ]);
        if (!$apply) {
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
        // 查询联赛数据
        $match = $leagueS->getLeaugeInfoWithOrg(['id' => $apply['organization_id']]);
        // 检查当前会员登录信息
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        // 检查当前会员联赛组织人员信息（操作权限）
        $checkorgmember = $leagueS->getMatchOrgMember([
            'match_org_id' => $match['match_org_id'],
            'member_id' => $this->memberInfo['id'],
            'status' => 1
        ]);
        if (!$checkorgmember || $checkorgmember['status'] != 1) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        // apply（申请表）职位文案
        $applyTypeStr = '';
        // 工作人员（type字段）内容值
        $matchMemberType = 0;
        switch ($apply['type']) {
            case 3:
                $applyTypeStr = '管理员';
                $matchMemberType = 9;
                break;  // 管理员
            case 8:
                $applyTypeStr = '记分员';
                $matchMemberType = 8;
                break;  // 记分员
            case 6:
                $applyTypeStr = '裁判员';
                $matchMemberType = 7;
                break;  // 裁判员
            default:
                $applyTypeStr = '工作人员';
        }
        // 同意status=2/拒绝status=3：更新申请状态,回复消息推送
        $status = $data['status'];
        $statusStr = '';
        if ($status == 3) {
            // 拒绝
            $statusStr = '已拒绝';
        } else {
            // 同意
            $statusStr = '已同意';
        }
        // 回复理由
        $reply = (!empty($data['reply'])) ? '回复说明：' . $data['reply'] : '';
        // 组合推送消息内容
        $message = [
            'title' => '联赛工作人员申请回复结果',
            'content' => '您的联赛' . $apply['organization'] . '担任' . $applyTypeStr . '申请回复结果：' . $statusStr,
            'url' => url('keeper/message/index', '', '', true),
            'keyword1' => '您的联赛' . $apply['organization'] . '担任' . $applyTypeStr . '申请回复结果：' . $statusStr,
            'keyword2' => $statusStr,
            'remark' => '点击登录平台查看更多信息',
            'steward_type' => 2
        ];
        try {
            // 更新apply数据
            $resultUpdateApply = $leagueS->saveApplyByLeague([
                'id' => $apply['id'],
                'status' => $status,
                'reply' => $reply,
                'remarks' => $statusStr
            ]);
            // 同意，更新联赛组织人员数据
            if ($status == 2) {
                // 获取联赛信息
                $match = $leagueS->getLeaugeInfoWithOrg(['id' => $apply['organization_id']]);
                // 获取申请工作人员的会员详细数据
                $memberS = new MemberService();
                $memberInfo = $memberS->getMemberInfo(['id' => $apply['member_id']]);
                // 保存联赛工作人员数据
                $dataMatchMember = [
                    'match_id' => $match['id'],
                    'match' => $match['name'],
                    'match_logo' => $match['logo'],
                    'member_id' => $memberInfo['id'],
                    'member' => $memberInfo['member'],
                    'member_avatar' => $memberInfo['avatar'],
                    'realname' => $memberInfo['realname'],
                    'type' => $matchMemberType,
                    'status' => 1
                ];
                // 获取联赛工作人员数据
                $matchMember = $leagueS->getMatchMember([
                    'match_id' => $apply['organization_id'],
                    'member_id' => $apply['member_id']
                ]);
                if ($matchMember) {
                    $dataMatchMember['id'] = $matchMember['id'];
                }
                $leagueS->saveMatchMember($dataMatchMember);
            }
            // 向申请人 发送申请回复 消息推送
            $messageS = new MessageService();
            $messageS->sendMessageToMember($apply['member_id'], $message, config('wxTemplateID.applyResult'));
        } catch (Exception $e) {
            trace('error' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        return json($resultUpdateApply);
    }

    // 删除联赛工作人员
    public function delmatchmember()
    {
        $id = input('id', 0, 'intval');
        if (!$id) {
            return json(['code' => 100, 'msg' => __lang('MSG_402')]);
        }
        // 查询联赛工作人员数据
        $leagueS = new LeagueService();
        $matchMember = $leagueS->getMatchMember(['id' => $id]);
        if (!$matchMember) {
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
        // 检查会员登录信息
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        // 检查会员操作权限(联赛工作人员)
        $matchMemberPower = $leagueS->getMatchMember([
            'match_id' => $matchMember['match_id'],
            'member_id' => $this->memberInfo['id'],
            'status' => 1
        ]);
        if (!$matchMemberPower || $matchMemberPower['type'] < 10) {
            return json(['code' => 100, 'msg' => __lang('MSG_402')]);
        }
        // 负责人不能删除
        if ($matchMember['type'] == 10) {
            return json(['code' => 100, 'msg' => '负责人不能删除']);
        }

        try {
            // 删除联赛工作人员数据
            $resultDelete = $leagueS->delMatchMember($matchMember['id']);
        } catch (Exception $e) {
            trace('error:' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }

        if (!$resultDelete) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        // 向该会员发送被移出联赛工作人员 消息推送
        try {
            $messageContent = [
                'title' => '联赛工作人员被移出通知',
                'content' => '您已被移出联赛' . $matchMember['match'],
                'url' => url('keeper/message/index', '', '', true),
                'keyword1' => '您已被移出联赛' . $matchMember['match'],
                'keyword2' => '被移出联赛',
                'remark' => '点击登录平台查看更多信息',
                'steward_type' => 2
            ];
            $messageS = new MessageService();
            $messageS->sendMessageToMember($matchMember['member_id'], $messageContent, config('wxTemplateID.informationChange'));
        } catch (Exception $e) {
            trace('error:' . $e->getMessage(), 'error');
        }
        return json(['code' => 200, 'msg' => __lang('MSG_200')]);
    }

    // 获取联赛工作人员（裁判）列表
    public function getleaguerefereelist()
    {
        try {
            $data = input('param.');
            $page = input('page', 1, 'intval');
            if (input('?page')) {
                unset($data['page']);
            }
            // 查询条件组合
            if (input('league_id')) {
                $data['match_id'] = input('league_id');
                unset($data['league_id']);
            }
            $data['type'] = 7;
            $data['status'] = input('param.status', 1, 'intval');

            // 查询联赛工作人员（裁判员角色）列表
            $leagueS = new LeagueService();
            $result = $leagueS->getMatchMemberList($data, $page);
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
            // 遍历查询裁判员详细信息
            $refereeS = new RefereeService();
            foreach ($result as $k => $val) {
                $refereeInfo = $refereeS->getReferee(['member_id' => $val['member_id']]);
                if ($refereeInfo) {
                    $result[$k]['referee'] = $refereeInfo;
                }
            }
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
        } catch (Exception $e) {
            trace('error:' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_401')]);
        }
    }

    // 获取联赛工作人员（裁判）列表-分页
    public function getleaguerefereepage()
    {
        try {
            $data = input('param.');
            if (input('?page')) {
                unset($data['page']);
            }
            // 查询条件组合
            if (input('league_id')) {
                $data['match_id'] = input('league_id');
                unset($data['league_id']);
            }
            $data['type'] = 7;
            $data['status'] = input('param.status', 1, 'intval');

            // 查询联赛工作人员（裁判员角色）列表
            $leagueS = new LeagueService();
            $result = $leagueS->getMatchMemberPaginator($data);
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
            // 遍历查询裁判员详细信息
            $refereeS = new RefereeService();
            foreach ($result['data'] as $k => $val) {
                $refereeInfo = $refereeS->getReferee(['member_id' => $val['member_id']]);
                if ($refereeInfo) {
                    $result['data'][$k]['referee'] = $refereeInfo;
                }
            }
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
        } catch (Exception $e) {
            trace('error:' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_401')]);
        }
    }

    // 创建赛程
    public function createschedule()
    {
        // 接收请求数据
        $data = input('post.');
        $data['member_id'] = $this->memberInfo['id'];
        $data['status'] = input('post.status', 1, 'intval');
        // 数据验证器
        $validate = validate('MatchScheduleVal');
        if (!$validate->scene('add')->check($data)) {
            return json(['code' => 100, 'msg' => $validate->getError()]);
        }
        // 检查会员操作权限（联赛工作人员-管理员以上）
        $leagueS = new LeagueService();
        $power = $leagueS->getMatchMemberType([
            'match_id' => $data['match_id'],
            'member_id' => $this->memberInfo['id'],
            'status' => 1
        ]);
        if (!$power || $power < 9) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        // 插入赛程数据
        $data['match_time'] = strtotime($data['match_time']);
        try {
            $result = $leagueS->saveMatchSchedule($data);
        } catch (Exception $e) {
            trace('error:' . $e->getMessage(), 'error');
        }
        if (!$result) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        return json(['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $result]);
    }

    // 编辑赛程
    public function updateschedule()
    {
        // 接收请求数据
        $data = input('post.');
        $data['member_id'] = $this->memberInfo['id'];
        $data['status'] = input('post.status', 1, 'intval');
        // 数据验证器
        $validate = validate('MatchScheduleVal');
        if (!$validate->scene('edit')->check($data)) {
            return json(['code' => 100, 'msg' => $validate->getError()]);
        }
        $leagueS = new LeagueService();
        // 获取赛程数据
        $scheduleInfo = $leagueS->getMatchSchedule([
            'id' => $data['id'],
            'match_id' => $data['match_id']
        ]);
        if (!$scheduleInfo) {
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
        // 检查会员操作权限（联赛工作人员-管理员以上）
        $power = $leagueS->getMatchMemberType([
            'match_id' => $data['match_id'],
            'member_id' => $this->memberInfo['id'],
            'status' => 1
        ]);
        if (!$power || $power < 9) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        // 修改赛程数据
        $data['match_time'] = strtotime($data['match_time']);
        try {
            $result = $leagueS->saveMatchSchedule($data);
        } catch (Exception $e) {
            trace('error:' . $e->getMessage(), 'error');
        }
        if (!$result) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        // 发送比赛消息
        $messageS = new MessageService();
        /**
         * 根据标识 对指定人群发送比赛信息更新消息
         * 1 check_court_time：改变比赛时间、场地 出赛2支球队领队与队长、裁判员、记分员、自定义人物
         * 2 check_referee: 改变裁判员名单 发送给相应裁判员
         * 3 check_scorers: 改变记分员名单 发送给相应记分员
         */
        $sendMessageMembers = [];
        $teamS = new TeamService();
        $refereeS = new RefereeService();
        $refereeMemberIds = [];
        $scorerIds = [];
        $customId = [];
        $changeStr = '';
        if (!empty($data['scorers']) && !is_null(json_decode($data['scorers']))) {
            $scorers = json_decode($data['scorers'], true);
            foreach ($scorers as $k => $val) {
                $scorerIds[]['id'] = $val['member_id'];
            }
        }
        if (!empty($data['custom_member']) && !is_null(json_decode($data['custom_member']))) {
            $scorers = json_decode($data['custom_member'], true);
            foreach ($scorers as $k => $val) {
                $customId[]['id'] = $val['member_id'];
            }
        }
        // 获取提交的裁判名单数据
        if (array_key_exists('referee1_id', $data) && $data['referee1_id']) {
            $referee1Info = $refereeS->getRefereeInfo(['id' => $data['referee1_id']]);
            $refereeMemberIds[]['id'] = $referee1Info['member_id'];
        }
        if (array_key_exists('referee2_id', $data) && $data['referee2_id']) {
            $referee1Info = $refereeS->getRefereeInfo(['id' => $data['referee2_id']]);
            $refereeMemberIds[]['id'] = $referee1Info['member_id'];
        }
        if (array_key_exists('referee3_id', $data) && $data['referee3_id']) {
            $referee1Info = $refereeS->getRefereeInfo(['id' => $data['referee3_id']]);
            $refereeMemberIds[]['id'] = $referee1Info['member_id'];
        }
        // check_scorers
        if (array_key_exists('check_scorers', $data) && $data['check_scorers']) {
            $sendMessageMembers = array_merge($sendMessageMembers, $scorerIds);
            $changeStr = '记分员修改';
        }
        // check_referee
        if (array_key_exists('check_referee', $data) && $data['check_referee']) {
            $sendMessageMembers = array_merge($sendMessageMembers, $refereeMemberIds);
            $changeStr = '裁判员修改';
        }
        // check_court_time
        if (array_key_exists('check_court_time', $data) && $data['check_court_time']) {
            // 获取2支球队的领队队长
            $homeTeamInfo = $teamS->getTeam(['id' => $scheduleInfo['home_team_id']]);
            $awayTeamInfo = $teamS->getTeam(['id' => $scheduleInfo['away_team_id']]);
            if ($homeTeamInfo['leader_id'] > 0) {
                array_push($sendMessageMembers, ['id' => $homeTeamInfo['leader_id']]);
            }
            if ($homeTeamInfo['captain_id'] > 0) {
                array_push($sendMessageMembers, ['id' => $homeTeamInfo['captain_id']]);
            }
            if ($awayTeamInfo['leader_id'] > 0) {
                array_push($sendMessageMembers, ['id' => $awayTeamInfo['leader_id']]);
            }
            if ($awayTeamInfo['captain_id'] > 0) {
                array_push($sendMessageMembers, ['id' => $awayTeamInfo['captain_id']]);
            }
            $sendMessageMembers = array_merge($sendMessageMembers, $refereeMemberIds);
            $sendMessageMembers = array_merge($sendMessageMembers, $scorerIds);
            $sendMessageMembers = array_merge($sendMessageMembers, $customId);
            $changeStr = '赛程时间或地点修改';
        }
        try {
            if (!empty($sendMessageMembers)) {
                // 过滤接收消息的会员id重复值，每个会员只收一条消息
                // 发送消息
                $message = [
                    'title' => $scheduleInfo['match'] . '赛程安排最新动态通知',
                    'content' => '联赛-' . $scheduleInfo['match'] . ':' . $scheduleInfo['home_team'] . ' VS ' . $scheduleInfo['away_team'] . '赛程安排最新动态通知',
                    'url' => url('keeper/match/leaguescheduleinfo', ['id' => $scheduleInfo['id']], '', true),
                    'keyword1' => '联赛赛程安排改动',
                    'keyword2' => $changeStr,
                    'keyword3' => date('Y-m-d H:i', time()),
                    'remark' => '更多详情点击进入查看',
                    'steward_type' => 2
                ];
                $messageS->sendMessageToMembers($sendMessageMembers, $message, config('wxTemplateID.informationChange'));
            }
        } catch (Exception $e) {
            trace('error:' . $e->getMessage(), 'error');
        }
        return json(['code' => 200, 'msg' => __lang('MSG_200')]);
    }

    // 发送赛程通知
    public function sendmatchschedulenotices()
    {
        $id = input('id', 0, 'intval');
        if (!$id) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        // 获取赛程数据
        $leagueS = new LeagueService();
        $scheduleInfo = $leagueS->getMatchSchedule(['id' => $id]);
        if (!$scheduleInfo) {
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
        // 发送比赛消息
        $messageS = new MessageService();
        $teamS = new TeamService();
        $refereeS = new RefereeService();
        // 收到通知人群：2支球队的领队和队长、相关裁判员、记分员、自定义人物会员
        $sendMessageMembers = [];
        // 裁判员名单集合
        $refereeMemberIds = [];
        // 记分员名单集合
        $scorerIds = [];
        // 自定义人物会员
        $customId = [];
        $changeStr = '赛前通知';
        if (!empty($scheduleInfo['scorers']) && !is_null(json_decode($scheduleInfo['scorers']))) {
            $scorers = json_decode($scheduleInfo['scorers'], true);
            foreach ($scorers as $k => $val) {
                $scorerIds[]['id'] = $val['member_id'];
            }
        }
        if (!empty($scheduleInfo['custom_member']) && !is_null(json_decode($scheduleInfo['custom_member']))) {
            $scorers = json_decode($scheduleInfo['custom_member'], true);
            foreach ($scorers as $k => $val) {
                $customId[]['id'] = $val['member_id'];
            }
        }
        // 获取提交的裁判名单数据
        if ($scheduleInfo['referee1_id']) {
            $referee1Info = $refereeS->getRefereeInfo(['id' => $scheduleInfo['referee1_id']]);
            $refereeMemberIds[]['id'] = $referee1Info['member_id'];
        }
        if ($scheduleInfo['referee2_id']) {
            $referee1Info = $refereeS->getRefereeInfo(['id' => $scheduleInfo['referee2_id']]);
            $refereeMemberIds[]['id'] = $referee1Info['member_id'];
        }
        if ($scheduleInfo['referee3_id']) {
            $referee1Info = $refereeS->getRefereeInfo(['id' => $scheduleInfo['referee3_id']]);
            $refereeMemberIds[]['id'] = $referee1Info['member_id'];
        }
        // 获取2支球队的领队队长
        $homeTeamInfo = $teamS->getTeam(['id' => $scheduleInfo['home_team_id']]);
        $awayTeamInfo = $teamS->getTeam(['id' => $scheduleInfo['away_team_id']]);
        if ($homeTeamInfo['leader_id'] > 0) {
            array_push($sendMessageMembers, ['id' => $homeTeamInfo['leader_id']]);
        }
        if ($homeTeamInfo['captain_id'] > 0) {
            array_push($sendMessageMembers, ['id' => $homeTeamInfo['captain_id']]);
        }
        if ($awayTeamInfo['leader_id'] > 0) {
            array_push($sendMessageMembers, ['id' => $awayTeamInfo['leader_id']]);
        }
        if ($awayTeamInfo['captain_id'] > 0) {
            array_push($sendMessageMembers, ['id' => $awayTeamInfo['captain_id']]);
        }
        $sendMessageMembers = array_merge($sendMessageMembers, $refereeMemberIds);
        $sendMessageMembers = array_merge($sendMessageMembers, $scorerIds);
        $sendMessageMembers = array_merge($sendMessageMembers, $customId);
        try {
            if (!empty($sendMessageMembers)) {
                // 过滤接收消息的会员id重复值，每个会员只收一条消息
                // 发送消息
                $message = [
                    'title' => $scheduleInfo['match'] . $changeStr,
                    'content' => '联赛-' . $scheduleInfo['match'] . ':' . $scheduleInfo['home_team'] . ' VS ' . $scheduleInfo['away_team'] . $changeStr,
                    'url' => url('keeper/match/leaguescheduleinfo', ['id' => $scheduleInfo['id']], '', true),
                    'keyword1' => $changeStr,
                    'keyword2' => $changeStr,
                    'keyword3' => !(empty($scheduleInfo['match_time'])) ? $scheduleInfo['match_time'] : '待定',
                    'remark' => '更多详情点击进入查看',
                    'steward_type' => 2
                ];
                $messageS->sendMessageToMembers($sendMessageMembers, $message, config('wxTemplateID.informationChange'));
            }
        } catch (Exception $e) {
            trace('error:' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        return json(['code' => 200, 'msg' => __lang('MSG_200')]);
    }

    // 赛程列表（无分页）
    public function getmatchschedules()
    {
        try {
            $data = input('param.');
            // 参数league_id -> match_id
            if (input('?param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }
            $leagueS = new LeagueService();
            $result = $leagueS->getMatchSchedules($data);
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
        } catch (Exception $e) {
            trace('error:' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 赛程列表
    public function getmatchschedulelist()
    {
        try {
            $data = input('param.');
            $page = input('page', 1, 'intval');
            // 参数league_id -> match_id
            if (input('?param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }
            if (input('?page')) {
                unset($data['page']);
            }
            $leagueS = new LeagueService();
            $result = $leagueS->getMatchScheduleList($data, $page);
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
        } catch (Exception $e) {
            trace('error:' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 赛程列表（页码）
    public function getmatchschedulepage()
    {
        try {
            $data = input('param.');
            $page = input('page', 1, 'intval');
            // 参数league_id -> match_id
            if (input('?param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }
            if (input('?page')) {
                unset($data['page']);
            }
            $leagueS = new LeagueService();
            $result = $leagueS->getMatchSchedulePaginator($data);
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
        } catch (Exception $e) {
            trace('error:' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 删除赛程
    public function delmatchschedule()
    {
        $id = input('id', 0, 'intval');
        if (!$id) {
            return json(['code' => 100, 'msg' => __lang('MSG_402')]);
        }
        // 获取赛程详情
        $leagueS = new LeagueService();
        $scheduleInfo = $leagueS->getMatchSchedule(['id' => $id]);
        if (!$scheduleInfo) {
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
        // 检查会员登录信息
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        // 检查会员操作权限
        $power = $leagueS->getMatchMemberType([
            'member_id' => $this->memberInfo['id'],
            'match_id' => $scheduleInfo['match_id'],
            'status' => 1
        ]);
        if (!$power || $power < 9) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        try {
            $result = $leagueS->delMatchSchedule($scheduleInfo['id']);
        } catch (Exception $e) {
            trace('error:' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        if (!$result) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        } else {
            return json(['code' => 200, 'msg' => __lang('MSG_200')]);
        }
    }

    // 根据联赛分组生成预览赛程
    public function buildschedulebygroup()
    {
        // 接收请求数据
        $data = input('post.');
        $leagueS = new LeagueService();
        // 数据验证
        if (!array_key_exists('match_id', $data)) {
            return json(['code' => 100, 'msg' => __lang('MSG_402')]);
        }
        // 查询联赛分组数据
        $orderby = ['group_id' => 'asc', 'group_number' => 'asc'];
        $battle = []; // 定义对阵关系数组
        $berger = new \Berger();
        // 传入分组id 以分组单位生成对阵预览
        if (array_key_exists('group_id', $data) && !empty($data['group_id']) && $data['group_id']) {
            // 根据分组查询分组下球队
            $groupInfo = $leagueS->getMatchGroup(['id' => $data['group_id']]);
            if (!$groupInfo) {
                return json(['code' => 100, 'msg' => '联赛分组' . __lang('MSG_404')]);
            }
            // 获取联赛分组球队数据
            $groupTeams = $leagueS->getMatchGroupTeams([
                'match_id' => $groupInfo['match_id'],
                'group_id' => $groupInfo['id']
            ], $orderby);
            if (!$groupTeams) {
                return json(['code' => 100, 'msg' => '联赛分组球队' . __lang('MSG_404')]);
            }
            try {
                // 计算对阵关系(单循环）
                $singleCycleBattle = $berger->singleCycle($groupTeams);
                //dump($singleCycleBattle);
                $groupBattle = [];
                foreach ($singleCycleBattle as $loop) {
                    foreach ($loop as $team) {
                        //  排除球队轮空
                        if ($team['away_team_id'] && $team['home_team_id']) {
                            array_push($groupBattle, $team);
                        }
                    }
                }
            } catch (Exception $e) {
                trace('error:' . $e->getMessage());
                return json(['code' => 100, 'msg' => $e->getMessage()]);
            }
            // 组合对阵预览数据
            $battle['group_id'] = $groupInfo['id'];
            $battle['group_name'] = $groupInfo['name'];
            $battle['battles'] = $groupBattle;
        } else {
            // 获取整个联赛的所有分组生成对阵预览数据
            // 获取联赛分组
            $groups = $leagueS->getMatchGroups([
                'match_id' => $data['match_id'],
                'status' => 1
            ], ['id' => 'asc']);
            if (!$groups) {
                return json(['code' => 100, 'msg' => '分组' . __lang('MSG_000')]);
            }
            // 遍历分组获取分组下球队列表
            foreach ($groups as $k => $group) {
                $groupTeams = $leagueS->getMatchGroupTeams([
                    'group_id' => $group['id'],
                    'status' => 1
                ], $orderby);
                if (!$groupTeams) {
                    return json(['code' => 100, 'msg' => '分组球队' . __lang('MSG_000')]);
                    break;
                }
                try {
                    // 计算对阵关系(单循环）
                    $singleCycleBattle = $berger->singleCycle($groupTeams);
                    $groupBattle = [];
                    foreach ($singleCycleBattle as $loop) {
                        foreach ($loop as $team) {
                            //  排除球队轮空
                            if ($team['away_team_id'] && $team['home_team_id']) {
                                array_push($groupBattle, $team);
                            }
                        }
                    }
                } catch (Exception $e) {
                    trace('error:' . $e->getMessage());
                    return json(['code' => 100, 'msg' => $e->getMessage()]);
                }
                // 组合对阵预览数据
                $battle[$k]['group_id'] = $group['id'];
                $battle[$k]['group_name'] = $group['name'];
                $battle[$k]['battles'] = $groupBattle;
            }
        }
        if ($battle) {
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $battle]);
        } else {
            return json(['code' => 100, 'msg' => __lang('MSG_000')]);
        }
    }

    // 批量保存比赛赛程数据
    public function saveallmatchschedule()
    {
        $data = input('post.');
        $data['member_id'] = $this->memberInfo['id'];
        // 数据验证器
        $validate = validate('MatchScheduleVal');
        if (!$validate->scene('add')->check($data)) {
            return json(['code' => 100, 'msg' => $validate->getError()]);
        }
        // 检查会员操作权限（联赛工作人员-管理员以上）
        $leagueS = new LeagueService();
        $power = $leagueS->getMatchMemberType([
            'match_id' => $data['match_id'],
            'member_id' => $this->memberInfo['id'],
            'status' => 1
        ]);
        if (!$power || $power < 9) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        if (!array_key_exists('scheduleList', $data) || is_null(json_decode($data['scheduleList']))) {
            return json(['code' => 100, 'msg' => '请提交预览赛程']);
        }
        // 事务处理：检查联赛有无赛程数据 若有数据先物理删除原有数据
        Db::startTrans();
        try {
            $matchSchedules = $leagueS->getMatchSchedules([
                'match_id' => $data['match_id'],
                'match_stage_id' => $data['match_stage_id']
            ]);
            if ($matchSchedules) {
                $leagueS->delMatchSchedule(['match_id' => $data['match_id']], true);
            }
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
        }
        // 保存赛程数据
        $scheduleData = json_decode($data['scheduleList'], true);
        foreach ($scheduleData as $k => $val) {
            $scheduleData[$k]['status'] = 1;
            $scheduleData[$k]['match_stage_id'] = $data['match_stage_id'];
            $scheduleData[$k]['match_stage'] = $data['match_stage'];
            $scheduleData[$k]['add_mode'] = 1;
        }
        try {
            $result = $leagueS->saveAllMatchSchedule($scheduleData);
        } catch (Exception $e) {
            trace('error: ' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        if (!$result) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        } else {
            return json(['code' => 200, 'msg' => __lang('MSG_200')]);
        }
    }

    // 获取根据阶段分组的赛程列表
    public function getmatchschedulelistbystageandgroup()
    {
        try {
            $data = input('param.');
            $page = input('page', 1, 'intval');
            // 参数league_id -> match_id
            if (input('?param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }
            if (input('?page')) {
                unset($data['page']);
            }
            $leagueS = new LeagueService();
            $result = $leagueS->getMatchScheduleListByStageAndGroup($data, $page);
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            } else {
                return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
            }
        } catch (Exception $e) {
            trace('error: ' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 根据赛程时间排序，层级（时间-阶段-赛程）的赛程列表
    public function getmatchschedulelistbytime()
    {
        try {
            $data = input('param.');
            $page = input('page', 1, 'intval');
            // 参数league_id -> match_id
            if (input('?param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }
            if (input('?page')) {
                unset($data['page']);
            }
            $leagueS = new LeagueService();
            $orderby = ['match_time' => 'asc', 'id' => 'desc'];
            $_result = $leagueS->getMatchSchedules($data, $orderby);
            if (!$_result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
            $_result1 = $result = [];
            // 根据比赛时间（年月日）对数据分片
            foreach ($_result as $key => $value) {
                $date = ($value['match_timestamp']) ? date('Y-m-d', $value['match_timestamp']) : 0;
                $_result1[$value['match_stage'] . '|' . $date][] = $value;
            }
            foreach ($_result1 as $key => $value) {
                $_array = [];
                $keyExplode = explode('|', $key);
                $_array['date'] = $keyExplode[1];
                $_array['stage']['name'] = $keyExplode[0];
                $_array['stage']['schedules'] = $value;
                array_push($result, $_array);
            }
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            } else {
                return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
            }
        } catch (Exception $e) {
            trace('error: ' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 批量保存自定义赛程数据
    public function saveallcustommatchschedule() {
        $data = input('post.');
        $data['member_id'] = $this->memberInfo['id'];
        // 数据验证器
        $validate = validate('MatchScheduleVal');
        if (!$validate->scene('custom_add')->check($data)) {
            return json(['code' => 100, 'msg' => $validate->getError()]);
        }
        // 检查会员操作权限（联赛工作人员-管理员以上）
        $leagueS = new LeagueService();
        $power = $leagueS->getMatchMemberType([
            'match_id' => $data['match_id'],
            'member_id' => $this->memberInfo['id'],
            'status' => 1
        ]);
        if (!$power || $power < 9) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        if ( !array_key_exists('scheduleList', $data) || is_null(json_decode($data['scheduleList'])) ) {
            return json(['code' => 100, 'msg' => '请提交赛程']);
        }
        // 遍历组合赛程数据
        $scheduleData = json_decode($data['scheduleList'], true);
        foreach ($scheduleData as $key => $value) {
            $scheduleData[$key]['match_id'] = $data['match_id'];
            $scheduleData[$key]['match'] = $data['match'];
            $scheduleData[$key]['match_time'] = checkDatetimeIsValid($value['match_time']) ? strtotime($value['match_time']) : $value['match_time'];
            $scheduleData[$key]['add_mode'] = 2;
            $scheduleData[$key]['status'] = 1;
        }
        // 批量保存赛程数据
        try {
            $leagueS = new LeagueService();
            $result = $leagueS->saveAllMatchSchedule($scheduleData);
        } catch (Exception $e) {
            trace('error: ' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        // 返回结果
        if (!$result) {
            return json(['code' => 100, 'msg' => __lang('MSG_000')]);
        } else {
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
        }
    }

    // 获取赛程列表(外部展示)
    public function getshowmatchschedulelist() {
        try {
            $map = input('param.');
            $page = input('page', 1, 'intval');
            // 参数league_id -> match_id
            if (input('?param.league_id')) {
                unset($map['league_id']);
                $map['match_id'] = input('param.league_id');
            }
            if (input('?page')) {
                unset($map['page']);
            }
            if ( input('?param.sort') ) {
                $sort = input('sort', 0, 'intval');
                unset($map['sort']);
                switch ($sort) {
                    case 1: {
                        // match_time区间 查询条件组合:当前时间至所选未来7天
                        $nowTime = time();
                        $dateTimeStamp = strtotime("+7 days");
                        $endDate = getStartAndEndUnixTimestamp(date('Y', $dateTimeStamp), date('m', $dateTimeStamp), date('d', $dateTimeStamp));
                        $map['match_time'] = ['between', [$nowTime, $endDate['end']]];
                        break;
                    }
                    case 2: {
                        // 未完成的赛程
                        $map['status'] = 1;
                        break;
                    }
                    case 3: {
                        // 已完成有比分信息的赛程
                        $map['status'] = 2;
                    }
                    default:
                        break;
                }
            }
            $leagueS = new LeagueService();
            $matchS = new MatchService();
            $orderby = ['match_time' => 'asc', 'id' => 'desc'];
            $_result = $leagueS->getMatchSchedules($map, $orderby);
            if (!$_result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
            $_result1 = $result = [];
            // 遍历获取赛程比赛结果信息
            foreach ( $_result as $key => $value ) {
                $recordInfo = $matchS->getMatchRecord(['match_schedule_id' => $value['id'], 'match_id' => $value['match_id']]);
                if ($recordInfo) {
//                    $_result[$key]['match_time'] = ($recordInfo['match_time']) ? date('Y-m-d H:i', $recordInfo['match_time']) : '';
//                    $_result[$key]['match_timestamp'] = $recordInfo['match_time'];
                    $_result[$key]['match_record_id'] = $recordInfo['id'];
                    $_result[$key]['home_team_score'] = $recordInfo['home_score'];
                    $_result[$key]['away_team_score'] = $recordInfo['away_score'];
                } else {
                    $_result[$key]['match_record_id'] = 0;
                    $_result[$key]['home_team_score'] = 0;
                    $_result[$key]['away_team_score'] = 0;
                }
            }
            // 根据比赛时间（年月日）对数据分片
            foreach ($_result as $key => $value) {
                $date = ($value['match_timestamp']) ? date('Y-m-d', $value['match_timestamp']) : 0;
                $_result1[$value['match_stage'] . '|' . $date][] = $value;
            }
            $dayArr = ['星期日','星期一', '星期二', '星期三', '星期四', '星期五', '星期六'];
            foreach ($_result1 as $key => $value) {
                $_array = [];
                $keyExplode = explode('|', $key);
                $datetime =  strtotime($keyExplode[1]);
                $_array['datetime'] = $datetime;
                $_array['date'] = ($datetime) ? date('n月d', $datetime) : '';
                $_array['day'] = ($datetime) ? $dayArr[date('w', $datetime)] : '';
                $_array['stage']['name'] = $keyExplode[0];
                $_array['stage']['schedules'] = $value;
                array_push($result, $_array);
            }
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            } else {
                $result = arraySort($result, 'datetime', SORT_DESC);
                return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
            }
        } catch (Exception $e) {
            trace('error: ' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 比赛阶段列表
    public function getmatchstagelist()
    {
        try {
            $data = input('param.');
            $page = input('page', 1, 'intval');
            // 参数league_id -> match_id
            if (input('?param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }
            if (input('?page')) {
                unset($data['page']);
            }
            $leagueS = new LeagueService();
            $result = $leagueS->getMatchStageList($data, $page);
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
        } catch (Exception $e) {
            trace('error: ' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 比赛阶段列表（页码）
    public function getmatchstagepage()
    {
        try {
            $data = input('param.');
            // 参数league_id -> match_id
            if (input('?param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }
            if (input('?page')) {
                unset($data['page']);
            }
            $leagueS = new LeagueService();
            $result = $leagueS->getMatchStagePaginator($data);
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
        } catch (Exception $e) {
            trace('error: ' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 新增比赛阶段
    public function addmatchstage()
    {
        $data = input('post.');
        // 验证器
        $validate = validate('MatchStageVal');
        if (!$validate->scene('add')->check($data)) {
            return json(['code' => 100, 'msg' => $validate->getError()]);
        }
        // 会员登录信息
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        // 联赛工作人员操作权限
        $leagueS = new LeagueService();
        $power = $leagueS->getMatchMemberType([
            'match_id' => $data['match_id'],
            'member_id' => $this->memberInfo['id'],
            'status' => 1
        ]);
        if (!$power || $power < 9) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        // 插入数据
        try {
            $result = $leagueS->saveMatchStage($data);
        } catch (Exception $e) {
            trace('error: ' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        // 返回结果
        if (!$result) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        } else {
            return json(['code' => 200, 'msg' => __lang('MSG_200')]);
        }
    }

    // 编辑比赛阶段
    public function updatematchstage()
    {
        $data = input('post.');
        // 验证器
        $validate = validate('MatchStageVal');
        if (!$validate->scene('edit')->check($data)) {
            return json(['code' => 100, 'msg' => $validate->getError()]);
        }
        // 会员登录信息
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        // 联赛工作人员操作权限
        $leagueS = new LeagueService();
        $power = $leagueS->getMatchMemberType([
            'match_id' => $data['match_id'],
            'member_id' => $this->memberInfo['id'],
            'status' => 1
        ]);
        if (!$power || $power < 9) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        // 插入数据
        try {
            $result = $leagueS->saveMatchStage($data);
        } catch (Exception $e) {
            trace('error: ' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        // 返回结果
        if ($result === false) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        } else {
            return json(['code' => 200, 'msg' => __lang('MSG_200')]);
        }
    }

    // 删除比赛阶段
    public function delmatchstage()
    {
        $id = input('post.id', 0, 'intval');
        // 查询比赛阶段数据
        $leagueS = new LeagueService();
        $stageInfo = $leagueS->getMatchStage(['id' => $id]);
        if (!$stageInfo) {
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
        // 会员登录信息
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        // 联赛工作人员操作权限
        $power = $leagueS->getMatchMemberType([
            'match_id' => $stageInfo['match_id'],
            'member_id' => $this->memberInfo['id'],
            'status' => 1
        ]);
        if (!$power || $power < 9) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        // 删除数据
        try {
            $result = $leagueS->delMatchStage($id);
        } catch (Exception $e) {
            trace('error: ' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        // 返回结果
        if ($result === false) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        } else {
            return json(['code' => 200, 'msg' => __lang('MSG_200')]);
        }
    }

    // 查看联赛阶段出线球队名单
    public function getstageadvanceteams() {
        $id = input('post.stage_id', 0, 'intval');
        $matchId = input('post.match_id', 0, 'intval');
        // 查询比赛阶段数据
        $leagueS = new LeagueService();
        $stageInfo = $leagueS->getMatchStage([
            'id' => $id,
            'match_id' => $matchId
        ]);
        if (!$stageInfo) {
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
        // 检查此阶段的比赛赛程是否已完成（赛程记录数=比赛结果记录数）
        $scheduleCount = $leagueS->getMatchScheduleCount([
            'match_stage_id' => $id,
            'match_id' => $matchId
        ]);
        $recordCount = $leagueS->getMatchRecordCount([
            'match_stage_id' => $id,
            'match_id' => $matchId
        ]);
        if ( $scheduleCount != $recordCount ) {
            return json(['code' => 100, 'msg' => '此阶段赛程尚未完成，待完成后才可查看晋级球队']);
        }
        // 获取联赛球队积分数据
        $_result = $leagueS->getMatchRanks([
            'match_stage_id' => $id,
            'match_id' => $matchId
        ]);
    }

    // 联赛积分排名
    public function getmatchranklist()
    {
        try {
            $data = input('param.');
            // 参数league_id -> match_id
            if (input('?param.league_id')) {
                unset($data['league_id']);
                $data['match_id'] = input('param.league_id');
            }
            if (input('?page')) {
                unset($data['page']);
            }
            $leagueS = new LeagueService();
            // 获取联赛球队积分数据
            $_result = $leagueS->getMatchRanks($data);
            if (!$_result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
            $_result1 = $result = [];
            // 获取比赛阶段type字段信息
            foreach ($_result as $key => $value) {
                $stageInfo = $leagueS->getMatchStage(['id' => $value['match_stage_id']]);
                $_result[$key]['match_stage_type'] = ($stageInfo) ? $stageInfo['type'] : 0;
            }
            // 根据联赛阶段、分组将数据分片
            foreach ($_result as $key => $value) {
                $_result1[$value['match_stage'] .'|' . $value['match_stage_type'] . '|' . $value['match_group']][] = $value;
            }
            foreach ($_result1 as $key => $value) {
                $_array = $_array1 = [];
                $keyExplode = explode('|', $key);
                $_array['stage_name'] = $keyExplode[0];
                $_array['stage_type'] = $keyExplode[1];
                $_array['group_name'] = $keyExplode[2];
                $_array['teams'] = [];
                $ranks = $value;
                foreach ($ranks as $k => $rank) {
                    $_array1[$rank['team'] . '|' . $rank['team_id'] . '|' . $rank['team_logo']][] = $rank;
                }
                if (!empty($_array1)) {
                    foreach ($_array1 as $k => $val) {
                        $kExplode = explode('|', $k);
                        $_arr = [];
                        $_arr['team_id'] = $kExplode[1];
                        $_arr['team'] = $kExplode[0];
                        $_arr['team_logo'] = $kExplode[2];
                        // 球队在比赛阶段的积分累加
                        $score = $winCount = $loseCount = 0;
                        for ($i = 0; $i < count($val); $i++) {
                            if ($val[$i]['score'] > 0) {
                                $score += 1;
                            }
                            $winCount = $leagueS->getMatchRecordCount(['match_id' => $val[$i]['match_id'], 'match_stage_id' => $val[$i]['match_stage_id'], 'win_team_id' => $kExplode[1]]);
                            $loseCount = $leagueS->getMatchRecordCount(['match_id' => $val[$i]['match_id'], 'match_stage_id' => $val[$i]['match_stage_id'], 'lose_team_id' => $kExplode[1]]);
                        }
                        $_arr['score'] = $score;
                        $_arr['win_count'] = $winCount;
                        $_arr['lose_count'] = $loseCount;
                        array_push($_array['teams'], $_arr);
                    }
                    // 根据球队获得积分降序排列
                    $_array['teams'] = arraySort($_array['teams'], 'score', SORT_DESC);
                }
                array_push($result, $_array);
            }
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            } else {
                return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
            }
        } catch (Exception $e) {
            trace('error: ' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 创建比赛结果数据
    public function creatematchrecord()
    {
        $data = input('post.');
        // 验证器
        $validate = validate('MatchRecordVal');
        if (!$validate->scene('league_add')->check($data)) {
            return json(['code' => 100, 'msg' => $validate->getError()]);
        }
        // 验证会员操作权限 记分员以上才能操作
        if (!$this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        $leagueS = new LeagueService();
        $power = $leagueS->getMatchMemberType([
            'member_id' => $this->memberInfo['id'],
            'match_id' => $data['match_id'],
            'status' => 1
        ]);
        if ($power < 8) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        $data['match_time'] = strtotime($data['match_time']);
        $data['status'] = 1;
        // 根据双方球队比分获取胜负方队
        $winTeamName = '';
        if ($data['home_score'] > $data['away_score']) {
            $data['win_team_id'] = $data['home_team_id'];
            $data['lose_team_id'] = $data['away_team_id'];
            $winTeamName = $data['home_team'];
        } else if ($data['home_score'] < $data['away_score']) {
            $data['win_team_id'] = $data['away_team_id'];
            $data['lose_team_id'] = $data['home_team_id'];
            $winTeamName = $data['away_team'];
        }
        try {
            // 保存比赛结果数据
            $matchS = new MatchService();
            $result = $matchS->saveMatchRecord($data);
            // 对应赛程更新完成状态 status=2
            $leagueS->saveMatchSchedule([
                'id' => $data['match_schedule_id'],
                'status' => 2
            ]);
        } catch (Exception $e) {
            trace('error: ' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        if ($result['code'] != 200) {
            return json($result);
        }

        if ( input('?post.sendmessage') && input('post.sendmessage') == 1 ) {
            // 收到通知人群：2支球队的领队和队长
            //  $sendMessageMembers: 确实收到消息的会员id集合  $_sendMessageMembersTmp：收到消息的会员id集合（会出现id重复，要过滤重复值）
            $sendMessageMembers = $_sendMessageMembersTmp =  [];
            // 获取2支球队的领队队长
            $teamS = new TeamService();
            $homeTeamInfo = $teamS->getTeam(['id' => $data['home_team_id']]);
            $awayTeamInfo = $teamS->getTeam(['id' => $data['away_team_id']]);
            if ($homeTeamInfo['leader_id'] > 0) {
                array_push($_sendMessageMembersTmp, $homeTeamInfo['leader_id']);
            }
            if ($homeTeamInfo['captain_id'] > 0) {
                array_push($_sendMessageMembersTmp, $homeTeamInfo['captain_id']);
            }
            if ($awayTeamInfo['leader_id'] > 0) {
                array_push($_sendMessageMembersTmp, $awayTeamInfo['leader_id']);
            }
            if ($awayTeamInfo['captain_id'] > 0) {
                array_push($_sendMessageMembersTmp, $awayTeamInfo['captain_id']);
            }
            $_sendMessageMembersTmp = array_unique($_sendMessageMembersTmp);
            if (!empty($_sendMessageMembersTmp)) {
                foreach ($_sendMessageMembersTmp as $key => $value) {
                    array_push($sendMessageMembers, ['id' => $value]);
                }
            }
            $messageS = new MessageService();
            $message = [
                'title' => '联赛 '.$data['match'].'-'.$data['match_stage'].'比赛结果',
                'content' => '联赛 '.$data['match'].'-'.$data['match_stage'].'比赛场次：'.$data['home_team'] . 'VS'. $data['away_team'].'比赛结果',
                'url' => url('keeper/match/leaguerecordinfo', ['id' => $data['id']], '', true),
                'keyword1' => $data['home_team'] . 'VS'. $data['away_team'],
                'keyword2' => $data['home_score'] . '：' . $data['away_score'],
                'keyword3' => $winTeamName,
                'remark' => '更多详情点击进入查看',
                'steward_type' => 2
            ];
            $messageS->sendMessageToMembers($sendMessageMembers, $message, config('wxTemplateID.matchResult'));
        }

        // 返回结果
        return json($result);
    }

    // 更新比赛结果数据
    public function updatematchrecord()
    {
        $data = input('post.');
        // 验证器
        $validate = validate('MatchRecordVal');
        if (!$validate->scene('league_edit')->check($data)) {
            return json(['code' => 100, 'msg' => $validate->getError()]);
        }
        // 验证会员操作权限 记分员以上才能操作
        if (!$this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        $leagueS = new LeagueService();
        $matchS = new MatchService();
        $power = $leagueS->getMatchMemberType([
            'member_id' => $this->memberInfo['id'],
            'match_id' => $data['match_id'],
            'status' => 1
        ]);
        if ($power < 8) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        // 获取比赛成绩数据
        $matchRecord = $matchS->getMatchRecord(['id' => $data['id']]);
        // 当前时间超过数据允许修改时间（1天） 不能修改
        $nowtime = time();
        if ($matchRecord['is_record']) {
            return json(['code' => 100, 'msg' => '比赛结果已无法修改']);
        }
        if (!empty($matchRecord['record_time']) && ($nowtime > $matchRecord['record_time'] + 3600 * 24)) {
            return json(['code' => 100, 'msg' => '超过允许修改时间']);
        }

        $data['match_time'] = strtotime($data['match_time']);
        $data['status'] = 1;
        // 根据双方球队比分获取胜负方队
        $winTeamName = '';
        if ($data['home_score'] > $data['away_score']) {
            $data['win_team_id'] = $data['home_team_id'];
            $data['lose_team_id'] = $data['away_team_id'];
            $winTeamName = $data['home_team'];
        } else if ($data['home_score'] < $data['away_score']) {
            $data['win_team_id'] = $data['away_team_id'];
            $data['lose_team_id'] = $data['home_team_id'];
            $winTeamName = $data['away_team'];
        }
        try {
            // 保存比赛结果数据
            $matchS = new MatchService();
            $result = $matchS->saveMatchRecord($data);
        } catch (Exception $e) {
            trace('error: ' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        if ($result['code'] != 200) {
            return json($result);
        }
        if ( input('?post.sendmessage') && input('post.sendmessage') == 1 ) {
            // 收到通知人群：2支球队的领队和队长
            //  $sendMessageMembers: 确实收到消息的会员id集合  $_sendMessageMembersTmp：收到消息的会员id集合（会出现id重复，要过滤重复值）
            $sendMessageMembers = $_sendMessageMembersTmp =  [];
            // 获取2支球队的领队队长
            $teamS = new TeamService();
            $homeTeamInfo = $teamS->getTeam(['id' => $data['home_team_id']]);
            $awayTeamInfo = $teamS->getTeam(['id' => $data['away_team_id']]);
            if ($homeTeamInfo['leader_id'] > 0) {
                array_push($_sendMessageMembersTmp, $homeTeamInfo['leader_id']);
            }
            if ($homeTeamInfo['captain_id'] > 0) {
                array_push($_sendMessageMembersTmp, $homeTeamInfo['captain_id']);
            }
            if ($awayTeamInfo['leader_id'] > 0) {
                array_push($_sendMessageMembersTmp, $awayTeamInfo['leader_id']);
            }
            if ($awayTeamInfo['captain_id'] > 0) {
                array_push($_sendMessageMembersTmp, $awayTeamInfo['captain_id']);
            }
            $_sendMessageMembersTmp = array_unique($_sendMessageMembersTmp);
            if (!empty($_sendMessageMembersTmp)) {
                foreach ($_sendMessageMembersTmp as $key => $value) {
                    array_push($sendMessageMembers, ['id' => $value]);
                }
            }
            $messageS = new MessageService();
            $message = [
                'title' => '联赛 '.$data['match'].'-'.$data['match_stage'].'比赛结果',
                'content' => '联赛 '.$data['match'].'-'.$data['match_stage'].'比赛场次：'.$data['home_team'] . 'VS'. $data['away_team'].'比赛结果',
                'url' => url('keeper/match/leaguerecordinfo', ['id' => $data['id']], '', true),
                'keyword1' => $data['home_team'] . 'VS'. $data['away_team'],
                'keyword2' => $data['home_score'] . '：' . $data['away_score'],
                'keyword3' => $winTeamName,
                'remark' => '更多详情点击进入查看',
                'steward_type' => 2
            ];
            $messageS->sendMessageToMembers($sendMessageMembers, $message, config('wxTemplateID.matchResult'));
        }
        // 返回结果
        return json($result);
    }

    // 确认发布比赛结果记录
    public function publishmatchrecord()
    {
        $data = input('post.');
        // 验证器
        $validate = validate('MatchRecordVal');
        if (!$validate->scene('league_add')->check($data)) {
            return json(['code' => 100, 'msg' => $validate->getError()]);
        }

        // 验证会员操作权限 记分员以上才能操作
        if (!$this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        $leagueS = new LeagueService();
        $matchS = new MatchService();
        $power = $leagueS->getMatchMemberType([
            'member_id' => $this->memberInfo['id'],
            'match_id' => $data['match_id'],
            'status' => 1
        ]);
        if ($power < 8) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }

        // 传入id 查询比赛成绩数据
        if (input('?post.id')) {
            // 获取比赛成绩数据
            $matchRecord = $matchS->getMatchRecord(['id' => $data['id']]);
            if ($matchRecord && $matchRecord['is_record']) {
                return json(['code' => 100, 'msg' => '比赛结果已无法修改']);
            }
        }

        // 比赛比分数据组合
        $data['match_time'] = strtotime($data['match_time']);
        $data['status'] = 1;
        // 根据双方球队比分获取胜负方队
        $winTeamName = '';
        if ($data['home_score'] > $data['away_score']) {
            $data['win_team_id'] = $data['home_team_id'];
            $data['lose_team_id'] = $data['away_team_id'];
            $winTeamName = $data['home_team'];
        } else if ($data['home_score'] < $data['away_score']) {
            $data['win_team_id'] = $data['away_team_id'];
            $data['lose_team_id'] = $data['home_team_id'];
            $winTeamName = $data['away_team'];
        }
        $data['is_record'] = 1;
        $data['record_time'] = time();
        try {
            // 保存比赛结果数据
            $matchS = new MatchService();
            $result = $matchS->saveMatchRecord($data);
            // 对应赛程更新完成状态 status=2
            $leagueS->saveMatchSchedule([
                'id' => $data['match_schedule_id'],
                'status' => 2
            ]);
        } catch (Exception $e) {
            trace('error: ' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }

        if ($result['code'] != 200) {
            return json($result);
        }

        // 保存比赛结果数据 比赛双方球队比赛数+1，相关裁判执裁比赛记录
        $matchRecordId = (input('?post.id')) ? input('post.id') : $result['data'];
        $refereeIds = $matchRefereeData = [];
        $refereeS = new RefereeService();
        // 裁判1（主裁判）
        if (input('?post.referee1_id') && input('post.referee1_id')) {
            $referee1Info = $refereeS->getReferee(['id' => $data['referee1_id']]);
            $referee1MatchRefereeId = $matchS->getMatchReferee([
                'referee_id' => $data['referee1_id'],
                'match_id' => $data['match_id'],
                'match_record_id' => $matchRecordId
            ]);
            $_array = [
                'match_id' => $data['match_id'],
                'match' => $data['match'],
                'match_record_id' => $matchRecordId,
                'referee_id' => $referee1Info['id'],
                'referee' => $referee1Info['referee'],
                'member_id' => $referee1Info['member_id'],
                'member' => $referee1Info['member'],
                'referee_type' => 1,
                'appearance_fee' => 0,
                'is_attend' => 2,
                'status' => 1
            ];
            if ($referee1MatchRefereeId) {
                $_array['id'] = $referee1MatchRefereeId;
            } else {
                array_push($refereeIds, $referee1Info['id']);
            }
            array_push($matchRefereeData, $_array);
        }
        // 裁判2（副裁判）
        if (input('?post.referee2_id') && input('post.referee2_id')) {
            $referee2Info = $refereeS->getReferee(['id' => $data['referee2_id']]);
            $referee2MatchRefereeId = $matchS->getMatchReferee([
                'referee_id' => $data['referee1_id'],
                'match_id' => $data['match_id'],
                'match_record_id' => $matchRecordId
            ]);
            $_array = [
                'match_id' => $data['match_id'],
                'match' => $data['match'],
                'match_record_id' => $matchRecordId,
                'referee_id' => $referee2Info['id'],
                'referee' => $referee2Info['referee'],
                'member_id' => $referee2Info['member_id'],
                'member' => $referee2Info['member'],
                'referee_type' => 2,
                'appearance_fee' => 0,
                'is_attend' => 2,
                'status' => 1
            ];
            if ($referee2MatchRefereeId) {
                $_array['id'] = $referee2MatchRefereeId;
            } else {
                array_push($refereeIds, $referee2Info['id']);
            }
            array_push($matchRefereeData, $_array);
        }
        // 裁判3（副裁判）
        if (input('?post.referee3_id') && input('post.referee3_id')) {
            $referee3Info = $refereeS->getReferee(['id' => $data['referee3_id']]);
            $referee3MatchRefereeId = $matchS->getMatchReferee([
                'referee_id' => $data['referee1_id'],
                'match_id' => $data['match_id'],
                'match_record_id' => $matchRecordId
            ]);
            $_array = [
                'match_id' => $data['match_id'],
                'match' => $data['match'],
                'match_record_id' => $matchRecordId,
                'referee_id' => $referee3Info['id'],
                'referee' => $referee3Info['referee'],
                'member_id' => $referee3Info['member_id'],
                'member' => $referee3Info['member'],
                'referee_type' => 2,
                'appearance_fee' => 0,
                'is_attend' => 2,
                'status' => 1
            ];
            if ($referee3MatchRefereeId) {
                $_array['id'] = $referee3MatchRefereeId;
            } else {
                array_push($refereeIds, $referee3Info['id']);
            }
            array_push($matchRefereeData, $_array);
        }

        // 双方球队积分数据
        $matchRankData = [
            // 主队数据
            [
                'match_id' => $data['match_id'],
                'match' => $data['match'],
                'match_group_id' => ($data['match_group_id']) ? $data['match_group_id'] : 0,
                'match_group' => ($data['match_group']) ? $data['match_group'] : '',
                'match_stage_id' => ($data['match_stage_id']) ? $data['match_stage_id'] : 0,
                'match_stage' => ($data['match_stage']) ? $data['match_stage'] : '',
                'match_schedule_id' => $data['match_schedule_id'],
                'match_record_id' => $matchRecordId,
                'team' => $data['home_team'],
                'team_id' => $data['home_team_id'],
                'team_logo' => $data['home_team_logo'],
                'score' => ($data['win_team_id'] == $data['home_team_id']) ? 1 : 0,
                'status' => 1
            ],
            // 客队数据
            [
                'match_id' => $data['match_id'],
                'match' => $data['match'],
                'match_group_id' => ($data['match_group_id']) ? $data['match_group_id'] : 0,
                'match_group' => ($data['match_group']) ? $data['match_group'] : '',
                'match_stage_id' => ($data['match_stage_id']) ? $data['match_stage_id'] : 0,
                'match_stage' => ($data['match_stage']) ? $data['match_stage'] : '',
                'match_schedule_id' => $data['match_schedule_id'],
                'match_record_id' => $matchRecordId,
                'team' => $data['away_team'],
                'team_id' => $data['away_team_id'],
                'team_logo' => $data['away_team_logo'],
                'score' => ($data['win_team_id'] == $data['away_team_id']) ? 1 : 0,
                'status' => 1
            ]
        ];
        // 启动事务
        Db::startTrans();
        try {
            // 双方球队比赛场数+1
            db('team')->where('id', $data['home_team_id'])->setInc('match_num', 1);
            db('team')->where('id', $data['away_team_id'])->setInc('match_num', 1);
            // 相关裁判 保存比赛-执裁数据
            if (!empty($matchRefereeData)) {
                $matchS->saveAllMatchReferee($matchRefereeData);
            }
            if (!empty($refereeIds)) {
                db('referee')->where('id', 'in', $refereeIds)->setInc('total_played', 1);
            }
            // 保存双方球队积分数据
            $leagueS->saveAllMatchRank($matchRankData);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            trace('error: ' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        // 收到通知人群：2支球队的领队和队长
        //  $sendMessageMembers: 确实收到消息的会员id集合  $_sendMessageMembersTmp：收到消息的会员id集合（会出现id重复，要过滤重复值）
        $sendMessageMembers = $_sendMessageMembersTmp =  [];
        // 获取2支球队的领队队长
        $teamS = new TeamService();
        $homeTeamInfo = $teamS->getTeam(['id' => $data['home_team_id']]);
        $awayTeamInfo = $teamS->getTeam(['id' => $data['away_team_id']]);
        if ($homeTeamInfo['leader_id'] > 0) {
            array_push($_sendMessageMembersTmp, $homeTeamInfo['leader_id']);
        }
        if ($homeTeamInfo['captain_id'] > 0) {
            array_push($_sendMessageMembersTmp, $homeTeamInfo['captain_id']);
        }
        if ($awayTeamInfo['leader_id'] > 0) {
            array_push($_sendMessageMembersTmp, $awayTeamInfo['leader_id']);
        }
        if ($awayTeamInfo['captain_id'] > 0) {
            array_push($_sendMessageMembersTmp, $awayTeamInfo['captain_id']);
        }
        $_sendMessageMembersTmp = array_unique($_sendMessageMembersTmp);
        if (!empty($_sendMessageMembersTmp)) {
            foreach ($_sendMessageMembersTmp as $key => $value) {
                array_push($sendMessageMembers, ['id' => $value]);
            }
        }
        $messageS = new MessageService();
        $message = [
            'title' => '联赛 '.$data['match'].'-'.$data['match_stage'].'比赛结果',
            'content' => '联赛 '.$data['match'].'-'.$data['match_stage'].'比赛场次：'.$data['home_team'] . 'VS'. $data['away_team'].'比赛结果',
            'url' => url('keeper/match/leaguerecordinfo', ['id' => $matchRecordId], '', true),
            'keyword1' => $data['home_team'] . 'VS'. $data['away_team'],
            'keyword2' => $data['home_score'] . '：' . $data['away_score'],
            'keyword3' => $winTeamName,
            'remark' => '更多详情点击进入查看',
            'steward_type' => 2
        ];
        $messageS->sendMessageToMembers($sendMessageMembers, $message, config('wxTemplateID.matchResult'));
        // 返回结果
        return json($result);
    }

    // 比赛战绩列表（根据时间、阶段、分组）
    public function matchrecordlistbystage()
    {
        $data = input('param.');
        // 参数league_id -> match_id
        if (input('?param.league_id')) {
            unset($data['league_id']);
            $data['match_id'] = input('param.league_id');
        }
        if (input('?page')) {
            unset($data['page']);
        }
        $leagueS = new LeagueService();
        $orderby = ['match_time' => 'asc', 'id' => 'desc'];
        $list = $leagueS->getMatchRecords($data, $orderby);
        if (!$list) {
            return json(['code' => 100, 'msg' => __lang('MSG_000')]);
        }
        // 获取比赛阶段type字段信息
        foreach ($list as $key => $value) {
            $stageInfo = $leagueS->getMatchStage(['id' => $value['match_stage_id']]);
            $list[$key]['match_stage_type'] = ($stageInfo) ? $stageInfo['type'] : 0;
        }
        $_result = $result = [];
        // 根据比赛时间（年月日）对数据分片
        foreach ($list as $key => $value) {
            $date = ($value['match_timestamp']) ? date('Y-m-d', $value['match_timestamp']) : 0;
            $_result[$value['match_stage'] . '|' . $date. '|' . $value['match_stage_type']][] = $value;
        }
        foreach ($_result as $key => $value) {
            $_array = [];
            $keyExplode = explode('|', $key);
            $_array['date'] = $keyExplode[1];
            $_array['stage']['type'] = $keyExplode[2];
            $_array['stage']['name'] = $keyExplode[0];
            $_array['stage']['records'] = $value;
            array_push($result, $_array);
        }
        if (!$result) {
            return json(['code' => 100, 'msg' => __lang('MSG_000')]);
        } else {
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
        }
    }

    // 创建联赛文章
    public function createleaguearticle()
    {
        $data = input('post.');
        // 验证器
        $validate = validate('ArticleVal');
        if (!$validate->scene('add')->check($data)) {
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        // 验证会员操作权限 管理员以上才能操作
        if (!$this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        $leagueS = new LeagueService();
        $matchS = new MatchService();
        $power = $leagueS->getMatchMemberType([
            'member_id' => $this->memberInfo['id'],
            'match_id' => $data['organization_id'],
            'status' => 1
        ]);
        if ($power < 9) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        // 数据组合
        $data['category'] = input('post.category', 3, 'intval');
        $data['member'] = $this->memberInfo['member'];
        $data['organization_type'] = input('post.organization_type', 4, 'intval');
        $data['status'] = input('post.status', -1, 'intval');
        $data['likes'] = 0;
        try {
            $result = $leagueS->saveArticle($data);
        } catch (Exception $e) {
            trace('error: ' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        if (!$result) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        } else {
            return json(['code' => 200, 'msg' => __lang('MSG_200')]);
        }
    }

    // 编辑联赛文章
    public function updateleaguearticle()
    {
        $data = input('post.');
        // 验证器
        $validate = validate('ArticleVal');
        if (!$validate->scene('edit')->check($data)) {
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        // 验证会员操作权限 管理员以上才能操作
        if (!$this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        $leagueS = new LeagueService();
        $matchS = new MatchService();
        $power = $leagueS->getMatchMemberType([
            'member_id' => $this->memberInfo['id'],
            'match_id' => $data['organization_id'],
            'status' => 1
        ]);
        if ($power < 9) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        try {
            $result = $leagueS->saveArticle($data);
        } catch (Exception $e) {
            trace('error: ' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        if (!$result) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        } else {
            return json(['code' => 200, 'msg' => __lang('MSG_200')]);
        }
    }

    // 删除联赛文章
    public function delleaguearticle()
    {
        $id = input('post.id');
        // 查询文章数据
        $articleS = new ArticleService();
        $articleInfo = $articleS->getArticleInfo($id);
        if (!$articleInfo) {
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
        // 验证会员操作权限 管理员以上才能操作
        if (!$this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        $leagueS = new LeagueService();
        $power = $leagueS->getMatchMemberType([
            'member_id' => $this->memberInfo['id'],
            'match_id' => $articleInfo['organization_id'],
            'status' => 1
        ]);
        if ($power < 9) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        try {
            $result = $articleS->SoftDeleteArticle($articleInfo['id']);
        } catch (Exception $e) {
            trace('error: ' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        return json($result);
    }

    // 联赛文章列表
    public function getleaguearticlelist()
    {
        $map = input('param.');
        $page = input('page', 1, 'intval');
        // 参数league_id -> organization_id
        if (input('?param.league_id')) {
            unset($map['league_id']);
            $map['organization_id'] = input('param.league_id');
        }
        if (input('?page')) {
            unset($map['page']);
        }
        $map['organization_type'] = input('post.organization_type', 4, 'intval');
        $map['category'] = input('post.category', 3, 'intval');
        $orberby = ['hit' => 'desc', 'id' => 'desc'];
        $articleS = new ArticleService();
        $result = $articleS->getArticleList($map, $page, $orberby);
        if (!$result) {
            return json(['code' => 100, 'msg' => __lang('MSG_000')]);
        } else {
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result->toArray()]);
        }
    }

    // 联赛文章列表（页码）
    public function getleaguearticlepage()
    {
        $map = input('param.');
        // 参数league_id -> organization_id
        if (input('?param.league_id')) {
            unset($map['league_id']);
            $map['organization_id'] = input('param.league_id');
        }
        if (input('?page')) {
            unset($map['page']);
        }
        $map['organization_type'] = input('post.organization_type', 4, 'intval');
        $map['category'] = input('post.category', 3, 'intval');
        $orberby = ['hit' => 'desc', 'id' => 'desc'];
        $articleS = new ArticleService();
        $result = $articleS->getArticleListByPage($map, $orberby);
        if (!$result) {
            return json(['code' => 100, 'msg' => __lang('MSG_000')]);
        } else {
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result->toArray()]);
        }
    }

    // 联赛模块评论列表
    public function leaguecommentlist()
    {
        try {
            // 判断必传参数
            // 评论类型
            $comment_type = input('post.comment_type');
            if (!$comment_type ) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            // 组合传参作查询条件
            $map = input('post.');
            // 页码参数
            $page = input('page', 1);
            unset($map['page']);
            $leagueS = new LeagueService();
            // 返回结果
            $result = $leagueS->getCommentList($map, $page);
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
                $thumbupsCount = $leagueS->getCommentThumbsCount($map);
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result, 'thumbsup_count' => $thumbupsCount];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 联赛模块评论列表（有页码）
    public function leaguecommentlistpage()
    {
        try {
            // 判断必传参数
            // 评论类型
            $comment_type = input('post.comment_type');
            if (!$comment_type) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            // 组合传参作查询条件
            $page = input('page', 1);
            $map = input('post.');
            $leagueS = new LeagueService();
            // 返回结果
            $result = $leagueS->getCommentPaginator($map);
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
                $thumbupsCount = $leagueS->getCommentThumbsCount($map);
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result, 'thumbsup_count' => $thumbupsCount];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 发布联赛模块评论
    public function addleaguecomment()
    {
        try {
            // 检测会员登录
            if ( $this->memberInfo['id'] === 0) {
                return json(['code' => 100, 'msg' => '请先登录或注册会员']);
            }
            // 将接收参数作提交数据
            $data = input('post.');
            // 判断必传参数
            // 评论类型
            $comment_type = input('post.comment_type');
            if (!$comment_type) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            $leagueS = new LeagueService();
            // 查询会员有无评论记录
            $map = [
                'comment_type' => $comment_type,
                'member_id' => $this->memberInfo['id'],
            ];
            if ( input('?post.match_id') ) {
                $map['match_id'] = $data['match_id'];
            }
            if ( input('?post.match_record_id') ) {
                $map['match_record_id'] = $data['match_record_id'];
            }
            $hasCommented = $leagueS->getCommentInfo($map);
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
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['member_avatar'] = $this->memberInfo['avatar'];
            // 发表文字评论时间
            $data['comment_time'] = time();
            $res = $leagueS->saveComment($data);
            return json($res);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 删除联赛模块评论
    public function delleaguecomment() {
        $id  = input('post.id');
        if (!$id) {
            return json(['code' => 100, 'msg' => __lang('MSG_402')]);
        }
        // 查询评论数据
        $leagueS = new LeagueService();
        $comment = $leagueS->getCommentInfo(['id' => $id]);
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
            $res = $leagueS->delComment($comment['id']);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        if ($res) {
            return json(['code' => 200, 'msg' => __lang('MSG_200')]);
        } else {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
    }

    // 联赛模块点赞
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
            // 评论类型
            $comment_type = input('post.comment_type');
            if (!$comment_type) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            $leagueS = new LeagueService();
            // 查询会员有无评论记录
            $map = [
                'comment_type' => $comment_type,
                'member_id' => $this->memberInfo['id'],
                'match_id' => $data['match_id'],
                'match_record_id' => $data['match_record_id']
            ];
            $hasCommented = $leagueS->getCommentInfo($map);
            // 有评论记录就更新记录的thumbsup字段
            if ($hasCommented) {
                $data['id'] = $hasCommented['id'];
            }
            // 防止有传入comment参数 过滤掉
            if (isset($data['comment'])) {
                unset($data['comment']);
            }
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['member_avatar'] = $this->memberInfo['avatar'];
            $data['thumbsup'] = ($hasCommented && ($hasCommented['thumbsup'] == 1)) ? 0 : 1;
            $result = $leagueS->saveComment($data);
            if ($result['code'] == 200) {
                // 返回最新的点赞数统计
                $thumbsupCount = $leagueS->getCommentThumbsCount([
                    'comment_type' => $comment_type,
                    'match_id' => $data['match_id'],
                    'match_record_id' => $data['match_record_id']
                ]);
                $result['thumbsup_count'] = $thumbsupCount;
            }
            return json($result);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 获取会员在联赛模块当前点赞信息
    public function listhumbup()
    {
        try {
            // 将接收参数作提交数据
            $data = input('post.');
            // 判断必传参数
            // 评论类型
            $comment_type = input('post.comment_type');
            if (!$comment_type) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            $leagueS = new LeagueService();
            // 查询会员有无评论记录
            $map = [
                'comment_type' => $comment_type,
                'member_id' => $this->memberInfo['id'],
                'match_id' => $data['match_id'],
                'match_record_id' => $data['match_record_id']
            ];
            $commentInfo = $leagueS->getCommentInfo($map);
            // 点赞字段值
            $thumbsup = ($commentInfo) ? $commentInfo['thumbsup'] : 0;
            // 点赞数统计
            $thumbupCount = $leagueS->getCommentThumbsCount([
                'comment_type' => $comment_type,
                'match_id' => $data['match_id'],
                'match_record_id' => $data['match_record_id']
            ]);
            return json(['code' => 200, 'msg' => __lang('MSG_200'), 'thumbsup' => $thumbsup, 'thumbsup_count' => $thumbupCount]);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }
}