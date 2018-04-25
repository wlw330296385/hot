<?php
// 比赛api
namespace app\api\controller;

use app\model\MatchRecord;
use app\service\MatchService;
use app\service\MessageService;
use app\service\RefereeService;
use app\service\TeamService;
use think\Exception;
use think\Db;

class Match extends Base
{
    // 创建比赛
    public function creatematch()
    {
        // 接收请求参数 $data：match表字段
        $data = input('post.');
        $data['member_id'] = $this->memberInfo['id'];
        $data['member'] = $this->memberInfo['member'];
        $data['member_avatar'] = $this->memberInfo['avatar'];
        // 数据字段验证
        $validate = validate('MatchVal');
        if ( !$validate->scene('add')->check($data) ) {
            return json(['code' => 100, 'msg' => $validate->getError()]);
        }
        // 严格检查数据字段
        if ( !array_key_exists('team_id', $data) ) {
            return json(['code' => 100, 'msg' => __lang('MSG_402') . '请选择主队']);
        }
        // 时间字段格式转换
        $data['match_time'] = checkDatetimeIsValid($data['match_time']) ? strtotime($data['match_time']) : 0;
        if (!empty($data['match_time']) && $data['match_time'] <= time()) {
            return json(['code' => 100, 'msg' => '比赛时间不能小于当前时间']);
        }
        $teamS = new TeamService();
        // 组合比赛战绩数据 match_record表字段
        $dataMatchRecord = $data['record'];
        $dataMatchRecord['match_time'] = $data['match_time'];
        $dataMatchRecord['team_id'] = $data['team_id'];
        // 获取主队信息
        $homeTeam = $teamS->getTeam(['id' => $data['team_id']]);
        if ($homeTeam) {
            $dataMatchRecord['home_team_id'] = $homeTeam['id'];
            $dataMatchRecord['home_team'] = $homeTeam['name'];
            $dataMatchRecord['home_team_logo'] = $homeTeam['logo'];
        }
        // 如果有提交客队信息，获取客队信息
        if ( isset($data['away_team_id']) && !empty($data['away_team_id']) ) {
            // 客队不能与主队相同
            if ($data['away_team_id'] == $data['team_id']) {
                return json(['code' => 100, 'msg' => '请选择其他球队']);
            }
            $dataMatchRecord['away_team_id'] = $data['away_team_id'];
            $dataMatchRecord['away_team'] = $data['away_team'];
            $dataMatchRecord['away_team_logo'] = $data['away_team_logo'];
            // 比赛名称
            $data['name'] = $homeTeam['name'].' vs '.$data['away_team'];
        } else {
            $data['name'] = $homeTeam['name'].'约战';
        }
        // 保存数据
        $matchS = new MatchService();
        $messageS = new MessageService();
        // 裁判数据业务：
        // 1 json数据中referee_id不为空 即邀请裁判，发送比赛邀请裁判消息
        // 2 只有referee_cost 对符合价钱的裁判发送比赛裁判任务领取消息
        $inviteeRefereeIds = []; // 发出比赛邀请的裁判名单
        $sendMatchToRefereeByCost = []; // 发送比赛裁判任务给指定出场费的裁判人群
        if ( !empty($data['referee1']) && !is_null(json_decode($data['referee1'])) ) {
            $dataMatchRecord['referee1'] = $data['referee1'];
            $referee1 = json_decode($data['referee1'], true);
            if ( $referee1['referee_id']
                && !in_array($referee1['referee_id'], $inviteeRefereeIds)
            ) {
                array_push($inviteeRefereeIds, $referee1['referee_id']);

            } elseif ( $referee1['referee_cost']
                && !in_array($referee1['referee_cost'], $sendMatchToRefereeByCost)
            ) {
                array_push($sendMatchToRefereeByCost, $referee1['referee_cost']);
            }
        }
        if ( !empty($data['referee2']) && !is_null(json_decode($data['referee2'])) ) {
            $dataMatchRecord['referee2'] = $data['referee2'];
            $referee2 = json_decode($data['referee2'], true);
            if ( $referee2['referee_id']
                && !in_array($referee2['referee_id'], $inviteeRefereeIds)
            ) {
                array_push($inviteeRefereeIds, $referee2['referee_id']);

            } elseif ( $referee2['referee_cost']
                && !in_array($referee2['referee_cost'], $sendMatchToRefereeByCost)
            ) {
                array_push($sendMatchToRefereeByCost, $referee2['referee_cost']);
            }
        }
        if ( !empty($data['referee3']) && !is_null(json_decode($data['referee3'])) ) {
            $dataMatchRecord['referee3'] = $data['referee3'];
            $referee3 = json_decode($data['referee3'], true);
            if ( $referee3['referee_id']
                && !in_array($referee3['referee_id'], $inviteeRefereeIds)
            ) {
                array_push($inviteeRefereeIds, $referee3['referee_id']);

            } elseif ( $referee3['referee_cost']
                && !in_array($referee3['referee_cost'], $sendMatchToRefereeByCost)
            ) {
                array_push($sendMatchToRefereeByCost, $referee3['referee_cost']);
            }
        }
        try {
            // 创建match数据
            $res = $matchS->saveMatch($data);
            // 创建match数据成功后续业务
            if ($res['code'] == 200) {
                $matchId = $res['data'];
                // 记录比赛战绩数据
                $dataMatchRecord['match_id'] = $res['data'];
                $dataMatchRecord['match'] = $data['name'];
                $resMatchRecord = $matchS->saveMatchRecord($dataMatchRecord);
                $matchRecordId = $resMatchRecord['data'];

                // 执行裁判消息通知业务
                $this->setMatchReferee($data, $matchId, $matchRecordId, $inviteeRefereeIds, $sendMatchToRefereeByCost);

                // 发送比赛邀请给对手球队
                if (array_key_exists('away_team_id', $data)) {
                    $awayTeam = $teamS->getTeam(['id' => $data['away_team_id']]);
                    if ($awayTeam) {
                        // 保存约战申请
                        $applyData = [
                            'match_id' => $res['data'],
                            'match' => $data['name'],
                            'team_id' => $data['team_id'],
                            'team' => $data['team'],
                            'telphone' => $this->memberInfo['telephone'],
                            'contact' => empty($this->memberInfo['realname']) ? $this->memberInfo['member'] : $this->memberInfo['realname'],
                            'member_id' => $this->memberInfo['id'],
                            'member' => $this->memberInfo['member'],
                            'member_avatar' => $this->memberInfo['avatar'],
                            'revice_team_id' => $awayTeam['id'],
                            'revice_team' => $awayTeam['name'],
                            'status' => 1
                        ];
                        $resApply = $matchS->saveMatchApply($applyData);
                        // 组合推送消息内容
                        $dataMessage = [
                            'title' => '您好，' . $data['team'] . '球队向您所在 ' . $awayTeam['name'] . '球队发起约战',
                            'content' => '您好，' . $data['team'] . '球队向您所在 ' . $awayTeam['name'] . '球队发起约战',
                            'url' => url('keeper/team/matchapplyinfo', ['apply_id' => $resApply['data'], 'team_id' => $awayTeam['id']], '', true),
                            'keyword1' => '球队发起约战',
                            'keyword2' => $this->memberInfo['member'],
                            'keyword3' => date('Y-m-d h:i', time()),
                            'remark' => '请登录平台进入球队管理-》约战申请回复处理',
                            // 比赛发布球队id
                            'team_id' => $data['team_id'],
                            'steward_type' => 2
                        ];
                        // 推送消息给发布比赛的球队领队
                        $messageS->sendMessageToMember($awayTeam['leader_id'], $dataMessage, config('wxTemplateID.checkPend'));
                        // 保存球队公告
                        $teamS->saveTeamMessage($dataMessage);
                    }
                }
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        return json($res);
    }

    /** 根据比赛信息所选裁判类型执行的业务
     * @param array $matchData 比赛信息数据
     * @param $matchId match表id
     * @param $matchRecordId match_record表id
     * @param array $inviteeRefereeIds 数据内容：[referee_id,referee_id] 发送比赛邀请裁判消息
     * @param array $sendMatchToRefereeByCost 数据内容：[referee_cost, referee_cost] 根据出场费所对应的裁判人群发送比赛裁判任务消息
     */
    protected function setMatchReferee($matchData=[], $matchId, $matchRecordId, $inviteeRefereeIds=[], $sendMatchToRefereeByCost=[]) {
        $refereeS = new RefereeService();
        $matchS = new MatchService();
        $messageS = new MessageService();
        // 发送比赛邀请裁判消息
        if ( is_array($inviteeRefereeIds) && !empty($inviteeRefereeIds) ) {
            // 组合接收信息member_id集合
            $memberIds = $applyData = [];
            foreach ($inviteeRefereeIds as $k => $val) {
                // 获取裁判详情数据
                $refereeInfo = $refereeS->getRefereeInfo(['id' => $val]);
                $memberIds[$k]['id'] = $refereeInfo['member_id'];
                // 组合邀请裁判数据
                $applyData[$k] = [
                    'apply_type' => 2,
                    'match_id' => $matchId,
                    'match' => $matchData['name'],
                    'match_record_id' => $matchRecordId,
                    'team_id' => $matchData['team_id'],
                    'team' => $matchData['team'],
                    'referee_id' => $refereeInfo['id'],
                    'referee' => $refereeInfo['referee'],
                    'referee_avatar' => $refereeInfo['portraits'],
                    'referee_cost' => $refereeInfo['appearance_fee'],
                    'member_id' => $this->memberInfo['id'],
                    'member' => $this->memberInfo['member'],
                    'member_avatar' => $this->memberInfo['avatar'],
                    'status' => 1
                ];
                $hasMatchRefereeApply = $matchS->getMatchRerfereeApply([
                    'match_id' => $matchId,
                    'match_record_id' => $matchRecordId,
                    'referee_id' => $refereeInfo['id']
                ]);
                if ($hasMatchRefereeApply) {
                    $applyData[$k]['id'] = $hasMatchRefereeApply['id'];
                }
            }
            if ( !empty($applyData) ) {
                // 保存比赛邀请裁判数据
                $matchS->saveAllMatchRerfereeApply($applyData);
                // 信息内容
                $daidingStr = '待定';
                $messageData = [
                    'title' => '您有一条执裁比赛邀请信息',
                    'content' => '您好，有比赛邀请您执裁',
                    'url' => url('keeper/referee/matchapply', ['match_id' => $matchId], '', true),
                    'keyword1' => empty($matchData['match_time']) ? $daidingStr : date('Y年m月d日 H:i', $matchData['match_time']),
                    'keyword2' => empty($matchData['court']) ? $daidingStr : $matchData['court'],
                    'keyword3' => $matchData['name'],
                    'remark' => '点击进入，查看比赛信息',
                    'steward_type' => 2
                ];
                $messageS->sendMessageToMembers($memberIds, $messageData, config('wxTemplateID.refereeTask'));
            }
        }
        // 根据出场费所对应的裁判人群发送比赛裁判任务消息
        if ( is_array($sendMatchToRefereeByCost) && !empty($sendMatchToRefereeByCost) ) {
            $map = [];
            $memberIds1 = [];
            if ($matchData['city']) {
                $map['city'] = $matchData['city'];
            }
            $map['status'] = 1;
            $map['accept_rand_match'] = 1;
            $map['appearance_fee'] = ['in', $sendMatchToRefereeByCost];
            $refereeList = $refereeS->getRefereeAll($map);

            if ($refereeList) {
                foreach ($refereeList as $k => $referee) {
                    $memberIds1[$k]['id'] = $referee['member_id'];
                }
                $daidingStr = '待定';
                $messageData = [
                    'title' => '您好，您有一条新的系统指派比赛执裁订单，请注意查收',
                    'content' => '您好，您有一条新的系统指派比赛执裁订单，请注意查收',
                    'url' => url('keeper/team/matchInfo', ['match_id' => $matchId, 'team_id' => $matchData['team_id']], '', true),
                    'keyword1' => empty($matchData['match_time']) ? $daidingStr : date('Y年m月d日 H:i', $matchData['match_time']),
                    'keyword2' => empty($matchData['court']) ? $daidingStr : $matchData['court'],
                    'keyword3' => $matchData['name'],
                    'remark' => '点击进入，查看比赛信息',
                    'steward_type' => 2
                ];
                $messageS->sendMessageToMembers($memberIds1, $messageData, config('wxTemplateID.refereeTask'));
            }
        }
    }

    // 更新球队比赛
    public function updateteammatch()
    {
        // 接收请求参数 $data：match表字段
        $data = input('post.');
        // service
        $matchS = new MatchService();
        $teamS = new TeamService();
        $messageS = new MessageService();
        $refereeS = new RefereeService();
        // 获取当前比赛数据、比赛战绩数据
        $match_id = $data['id'];
        $match = $matchS->getMatch(['id' => $match_id]);
        $matchRecord = $matchS->getMatchRecord(['match_id' => $match['id']]);
        if (!$match || !$matchRecord) {
            return json(['code' => 100, 'msg' => __lang('MSG_404') . '请选择其他比赛']);
        }
        $matchRecordId = $matchRecord['id'];
        // 数据字段验证
        $validate = validate('MatchVal');
        if ( !$validate->scene('edit')->check($data) ) {
            return json(['code' => 100, 'msg' => $validate->getError()]);
        }
        // 时间字段格式转换
        $data['match_time'] = checkDatetimeIsValid($data['match_time']) ? strtotime($data['match_time']) : null;
        // 组合比赛战绩数据 match_record表字段
        $dataMatchRecord = $data['record'];
        // 比赛完成状态match is_finished标识
        $isFinished = 0;
        // 提取球队、比分变量
        $homeTeamId = $dataMatchRecord['home_team_id'];
        $homeScore = $dataMatchRecord['home_score'];
        $awayTeamId = $dataMatchRecord['away_team_id'];
        $awayScore = $dataMatchRecord['away_score'];
        // 提交is_finished=1 即比赛完成 验证数据
        if (isset($data['is_finished']) && $data['is_finished'] == 1) {
            if (empty($awayTeamId) && empty($dataMatchRecord['away_team'])) {
                return json(['code' => 100, 'msg' => '请填写客队信息']);
            }
            $isFinished = 1;
            $data['finished_time'] = $data['match_time'];
            $data['is_live'] = -1;

            // dataMatchRecord[win_team_id]: 比赛胜利球队id
            if ($homeScore > 0 && $awayScore > 0) {
                if ($homeScore >= $awayScore) {
                    $recordData['win_team_id'] = $homeTeamId;
                    $recordData['lose_team_id'] = $awayTeamId;
                } else {
                    $recordData['win_team_id'] = $awayTeamId;
                    $recordData['lose_team_id'] = $homeTeamId;
                }
            }
        }
        $dataMatchRecord['match_time'] = $data['match_time'];
        // 相册不为空保存数据
        if (isset($data['album']) && $data['album'] != "[]") {
            $dataMatchRecord['album'] = $data['album'];
        }
        // 更新比赛名称match_name 有选择对手队：当前球队名vs对手队名|无选择对手队：当前球队名友谊赛（对手待定）
        if (!empty($awayTeamId)) {
            $data['name'] = $data['record']['home_team'] . ' vs ' . $data['record']['away_team'];
        } else {
            $data['name'] = $data['record']['home_team'] . '约战';
        }
        // 裁判数据业务：
        // 1 json数据中referee_id不为空 即邀请裁判，发送比赛邀请裁判消息
        // 2 只有referee_cost 对符合价钱的裁判发送比赛裁判任务领取消息
        $inviteeRefereeIds = []; // 发出比赛邀请的裁判名单
        $sendMatchToRefereeByCost = []; // 发送比赛裁判任务给指定出场费的裁判人群
        $withdrawRefereeIds = []; // 撤销了邀请的裁判名单
        if ( !empty($data['referee1']) && !is_null(json_decode($data['referee1'])) ) {
            $referee1 = json_decode($data['referee1'], true);
            // 提交数据发生改变
            if ( empty($referee1['referee_id']) ) { //提交的裁判内容为空
                if ($matchRecord['referee1']['referee_id']) {
                    array_push($withdrawRefereeIds, $matchRecord['referee1']['referee_id']);
                }
            } else {
                if ( $referee1['referee_id']
                    && !in_array($referee1['referee_id'], $inviteeRefereeIds)
                    && $referee1['referee_id'] != $matchRecord['referee1']['referee_id']
                ) {
                    array_push($inviteeRefereeIds, $referee1['referee_id']);
                    array_push($withdrawRefereeIds, $matchRecord['referee1']['referee_id']);
                }
            }
            if ( $referee1['referee_cost']
                && !in_array($referee1['referee_cost'], $sendMatchToRefereeByCost)
                && $referee1['referee_cost'] != $matchRecord['referee1']['referee_cost']
            ) {
                array_push($sendMatchToRefereeByCost, $referee1['referee_cost']);
            }
            $dataMatchRecord['referee1'] = $data['referee1'];
        }
        if ( !empty($data['referee2']) && !is_null(json_decode($data['referee2'])) ) {
            $referee2 = json_decode($data['referee2'], true);
            // 提交数据发生改变
            if ( empty($referee2['referee_id']) ) { //提交的裁判内容为空
                if ($matchRecord['referee2']['referee_id']) {
                    array_push($withdrawRefereeIds, $matchRecord['referee2']['referee_id']);
                }
            } else {
                if ( $referee2['referee_id']
                    && !in_array($referee2['referee_id'], $inviteeRefereeIds)
                    && $referee2['referee_id'] != $matchRecord['referee2']['referee_id']
                ) {
                    array_push($inviteeRefereeIds, $referee2['referee_id']);
                    array_push($withdrawRefereeIds, $matchRecord['referee2']['referee_id']);
                }
            }
            if ( $referee2['referee_cost']
                && !in_array($referee2['referee_cost'], $sendMatchToRefereeByCost)
                && $referee2['referee_cost'] != $matchRecord['referee2']['referee_cost']
            ) {
                array_push($sendMatchToRefereeByCost, $referee2['referee_cost']);
            }
            $dataMatchRecord['referee2'] = $data['referee2'];
        }
        if ( !empty($data['referee3']) && !is_null(json_decode($data['referee3'])) ) {
            $referee3 = json_decode($data['referee3'], true);
            // 提交数据发生改变
            if ( empty($referee2['referee_id']) ) { //提交的裁判内容为空
                if ($matchRecord['referee3']['referee_id']) {
                    array_push($withdrawRefereeIds, $matchRecord['referee3']['referee_id']);
                }
            } else {
                if ( $referee3['referee_id']
                    && !in_array($referee3['referee_id'], $inviteeRefereeIds)
                    && $referee3['referee_id'] != $matchRecord['referee3']['referee_id']
                ) {
                    array_push($inviteeRefereeIds, $referee3['referee_id']);
                    array_push($withdrawRefereeIds, $matchRecord['referee3']['referee_id']);
                }
            }
            if ( $referee3['referee_cost']
                && !in_array($referee3['referee_cost'], $sendMatchToRefereeByCost)
                && $referee3['referee_cost'] != $matchRecord['referee3']['referee_cost']
            ) {
                array_push($sendMatchToRefereeByCost, $referee3['referee_cost']);
            }
            $dataMatchRecord['referee3'] = $data['referee3'];
        }
        // 组合比赛信息数据、比赛战绩数据end
        // 比赛队员业务操作
        // 保留显示的成员名单（status=1 报名is_apply=1 、出席is_attend=1）
        if (isset($data['HomeMemberData']) && $data['HomeMemberData'] != "[]") {
            $homeMember = json_decode($data['HomeMemberData'], true);
            $dataUpdateTeamMember = [];
            foreach ($homeMember as $k => $member) {
                // 查询球员有无对应比赛match_record_member记录
                $matchRecordMember = $matchS->getMatchRecordMember(['match_id' => $match['id'], 'match_record_id' => $dataMatchRecord['id'], 'member_id' => $member['member_id'], 'team_member_id' => $member['tmid']]);
                if ($matchRecordMember) {
                    // 更新match_record_member
                    $homeMember[$k]['id'] = $matchRecordMember['id'];
                }
                // 获取球队成员数据
                $teamMember = $teamS->getTeamMemberInfo(['id' => $member['tmid']]);
                $homeMember[$k]['match_id'] = $match['id'];
                $homeMember[$k]['match'] = $data['name'];
                $homeMember[$k]['team_id'] = $dataMatchRecord['home_team_id'];
                $homeMember[$k]['team'] = $dataMatchRecord['home_team'];
                $homeMember[$k]['team_member_id'] = ($teamMember) ? $teamMember['id'] : 0;
                $homeMember[$k]['match_record_id'] = $dataMatchRecord['id'];
                $homeMember[$k]['avatar'] = ($teamMember['member_id'] > 0) ? $teamMember['avatar'] : config('default_image.member_avatar');
                $homeMember[$k]['contact_tel'] = $teamMember['telephone'];
                $homeMember[$k]['status'] = 1;
                $homeMember[$k]['is_checkin'] = 1;
                // 若比赛完成 比赛参赛球队成员 match_record_member is_attend=1
                if ($isFinished == 1) {
                    $homeMember[$k]['is_attend'] = 1;

                    // 批量更新team_member 比赛数match_num
                    if ($matchRecordMember['is_checkin'] == 1) {
                        if ($teamMember) {
                            $dataUpdateTeamMember[$k]['id'] = $teamMember['id'];
                            $dataUpdateTeamMember[$k]['match_num'] = $teamMember['match_num'] + 1;
                        }
                    }
                }
            }
            try {
                $saveHomeTeamMemberRes = $matchS->saveAllMatchRecordMember($homeMember);
                $teamS->saveAllTeamMember($dataUpdateTeamMember);
            } catch (Exception $e) {
                return json(['code' => 100, 'msg' => __lang('MSG_400')]);
            }
        }
        // 剔除不显示的成员名单（无效 status=-1）
        if (isset($data['HomeMemberDataDel']) && $data['HomeMemberDataDel'] != "[]") {
            $memberArr = json_decode($data['HomeMemberDataDel'], true);
            foreach ($memberArr as $k => $member) {
                // 提交有match_record_member的id主键
                // 查询球员有无对应比赛match_record_member记录
                $matchRecordMember2 = $matchS->getMatchRecordMember(['match_id' => $match['id'], 'match_record_id' => $dataMatchRecord['id'], 'member_id' => $member['member_id'], 'team_member_id' => $member['tmid']]);
                if ($matchRecordMember2) {
                    // 更新match_record_member
                    $memberArr[$k]['id'] = $matchRecordMember2['id'];
                }
                $memberArr[$k]['match'] = $data['name'];
                $memberArr[$k]['status'] = -1;
                $memberArr[$k]['is_checkin'] = -1;
            }
            try {
                $resultsaveMatchRecordMember2 = $matchS->saveAllMatchRecordMember($memberArr);
            } catch (Exception $e) {
                return json(['code' => 100, 'msg' => __lang('MSG_400')]);
            }
        }
        // 比赛队员业务操作 end

        // 保存match_record数据
        try {
            $resSaveMatchRecord = $matchS->saveMatchRecord($dataMatchRecord);
            $resultSaveMatch = $matchS->saveMatch($data);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        // 保存match_record数据 后续业务
        // 执行裁判消息通知业务
        $this->setMatchReferee($data, $match_id, $matchRecordId, $inviteeRefereeIds, $sendMatchToRefereeByCost);
        // 未完成比赛 撤销邀请的裁判数据更新
        if ( !empty($withdrawRefereeIds) && $isFinished ==0 ) {
            try {
                $matchS->saveMatchRerfereeApply([
                    'status' => 3
                ], [
                    'match_id' => $match_id,
                    'match_record_id' => $matchRecordId,
                    'referee_id' => ['in', $withdrawRefereeIds]
                ]);
            } catch (Exception $e) {
                return json(['code' => 100, 'msg' => __lang('MSG_400')]);
            }
            // 发送撤销裁判消息给裁判
            foreach ($withdrawRefereeIds as $val) {
                $refereeInfo = $refereeS->getRefereeInfo(['id' => $val]);
                $messageData = [
                    'title' => '您好，您的"' . $match['name'] . '" 执裁比赛申请已被拒绝。',
                    'content' => '您好，您的"' . $match['name'] . '" 执裁比赛申请已被拒绝。',
                    'keyword1' => $match['match_time'],
                    'keyword2' => $match['court'],
                    'remark' => '点击查看更多',
                    'steward_type' => 2,
                    'url' => url('keeper/team/matchInfo', ['match_id' => $match['id']], '', true)
                ];
                $messageS->sendMessageToMember($refereeInfo['member_id'], $messageData, config('wxTemplateID.refereeTask'));
            }
        }

        // 原match_record表away_team字段为空并post提交away_team不为空 代表对away_team发送约战邀请
        if (empty($matchRecord['away_team']) && !empty($dataMatchRecord['away_team'])) {
            // 发送比赛邀请给对手球队
            $awayTeam = $teamS->getTeam(['id' => $awayTeamId]);
            if ($awayTeam) {
                // 保存约战申请
                $applyData = [
                    'match_id' => $match['id'],
                    'match' => $data['name'],
                    'team_id' => $data['team_id'],
                    'team' => $dataMatchRecord['home_team'],
                    'telphone' => $this->memberInfo['telephone'],
                    'contact' => empty($this->memberInfo['realname']) ? $this->memberInfo['member'] : $this->memberInfo['realname'],
                    'member_id' => $this->memberInfo['id'],
                    'member' => $this->memberInfo['member'],
                    'member_avatar' => $this->memberInfo['avatar'],
                    'revice_team_id' => $awayTeam['id'],
                    'revice_team' => $awayTeam['name'],
                    'status' => 1
                ];
                $resApply = $matchS->saveMatchApply($applyData);
                // 组合推送消息内容
                $dataMessage = [
                    'title' => '您好，' . $dataMatchRecord['home_team'] . '球队向您所在 ' . $dataMatchRecord['name'] . '球队发起约战',
                    'content' => '您好，' . $dataMatchRecord['home_team'] . '球队向您所在 ' . $dataMatchRecord['name'] . '球队发起约战',
                    'url' => url('keeper/team/matchapplyinfo', ['apply_id' => $resApply['data'], 'team_id' => $awayTeam['id']], '', true),
                    'keyword1' => '球队发起约战',
                    'keyword2' => $this->memberInfo['member'],
                    'keyword3' => date('Y-m-d h:i', time()),
                    'remark' => '请登录平台进入球队管理-》约战申请回复处理',
                    // 比赛发布球队id
                    'team_id' => $data['team_id'],
                    'steward_type' => 2
                ];
                // 推送消息给发布比赛的球队领队
                $messageS->sendMessageToMember($awayTeam['leader_id'], $dataMessage, config('wxTemplateID.checkPend'));
                // 保存球队公告
                $teamS->saveTeamMessage($dataMessage);
            }
        }

        // 比赛完成的操作
        if ($isFinished == 1) {
            // 保存球队历史比赛对手信息
            // 查询有无原数据
            $mapHistoryTeam = [
                'team_id' => $homeTeamId,
                'opponent_team_id' => $awayTeamId
            ];
            $historyTeam = $matchS->getHistoryTeam($mapHistoryTeam);
            // 插入新数据
            if (!$historyTeam) {
                $dataHistoryTeam = [
                    'team_id' => $homeTeamId,
                    'team' => $dataMatchRecord['home_team'],
                    'opponent_team_id' => $awayTeamId,
                    'opponent_team' => $dataMatchRecord['away_team'],
                    'match_num' => 1
                ];
            } else {
                // 更新原数据 比赛次数+1
                $dataHistoryTeam['id'] = $historyTeam['id'];
                $dataHistoryTeam['match_num'] = $historyTeam['match_num'] + 1;
            }
            $matchS->saveHistoryTeam($dataHistoryTeam);
            // 保存球队历史比赛对手信息 end

            // 记录裁判出勤
            $matchS->saveMatchReferee([
                'is_attend' => 2
            ], [
                'match_id' => $match['id'],
                'match_record_id' => $matchRecord['id'],
                'status' => 1
            ]);
        }
        // 比赛完成的操作 end

        // 更新球队胜场数、比赛场数
        $matchS->countTeamMatchNum($homeTeamId);
        $matchS->countTeamMatchNum($awayTeamId);
        return json($resultSaveMatch);
    }

    // 直接录入球队比赛
    public function directteammatch()
    {
        // 接收请求参数 $data：match表字段
        $data = input('post.');
        $data['member_id'] = $this->memberInfo['id'];
        $data['member'] = $this->memberInfo['member'];
        $data['member_avatar'] = $this->memberInfo['avatar'];
        // 数据字段验证
        $validate = validate('MatchVal');
        if ( !$validate->scene('add')->check($data) ) {
            return json(['code' => 100, 'msg' => $validate->getError()]);
        }
        // 严格检查数据字段
        if ( !array_key_exists('team_id', $data) ) {
            return json(['code' => 100, 'msg' => __lang('MSG_402') . '请选择主队']);
        }
        // 时间字段格式转换
        $data['match_time'] = checkDatetimeIsValid($data['match_time']) ? strtotime($data['match_time']) : 0;
        if ($data['match_time'] >= time()) {
            return json(['code' => 100, 'msg' => '录入的比赛时间不能大于当前时间']);
        }
        $teamS = new TeamService();
        // 组合比赛战绩数据 match_record表字段
        $dataMatchRecord = $data['record'];
        $dataMatchRecord['match_time'] = $data['match_time'];
        // 获取主队信息
        $homeTeam = $teamS->getTeam(['id' => $data['team_id']]);
        if ($homeTeam) {
            $dataMatchRecord['home_team_id'] = $homeTeam['id'];
            $dataMatchRecord['home_team'] = $homeTeam['name'];
            $dataMatchRecord['home_team_logo'] = $homeTeam['logo'];
        }

        // 比赛完成状态match is_finished标识
        $isFinished = 0;
        // 提取球队、比分变量
        $homeTeamId = $dataMatchRecord['home_team_id'];
        $homeScore = $dataMatchRecord['home_score'];
        $awayTeamId = $dataMatchRecord['away_team_id'];
        $awayScore = $dataMatchRecord['away_score'];
        // 提交is_finished=1 即比赛完成 验证数据
        if (isset($data['is_finished']) && $data['is_finished'] == 1) {
            if (empty($awayTeamId) && empty($dataMatchRecord['away_team'])) {
                return json(['code' => 100, 'msg' => '请填写客队信息']);
            }
            $isFinished = 1;
            $data['finished_time'] = $data['match_time'];
            $data['is_live'] = -1;

            // dataMatchRecord[win_team_id]: 比赛胜利球队id
            if ($homeScore > 0 && $awayScore > 0) {
                if ($homeScore >= $awayScore) {
                    $recordData['win_team_id'] = $homeTeamId;
                    $recordData['lose_team_id'] = $awayTeamId;
                } else {
                    $recordData['win_team_id'] = $awayTeamId;
                    $recordData['lose_team_id'] = $homeTeamId;
                }
            }
        }

        // 裁判数据业务：
        // 1 json数据中referee_id不为空 即邀请裁判，发送比赛邀请裁判消息
        // 2 只有referee_cost 对符合价钱的裁判发送比赛裁判任务领取消息
        $inviteeRefereeIds = []; // 发出比赛邀请的裁判名单
        $sendMatchToRefereeByCost = []; // 发送比赛裁判任务给指定出场费的裁判人群
        if ( !empty($data['referee1']) && !is_null(json_decode($data['referee1'])) ) {
            $dataMatchRecord['referee1'] = $data['referee1'];
            $referee1 = json_decode($data['referee1'], true);
            if ( $referee1['referee_id']
                && !in_array($referee1['referee_id'], $inviteeRefereeIds)
            ) {
                array_push($inviteeRefereeIds, $referee1['referee_id']);

            } elseif ( $referee1['referee_cost']
                && !in_array($referee1['referee_cost'], $sendMatchToRefereeByCost)
            ) {
                array_push($sendMatchToRefereeByCost, $referee1['referee_cost']);
            }
        }
        if ( !empty($data['referee2']) && !is_null(json_decode($data['referee2'])) ) {
            $dataMatchRecord['referee2'] = $data['referee2'];
            $referee2 = json_decode($data['referee2'], true);
            if ( $referee2['referee_id']
                && !in_array($referee2['referee_id'], $inviteeRefereeIds)
            ) {
                array_push($inviteeRefereeIds, $referee2['referee_id']);

            } elseif ( $referee2['referee_cost']
                && !in_array($referee2['referee_cost'], $sendMatchToRefereeByCost)
            ) {
                array_push($sendMatchToRefereeByCost, $referee2['referee_cost']);
            }
        }
        if ( !empty($data['referee3']) && !is_null(json_decode($data['referee3'])) ) {
            $dataMatchRecord['referee3'] = $data['referee3'];
            $referee3 = json_decode($data['referee3'], true);
            if ( $referee3['referee_id']
                && !in_array($referee3['referee_id'], $inviteeRefereeIds)
            ) {
                array_push($inviteeRefereeIds, $referee3['referee_id']);

            } elseif ( $referee3['referee_cost']
                && !in_array($referee3['referee_cost'], $sendMatchToRefereeByCost)
            ) {
                array_push($sendMatchToRefereeByCost, $referee3['referee_cost']);
            }
        }
        // 如果有提交客队信息，获取客队信息
        if ( isset($dataMatchRecord['away_team_id']) ) {
            // 客队不能与主队相同
            if ($dataMatchRecord['away_team_id'] == $dataMatchRecord['home_team_id']) {
                return json(['code' => 100, 'msg' => '请选择其他球队']);
            }
            // 比赛名称
            $data['name'] = $homeTeam['name'].' vs '.$dataMatchRecord['away_team'];
        } else {
            $data['name'] = $homeTeam['name'].'约战';
        }

        // 保存数据
        $matchS = new MatchService();
        $messageS = new MessageService();
        try {
            // 创建match数据
            $res = $matchS->saveMatch($data);
            // 创建match数据成功后续业务
            if ($res['code'] == 200) {
                $matchId = $res['data'];
                // 发送比赛邀请给对手球队
                if (isset($data['away_team_id'])) {
                    $awayTeam = $teamS->getTeam(['id' => $data['away_team_id']]);
                    if ($awayTeam) {
                        // 保存约战申请
                        $applyData = [
                            'match_id' => $res['data'],
                            'match' => $data['name'],
                            'team_id' => $homeTeamId,
                            'team' => $homeTeam,
                            'telphone' => $this->memberInfo['telephone'],
                            'contact' => empty($this->memberInfo['realname']) ? $this->memberInfo['member'] : $this->memberInfo['realname'],
                            'member_id' => $this->memberInfo['id'],
                            'member' => $this->memberInfo['member'],
                            'member_avatar' => $this->memberInfo['avatar'],
                            'revice_team_id' => $awayTeam['id'],
                            'revice_team' => $awayTeam['name'],
                            'status' => 1
                        ];
                        $resApply = $matchS->saveMatchApply($applyData);
                        // 组合推送消息内容
                        $dataMessage = [
                            'title' => '您好，' . $homeTeam['name'] . '球队向您所在 ' . $awayTeam['name'] . '球队发起约战',
                            'content' => '您好，' . $homeTeam['name'] . '球队向您所在 ' . $awayTeam['name'] . '球队发起约战',
                            'url' => url('keeper/team/matchapplyinfo', ['apply_id' => $resApply['data'], 'team_id' => $awayTeam['id']], '', true),
                            'keyword1' => '球队发起约战',
                            'keyword2' => $this->memberInfo['member'],
                            'keyword3' => date('Y-m-d h:i', time()),
                            'remark' => '请登录平台进入球队管理-》约战申请回复处理',
                            // 比赛发布球队id
                            'team_id' => $data['team_id'],
                            'steward_type' => 2
                        ];
                        // 推送消息给发布比赛的球队领队
                        $messageS->sendMessageToMember($awayTeam['leader_id'], $dataMessage, config('wxTemplateID.checkPend'));
                        // 保存球队公告
                        $teamS->saveTeamMessage($dataMessage);
                    }
                }
                // 记录比赛战绩数据
                $dataMatchRecord['match_id'] = $res['data'];
                $dataMatchRecord['match'] = $data['name'];
                $resMatchRecord = $matchS->saveMatchRecord($dataMatchRecord);
                $matchRecordId = $resMatchRecord['data'];
                // 执行裁判消息通知业务
                $this->setMatchReferee($data, $matchId, $matchRecordId, $inviteeRefereeIds, $sendMatchToRefereeByCost);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }

        // 保存比赛球队成员
        // 保留显示的成员名单（status=1 报名is_apply=1 、出席is_attend=1）
        if (isset($data['HomeMemberData']) && $data['HomeMemberData'] != "[]") {
            $homeMember = json_decode($data['HomeMemberData'], true);
            $dataUpdateTeamMember = [];
            foreach ($homeMember as $k => $member) {
                // 查询球员有无对应比赛match_record_member记录
                $matchRecordMember = $matchS->getMatchRecordMember(['match_id' => $matchId, 'match_record_id' => $matchRecordId, 'member_id' => $member['member_id'], 'team_member_id' => $member['tmid']]);
                if ($matchRecordMember) {
                    // 更新match_record_member
                    $homeMember[$k]['id'] = $matchRecordMember['id'];
                }
                // 获取球队成员数据
                $teamMember = $teamS->getTeamMemberInfo(['id' => $member['tmid']]);
                $homeMember[$k]['match_id'] = $matchId;
                $homeMember[$k]['match'] = $data['name'];
                $homeMember[$k]['team_id'] = $homeTeamId;
                $homeMember[$k]['team'] = $dataMatchRecord['home_team'];
                $homeMember[$k]['team_member_id'] = ($teamMember) ? $teamMember['id'] : 0;
                $homeMember[$k]['match_record_id'] = $matchRecordId;
                $homeMember[$k]['avatar'] = ($teamMember['member_id'] > 0) ? $teamMember['avatar'] : config('default_image.member_avatar');
                $homeMember[$k]['contact_tel'] = $teamMember['telephone'];
                $homeMember[$k]['status'] = 1;
                $homeMember[$k]['is_checkin'] = 1;
                // 若比赛完成 比赛参赛球队成员 match_record_member is_attend=1
                if ($isFinished == 1) {
                    $homeMember[$k]['is_attend'] = 1;

                    // 批量更新team_member 比赛数match_num
                    if ($matchRecordMember['is_checkin'] == 1) {
                        if ($teamMember) {
                            $dataUpdateTeamMember[$k]['id'] = $teamMember['id'];
                            $dataUpdateTeamMember[$k]['match_num'] = $teamMember['match_num'] + 1;
                        }
                    }
                }
            }
            $saveHomeTeamMemberRes = $matchS->saveAllMatchRecordMember($homeMember);
            $teamS->saveAllTeamMember($dataUpdateTeamMember);
        }
        // 剔除不显示的成员名单（无效 status=-1）
        if (isset($data['HomeMemberDataDel']) && $data['HomeMemberDataDel'] != "[]") {
            $memberArr = json_decode($data['HomeMemberDataDel'], true);
            foreach ($memberArr as $k => $member) {
                // 提交有match_record_member的id主键
                // 查询球员有无对应比赛match_record_member记录
                $matchRecordMember2 = $matchS->getMatchRecordMember(['match_id' => $matchId, 'match_record_id' => $matchRecordId, 'member_id' => $member['member_id'], 'team_member_id' => $member['tmid']]);
                if ($matchRecordMember2) {
                    // 更新match_record_member
                    $memberArr[$k]['id'] = $matchRecordMember2['id'];
                }
                $memberArr[$k]['match'] = $data['name'];
                $memberArr[$k]['status'] = -1;
                $memberArr[$k]['is_checkin'] = -1;
            }
            $resultsaveMatchRecordMember2 = $matchS->saveAllMatchRecordMember($memberArr);
        }
        // 保存比赛球队成员 end


        // 比赛完成的操作
        if ($isFinished == 1) {
            // 保存球队历史比赛对手信息
            // 查询有无原数据
            $mapHistoryTeam = [
                'team_id' => $homeTeamId,
                'opponent_team_id' => $awayTeamId
            ];
            $historyTeam = $matchS->getHistoryTeam($mapHistoryTeam);
            // 插入新数据
            if (!$historyTeam) {
                $dataHistoryTeam = [
                    'team_id' => $homeTeamId,
                    'team' => $dataMatchRecord['home_team'],
                    'opponent_team_id' => $awayTeamId,
                    'opponent_team' => $dataMatchRecord['away_team'],
                    'match_num' => 1
                ];
            } else {
                // 更新原数据 比赛次数+1
                $dataHistoryTeam['id'] = $historyTeam['id'];
                $dataHistoryTeam['match_num'] = $historyTeam['match_num'] + 1;
            }
            $matchS->saveHistoryTeam($dataHistoryTeam);
            // 保存球队历史比赛对手信息 end

            // 记录裁判出勤
            $matchS->saveMatchReferee([
                'is_attend' => 2
            ], [
                'match_id' => $matchId,
                'match_record_id' => $matchRecordId,
                'status' => 1
            ]);
        }
        // 比赛完成的操作 end
        return json($res);
    }

    // 发送球队比赛认领信息给球队
    public function sendteamclaimfinishmatch()
    {
        try {
            $param = input('param.');
            // 验证必传参数
            if (!isset($param['match_id'])) {
                return json(['code' => 100, 'msg' => __lang('MSG_402') . ',请选择比赛id']);
            }
            if (!isset($param['id'])) {
                return json(['code' => 100, 'msg' => __lang('MSG_402') . ',请选择比赛战绩id']);
            }
            $matchS = new MatchService();
            $messageS = new MessageService();
            // 获取相关比赛数据
            $matchInfo = $matchS->getMatch(['id' => $param['match_id']]);
            if (!$matchInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404') . ',无此比赛信息']);
            }
            $matchRecordInfo = $matchS->getMatchRecord(['id' => $param['id'], 'match_id' => $param['match_id']]);
            if (!$matchRecordInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404') . ',无此比赛战绩信息']);
            }
            // 检查比赛是否已完成
            if ($matchInfo['is_finished_num'] != 1) {
                return json(['code' => 100, 'msg' => '该比赛未完成']);
            }

            $winTeam = ($matchRecordInfo['win_team_id'] == $matchRecordInfo['home_team_id']) ? $matchRecordInfo['home_team'] : $matchRecordInfo['away_team'];
            // 发送比赛完成信息给对方球队
            $messageData = [
                'title' => '您的球队“' . $matchRecordInfo['away_team'] . '”有一场比赛已完成',
                'content' => '您的球队 ' . $matchRecordInfo['away_team'] . ' 与球队 ' . $matchRecordInfo['home_team'] . ' 比赛已完成，请认领比赛数据',
                'keyword1' => $matchRecordInfo['home_team'] . ' VS ' . $matchRecordInfo['away_team'],
                'keyword2' => $matchRecordInfo['home_score'] . '：' . $matchRecordInfo['away_score'],
                'keyword3' => $winTeam,
                'remark' => '点击进入查看详情',
                'url' => url('keeper/team/claimfinishedmatch', ['match_id' => $matchInfo['id'], 'team_id' => $matchRecordInfo['away_team_id']], '', true),
                'steward_type' => 2
            ];
            $memberId = db('team')->where('id', $matchRecordInfo['away_team_id'])->value('member_id');
            $messageS->sendMessageToMember($memberId, $messageData, config('wxTemplateID.matchResult'));
            return json(['code' => 200, 'msg' => __lang('MSG_200')]);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 比赛列表（分页）
    public function matchlistpage()
    {
        try {
            // 传递参数作为查询条件
            $map = input('param.');
            // 如果有传入年份 查询条件 create_time在区间内
            if (input('?year')) {
                $year = input('year');
                if (is_numeric($year)) {
                    $tInterval = getStartAndEndUnixTimestamp($year);
                    $map['create_time'] = ['between', [$tInterval['start'], $tInterval['end']]];
                }
                unset($map['year']);
            }
            // 传入比赛未来时间选择 1：7天/2：15天/3：30天
            if (input('?choice_time')) {
                $choiceTime = input('choice_time');
                // 生成未来时间戳
                if (!empty($choiceTime)) {
                    switch ($choiceTime) {
                        case 1:
                            {
                                $dateTimeStamp = strtotime("+7 days");
                                break;
                            }
                        case 2:
                            {
                                $dateTimeStamp = strtotime("+15 days");
                                break;
                            }
                        case 3:
                            {
                                $dateTimeStamp = strtotime("+30 days");
                                break;
                            }
                    }
                    //dump($dateTimeStamp);
                    // match_time区间 查询条件组合:当前时间至所选未来时间
                    $endDate = getStartAndEndUnixTimestamp(date('Y', $dateTimeStamp), date('m', $dateTimeStamp), date('d', $dateTimeStamp));
                    //dump($endDate);
                    $map['match_time'] = ['between', [time(), $endDate['end']]];
                }
                unset($map['choice_time']);
            }

            // 关键字搜索：发布比赛的球队名(team)
            $keyword = input('keyword');
            if (input('?param.keyword')) {
                unset($map['keyword']);
                // 关键字内容
                if ($keyword != null) {
                    if (!empty($keyword) || !ctype_space($keyword)) {
                        $map['team'] = ['like', "%$keyword%"];
                    }
                }
            }
            // 关键字null情况处理
            if ($keyword == null) {
                unset($map['keyword']);
            }

            // 默认地区为空
            if (input('?param.area')) {
                if (empty($map['area'])) {
                    unset($map['area']);
                }
            }

            if (input('?param.page')) {
                unset($map['page']);
            }
            // 组合查询条件 end

            $matchS = new MatchService();
            $teamS = new TeamService();
            $result = $matchS->matchListPaginator($map);
            if ($result) {
                // 获取比赛发布球队信息
                if (!empty($result['data'])) {
                    foreach ($result['data'] as $k => $val) {
                        $matchCreateTeam = $teamS->getTeam(['id' => $val['team_id']]);
                        if ($matchCreateTeam) {
                            $result['data'][$k]['team'] = $matchCreateTeam;
                        }
                    }
                }

                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 比赛列表+年份
    public function matchlist()
    {
        try {
            // 传递参数作为查询条件
            $map = input('param.');
            $page = input('page', 1);
            // 如果有传入年份 查询条件 create_time在区间内
            if (input('?year')) {
                $year = input('year');
                if (is_numeric($year)) {
                    $tInterval = getStartAndEndUnixTimestamp($year);
                    $map['create_time'] = ['between', [$tInterval['start'], $tInterval['end']]];
                }
                unset($map['year']);
            }
            // 传入比赛未来时间选择 1：7天/2：15天/3：30天
            // 传入比赛未来时间选择 1：7天/2：15天/3：30天
            if (input('?choice_time')) {
                $choiceTime = input('choice_time');
                // 生成未来时间戳
                if (!empty($choiceTime)) {
                    switch ($choiceTime) {
                        case 1:
                            {
                                $dateTimeStamp = strtotime("+7 days");
                                break;
                            }
                        case 2:
                            {
                                $dateTimeStamp = strtotime("+15 days");
                                break;
                            }
                        case 3:
                            {
                                $dateTimeStamp = strtotime("+30 days");
                                break;
                            }
                    }
                    //dump($dateTimeStamp);
                    // match_time区间 查询条件组合:当前时间至所选未来时间
                    $endDate = getStartAndEndUnixTimestamp(date('Y', $dateTimeStamp), date('m', $dateTimeStamp), date('d', $dateTimeStamp));
                    //dump($endDate);
                    $map['match_time'] = ['between', [time(), $endDate['end']]];
                }
                unset($map['choice_time']);
            }

            // 关键字搜索：发布比赛的球队名(team)
            $keyword = input('keyword');
            if (isset($keyword)) {
                // 关键字null情况处理
                if ($keyword == null) {
                    unset($map['keyword']);
                } else {
                    if (!empty($keyword)) {
                        if (!ctype_space($keyword)) {
                            $map['team'] = ['like', "%$keyword%"];
                        }
                    }
                }
                unset($map['keyword']);
            }

            // 默认地区为空
            if (input('?param.area')) {
                if (empty($map['area'])) {
                    unset($map['area']);
                }
            }

            if (input('?param.page')) {
                unset($map['page']);
            }
            // 组合查询条件 end

            $matchS = new MatchService();
            $teamS = new TeamService();
            $result = $matchS->matchList($map, $page);
            if ($result) {
                // 获取比赛发布球队信息
                if (!empty($result)) {
                    foreach ($result as $k => $val) {
                        $matchCreateTeam = $teamS->getTeam(['id' => $val['team_id']]);
                        if ($matchCreateTeam) {
                            $result[$k]['team'] = $matchCreateTeam;
                        }
                    }
                }

                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 比赛列表（所有数据）
    public function matchlistall()
    {
        try {
            // 传递参数作为查询条件
            $map = input('param.');
            $matchS = new MatchService();
            $result = $matchS->matchListAll($map);
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 比赛列表（含有比赛战绩、参赛球员）
    public function matchpagewithrecord() {
        try {
            $data = input('param.');
            $matchS = new MatchService();
            // 查询条件
            // 关键字搜索：发布比赛的球队名(team)
            $keyword = input('keyword');
            if (isset($keyword)) {
                // 关键字null情况处理
                if ($keyword == null) {
                    unset($data['keyword']);
                } else {
                    if (!empty($keyword)) {
                        if (!ctype_space($keyword)) {
                            $data['team'] = ['like', "%$keyword%"];
                        }
                    }
                }
                unset($data['keyword']);
            }
            if (input('?param.page')) {
                unset($data['page']);
            }
            // 查询条件 end

            // 比赛信息列表分页
            $result = $matchS->matchListPaginator($data);
            if (!$result) {
                // 无数据
                return json(['code' => 100, 'msg' => __lang('MSG_401')]);
            }
            foreach ($result['data'] as $k => $val) {
                // 获取比赛战绩数据
                $matchRecord = $matchS->getMatchRecord(['match_id' => $val['id']]);
                $result['data'][$k]['record'] = ($matchRecord) ? $matchRecord : [];
                // 获取参赛球员列表
                $matchRecordMembers = $matchS->getMatchRecordMemberListAll(['match_id' => $val['id'], 'match_record_id' => $matchRecord['id']]);
                $result['data'][$k]['record_members'] = ($matchRecordMembers) ? $matchRecordMembers : [];
            }
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队认领比赛列表（分页）
    public function teamclaimfinishmatchpage()
    {
        try {
            // 传入变量作为查询条件
            $map = input('param.');
            // 查询条件组合
            // 有传入查询年份
            if (input('?param.year')) {
                $year = input('param.year');
                $tInterval = getStartAndEndUnixTimestamp($year);
                $map['match_record.match_time'] = ['between', [$tInterval['start'], $tInterval['end']]];
                unset($map['year']);
            }
            // 传入球队team_id 组合复合查询 查询作为主队或客队
            if (input('?param.team_id')) {
                $team_id = input('param.team_id');
                $map['match_record.away_team_id'] = $team_id;
                unset($map['team_id']);
            }
            // 比赛已完成
            $map['match.is_finished'] = 1;
            $map['match_record.claim_team_id'] = 0;
            // 查询条件组合end
            if (input('?param.page')) {
                unset($map['page']);
            }

            // 获取数据列表
            $matchS = new MatchService();
            $result = $matchS->matchRecordListPaginator($map);
            // 返回结果
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队认领比赛列表
    public function teamclaimfinishmatchlist()
    {
        try {
            // 传入变量作为查询条件
            $map = input('param.');
            $page = input('page', 1);
            // 查询条件组合
            // 有传入查询年份
            if (input('?param.year')) {
                $year = input('param.year');
                //if (is_numeric($year)) {
                $tInterval = getStartAndEndUnixTimestamp($year);
                $map['match_record.match_time'] = ['between', [$tInterval['start'], $tInterval['end']]];
                //}
                unset($map['year']);
            }
            // 传入球队team_id 组合复合查询 查询作为主队或客队
            if (input('?param.team_id')) {
                $team_id = input('param.team_id');
                $map['match_record.away_team_id'] = $team_id;
                unset($map['team_id']);
            }
            // 比赛已完成
            $map['match.is_finished'] = 1;
            $map['match_record.claim_team_id'] = 0;
            // 查询条件组合end
            if (input('?param.page')) {
                unset($map['page']);
            }

            // 获取数据列表
            $matchS = new MatchService();
            $result = $matchS->matchRecordList($map, $page);
            // 返回结果
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 认领比赛数据提交
    public function claimfinishmatch()
    {
        try {
            $post = input('post.');
            $recordData = $post['record'];
            // 验证提交参数
            if (!$post['id']) {
                return json(['code' => 100, 'msg' => __lang('MSG_402') . '，缺少比赛id']);
            }
            if (!$post['record']['id']) {
                return json(['code' => 100, 'msg' => __lang('MSG_402') . '，缺少比赛战绩id']);
            }
            // service
            $matchS = new MatchService();
            $teamS = new TeamService();
            // 获取认领的比赛数据、比赛战绩数据
            $match_id = $post['id'];
            $match = $matchS->getMatch(['id' => $match_id]);
            $matchRecord = $matchS->getMatchRecord(['match_id' => $match['id'], 'id' => $post['record']['id']]);
            if (!$match) {
                return json(['code' => 100, 'msg' => __lang('MSG_404') . '请选择其他比赛']);
            }
            if (!$matchRecord) {
                return json(['code' => 100, 'msg' => __lang('MSG_404') . '请选择其他比赛']);
            }
            // 检测会员登录
            if ($this->memberInfo['id'] === 0) {
                return json(['code' => 100, 'msg' => '请先登录或者注册平台会员']);
            }
            // 保存比赛球队成员
            // 保留显示的成员名单（status=1 报名is_apply=1 、出席is_attend=1）
            if (isset($post['HomeMemberData']) && $post['HomeMemberData'] != "[]") {
                $homeMember = json_decode($post['HomeMemberData'], true);
                $dataUpdateTeamMember = [];
                foreach ($homeMember as $k => $member) {
                    // 提交有match_record_member的id主键
                    // 查询球员有无对应比赛match_record_member记录
                    $matchRecordMember = $matchS->getMatchRecordMember(['match_id' => $match['id'], 'match_record_id' => $matchRecord['id'], 'member_id' => $member['member_id'], 'team_member_id' => $member['tmid']]);
                    if ($matchRecordMember) {
                        // 更新match_record_member
                        $homeMember[$k]['id'] = $matchRecordMember['id'];
                    }
                    // 获取球队成员数据
                    $teamMember = $teamS->getTeamMemberInfo(['id' => $member['tmid']]);
                    $homeMember[$k]['match_id'] = $match['id'];
                    $homeMember[$k]['match'] = $match['name'];
                    $homeMember[$k]['team_id'] = $matchRecord['home_team_id'];
                    $homeMember[$k]['team'] = $matchRecord['home_team'];
                    $homeMember[$k]['team_member_id'] = ($teamMember) ? $teamMember['id'] : -1;
                    $homeMember[$k]['match_record_id'] = $matchRecord['id'];
                    $homeMember[$k]['avatar'] = ($teamMember['member_id'] > 0) ? $teamMember['avatar'] : config('default_image.member_avatar');
                    $homeMember[$k]['contact_tel'] = $teamMember['telephone'];
                    $homeMember[$k]['status'] = 1;
                    $homeMember[$k]['is_checkin'] = 1;
                    $homeMember[$k]['is_attend'] = 1;

                    // 批量更新team_member 比赛数match_num
                    if ($matchRecordMember['is_checkin'] == 1) {
                        if ($teamMember) {
                            $dataUpdateTeamMember[$k]['id'] = $teamMember['id'];
                            $dataUpdateTeamMember[$k]['match_num'] = $teamMember['match_num'] + 1;
                        }
                    }
                }
                // 批量保存match_record_member
                $saveHomeTeamMemberRes = $matchS->saveAllMatchRecordMember($homeMember);
                $teamS->saveAllTeamMember($dataUpdateTeamMember);
            }
            // 剔除不显示的成员名单（无效 status=-1）
            if (isset($post['HomeMemberDataDel']) && $post['HomeMemberDataDel'] != "[]") {
                $memberArr = json_decode($post['HomeMemberDataDel'], true);
                foreach ($memberArr as $k => $member) {
                    // 提交有match_record_member的id主键
                    // 查询球员有无对应比赛match_record_member记录
                    if (isset($member['id'])) {
                        $matchRecordMember2 = $matchS->getMatchRecordMember(['id' => $member['id']]);
                    } else {
                        $matchRecordMember2 = $matchS->getMatchRecordMember(['match_id' => $match['id'], 'match_record_id' => $matchRecord['id'], 'member_id' => $member['member_id'], 'member|name' => $member['name']]);
                    }
                    if ($matchRecordMember2) {
                        // 更新match_record_member
                        $homeMember[$k]['id'] = $matchRecordMember2['id'];
                    }
                    $memberArr[$k]['match'] = $match['name'];
                    $memberArr[$k]['status'] = -1;
                    $memberArr[$k]['is_checkin'] = -1;
                }
                $resultsaveMatchRecordMember2 = $matchS->saveAllMatchRecordMember($memberArr);
            }
            // 保存比赛球队成员 end
            // 相册不为空保存数据
            if (isset($post['album']) && $post['album'] != "[]") {
                $recordData['album'] = $post['album'];
            }
            // 保存match_record数据
            $recordData['claim_status'] = 1;
            $resultSaveMatchRecord = $matchS->saveMatchRecord($recordData);
            if ($resultSaveMatchRecord['code'] == 200) {
                // 更新被认领比赛战绩 认领状态claim_status=1
                if ($post['claim_record_id']) {
                    db('match_record')->where('id', $post['claim_record_id'])->update(['claim_status' => 1]);
                }
                // 球队积分数据 胜队积2分，输队积1分
                $dataWinTeamRank = [
                    'match_id' => $match['id'],
                    'match' => $match['name'],
                    'match_type' => $match['type_num'],
                    'match_record_id' => $matchRecord['id'],
                    'team_id' => $matchRecord['win_team_id'],
                    'team' => db('team')->where('id', $matchRecord['win_team_id'])->value('name'),
                    'score' => 2
                ];
                $dataLoseTeamRank = [
                    'match_id' => $match['id'],
                    'match' => $match['name'],
                    'match_type' => $match['type_num'],
                    'match_record_id' => $matchRecord['id'],
                    'team_id' => $matchRecord['lose_team_id'],
                    'team' => db('team')->where('id', $matchRecord['lose_team_id'])->value('name'),
                    'score' => 1
                ];
                $teamS->saveTeamRank($dataWinTeamRank, ['match_id' => $match['id'], 'match_record_id' => $matchRecord['id'], 'team_id' => $matchRecord['win_team_id']]);
                $teamS->saveTeamRank($dataLoseTeamRank, ['match_id' => $match['id'], 'match_record_id' => $matchRecord['id'], 'team_id' => $matchRecord['lose_team_id']]);
            }
            return json($resultSaveMatchRecord);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 比赛管理操作
    public function removematch()
    {
        try {
            // 接收参数
            $id = input('post.match_id');
            $action = input('post.action');
            if (!$id || !$action) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            $matchS = new MatchService();
            $refereeS = new RefereeService();
            $messageS = new MessageService();
            // 获取比赛信息
            $match = $matchS->getMatch(['id' => $id]);
            if (!$match) {
                return json(['code' => 100, 'msg' => __lang('MSG_404') . '，没有此比赛信息']);
            }

            // 根据比赛当前状态(1上架,-1下架)+不允许操作条件
            // 根据action参数 editstatus执行上下架/del删除操作
            // 更新数据 返回结果
            if ($action == 'editstatus') {
                // 改变比赛状态
                $statusTo = ($match['status_num'] == 1) ? -1 : 1;
                $resUpdateMatchStatus = $matchS->saveMatch([
                    'id' => $match['id'],
                    'status' => $statusTo
                ], 'status');
                return json($resUpdateMatchStatus);
            } else {
                // 删除比赛信息
                if ($match['is_finished_num'] == 1) {
                    return json(['code' => 100, 'msg' => __lang('MSG_400') . '，此比赛已完成不能删除']);
                }
                $delRes = $matchS->deleteMatch($match['id']);
                if ($delRes) {
                    $response = ['code' => 200, 'msg' => __lang('MSG_200')];
                    // 获取比赛相关裁判申请|邀请记录（非拒绝记录）
                    $matchRefereeApplyList = $matchS->getMatchRefereeApplyList([
                        'match_id' => $match['id'],
                        'status' => ['neq', 3]
                    ]);
                    // 发送比赛取消消息给裁判
                    if (!empty($matchRefereeApplyList)) {
                        $delAllMatchRefereeApply = [];
                        foreach ($matchRefereeApplyList as $k => $val) {
                            $refereeInfo = $refereeS->getRefereeInfo(['id' => $val['referee_id']]);
                            $title = $applyStr = '';
                            if ($val['apply_type'] == 2) {
                                $title = '您申请执裁：';
                                $applyStr = '申请';
                            } else {
                                $title = '您申请执裁：';
                                $applyStr = '邀请';
                            }
                            $title = $title . $match['name'] . ' 比赛已取消';
                            $messageData = [
                                'title' => $title,
                                'content' => $title,
                                'url' => url('keeper/match/leaguelist', '', '', true),
                                'keyword1' => '比赛已取消',
                                'keyword2' => '撤销比赛' . $applyStr,
                                'keyword3' => date('Ymd H:i', time()),
                                'remark' => '点击进入查看其它比赛信息',
                                'steward_type' => 2
                            ];
                            $messageS->sendMessageToMember($refereeInfo['member_id'], $messageData, config('wxTemplateID.informationChange'));
                            $delAllMatchRefereeApply[$k] = [
                                'id' => $val['id'],
                                'delete_time' => time()
                            ];
                        }
                        $matchS->saveAllMatchRerfereeApply($delAllMatchRefereeApply);
                    }
                    // match_referee比赛裁判表相关数据 软删除
                    db('match_referee')->where('match_id', $match['id'])->update(['delete_time' => time()]);
                    // match_record比赛战绩表相关数据 软删除
                    db('match_record')->where('match_id', $match['id'])->update(['delete_time' => time()]);
                } else {
                    $response = ['code' => 100, 'msg' => __lang('MSG_400')];
                }
                return json($response);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队成员报名参加比赛
    public function joinmatch()
    {
        try {
            // 接收输入变量
            $id = input('match_id');
            $matchS = new MatchService();
            $teamS = new TeamService();
            $matchRecord = $matchS->getMatchRecord(['id' => $id]);
            // 查询比赛match数据
            $match = $matchS->getMatch(['id' => $matchRecord['match_id']]);
            if (!$match) {
                return json(['code' => 100, 'msg' => __lang('MSG_404') . '，请选择其他比赛']);
            }
            if ($match['is_finished_num'] == 1) {
                return json(['code' => 100, 'msg' => '此比赛' . $match['is_finished'] . '，请选择其他比赛']);
            }
            if ($matchRecord) {
                $match['record'] = $matchRecord;
            }

            // 查询会员有无在比赛的相关球队
            $inHomeTeam = 0;
            $inAwayTeam = 0;
            if ($match['record']['home_team_id']) {
                $whereMemberInHomeTeam = [
                    'team_id' => $match['record']['home_team_id'],
                    'member_id' => $this->memberInfo['id'],
                    'status' => 1
                ];
                $inHomeTeam = $teamS->getTeamMemberInfo($whereMemberInHomeTeam);
            }
            if ($match['record']['away_team_id']) {
                $whereMemberInAwayTeam = [
                    'team_id' => $match['record']['away_team_id'],
                    'member_id' => $this->memberInfo['id'],
                    'status' => 1
                ];
                $inAwayTeam = $teamS->getTeamMemberInfo($whereMemberInAwayTeam);
            }
            if (!$inHomeTeam && !$inAwayTeam) {
                return json(['code' => 100, 'msg' => '您不是此比赛的球队成员，请选择其他比赛或加入球队']);
            }

            // 检查是否已有match_record_member数据
            $hasJoinMatchMap = [
                'match_id' => $match['id'],
                'member_id' => $this->memberInfo['id']
            ];
            $hasJoinMatch = $matchS->getMatchRecordMember($hasJoinMatchMap);
            if ($hasJoinMatch) {
                return json(['code' => 100, 'msg' => '您已报名参加此比赛，无需再次报名']);
            }

            // 组合保存报名比赛信息
            $dataRecordMember = [
                'match_id' => $match['id'],
                'match' => $match['name'],
                'match_record_id' => $match['record']['id'],
                'status' => 1,
                'is_apply' => 1
            ];
            if ($inHomeTeam) {
                $dataRecordMember['team_id'] = $inHomeTeam['team_id'];
                $dataRecordMember['team'] = $inHomeTeam['team'];
                $dataRecordMember['member_id'] = $inHomeTeam['member_id'];
                $dataRecordMember['member'] = $inHomeTeam['member'];
                $dataRecordMember['name'] = $inHomeTeam['name'];
                $dataRecordMember['team_member_id'] = $inHomeTeam['id'];
                $dataRecordMember['avatar'] = $inHomeTeam['avatar'];
                $dataRecordMember['contact_tel'] = $inHomeTeam['telephone'];
                if ($inHomeTeam['student_id']) {
                    $dataRecordMember['student_id'] = $inHomeTeam['student_id'];
                    $dataRecordMember['student'] = $inHomeTeam['student'];
                }
            } elseif ($inAwayTeam) {
                $dataRecordMember['team_id'] = $inAwayTeam['team_id'];
                $dataRecordMember['team'] = $inAwayTeam['team'];
                $dataRecordMember['member_id'] = $inAwayTeam['member_id'];
                $dataRecordMember['member'] = $inAwayTeam['member'];
                $dataRecordMember['name'] = $inAwayTeam['name'];
                $dataRecordMember['team_member_id'] = $inAwayTeam['id'];
                $dataRecordMember['avatar'] = $inAwayTeam['avatar'];
                $dataRecordMember['contact_tel'] = $inAwayTeam['telephone'];
                if ($inAwayTeam['student_id']) {
                    $dataRecordMember['student_id'] = $inAwayTeam['student_id'];
                    $dataRecordMember['student'] = $inAwayTeam['student'];
                }
            }
//                dump($dataRecordMember);
            // 保存报名比赛信息数据
            $result = $matchS->saveMatchRecordMember($dataRecordMember);
            return json($result);

        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 历史对手球队列表（页码）
    public function historyteampage()
    {
        try {
            // 传递参数作为查询条件
            $map = input('param.');
            // 关键字搜索：对手球队名 opponent_team
            if (input('?keyword')) {
                $keyword = input('keyword');
                // 关键字内容
                if (!empty($keyword) && !ctype_space($keyword)) {
                    $map['opponent_team'] = ['like', "%$keyword%"];
                }
                unset($map['keyword']);
            }
            // 剔除map[page]
            if (input('?param.page')) {
                unset($map['page']);
            }
            $matchS = new MatchService();
            // 获取历史对手球队分页数据
            $result = $matchS->getHistoryTeamPaginator($map);
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            // 返回结果
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 历史对手球队列表
    public function historyteamlist()
    {
        try {
            // 传递参数作为查询条件
            $map = input('param.');
            $page = input('page', 1);
            // 关键字搜索：对手球队名 opponent_team
            if (input('?keyword')) {
                $keyword = input('keyword');
                // 关键字内容
                if (!empty($keyword) && !ctype_space($keyword)) {
                    $map['opponent_team'] = ['like', "%$keyword%"];
                }
                unset($map['keyword']);
            }
            // 剔除map[page]
            if (input('?param.page')) {
                unset($map['page']);
            }
            $matchS = new MatchService();
            // 获取历史对手球队列表数据
            $result = $matchS->getHistoryTeamList($map, $page);
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            // 返回结果
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 历史对手球队列表（所有数据）
    public function historyteamall()
    {
        try {
            // 传递参数作为查询条件
            $map = input('param.');
            $matchS = new MatchService();
            // 获取历史对手球队列表所有数据
            $result = $matchS->getHistoryTeamAll($map);
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            // 返回结果
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 比赛球队列表（页码）
    public function matchteamlistpage()
    {
        try {

        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 比赛球队列表

    // 比赛球队列表（所有数据）

    // 比赛战绩列表（页码）+年份
    public function matchrecordlistpage()
    {
        try {
            // 传入变量作为查询条件
            $map = input('param.');
            // 有传入查询年份
            if (input('?param.year')) {
                $year = input('param.year');
                //if (is_numeric($year)) {
                $tInterval = getStartAndEndUnixTimestamp($year);
                $map['match_record.match_time'] = ['between', [$tInterval['start'], $tInterval['end']]];
                //}
                unset($map['year']);
            }
            // 传入球队team_id 组合复合查询 查询作为主队或客队
            if (input('?param.team_id')) {
                $team_id = input('param.team_id');
                $map['match_record.home_team_id|match_record.away_team_id'] = $team_id;
                $map['match_record.team_id'] = $team_id;
                unset($map['team_id']);
            }
            if (input('?param.page')) {
                unset($map['page']);
            }
            // 获取数据列表
            $matchS = new MatchService();
            $result = $matchS->matchRecordListPaginator($map);
            // 返回结果
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 比赛战绩列表+年份
    public function matchrecordlist()
    {
        try {
            // 传入变量作为查询条件
            $map = input('param.');
            $page = input('page', 1);
            // 有传入查询年份
            if (input('?year')) {
                $year = input('year');
                if (is_numeric($year)) {
                    $tInterval = getStartAndEndUnixTimestamp($year);
                    $map['match_record.match_time'] = ['between', [$tInterval['start'], $tInterval['end']]];
                }
                unset($map['year']);
            }
            // 传入球队team_id 组合复合查询 查询作为主队或客队
            if (input('?param.team_id')) {
                $team_id = input('param.team_id');
                $map['match_record.home_team_id|match_record.away_team_id'] = $team_id;
                $map['match_record.team_id'] = $team_id;
                unset($map['team_id']);
            }
            if (input('?param.page')) {
                unset($map['page']);
            }
            // 获取数据列表
            $matchS = new MatchService();
            $result = $matchS->matchRecordList($map, $page);
            // 返回结果
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 比赛战绩列表（所有数据）
    public function matchrecordlistall()
    {
        try {
            // 传入变量作为查询条件
            $map = input('param.');
            // 获取数据列表
            $matchS = new MatchService();
            // 传入球队team_id 组合复合查询 查询作为主队或客队
            if (input('?param.team_id')) {
                $team_id = input('param.team_id');
                $map['match_record.home_team_id|match_record.away_team_id'] = $team_id;
                $map['match_record.team_id'] = $team_id;
                unset($map['team_id']);
            }
            $result = $matchS->matchRecordListAll($map);
            // 返回结果
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 比赛战绩-会员关联列表（页码）
    public function recordmemberpage()
    {
        try {
            // 传入变量作为查询条件
            $map = input('param.');
            if (input('?param.page')) {
                unset($map['page']);
            }
            // 获取数据列表
            $matchS = new MatchService();
            $result = $matchS->getMatchRecordMemberListPaginator($map);
            // 返回结果
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 比赛战绩-会员关联列表
    public function recordmemberlist()
    {
        try {
            // 传入变量作为查询条件
            $map = input('param.');
            $page = input('page', 1);
            if (input('?param.page')) {
                unset($map['page']);
            }
            // 获取数据列表
            $matchS = new MatchService();
            $result = $matchS->getMatchRecordMemberList($map, $page);
            // 返回结果
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 比赛战绩-会员关联列表（所有数据）
    public function recordmemberall()
    {
        try {
            // 传入变量作为查询条件
            $map = input('param.');
            // 获取数据列表
            $matchS = new MatchService();
            $result = $matchS->getMatchRecordMemberListAll($map);
            // 返回结果
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队参加比赛申请
    public function joinmatchapply()
    {
        try {
            // 输入变量
            $request = input('post.');
            $matchS = new MatchService();
            $teamS = new TeamService();
            $messageS = new MessageService();
            // 输入变量必须要有的字段
            if (!isset($request['match_id'])) {
                return json(['code' => 100, 'msg' => '请选择比赛']);
            }
            if (!isset($request['team_id'])) {
                return json(['code' => 100, 'msg' => '请选择球队']);
            }
            // 检查比赛的信息
            $matchInfo = $matchS->getMatch(['id' => $request['match_id']]);
            if (!$matchInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404') . '请选择其他比赛']);
            }
            if ($matchInfo['is_finished_num'] == 1) {
                return json(['code' => 100, 'msg' => '此比赛' . $matchInfo['is_finished'] . '请选择其他比赛']);
            }
            if ($matchInfo['apply_status_num'] > 0) {
                return json(['code' => 100, 'msg' => '此比赛' . $matchInfo['apply_status'] . '请选择其他比赛']);
            }
            // 发布比赛的球队不能应战
            if ($matchInfo['team_id'] == $request['team_id']) {
                return json(['code' => 100, 'msg' => '您提交的球队是发布比赛的球队，不能应战']);
            }
            //dump($matchInfo);

            // 补充提交数据字段
            $request['member_id'] = $this->memberInfo['id'];
            $request['member'] = $this->memberInfo['member'];
            $request['member_avatar'] = $this->memberInfo['avatar'];
            $request['revice_team_id'] = $matchInfo['team_id'];
            $request['revice_team'] = $matchInfo['team'];
            // 查询有无比赛约战申请记录
            $matchApply = $matchS->getMatchApply([
                'team_id' => $request['team_id'],
                'match_id' => $request['match_id'],
                'revice_team_id' => $matchInfo['team_id']
            ]);
            if ($matchApply) {
                $request['id'] = $matchApply['id'];
            }

            // 保存球队参加比赛申请
            $resultJoinMatchApply = $matchS->saveMatchApply($request);
            if ($resultJoinMatchApply['code'] == 200) {
                $applyId = isset($matchApply) ? $matchApply['id'] : $resultJoinMatchApply['data'];
                // 更新比赛信息
                db('match')->where('id', $matchInfo['id'])->update(['apply_status' => 1]);
                // 获取比赛的发布球队信息
                $teamInfo = $teamS->getTeam(['id' => $matchInfo['team_id']]);
                // 组合推送消息内容
                $dataMessage = [
                    'title' => '您好，您发布的比赛有球队报名迎战',
                    'content' => '您所在球队' . $teamInfo['name'] . '发布的比赛' . $request['team'] . '报名迎战',
                    'url' => url('keeper/team/matchapplyinfo', ['team_id' => $teamInfo['id'], 'apply_id' => $applyId], '', true),
                    'keyword1' => '约战应战申请',
                    'keyword2' => $this->memberInfo['member'],
                    'keyword3' => date('Y-m-d h:i', time()),
                    'remark' => '请及时登录平台进入球队管理-》约战申请回复处理',
                    // 比赛发布球队id
                    'team_id' => $teamInfo['id'],
                    'steward_type' => 2
                ];
                // 推送消息给发布比赛的球队领队
                $messageS->sendMessageToMember($teamInfo['leader_id'], $dataMessage, config('wxTemplateID.checkPend'));
                // 保存球队公告
                $teamS->saveTeamMessage($dataMessage);
            }
            return json($resultJoinMatchApply);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 回复球队参加比赛申请
    public function replymatchapply()
    {
        try {
            // 输入变量
            $request = input('post.');
            $matchS = new MatchService();
            $teamS = new TeamService();
            $messageS = new MessageService();
            // 判断正确有无传参
            if (!isset($request['apply_id']) || !isset($request['status'])) {
                return json(['code' => 100, 'msg' => __lang('MSG_402') . '，请正确传参']);
            }
            $reply = $request['reply'];
            $status = $request['status'];
            if (!in_array($status, [2, 3])) {
                return json(['code' => 100, 'msg' => __lang('MSG_402') . '，请正确传参']);
            }
            // 查询match_apply数据
            $applyInfo = $matchS->getMatchApply(['id' => $request['apply_id']]);
            if (!$applyInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404') . '，没有此申请记录']);
            }
            /*if ($applyInfo['status'] != 1) {
                return json(['code' => 100, 'msg' => '此申请记录已回复结果，无需重复操作']);
            }*/
            // 获取match_apply的match信息
            $matchInfo = $matchS->getMatch(['id' => $applyInfo['match_id']]);
            //dump($matchInfo);
            // 回复结果字样
            $replystr = '已拒绝';
            // 更新match_apply数据组合
            $dataSaveApply = ['id' => $applyInfo['id'], 'status' => $status, 'reply' => $reply];
            if ($status == 2) {
                // 同意操作
                // 更新比赛战绩对手球队信息
                $matchRecordInfo = $matchS->getMatchRecord(['match_id' => $matchInfo['id']]);
                //dump($matchRecordInfo);
                // 获取对手球队信息
                $awayTeamInfo = $teamS->getTeam(['id' => $applyInfo['team_id']]);
                // match_name更新新内容
                $matchName = $matchRecordInfo['home_team'] . ' vs ' . $awayTeamInfo['name'];
                $resultSaveMatchRecord = $matchS->saveMatchRecord([
                    'id' => $matchRecordInfo['id'],
                    'match' => $matchName,
                    'away_team_id' => $awayTeamInfo['id'],
                    'away_team' => $awayTeamInfo['name'],
                    'away_team_logo' => $awayTeamInfo['logo']
                ]);
                if ($resultSaveMatchRecord['code'] == 100) {
                    return json(['code' => 100, 'msg' => '更新比赛对手信息失败，请重试']);
                }
                // 更新比赛match信息
                db('match')->where('id', $matchInfo['id'])->update([
                    'name' => $matchName,
                    'apply_status' => $status
                ]);

                // 组合推送消息内容
                $replystr = '已同意';
                $dataSaveApply['match'] = $matchName;
                // 同意操作 end
            }
            // 更新match_apply数据，post[reply]=2同意，3拒绝
            $applySaveResult = $matchS->saveMatchApply($dataSaveApply);
            // 更新match_apply数据成功 发送消息给申请人
            if ($applySaveResult['code'] == 200) {
                // 组合推送消息内容
                $dataMessage = [
                    'title' => '约战申请结果通知',
                    'content' => '球队' . $matchInfo['team'] . '发布的约战申请结果通知：' . $replystr,
                    'url' => url('keeper/message/index', '', '', true),
                    'keyword1' => '球队' . $matchInfo['team'] . '发布的约战申请结果',
                    'keyword2' => $replystr,
                    'remark' => '点击登录平台查看更多信息',
                    'team_id' => $applyInfo['team_id'],
                    'steward_type' => 2
                ];
                // 发送消息模板给申请人
                $messageS = new MessageService();
                $messageS->sendMessageToMember($applyInfo['member_id'], $dataMessage, config('wxTemplateID.applyResult'));
                // 球队公告
                $teamS->saveTeamMessage($dataMessage);
            }
            return json($applySaveResult);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队参加比赛申请列表分页
    public function matchapplypage()
    {
        try {
            // 传入变量作为查询条件
            $map = input('param.');
            // 发送申请|收到申请team_id
            if (input('?team_id')) {
                unset($map['team_id']);
                $map['team_id|revice_team_id'] = input('team_id');
            }
            if (input('?param.page')) {
                unset($map['page']);
            }
            // 获取数据列表
            $matchS = new MatchService();
            $result = $matchS->getMatchApplyPaginator($map);
            // 返回结果
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队参加比赛申请列表
    public function matchapplylist()
    {
        try {
            // 传入变量作为查询条件
            $map = input('param.');
            $page = input('page', 1);
            // 发送申请|收到申请team_id
            if (input('?team_id')) {
                unset($map['team_id']);
                $map['team_id|revice_team_id'] = input('team_id');
            }
            if (input('?param.page')) {
                unset($map['page']);
            }
            // 获取数据列表
            $matchS = new MatchService();
            $result = $matchS->getMatchApplyList($map, $page);
            // 返回结果
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }


    // 分页获取lat,lng最近数据（带分页,带页码）
    public function getMatchListOrderByDistanceApi()
    {
        try {

            $data = input('param.');
            $lat = input('param.lat', 22.52369);
            $lng = input('param.lng', 114.0261);
            $page = input('param.page', 1);
            $orderby = input('param.orderby', 'distance asc');
            // 传递参数作为查询条件
            $map = [];

            if (input('?province')) {
                $map['`match`.province'] = $data['province'];
            }
            if (input('?city')) {
                $map['`match`.city'] = $data['city'];
            }
            if ( input('?area') && !empty( input('area') ) ) {
                $map['`match`.area'] = $data['area'];
            }
            $map['`match`.islive'] = input('islive', -1);
            // 如果有传入年份 查询条件 create_time在区间内
            if (input('?year')) {
                $year = input('year');
                if (is_numeric($year)) {
                    $tInterval = getStartAndEndUnixTimestamp($year);
                    $map['`match`.create_time'] = ['between', [$tInterval['start'], $tInterval['end']]];
                }
            }
            // 传入比赛未来时间选择 1：7天/2：15天/3：30天
            if (input('?choice_time')) {
                $choiceTime = input('choice_time');
                // 生成未来时间戳
                if (!empty($choiceTime)) {
                    switch ($choiceTime) {
                        case 1:
                            {
                                $dateTimeStamp = strtotime("+7 days");
                                break;
                            }
                        case 2:
                            {
                                $dateTimeStamp = strtotime("+15 days");
                                break;
                            }
                        case 3:
                            {
                                $dateTimeStamp = strtotime("+30 days");
                                break;
                            }
                    }
                    //dump($dateTimeStamp);
                    // match_time区间 查询条件组合:当前时间至所选未来时间
                    $endDate = getStartAndEndUnixTimestamp(date('Y', $dateTimeStamp), date('m', $dateTimeStamp), date('d', $dateTimeStamp));
                    //dump($endDate);
                    $map['`match`.match_time'] = ['between', [time(), $endDate['end']]];
                }
            }

            // 关键字搜索：发布比赛的球队名(team)
            if (input('?param.keyword')) {
                // 关键字内容
                $keyword = input('keyword');
                if ($keyword != null) {
                    if (!empty($keyword) || !ctype_space($keyword)) {
                        $map['`match`.team'] = ['like', "%$keyword%"];
                    }
                }
            }
            // 传入训练营id
            if (input('?param.camp_id')) {
                $map['c.camp_id'] = input('camp_id');
            }

            $result = db('match')
                ->field("`match`.*,c.avg_height,c.logo,c.match_win,c.match_num,round(c.match_win/c.match_num) as sl,round(6378.138)*2*asin (sqrt(pow(sin(($lat *pi()/180 - `match`.court_lat*pi()/180)/2), 2)+cos($lat *pi()/180)*cos(`match`.court_lat*pi()/180)*pow(sin(($lng *pi()/180 - `match`.court_lng*pi()/180)/2),2))) as distance")
                ->join('__TEAM__ c', 'match.team_id = c.id')
                ->where($map)
                ->whereNull('match.delete_time')
                ->whereNull('c.delete_time')
                ->page($page)->order($orderby)->select();

            //echo  db('match')->getlastsql();exit();

            if ($result) {
                return json(['code' => 200, 'msg' => 'ok', 'data' => $result]);
            } else {
                return json(['code' => 100, 'msg' => 'ok']);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

}

