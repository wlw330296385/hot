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
        try {
            // 接收输入变量
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['member_avatar'] = $this->memberInfo['avatar'];
            $data['match_time'] = strtotime($data['match_time']);
            $data['referee_count'] = input('referee_count', 3, 'intval');
            $matchS = new MatchService();
            $teamS = new TeamService();
            $messageS = new MessageService();
            //记录比赛战绩数据
            $dataMatchRecord = [];
            $dataMatchRecord['team_id'] = $data['team_id'];
            $dataMatchRecord['match_time'] = $data['match_time'];
            // 主队信息保存数据组合
            if (!$data['team_id']) {
                return json(['code' => 100, 'msg' => __lang('MSG_402') . '请选择主队球队']);
            }
            $homeTeamId = $data['team_id'];
            $homeTeam = $teamS->getTeam(['id' => $homeTeamId]);
            //dump($homeTeam);
            $data['team'] = $homeTeam['name'];
            $dataHometeam = [
                'home_team_id' => $homeTeam['id'],
                'home_team' => $homeTeam['name'],
                'home_team_logo' => $homeTeam['logo'],
//                    'home_team_color' => $data['record']['home_team_color'],
//                    'home_team_colorstyle' => $data['record']['home_team_colorstyle']
            ];
            $dataMatchRecord = array_merge($dataMatchRecord, $dataHometeam);
            // 客队信息保存数据组合
            if (!empty($data['away_team_id'])) {
                if ($data['away_team_id'] == $data['team_id']) {
                    return json(['code' => 100, 'msg' => '请选择其他球队']);
                }

                $dataAwayteam = [
                    'away_team_id' => $data['away_team_id'],
                    'away_team' => $data['away_team'],
                    'away_team_logo' => $data['away_team_logo'],
                    //'away_team_color' => $data['away_team_color'],
                    //'away_team_colorstyle' => $data['away_team_colorstyle']
                ];
                $dataMatchRecord = array_merge($dataMatchRecord, $dataAwayteam);
                $data['name'] = $homeTeam['name'] . ' vs ' . $data['away_team'];

            } else {
                $data['name'] = $homeTeam['name'] . ' vs （待定）';
            }


            $res = $matchS->saveMatch($data);
            // 比赛记录创建成功后操作
            if ($res['code'] == 200) {
                $matchId = $res['data'];
                // 发送比赛邀请给对手球队
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
                        'title' => '您好，'.$data['team'] .'球队向您所在 '. $awayTeam['name'] .'球队发起约战',
                        'content' => '您好，'.$data['team'] .'球队向您所在 '. $awayTeam['name'] .'球队发起约战',
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
                
                // 记录比赛战绩数据
                $dataMatchRecord['match_id'] = $res['data'];
                $dataMatchRecord['match'] = $data['name'];
                $resMatchRecord = $matchS->saveMatchRecord($dataMatchRecord);
                $matchRecordId = $resMatchRecord['data'];

                // 裁判业务操作
                $refereeType = input('post.referee_type', 0);
                if ($refereeType) {
                    $this->setMatchRefereeType($refereeType, $data, $matchId, $matchRecordId);
                }
            }
            return json($res);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 根据提交的比赛信息所选裁判类型执行的业务
    protected function setMatchRefereeType($refereeType=0, $matchData=[], $matchId=0, $matchRecordId=0) {
        $refereeS = new RefereeService();
        $matchS = new MatchService();
        $messageS = new MessageService();
        // 组合接收信息member_id集合
        $memberIds = [];
        // 消息模板链接
        $linkurl = url('keeper/message/index', '', '', true);
        $daidingStr = '待定';
        $title = $content = '';
        if ($refereeType == 1) {
            // 选择随机安排 根据比赛信息 发送比赛裁判邀请给裁判人群
            // 获取符合条件裁判人群
            $map = [];
            if ($matchData['city']) {
                $map['city'] = $matchData['city'];
            }
            $map['status'] = 1;
            $map['accept_rand_match'] = 1;
            $refereeList = $refereeS->getRefereeAll($map);

            if ($refereeList) {
                foreach ($refereeList as $k => $referee) {
                    $memberIds[$k]['id'] = $referee['member_id'];
                }
            }
            $linkurl = url('keeper/team/matchInfo', ['match_id' => $matchId, 'team_id' => $matchData['team_id']], '', true);
            $title = '您好，您有一条新的系统指派比赛执裁订单，请注意查收';
            $content = '您好，您有一条新的系统指派比赛执裁订单，请注意查收';
        } elseif ($refereeType == 2) {
            // 自行安排安排
            $applyData = [];
            // 根据提交的裁判名单发送比赛裁判信息
            $refereeStr = $matchData['referee_str'];
            $refereeList = json_decode($refereeStr, true);
            if ($refereeList) {
                foreach ($refereeList as $k => $referee) {
                    $refereeInfo = $refereeS->getRefereeInfo(['id' => $referee['referee_id']]);
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
                }
            }
            // 保存比赛邀请裁判数据
            $matchS->saveAllMatchRerfereeApply($applyData);
            $linkurl = url('keeper/referee/matchapply', ['match_id' => $matchId], '', true);
            $title = '您有一条执裁比赛邀请信息';
            $content = '您好，有比赛邀请您执裁';
        }

        // 信息内容
        $daidingStr = '待定';
        $messageData = [
            'title' => $title,
            'content' => $content,
            'url' => $linkurl,
            'keyword1' => empty($matchData['match_time']) ? $daidingStr : date('Y年m月d日 H:i', $matchData['match_time']),
            'keyword2' => empty($matchData['court']) ? $daidingStr : $matchData['court'],
            'keyword3' => $matchData['name'],
            'remark' => '点击进入，查看比赛信息',
            'steward_type' => 2
        ];
        $messageS->sendMessageToMembers($memberIds, $messageData, config('wxTemplateID.refereeTask'));
    }

    // 创建球队比赛
    public function createteammatch() {
        try {
            // 接收输入变量
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['member_avatar'] = $this->memberInfo['avatar'];
            $data['match_time'] = strtotime($data['match_time']);
            $data['referee_count'] = input('referee_count', 3, 'intval');
            $matchS = new MatchService();
            $teamS = new TeamService();
            $messageS = new MessageService();
            //记录比赛战绩数据
            $dataMatchRecord = [];
            $dataMatchRecord['team_id'] = $data['team_id'];
            $dataMatchRecord['match_time'] = $data['match_time'];
            // 主队信息保存数据组合
            if (!$data['team_id']) {
                return json(['code' => 100, 'msg' => __lang('MSG_402') . '请选择主队球队']);
            }
            $homeTeamId = $data['team_id'];
            $homeTeam = $teamS->getTeam(['id' => $homeTeamId]);
            //dump($homeTeam);
            $data['team'] = $homeTeam['name'];
            $dataHometeam = [
                'home_team_id' => $homeTeam['id'],
                'home_team' => $homeTeam['name'],
                'home_team_logo' => $homeTeam['logo']
            ];
            $dataMatchRecord = array_merge($dataMatchRecord, $dataHometeam);
            // 客队信息保存数据组合
            if (!empty($data['away_team_id'])) {
                if ($data['away_team_id'] == $data['team_id']) {
                    return json(['code' => 100, 'msg' => '请选择其他球队']);
                }

                $dataAwayteam = [
                    'away_team_id' => $data['away_team_id'],
                    'away_team' => $data['away_team'],
                    'away_team_logo' => $data['away_team_logo'],
                ];
                $dataMatchRecord = array_merge($dataMatchRecord, $dataAwayteam);
                $data['name'] = $homeTeam['name'] . ' vs ' . $data['away_team'];

            } else {
                $data['name'] = $homeTeam['name'] . ' vs （待定）';
            }


            $res = $matchS->saveMatch($data);
            // 比赛记录创建成功后操作
            if ($res['code'] == 200) {
                $matchId = $res['data'];
                // 发送比赛邀请给对手球队
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
                        'title' => '您好，'.$data['team'] .'球队向您所在 '. $awayTeam['name'] .'球队发起约战',
                        'content' => '您好，'.$data['team'] .'球队向您所在 '. $awayTeam['name'] .'球队发起约战',
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

                // 记录比赛战绩数据
                $dataMatchRecord['match_id'] = $res['data'];
                $dataMatchRecord['match'] = $data['name'];
                $resMatchRecord = $matchS->saveMatchRecord($dataMatchRecord);
                $matchRecordId = $resMatchRecord['data'];

                // 裁判业务操作
                $refereeType = input('post.referee_type', 0);
                if ($refereeType) {
                    $this->setMatchRefereeType($refereeType, $data, $matchId, $matchRecordId);
                }
            }
            return json($res);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 更新球队比赛
    public function updateteammatch() {
        try {
            // 接收输入变量 其中post[record]为match_record保存数据
            $post = input('post.');
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
            $messageS = new MessageService();
            $refereeS = new RefereeService();
            // 获取当前比赛数据、比赛战绩数据
            $match_id = $post['id'];
            $match = $matchS->getMatch(['id' => $match_id]);
            $matchRecord = $matchS->getMatchRecord(['match_id' => $match['id']]);
            if (!$match) {
                return json(['code' => 100, 'msg' => __lang('MSG_404') . '请选择其他比赛']);
            }

            // post[match_time] 比赛时间转为时间戳格式
            $matchTimeStamp = strtotime($post['match_time']);
            // 比赛完成状态match is_finished标识
            $isFinished = 0;
            // 提取球队、比分变量
            $homeTeamId = $post['record']['home_team_id'];
            $homeScore = $post['record']['home_score'];
            $awayTeamId = $post['record']['away_team_id'];
            $awayScore = $post['record']['away_score'];
            // 提交is_finished=1 即比赛完成（match记录完成状态is_finished）
            if (isset($post['is_finished'])) {
                if ($post['is_finished'] == 1) {
                    if (empty($post['record']['away_team_id']) && empty($post['record']['away_team'])) {
                        return json(['code' => 100, 'msg' => '请填写客队信息']);
                    }
                    $isFinished = 1;
                    $post['finished_time'] = $matchTimeStamp;
                }
            }

            // 组合match_record保存数据
            $recordData = $post['record'];
            $recordData['match_time'] = $matchTimeStamp;
            // 相册不为空保存数据
            if (isset($post['album']) && $post['album'] != "[]") {
                $recordData['album'] = $post['album'];
            }
            // recordData[win_team_id]: 比赛胜利球队id
            if ($isFinished == 1) {
                if ($homeScore > 0 && $awayScore > 0) {
                    if ($homeScore >= $awayScore) {
                        $recordData['win_team_id'] = $recordData['home_team_id'];
                        $recordData['lose_team_id'] = $recordData['away_team_id'];
                    } else {
                        $recordData['win_team_id'] = $recordData['away_team_id'];
                        $recordData['lose_team_id'] = $recordData['home_team_id'];
                    }
                }
            }
            // 组合match_record保存数据 end
            // 组合match保存数据
            $dataMatch = $post;
            $dataMatch['match_time'] = $matchTimeStamp;
            // 更新比赛名称match_name 有选择对手队：当前球队名vs对手队名|无选择对手队：当前球队名友谊赛（对手待定）
            if (!empty($post['record']['away_team'])) {
                $matchName = $post['record']['home_team'] . ' vs ' . $post['record']['away_team'];
            } else {
                $matchName = $post['record']['home_team'] . ' vs （待定）';
            }
            $recordData['match'] = $matchName;
            $dataMatch['name'] = $matchName;
            if ($isFinished == 1) {
                $dataMatch['is_live'] = -1;
            }
            // 保存比赛球队成员
            // 保留显示的成员名单（status=1 报名is_apply=1 、出席is_attend=1）
            if (isset($post['HomeMemberData']) && $post['HomeMemberData'] != "[]") {
                $homeMember = json_decode($post['HomeMemberData'], true);
                $dataUpdateTeamMember = [];
                foreach ($homeMember as $k => $member) {
                    // 查询球员有无对应比赛match_record_member记录
                    $matchRecordMember = $matchS->getMatchRecordMember(['match_id' => $match['id'], 'match_record_id' => $recordData['id'], 'member_id' => $member['member_id'], 'team_member_id' => $member['tmid']]);
                    if ($matchRecordMember) {
                        // 更新match_record_member
                        $homeMember[$k]['id'] = $matchRecordMember['id'];
                    }
                    // 获取球队成员数据
                    $teamMember = $teamS->getTeamMemberInfo(['id' => $member['tmid']]);
                    $homeMember[$k]['match_id'] = $match['id'];
                    $homeMember[$k]['match'] = $matchName;
                    $homeMember[$k]['team_id'] = $recordData['home_team_id'];
                    $homeMember[$k]['team'] = $recordData['home_team'];
                    $homeMember[$k]['team_member_id'] = ($teamMember) ? $teamMember['id'] : 0;
                    $homeMember[$k]['match_record_id'] = $recordData['id'];
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
            if (isset($post['HomeMemberDataDel']) && $post['HomeMemberDataDel'] != "[]") {
                $memberArr = json_decode($post['HomeMemberDataDel'], true);
                foreach ($memberArr as $k => $member) {
                    // 提交有match_record_member的id主键
                    // 查询球员有无对应比赛match_record_member记录
                    $matchRecordMember2 = $matchS->getMatchRecordMember(['match_id' => $match['id'], 'match_record_id' => $recordData['id'], 'member_id' => $member['member_id'], 'team_member_id' => $member['tmid']]);
                    if ($matchRecordMember2) {
                        // 更新match_record_member
                        $homeMember[$k]['id'] = $matchRecordMember2['id'];
                    }
                    $memberArr[$k]['match'] = $matchName;
                    $memberArr[$k]['status'] = -1;
                    $memberArr[$k]['is_checkin'] = -1;
                }
                $resultsaveMatchRecordMember2 = $matchS->saveAllMatchRecordMember($memberArr);
            }
            // 保存比赛球队成员 end
            // 保存match_record数据
            $resultSaveMatchRecord = $matchS->saveMatchRecord($recordData);
            if ($resultSaveMatchRecord['code'] == 100) {
                return json(['code' => 100, 'msg' => '保存比赛比分失败']);
            }

            // 裁判系统安排：裁判名单有变动
            if ( isset($post['refereeApChange_str']) && $post['refereeApChange_str'] != '[]' ) {
                $refereeApplyChange = json_decode( $post['refereeApChange_str'], true);
                if ($refereeApplyChange) {
                    $saveAllMatchRefereeApplyData = $saveAllMatchRefereeData = [];
                    // 遍历更新裁判-比赛申请|邀请数据
                    foreach ($refereeApplyChange as $k => $refereeApply) {
                        // 当前match_referee_apply status字段内容
                        $applyStatus = $refereeApply['apply_status'];
                        // match_referee_apply status字段要更新的内容 默认为1（未处理）
                        $applyStatusTo = 1;
                        if ($applyStatus == 1 || $applyStatus==3) {
                            // 设为“同意”
                            $applyStatusTo = 2;
                        } else if ($applyStatus==2) {
                            // 设为”已撤销“
                            $applyStatusTo = 3;
                        }
                        // 查询裁判信息详细数据
                        $refereeInfo = $refereeS->getRefereeInfo(['id' => $refereeApply['referee_id']]);
                        // 查询裁判有无裁判-比赛制裁关系数据
                        $matchReferee = $matchS->getMatchReferee([
                            'match_id' => $match['id'],
                            'match_record_id' => $matchRecord['id'],
                            'referee_id' => $refereeApply['referee_id']
                        ]);
                        // 保存match_referee数据,查询有无原数据 有则更新数据
                        $saveAllMatchRefereeData[$k] = [
                            'match_id' => $match['id'],
                            'match' => $matchName,
                            'match_record_id' => $matchRecord['id'],
                            'referee_id' => $refereeInfo['id'],
                            'referee' => $refereeInfo['referee'],
                            'member_id' => $refereeInfo['member_id'],
                            'member' => $refereeInfo['member']['member'],
                            'referee_type' => 1,
                            'appearance_fee' => $refereeInfo['appearance_fee'],
                            'is_attend' => 1, // 比赛完成 裁判出勤比赛制裁
                            'status' => ($applyStatusTo == 3) ? -1 : 1, // 撤销裁判-比赛申请数据
                        ];
                        if ($matchReferee) {
                            $saveAllMatchRefereeData[$k]['id'] = $matchReferee['id'];
                        }
                        // 查询有无裁判-比赛申请|邀请原数据
                        if (isset($refereeApply['id'])) {
                            echo 1;
                            $refereeMatchApply = $matchS->getMatchRerfereeApply(['id' => $refereeApply['id']]);
                        } else {
                            echo 2;
                            $refereeMatchApply = $matchS->getMatchRerfereeApply(['match_id' => $match_id, 'match_record_id' => $recordData['id'], 'referee_id' => $refereeApply['referee_id']]);
                        }
                        if ($refereeMatchApply) {
                            // 更新裁判-比赛申请|邀请原数据
                            $saveAllMatchRefereeApplyData[$k]['id'] = $refereeApply['id'];
                        }
                        // 更新match_referee_apply status字段
                        $saveAllMatchRefereeApplyData[$k]['status'] = $applyStatusTo;
                        $reviceMessageMemberIds[$k]['id'] = $refereeMatchApply['member_id'];

                        // 未完成比赛 裁判暂定名单改变 给裁判发送比赛申请回复改变消息
                        if ($isFinished == 0) {
                            $wxTemplateID = config('wxTemplateID.refereeTask');
                            $replyStr = ($applyStatusTo == 3) ? '已被拒绝。' : '已被同意。';
                            $messageData = [
                                'title' => '您好，您的"'. $match['name'] .'" 执裁比赛申请'.$replyStr,
                                'content' => '您好，您的"'. $match['name'] .'" 执裁比赛申请'.$replyStr,
                                'keyword1' => $match['match_time'],
                                'keyword2' => $match['court'],
                                'remark' => '点击查看更多',
                                'steward_type' => 2,
                                'url' => url('keeper/team/matchInfo', ['match_id' => $match['id']], '', true)
                            ];
                            $messageS->sendMessageToMember($refereeInfo['member_id'], $messageData, $wxTemplateID);
                        }
                    }
                    // 批量更新match_referee_apply数据
                    if (!empty($saveAllMatchRefereeApplyData)) {
                        $matchS->saveAllMatchRerfereeApply($saveAllMatchRefereeApplyData);
                    }
                    // 批量更新match_referee数据
                    if (!empty($saveAllMatchRefereeData)) {
                        $matchS->saveAllMatchReferee($saveAllMatchRefereeData);
                    }
                }
            }
            // 裁判系统安排：裁判名单有变动end

            // 裁判自行安排：裁判名单有变动
            if (isset($post['refereeChange_str']) && $post['refereeChange_str'] != []) {
                $refereeChange = json_decode($post['refereeChange_str'], true);
                if ($refereeChange) {
                    // 遍历提交的数据
                    $refereeMemberIds= [];
                    foreach ($refereeChange as $k => $val) {
                        // 获取裁判员信息
                        $refereeInfo = $refereeS->getRefereeInfo(['id' => $val['referee_id']]);
                        if ($val['id']) {
                            // 提交名单数据内有裁判-比赛申请记录
                            // 查询裁判-比赛申请记录
                            $refereeApplyInvitation = $matchS->getMatchRerfereeApply(['id' => $val['id']]);
                            if ($refereeApplyInvitation && $refereeApplyInvitation['status'] == 0) {
                                $refereeMemberIds[$k]['member_id'] = $refereeInfo['member_id'];
                            }
                        } else {
                            // 插入新的裁判-比赛申请数据
                            $dataRefereeApplyInvitaion = [
                                'apply_type' => 2,
                                'match_id' => $matchRecord['match_id'],
                                'match' => $matchName,
                                'match_record_id' => $matchRecord['id'],
                                'team_id' => $match['team_id'],
                                'team' => $match['team'],
                                'referee_id' => $val['referee_id'],
                                'referee' => $val['referee'],
                                'referee_cost' => $val['referee_cost'],
                                'referee_avatar' => $refereeInfo['portraits'],
                                'member_id' => $this->memberInfo['id'],
                                'member' => $this->memberInfo['member'],
                                'member_avatar' => $this->memberInfo['avatar'],
                                'status' => 1
                            ];
                            $resSaveMatchRefereeApplyInvitaion = $matchS->saveMatchRerfereeApply($dataRefereeApplyInvitaion, [
                                'apply_type' => 2,
                                'match_id' => $matchRecord['match_id'],
                                'match_record_id' => $matchRecord['id'],
                                'referee_id' => $val['referee_id']
                            ]);
                            // 数据保存出现错误 跳出循环
                            if ($resSaveMatchRefereeApplyInvitaion['code'] == 100) {
                                continue;
                            }
                            $refereeMemberIds[$k]['member_id'] = $refereeInfo['member_id'];
                        }
                    }
                    if (!empty($refereeMemberIds)) {
                        // 发送比赛制裁邀请给裁判
                        $daidingStr = '待定';
                        $linkurl = url('keeper/referee/matchapply', ['match_id' => $matchRecord['match_id']], '', true);
                        $title = '您有一条执裁比赛邀请信息';
                        $content = '您好，有比赛邀请您执裁';
                        $messageData = [
                            'title' => $title,
                            'content' => $content,
                            'url' => $linkurl,
                            'keyword1' => empty($matchTimeStamp) ? $daidingStr : date('Y年m月d日 H:i', $matchTimeStamp),
                            'keyword2' => empty($post['court']) ? $daidingStr : $post['court'],
                            'keyword3' => $matchName,
                            'remark' => '点击进入，查看比赛信息',
                            'steward_type' => 2
                        ];
                        $messageS->sendMessageToMembers($refereeMemberIds, $messageData, config('wxTemplateID.refereeTask'));
                    }
                }
            }

            // 组合match表referee_str字段：match_referee_apply status=2的裁判信息
            $newRefereeStr = $matchS->setMatchRefereeStr($matchRecord['match_id'], $matchRecord['id']);
            if ($newRefereeStr) {
                $dataMatch['referee_str'] = $newRefereeStr['referee_str'];
                $dataMatch['referee_cost'] = $newRefereeStr['referee_cost'];
            }


            // 原match_record表away_team字段为空并post提交away_team不为空 代表对away_team发送约战邀请
            if ( empty($matchRecord['away_team']) && !empty($recordData['away_team']) ) {
                // 发送比赛邀请给对手球队
                $awayTeam = $teamS->getTeam(['id' => $awayTeamId]);
                if ($awayTeam) {
                    // 保存约战申请
                    $applyData = [
                        'match_id' => $match['id'],
                        'match' => $matchName,
                        'team_id' => $post['team_id'],
                        'team' => $recordData['home_team'],
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
                        'title' => '您好，'. $recordData['home_team'] .'球队向您所在 '. $awayTeam['name'] .'球队发起约战',
                        'content' => '您好，'. $recordData['home_team'] .'球队向您所在 '. $awayTeam['name'] .'球队发起约战',
                        'url' => url('keeper/team/matchapplyinfo', ['apply_id' => $resApply['data'], 'team_id' => $awayTeam['id']], '', true),
                        'keyword1' => '球队发起约战',
                        'keyword2' => $this->memberInfo['member'],
                        'keyword3' => date('Y-m-d h:i', time()),
                        'remark' => '请登录平台进入球队管理-》约战申请回复处理',
                        // 比赛发布球队id
                        'team_id' => $post['team_id'],
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
                    'team_id' => $post['record']['home_team_id'],
                    'opponent_team_id' => $post['record']['away_team_id']
                ];
                $historyTeam = $matchS->getHistoryTeam($mapHistoryTeam);
                // 插入新数据
                if (!$historyTeam) {
                    $dataHistoryTeam = [
                        'team_id' => $post['record']['home_team_id'],
                        'team' => $post['record']['home_team'],
                        'opponent_team_id' => $post['record']['away_team_id'],
                        'opponent_team' => $post['record']['away_team'],
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

            // 更新match数据
            $resultSaveMatch = $matchS->saveMatch($dataMatch);
            if ($resultSaveMatch['code'] == 100) {
                return json(['code' => 100, 'msg' => '更新比赛信息失败']);
            }
            // 更新球队胜场数、比赛场数
            $matchS->countTeamMatchNum($homeTeamId);
            $matchS->countTeamMatchNum($awayTeamId);

            // 返回响应结果
            return json($resultSaveMatchRecord);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 直接录入球队比赛
    public function directteammatch() {
        try {
            // 接收输入变量 其中post[record]为match_record保存数据
            $post = input('post.');
            // service
            $matchS = new MatchService();
            $teamS = new TeamService();
            $messageS = new MessageService();
            // post[match_time] 比赛时间转为时间戳格式
            $matchTimeStamp = strtotime($post['match_time']);
            // 比赛完成状态match is_finished标识
            $isFinished = 0;
            // 提取球队、比分变量
            $homeTeamId = $post['record']['home_team_id'];
            $homeScore = $post['record']['home_score'];
            $awayTeamId = $post['record']['away_team_id'];
            $awayScore = $post['record']['away_score'];
            // 提交is_finished=1 即比赛完成（match记录完成状态is_finished）
            if (isset($post['is_finished'])) {
                if ($post['is_finished'] == 1) {
                    if (empty($post['record']['away_team_id']) && empty($post['record']['away_team'])) {
                        return json(['code' => 100, 'msg' => '请填写客队信息']);
                    }
                    $isFinished = 1;
                    $post['finished_time'] = $matchTimeStamp;
                }
            }
            // 组合match保存数据（补充字段创建人数据）
            $post['team'] = db('team')->where('id', $post['team_id'])->value('name');
            $post['member_id'] = $this->memberInfo['id'];
            $post['member'] = $this->memberInfo['member'];
            $post['member_avatar'] = $this->memberInfo['avatar'];
            // 比赛名称match_name 有选择对手队：当前球队名vs对手队名|无选择对手队：当前球队名友谊赛（对手待定）
            if (!empty($post['record']['away_team'])) {
                $post['name'] = $post['record']['home_team'] . ' vs ' . $post['record']['away_team'];
            } else {
                $post['name'] = $post['record']['home_team'] . ' vs （待定）';
            }
            $post['match_time'] = $matchTimeStamp;
            // 组合match保存数据 end

            // 保存match数据
            $resultSaveMatch = $matchS->saveMatch($post);
            // 保存match数据成功 保存match_record数据
            if ($resultSaveMatch['code'] == 200) {
                // 组合match_record保存数据
                $recordData = $post['record'];
                $recordData['match_id'] = $resultSaveMatch['data'];
                $recordData['match'] = $post['name'];
                $recordData['match_time'] = $matchTimeStamp;
                $recordData['team_id'] = $post['team_id'];
                // 相册不为空保存数据
                if (isset($post['album']) && $post['album'] != "[]") {
                    $recordData['album'] = $post['album'];
                }
                // recordData[win_team_id]: 比赛胜利球队id
                if ($isFinished == 1) {
                    if ($homeScore > 0 && $awayScore > 0) {
                        if ($homeScore >= $awayScore) {
                            $recordData['win_team_id'] = $recordData['home_team_id'];
                            $recordData['lose_team_id'] = $recordData['away_team_id'];
                        } else {
                            $recordData['win_team_id'] = $recordData['away_team_id'];
                            $recordData['lose_team_id'] = $recordData['home_team_id'];
                        }
                    }
                }
                // 组合match_record保存数据 end
                $resultSaveMatchRecord = $matchS->saveMatchRecord($recordData);
                // 保存match_record数据失败 抛出提示
                if ($resultSaveMatchRecord['code'] == 100) {
                    return json(['code' => 100, 'msg' => '保存比赛比分失败']);
                }

                // 保存参赛球队成员（match_record_member is_attend=1）
                if (isset($post['HomeMemberData']) && $post['HomeMemberData'] != "[]") {
                    $homeMember = json_decode($post['HomeMemberData'], true);
                    $dataUpdateTeamMember = [];
                    foreach ($homeMember as $k => $member) {
                        $homeMember[$k]['match_id'] = $resultSaveMatch['data'];
                        $homeMember[$k]['match'] = $post['name'];
                        $homeMember[$k]['team_id'] = $recordData['team_id'];
                        $homeMember[$k]['team'] = $recordData['home_team'];
                        $homeMember[$k]['match_record_id'] = $resultSaveMatchRecord['data'];
                        // 获取球队成员数据
                        $teamMember = $teamS->getTeamMemberInfo(['id' => $member['tmid']]);
                        $homeMember[$k]['avatar'] = ($teamMember) ? $teamMember['avatar'] : config('default_image.member_avatar');
                        $homeMember[$k]['contact_tel'] = $teamMember['telephone'];
                        $homeMember[$k]['status'] = 1;
                        $homeMember[$k]['is_attend'] = 1;
                        $homeMember[$k]['is_checkin'] = 1;

                        // 批量更新team_member 比赛数match_num
                        //dump($teamMember);
                        if ($teamMember) {
                            $dataUpdateTeamMember[$k]['id'] = $teamMember['id'];
                            $dataUpdateTeamMember[$k]['match_num'] = $teamMember['match_num'] + 1;
                        }
                    }
                    $saveHomeTeamMemberRes = $matchS->saveAllMatchRecordMember($homeMember);
                    if ($saveHomeTeamMemberRes['code'] == 100) {
                        return json($saveHomeTeamMemberRes);
                    }
                    $teamS->saveAllTeamMember($dataUpdateTeamMember);
                }
                // 保存参赛球队成员 end

                // 更新球队胜场数、比赛场数
                // 更新球队胜场数、比赛场数
                $matchS->countTeamMatchNum($homeTeamId);
                $matchS->countTeamMatchNum($awayTeamId);

                // 比赛完成的操作
                if ($isFinished == 1) {
                    // 保存球队历史比赛对手信息
                    // 查询有无原数据
                    $mapHistoryTeam = [
                        'team_id' => $post['record']['home_team_id'],
                        'opponent_team_id' => $post['record']['away_team_id']
                    ];
                    $historyTeam = $matchS->getHistoryTeam($mapHistoryTeam);
                    // 插入新数据
                    if (!$historyTeam) {
                        $dataHistoryTeam = [
                            'team_id' => $post['record']['home_team_id'],
                            'team' => $post['record']['home_team'],
                            'opponent_team_id' => $post['record']['away_team_id'],
                            'opponent_team' => $post['record']['away_team'],
                            'match_num' => 1
                        ];
                    } else {
                        // 更新原数据 比赛次数+1
                        $dataHistoryTeam['id'] = $historyTeam['id'];
                        $dataHistoryTeam['match_num'] = $historyTeam['match_num'] + 1;
                    }
                    $matchS->saveHistoryTeam($dataHistoryTeam);
                    // 保存球队历史比赛对手信息 end

                }
                // 比赛完成的操作 end
            }
            // 返回响应结果
            return json($resultSaveMatch);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 发送球队比赛认领信息给球队
    public function sendteamclaimfinishmatch() {
        try {
            $param = input('param.');
            // 验证必传参数
            if (!isset($param['match_id'])) {
                return json(['code' => 100, 'msg' => __lang('MSG_402').',请选择比赛id']);
            }
            if (!isset($param['id'])) {
                return json(['code' => 100, 'msg' => __lang('MSG_402').',请选择比赛战绩id']);
            }
            $matchS = new MatchService();
            $messageS = new MessageService();
            // 获取相关比赛数据
            $matchInfo = $matchS->getMatch(['id' => $param['match_id']]);
            if (!$matchInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404').',无此比赛信息']);
            }
            $matchRecordInfo = $matchS->getMatchRecord(['id' => $param['id'], 'match_id' => $param['match_id']]);
            if (!$matchRecordInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404').',无此比赛战绩信息']);
            }
            // 检查比赛是否已完成
            if ($matchInfo['is_finished_num'] != 1) {
                return json(['code' => 100, 'msg' => '该比赛未完成']);
            }
            //dump($matchInfo);
            //dump($matchRecordInfo);
            $winTeam = ($matchRecordInfo['win_team_id'] == $matchRecordInfo['home_team_id']) ? $matchRecordInfo['home_team'] : $matchRecordInfo['away_team'];
            // 发送比赛完成信息给对方球队
            $messageData = [
                'title' => '您的球队“'.$matchRecordInfo['away_team'].'”有一场比赛已完成',
                'content' => '您的球队 '.$matchRecordInfo['away_team'].' 与球队 '.$matchRecordInfo['home_team'].' 比赛已完成，请认领比赛数据',
                'keyword1' =>  $matchRecordInfo['home_team'].' VS '. $matchRecordInfo['away_team'],
                'keyword2' => $matchRecordInfo['home_score'].'：'.$matchRecordInfo['away_score'],
                'keyword3' => $winTeam,
                'remark' => '点击进入查看详情',
                'url' => url('keeper/team/claimfinishedmatch', ['match_id' => $matchInfo['id'], 'team_id' => $matchRecordInfo['away_team_id']], '', true)
            ];
            $memberId = db('team')->where('id', $matchRecordInfo['away_team_id'])->value('member_id');
            $messageS->sendMessageToMember($memberId, $messageData, config('wxTemplateID.matchResult'));
            return json(['code' => 200, 'msg' => __lang('MSG_200')]);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 保存球队友谊赛比赛+比赛战绩数据
    public function storefriendlymatchrecord()
    {
        try {
            // 接收输入变量 其中post[record]为match_record保存数据
            $post = input('post.');
            // service
            $matchS = new MatchService();
            $teamS = new TeamService();
            $messageS = new MessageService();
            $refereeS = new RefereeService();
            // post[match_time] 比赛时间转为时间戳格式
            $matchTimeStamp = strtotime($post['match_time']);
            // 比赛完成状态match is_finished标识
            $isFinished = 0;
            // 提取球队、比分变量
            $homeTeamId = $post['record']['home_team_id'];
            $homeScore = $post['record']['home_score'];
            $awayTeamId = $post['record']['away_team_id'];
            $awayScore = $post['record']['away_score'];
            // 提交is_finished=1 即比赛完成（match记录完成状态is_finished）
            if (isset($post['is_finished'])) {
                if ($post['is_finished'] == 1) {
                    if (empty($post['record']['away_team_id']) && empty($post['record']['away_team'])) {
                        return json(['code' => 100, 'msg' => '请填写客队信息']);
                    }
                    $isFinished = 1;
                    $post['finished_time'] = $matchTimeStamp;
                }
            }
            // 以有无post[id]区分插入/更新数据
            if (input('?id')) {
                // 更新数据操作
                // 获取当前比赛数据、比赛战绩数据
                $match_id = $post['id'];
                $match = $matchS->getMatch(['id' => $match_id]);
                $matchRecord = $matchS->getMatchRecord(['match_id' => $match['id']]);
                if (!$match) {
                    return json(['code' => 100, 'msg' => __lang('MSG_404') . '请选择其他比赛']);
                }

                // post[match_time] 比赛时间转为时间戳格式
                $matchTimeStamp = strtotime($post['match_time']);
                // 比赛完成状态match is_finished标识
                $isFinished = 0;
                // 提取球队、比分变量
                $homeTeamId = $post['record']['home_team_id'];
                $homeScore = $post['record']['home_score'];
                $awayTeamId = $post['record']['away_team_id'];
                $awayScore = $post['record']['away_score'];
                // 提交is_finished=1 即比赛完成（match记录完成状态is_finished）
                if (isset($post['is_finished'])) {
                    if ($post['is_finished'] == 1) {
                        if (empty($post['record']['away_team_id']) && empty($post['record']['away_team'])) {
                            return json(['code' => 100, 'msg' => '请填写客队信息']);
                        }
                        $isFinished = 1;
                        $post['finished_time'] = $matchTimeStamp;
                    }
                }

                // 组合match_record保存数据
                $recordData = $post['record'];
                $recordData['match_time'] = $matchTimeStamp;
                // 相册不为空保存数据
                if (isset($post['album']) && $post['album'] != "[]") {
                    $recordData['album'] = $post['album'];
                }
                // recordData[win_team_id]: 比赛胜利球队id
                if ($isFinished == 1) {
                    if ($homeScore > 0 && $awayScore > 0) {
                        if ($homeScore >= $awayScore) {
                            $recordData['win_team_id'] = $recordData['home_team_id'];
                            $recordData['lose_team_id'] = $recordData['away_team_id'];
                        } else {
                            $recordData['win_team_id'] = $recordData['away_team_id'];
                            $recordData['lose_team_id'] = $recordData['home_team_id'];
                        }
                    }
                }
                // 组合match_record保存数据 end
                // 组合match保存数据
                $dataMatch = $post;
                $dataMatch['match_time'] = $matchTimeStamp;
                // 更新比赛名称match_name 有选择对手队：当前球队名vs对手队名|无选择对手队：当前球队名友谊赛（对手待定）
                if (!empty($post['record']['away_team'])) {
                    $matchName = $post['record']['home_team'] . ' vs ' . $post['record']['away_team'];
                } else {
                    $matchName = $post['record']['home_team'] . ' vs （待定）';
                }
                $recordData['match'] = $matchName;
                $dataMatch['name'] = $matchName;
                if ($isFinished == 1) {
                    $dataMatch['is_live'] = -1;
                }
                // 保存比赛球队成员
                // 保留显示的成员名单（status=1 报名is_apply=1 、出席is_attend=1）
                if (isset($post['HomeMemberData']) && $post['HomeMemberData'] != "[]") {
                    $homeMember = json_decode($post['HomeMemberData'], true);
                    $dataUpdateTeamMember = [];
                    foreach ($homeMember as $k => $member) {
                        // 查询球员有无对应比赛match_record_member记录
                        $matchRecordMember = $matchS->getMatchRecordMember(['match_id' => $match['id'], 'match_record_id' => $recordData['id'], 'member_id' => $member['member_id'], 'team_member_id' => $member['tmid']]);
                        if ($matchRecordMember) {
                            // 更新match_record_member
                            $homeMember[$k]['id'] = $matchRecordMember['id'];
                        }
                        // 获取球队成员数据
                        $teamMember = $teamS->getTeamMemberInfo(['id' => $member['tmid']]);
                        $homeMember[$k]['match_id'] = $match['id'];
                        $homeMember[$k]['match'] = $matchName;
                        $homeMember[$k]['team_id'] = $recordData['home_team_id'];
                        $homeMember[$k]['team'] = $recordData['home_team'];
                        $homeMember[$k]['team_member_id'] = ($teamMember) ? $teamMember['id'] : 0;
                        $homeMember[$k]['match_record_id'] = $recordData['id'];
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
                if (isset($post['HomeMemberDataDel']) && $post['HomeMemberDataDel'] != "[]") {
                    $memberArr = json_decode($post['HomeMemberDataDel'], true);
                    foreach ($memberArr as $k => $member) {
                        // 提交有match_record_member的id主键
                        // 查询球员有无对应比赛match_record_member记录
                        $matchRecordMember2 = $matchS->getMatchRecordMember(['match_id' => $match['id'], 'match_record_id' => $recordData['id'], 'member_id' => $member['member_id'], 'team_member_id' => $member['tmid']]);
                        if ($matchRecordMember2) {
                            // 更新match_record_member
                            $homeMember[$k]['id'] = $matchRecordMember2['id'];
                        }
                        $memberArr[$k]['match'] = $matchName;
                        $memberArr[$k]['status'] = -1;
                        $memberArr[$k]['is_checkin'] = -1;
                    }
                    $resultsaveMatchRecordMember2 = $matchS->saveAllMatchRecordMember($memberArr);
                }
                // 保存比赛球队成员 end
                // 保存match_record数据
                $resultSaveMatchRecord = $matchS->saveMatchRecord($recordData);
                if ($resultSaveMatchRecord['code'] == 100) {
                    return json(['code' => 100, 'msg' => '保存比赛比分失败']);
                }

                // 裁判名单有变动（要保留的数据）
                if ( isset($post['refereeApChange_str']) && $post['refereeApChange_str'] != '[]' ) {
                    $refereeApplyChange = json_decode( $post['refereeApChange_str'], true);
                    if ($refereeApplyChange) {
                        $saveAllMatchRefereeApplyData = $saveAllMatchRefereeData = [];
                        // 遍历更新裁判-比赛申请|邀请数据
                        foreach ($refereeApplyChange as $k => $refereeApply) {
                            // 当前match_referee_apply status字段内容
                            $applyStatus = $refereeApply['apply_status'];
                            // match_referee_apply status字段要更新的内容 默认为1（未处理）
                            $applyStatusTo = 1;
                            if ($applyStatus == 1 || $applyStatusTo==3) {
                                // 设为“同意”
                                $applyStatusTo = 2;
                            } else if ($applyStatus==2) {
                                // 设为”已撤销“
                                $applyStatusTo = 3;
                            }
                            // 查询裁判信息详细数据
                            $refereeInfo = $refereeS->getRefereeInfo(['id' => $refereeApply['referee_id']]);
                            // 查询裁判有无裁判-比赛制裁关系数据
                            $matchReferee = $matchS->getMatchReferee([
                                'match_id' => $match['id'],
                                'match_record_id' => $matchRecord['id'],
                                'referee_id' => $refereeApply['referee_id']
                            ]);
                            // 保存match_referee数据,查询有无原数据 有则更新数据
                            $saveAllMatchRefereeData[$k] = [
                                'match_id' => $match['id'],
                                'match' => $matchName,
                                'match_record_id' => $matchRecord['id'],
                                'referee_id' => $refereeInfo['id'],
                                'referee' => $refereeInfo['referee'],
                                'member_id' => $refereeInfo['member_id'],
                                'member' => $refereeInfo['member']['member'],
                                'referee_type' => 1,
                                'appearance_fee' => $refereeInfo['appearance_fee'],
                                'is_attend' => 1, // 比赛完成 裁判出勤比赛制裁
                                'status' => ($applyStatusTo == 3) ? -1 : 1, // 撤销裁判-比赛申请数据
                            ];
                            if ($matchReferee) {
                                $saveAllMatchRefereeData[$k]['id'] = $matchReferee['id'];
                            }
                            // 查询有无裁判-比赛申请|邀请原数据
                            if (isset($refereeApply['id'])) {
                                $refereeMatchApply = $matchS->getMatchRerfereeApply(['id' => $refereeApply['id']]);
                            } else {
                                $refereeMatchApply = $matchS->getMatchRerfereeApply(['match_id' => $match_id, 'match_record_id' => $recordData['id'], 'referee_id' => $refereeApply['referee_id']]);
                            }
                            if ($refereeMatchApply) {
                                // 更新裁判-比赛申请|邀请原数据
                                $saveAllMatchRefereeApplyData[$k]['id'] = $refereeApply['id'];
                            }
                            // 更新match_referee_apply status字段
                            $saveAllMatchRefereeApplyData[$k]['status'] = $applyStatusTo;
                            $reviceMessageMemberIds[$k]['id'] = $refereeMatchApply['member_id'];

                            // 未完成比赛 裁判暂定名单改变 给裁判发送比赛申请回复改变消息
                            if ($isFinished == 0) {
                                $wxTemplateID = config('wxTemplateID.refereeTask');
                                $replyStr = ($applyStatusTo == 3) ? '已被拒绝。' : '已被同意。';
                                $messageData = [
                                    'title' => '您好，您的"'. $match['name'] .'" 执裁比赛申请'.$replyStr,
                                    'content' => '您好，您的"'. $match['name'] .'" 执裁比赛申请'.$replyStr,
                                    'keyword1' => $match['match_time'],
                                    'keyword2' => $match['court'],
                                    'remark' => '点击查看更多',
                                    'steward_type' => 2,
                                    'url' => url('keeper/team/matchInfo', ['match_id' => $match['id']], '', true)
                                ];
                                $messageS->sendMessageToMember($refereeInfo['member_id'], $messageData, $wxTemplateID);
                            }
                        }
                        // 批量更新match_referee_apply数据
                        if (!empty($saveAllMatchRefereeApplyData)) {
                            $matchS->saveAllMatchRerfereeApply($saveAllMatchRefereeApplyData);
                        }
                        // 批量更新match_referee数据
                        if (!empty($saveAllMatchRefereeData)) {
                            $matchS->saveAllMatchReferee($saveAllMatchRefereeData);
                        }
                    }
                }
                // 裁判名单有变动（要保留的数据） end
                // 组合match表referee_str字段：match_referee_apply status=2的裁判信息
                $newRefereeStr = $matchS->setMatchRefereeStr($matchRecord['match_id'], $matchRecord['id']);
                if ($newRefereeStr) {
                    $dataMatch['referee_str'] = $newRefereeStr['referee_str'];
                    $dataMatch['referee_cost'] = $newRefereeStr['referee_cost'];
                }

                // 原match_record表away_team字段为空并post提交away_team不为空 代表对away_team发送约战邀请
                if ( empty($matchRecord['away_team']) && !empty($recordData['away_team']) ) {
                    // 发送比赛邀请给对手球队
                    $awayTeam = $teamS->getTeam(['id' => $awayTeamId]);
                    if ($awayTeam) {
                        // 保存约战申请
                        $applyData = [
                            'match_id' => $match['id'],
                            'match' => $matchName,
                            'team_id' => $post['team_id'],
                            'team' => $recordData['home_team'],
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
                            'title' => '您好，'. $recordData['home_team'] .'球队向您所在 '. $awayTeam['name'] .'球队发起约战',
                            'content' => '您好，'. $recordData['home_team'] .'球队向您所在 '. $awayTeam['name'] .'球队发起约战',
                            'url' => url('keeper/team/matchapplyinfo', ['apply_id' => $resApply['data'], 'team_id' => $awayTeam['id']], '', true),
                            'keyword1' => '球队发起约战',
                            'keyword2' => $this->memberInfo['member'],
                            'keyword3' => date('Y-m-d h:i', time()),
                            'remark' => '请登录平台进入球队管理-》约战申请回复处理',
                            // 比赛发布球队id
                            'team_id' => $post['team_id'],
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
                        'team_id' => $post['record']['home_team_id'],
                        'opponent_team_id' => $post['record']['away_team_id']
                    ];
                    $historyTeam = $matchS->getHistoryTeam($mapHistoryTeam);
                    // 插入新数据
                    if (!$historyTeam) {
                        $dataHistoryTeam = [
                            'team_id' => $post['record']['home_team_id'],
                            'team' => $post['record']['home_team'],
                            'opponent_team_id' => $post['record']['away_team_id'],
                            'opponent_team' => $post['record']['away_team'],
                            'match_num' => 1
                        ];
                    } else {
                        // 更新原数据 比赛次数+1
                        $dataHistoryTeam['id'] = $historyTeam['id'];
                        $dataHistoryTeam['match_num'] = $historyTeam['match_num'] + 1;
                    }
                    $matchS->saveHistoryTeam($dataHistoryTeam);
                    // 保存球队历史比赛对手信息 end

                    // 发送比赛完成信息给对手球队
                    // 发送比赛完成信息给对手球队 end

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

                // 更新match数据
                $resultSaveMatch = $matchS->saveMatch($dataMatch);
                if ($resultSaveMatch['code'] == 100) {
                    return json(['code' => 100, 'msg' => '更新比赛信息失败']);
                }
                // 更新球队胜场数、比赛场数
                $matchS->countTeamMatchNum($homeTeamId);
                $matchS->countTeamMatchNum($awayTeamId);

                // 返回响应结果
                return json($resultSaveMatchRecord);
            } else {
                // 插入数据操作
                // 组合match保存数据（补充字段创建人数据）
                $post['team'] = db('team')->where('id', $post['team_id'])->value('name');
                $post['member_id'] = $this->memberInfo['id'];
                $post['member'] = $this->memberInfo['member'];
                $post['member_avatar'] = $this->memberInfo['avatar'];
                // 比赛名称match_name 有选择对手队：当前球队名vs对手队名|无选择对手队：当前球队名友谊赛（对手待定）
                if (!empty($post['record']['away_team'])) {
                    $post['name'] = $post['record']['home_team'] . ' vs ' . $post['record']['away_team'];
                } else {
                    $post['name'] = $post['record']['home_team'] . ' vs （待定）';
                }
                $post['match_time'] = $matchTimeStamp;
                // 组合match保存数据 end

                // 保存match数据
                $resultSaveMatch = $matchS->saveMatch($post);
                // 保存match数据成功 保存match_record数据
                if ($resultSaveMatch['code'] == 200) {
                    // 组合match_record保存数据
                    $recordData = $post['record'];
                    $recordData['match_id'] = $resultSaveMatch['data'];
                    $recordData['match'] = $post['name'];
                    $recordData['match_time'] = $matchTimeStamp;
                    $recordData['team_id'] = $post['team_id'];
                    // 相册不为空保存数据
                    if (isset($post['album']) && $post['album'] != "[]") {
                        $recordData['album'] = $post['album'];
                    }
                    // recordData[win_team_id]: 比赛胜利球队id
                    if ($isFinished == 1) {
                        if ($homeScore > 0 && $awayScore > 0) {
                            if ($homeScore >= $awayScore) {
                                $recordData['win_team_id'] = $recordData['home_team_id'];
                                $recordData['lose_team_id'] = $recordData['away_team_id'];
                            } else {
                                $recordData['win_team_id'] = $recordData['away_team_id'];
                                $recordData['lose_team_id'] = $recordData['home_team_id'];
                            }
                        }
                    }
                    // 组合match_record保存数据 end
                    $resultSaveMatchRecord = $matchS->saveMatchRecord($recordData);
                    // 保存match_record数据失败 抛出提示
                    if ($resultSaveMatchRecord['code'] == 100) {
                        return json(['code' => 100, 'msg' => '保存比赛比分失败']);
                    }

                    // 保存参赛球队成员（match_record_member is_attend=1）
                    if (isset($post['HomeMemberData']) && $post['HomeMemberData'] != "[]") {
                        $homeMember = json_decode($post['HomeMemberData'], true);
                        $dataUpdateTeamMember = [];
                        foreach ($homeMember as $k => $member) {
                            $homeMember[$k]['match_id'] = $resultSaveMatch['data'];
                            $homeMember[$k]['match'] = $post['name'];
                            $homeMember[$k]['team_id'] = $recordData['team_id'];
                            $homeMember[$k]['team'] = $recordData['home_team'];
                            $homeMember[$k]['match_record_id'] = $resultSaveMatchRecord['data'];
                            // 获取球队成员数据
                            $teamMember = $teamS->getTeamMemberInfo(['team_id' => $recordData['home_team_id'], 'member_id' => $member['member_id'], 'member' => $member['member']]);
                            $homeMember[$k]['avatar'] = ($teamMember) ? $teamMember['avatar'] : config('default_image.member_avatar');
                            $homeMember[$k]['contact_tel'] = $teamMember['telephone'];
                            $homeMember[$k]['status'] = 1;
                            $homeMember[$k]['is_attend'] = 1;
                            $homeMember[$k]['is_checkin'] = 1;

                            // 批量更新team_member 比赛数match_num
                            //dump($teamMember);
                            if ($teamMember) {
                                $dataUpdateTeamMember[$k]['id'] = $teamMember['id'];
                                $dataUpdateTeamMember[$k]['match_num'] = $teamMember['match_num'] + 1;
                            }
                        }
                        $saveHomeTeamMemberRes = $matchS->saveAllMatchRecordMember($homeMember);
                        if ($saveHomeTeamMemberRes['code'] == 100) {
                            return json($saveHomeTeamMemberRes);
                        }
                        $teamS->saveAllTeamMember($dataUpdateTeamMember);
                    }
                    // 保存参赛球队成员 end

                    // 更新球队胜场数、比赛场数
                    // 更新球队胜场数、比赛场数
                    $matchS->countTeamMatchNum($homeTeamId);
                    $matchS->countTeamMatchNum($awayTeamId);
                    
                    // 比赛完成的操作
                    if ($isFinished == 1) {
                        // 保存球队历史比赛对手信息
                        // 查询有无原数据
                        $mapHistoryTeam = [
                            'team_id' => $post['record']['home_team_id'],
                            'opponent_team_id' => $post['record']['away_team_id']
                        ];
                        $historyTeam = $matchS->getHistoryTeam($mapHistoryTeam);
                        // 插入新数据
                        if (!$historyTeam) {
                            $dataHistoryTeam = [
                                'team_id' => $post['record']['home_team_id'],
                                'team' => $post['record']['home_team'],
                                'opponent_team_id' => $post['record']['away_team_id'],
                                'opponent_team' => $post['record']['away_team'],
                                'match_num' => 1
                            ];
                        } else {
                            // 更新原数据 比赛次数+1
                            $dataHistoryTeam['id'] = $historyTeam['id'];
                            $dataHistoryTeam['match_num'] = $historyTeam['match_num'] + 1;
                        }
                        $matchS->saveHistoryTeam($dataHistoryTeam);
                        // 保存球队历史比赛对手信息 end

                        // 发送比赛完成信息给对手球队
                        // 发送比赛完成信息给对手球队 end

                        // 保存裁判出席名单
                        if (!empty($post['refereeAttend_str']) && $post['refereeAttend_str'] != '[]') {
                            $matchRefereeAttend = [];
                            // 转换裁判出席比赛名单格式
                            $refereeAttends = json_decode($post['refereeAttend_str'], true);
                            if ($refereeAttends) {
                                // 遍历组合更新match_referee数据
                                foreach ($refereeAttends as $k => $referee) {
                                    $matchRefereeAttend[$k] = [
                                        'match_id' => $post['id'],
                                        'match_record_id' => $resultSaveMatchRecord['data'],
                                        'referee_id' => $referee['referee_id'],
                                        'referee' => $referee['referee'],
                                        'appearance_fee' => $referee['referee_cost'],
                                        'is_attend' => 2, //裁判出席比赛is_attend=2
                                        'status' => 1
                                    ];
                                    $matchRefereeInfo = $matchS->getMatchReferee([
                                        'match_id' => $post['id'],
                                        'match_record_id' => $resultSaveMatchRecord['data'],
                                        'referee_id' => $referee['referee_id'],
                                        'referee' => $referee['referee'],
                                        'appearance_fee' => $referee['referee_cost'],
                                    ]);
                                    if ($matchRefereeInfo) {
                                        $matchRefereeAttend[$k]['id'] = $matchRefereeInfo['id'];
                                    }
                                }
                                // 批量更新match_referee数据
                                $resSaveMatchReferee = $matchS->saveAllMatchReferee($matchRefereeAttend);
                                if ($resSaveMatchReferee['code'] ==100) {
                                    return json(['code' => 100, 'msg' => '保存裁判出席名单出错']);
                                }
                            }
                        }
                        // 保存裁判出席名单
                    }
                    // 比赛完成的操作 end
                }
                // 返回响应结果
                return json($resultSaveMatch);
            }
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
                        case 1: {
                            $dateTimeStamp = strtotime("+7 days");
                            break;
                        }
                        case 2: {
                            $dateTimeStamp = strtotime("+15 days");
                            break;
                        }
                        case 3: {
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
                        case 1: {
                            $dateTimeStamp = strtotime("+7 days");
                            break;
                        }
                        case 2: {
                            $dateTimeStamp = strtotime("+15 days");
                            break;
                        }
                        case 3: {
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
                        if (!ctype_space($keyword)){
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

    // 球队认领比赛列表（分页）
    public function teamclaimfinishmatchpage() {
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
    public function teamclaimfinishmatchlist() {
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
    public function claimfinishmatch() {
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
            $match = $matchS->getMatch(['id' => $id]);
            if (!$match) {
                return json(['code' => 100, 'msg' => __lang('MSG_404') . '，没有此比赛信息']);
            }
            if ($match['is_finished_num'] == 1) {
                return json(['code' => 100, 'msg' => __lang('MSG_400') . '，此比赛已完成不能删除']);
            }
            // 根据比赛当前状态(1上架,-1下架)+不允许操作条件
            // 根据action参数 editstatus执行上下架/del删除操作
            // 更新数据 返回结果
            switch ($match['status_num']) {
                case 1 : {
                    if ($action == 'editstatus') {
                        //$response = $matchS->saveMatch(['id' => $match['id'], 'status' => -1]);
                        $query = db('match')->where('id', $match['id'])->setField('status', -1);
                        if ($query) {
                            $response = ['code' => 200, 'msg' => __lang('MSG_200')];
                        } else {
                            $response = ['code' => 100, 'msg' => __lang('MSG_400')];
                        }
                    } else {
                        $delRes = $matchS->deleteMatch($match['id']);
                        if ($delRes) {
                            $response = ['code' => 200, 'msg' => __lang('MSG_200')];
                        } else {
                            $response = ['code' => 100, 'msg' => __lang('MSG_400')];
                        }
                    }
                    return json($response);
                    break;
                }
                case -1 : {
                    if ($action == 'editstatus') {
                        //$response = $matchS->saveMatch(['id' => $match['id'], 'status' => 1]);
                        $query = db('match')->where('id', $match['id'])->setField('status', 1);
                        if ($query) {
                            $response = ['code' => 200, 'msg' => __lang('MSG_200')];
                        } else {
                            $response = ['code' => 100, 'msg' => __lang('MSG_400')];
                        }
                    } else {
                        $delRes = $matchS->deleteMatch($match['id']);
                        if ($delRes) {
                            $response = ['code' => 200, 'msg' => __lang('MSG_200')];
                        } else {
                            $response = ['code' => 100, 'msg' => __lang('MSG_400')];
                        }
                    }
                    return json($response);
                    break;
                }
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
            // 查询比赛match数据
            $match = $matchS->getMatch(['id' => $id]);
            if (!$match) {
                return json(['code' => 100, 'msg' => __lang('MSG_404') . '，请选择其他比赛']);
            }
            if ($match['is_finished_num'] == 1) {
                return json(['code' => 100, 'msg' => '此比赛' . $match['is_finished'] . '，请选择其他比赛']);
            }

            $matchRecord = $matchS->getMatchRecord(['match_id' => $match['id']]);
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
                    'content' => '球队'. $matchInfo['team'] . '发布的约战申请结果通知：' . $replystr,
                    'url' => url('keeper/message/index', '', '', true),
                    'keyword1' => '球队'. $matchInfo['team'] . '发布的约战申请结果',
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
    public function getMatchListOrderByDistanceApi(){
        try{

            $data = input('param.');
            $lat = input('param.lat',22.52369);
            $lng = input('param.lng',114.0261);
            $page = input('param.page',1);
            $orderby = input('param.orderby','distance asc');
            // 传递参数作为查询条件
            $map = [];
            
            if (input('?province')) {
                $map['`match`.province'] = $data['province'];
            }
            if (input('?city')) {
                $map['`match`.city'] = $data['city'];
            }
            if ($data['area']) {
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
                        case 1: {
                            $dateTimeStamp = strtotime("+7 days");
                            break;
                        }
                        case 2: {
                            $dateTimeStamp = strtotime("+15 days");
                            break;
                        }
                        case 3: {
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


          

            $result = db('match')->field("`match`.*,c.avg_height,c.logo,c.match_win,c.match_num,round(c.match_win/c.match_num) as sl,round(6378.138)*2*asin (sqrt(pow(sin(($lat *pi()/180 - `match`.court_lat*pi()/180)/2), 2)+cos($lat *pi()/180)*cos(`match`.court_lat*pi()/180)*pow(sin(($lng *pi()/180 - `match`.court_lng*pi()/180)/2),2))) as distance")->where($map)->join('__TEAM__ c','match.team_id = c.id')->page($page)->order($orderby)->select();
            
            // echo  db('match')->getlastsql();

            if($result){
                return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'ok']);
            }
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

}

