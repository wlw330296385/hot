<?php
// 比赛api
namespace app\api\controller;

use app\model\MatchRecord;
use app\service\MatchService;
use app\service\TeamService;
use think\Exception;

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
            $matchS = new MatchService();
            $teamS = new TeamService();
            // 友谊赛类型 记录比赛战绩数据
            $dataMatchRecord = [];
            if ($data['type'] == 1) {
                $dataMatchRecord = $data['record'];
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
                    //$awayTeam = $teamS->getTeam(['id' => $data['opponent_id']]);
                    $dataAwayteam = [
                        'away_team_id' => $data['away_team_id'],
                        'away_team' => $data['away_team'],
                        'away_team_logo' => $data['away_team_logo'],
                        //'away_team_color' => $data['away_team_color'],
                        //'away_team_colorstyle' => $data['away_team_colorstyle']
                    ];
                    $dataMatchRecord = array_merge($dataMatchRecord, $dataAwayteam);
                    $data['name'] = $homeTeam['name'] . 'vs' . $data['away_team'];
                } else {
                    $data['name'] = $homeTeam['name'] . '友谊赛（对手待定）';
                }
            }
            $res = $matchS->saveMatch($data);
            // 比赛记录创建成功后操作
            if ($res['code'] == 200) {
                // 友谊赛类型 记录比赛战绩数据
                if ($data['type'] == 1) {
                    $dataMatchRecord['match_id'] = $res['data'];
                    $dataMatchRecord['match'] = $data['name'];
                    $matchS->saveMatchRecord($dataMatchRecord);
                }
            }
            return json($res);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 编辑比赛信息
    public function updatematch()
    {
        try {
            // 接收输入变量
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['member_avatar'] = $this->memberInfo['avatar'];

            $matchS = new MatchService();
            $teamS = new TeamService();
            $res = $matchS->saveMatch($data);
            return json($res);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 编辑比赛战绩
    public function updatematchrecord()
    {
        try {
            // 接收输入变量
            $data = input('post.');
            if (isset($data['record_id'])) {
                $data['id'] = $data['record_id'];
            }
            $matchS = new MatchService();
            $teamS = new TeamService();
            // 当前时间大于输入的比赛时间 记录比赛完成时间和完成状态
            $now = time();
            $matchTimeStamp = strtotime($data['match_time']);
            $data['match_time'] = $matchTimeStamp;
            if ($now > $matchTimeStamp) {
                $data['is_finished'] = 1;
                $data['finished_time'] = 1;
            }

            // 保存球队参赛人员
            // 主队成员
            if (isset($data['HomeMemberData']) && $data['HomeMemberData'] != "[]") {
                $homeMember = json_decode($data['HomeMemberData'], true);
                $homeTeam = $teamS->getTeam(['id' => $data['home_team_id']]);
                foreach ($homeMember as $k => $val) {
                    $homeMember[$k]['match_id'] = $data['match_id'];
                    $homeMember[$k]['team_id'] = $homeTeam['id'];
                    $homeMember[$k]['team'] = $homeTeam['name'];
                    $homeMember[$k]['match_record_id'] = $data['record_id'];
                    $homeMember[$k]['member_avatar'] = db('member')->where('id', $val['member_id'])->value('avatar');
                    $homeMember[$k]['status'] = 2;
                }
                $saveHomeTeamMemberRes = $matchS->saveAllMatchRecordMember($homeMember);
                if ($saveHomeTeamMemberRes['code'] != 200) {
                    return json($saveHomeTeamMemberRes);
                }
            }
            // 保存球队参赛人员end
            // 保存比赛战绩数据
            $res = $matchS->saveMatchRecord($data);
            return json($res);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 直接创建录入比赛战绩
    public function creatematchrecord()
    {
        try {
            // 接收输入变量
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['member_avatar'] = $this->memberInfo['avatar'];

            $matchS = new MatchService();
            $teamS = new TeamService();

            // 友谊赛类型 记录比赛战绩数据
            $dataMatchRecord = [];
            if ($data['type'] == 1) {
                // 主队信息保存数据组合
                if (!$data['home_team_id']) {
                    return json(['code' => 100, 'msg' => __lang('MSG_402') . '请选择主队球队']);
                }
                $homeTeamId = $data['home_team_id'];
                $homeTeam = $teamS->getTeam(['id' => $homeTeamId]);
                //dump($homeTeam);
                $data['team'] = $homeTeam['name'];
                $dataHometeam = [
                    'home_team_id' => $homeTeam['id'],
                    'home_team' => $homeTeam['name'],
                    'home_team_logo' => $homeTeam['logo'],
                    'home_team_color' => $data['home_team_color'],
                    'home_team_colorstyle' => $data['home_team_colorstyle'],
                    'home_score' => $data['home_score']
                ];
                $dataMatchRecord = array_merge($dataMatchRecord, $dataHometeam);
                // 客队信息保存数据组合
                if (!$data['away_team_id']) {
                    return json(['code' => 100, 'msg' => '请选择客队球队']);
                }
                if (!empty($data['away_team_id'])) {
                    if ($data['away_team_id'] == $data['team_id']) {
                        return json(['code' => 100, 'msg' => '请选择其他球队']);
                    }
                    $awayTeam = $teamS->getTeam(['id' => $data['away_team_id']]);
                    $dataAwayteam = [
                        'away_team_id' => $awayTeam['id'],
                        'away_team' => $awayTeam['name'],
                        'away_team_logo' => $awayTeam['logo'],
                        'away_team_color' => $data['away_team_color'],
                        'away_team_colorstyle' => $data['away_team_colorstyle'],
                        'away_score' => $data['away_score']
                    ];
                    $dataMatchRecord = array_merge($dataMatchRecord, $dataAwayteam);
                }
                $dataMatchRecord['province'] = $data['province'];
                $dataMatchRecord['city'] = $data['city'];
                $dataMatchRecord['area'] = $data['area'];
                $dataMatchRecord['court_id'] = $data['court_id'];
                $dataMatchRecord['court'] = $data['court'];

                // 当前时间大于输入的比赛时间 记录比赛完成时间和完成状态
                $now = time();
                $matchTimeStamp = strtotime($data['match_time']);
                $dataMatchRecord['match_time'] = $matchTimeStamp;
                if ($now > $matchTimeStamp) {
                    $dataMatchRecord['finished_time'] = $matchTimeStamp;
                    $dataMatchRecord['is_finished'] = 1;
                    $data['is_finished'] = 1;
                    $data['finished_time'] = 1;
                }

                // 保存球队参赛人员
                // 主队成员
                if (isset($data['HomeMemberData']) && $data['HomeMemberData'] != "[]") {
                    $homeMember = json_decode($data['HomeMemberData'], true);
                    $homeTeam = $teamS->getTeam(['id' => $data['home_team_id']]);
                    foreach ($homeMember as $k => $val) {
                        $homeMember[$k]['match_id'] = $data['match_id'];
                        $homeMember[$k]['team_id'] = $homeTeam['id'];
                        $homeMember[$k]['team'] = $homeTeam['name'];
                        $homeMember[$k]['match_record_id'] = $data['record_id'];
                        $homeMember[$k]['member_avatar'] = db('member')->where('id', $val['member_id'])->value('avatar');
                        $homeMember[$k]['status'] = 2;
                    }
                    $saveHomeTeamMemberRes = $matchS->saveAllMatchRecordMember($homeMember);
                    if ($saveHomeTeamMemberRes['code'] != 200) {
                        return json($saveHomeTeamMemberRes);
                    }
                }
                // 保存球队参赛人员end
            }

            $res = $matchS->saveMatch($data);
            // 比赛记录创建成功后操作
            if ($res['code'] == 200) {
                // 友谊赛类型 记录比赛战绩数据
                if ($data['type'] == 1) {
                    $dataMatchRecord['match_id'] = $res['data'];
                    $matchS->saveMatchRecord($dataMatchRecord);
                }
            }
            return json($res);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 保存球队友谊赛比赛+比赛战绩数据
    public function storefriendlymatchrecord()
    {
        try {
            $post = input('post.');
            $matchS = new MatchService();
            //dump($post);
            // 获取当前时间
            $nowTime = time();
            // 以有无post[id]获取match数据 区分插入/更新数据
            if (input('?id')) {
                // 更熟比赛+比赛战绩数据
                $match_id = $post['id'];
                $match = $matchS->getMatch(['id' => $match_id]);
                if ($match['type_num'] == 1) {
                    // 友谊赛 查询有无比赛战绩数据
                    // 组合match_record数据
                    $matchTimeStamp = strtotime($post['match_time']);
                    $recordData = $post['record'];
                    $recordData['match_time'] = $matchTimeStamp;
                    // 相册不为空保存数据
                    if (isset($post['album']) && $post['album'] != "[]") {
                        $recordData['album'] = $post['album'];
                    }

                    // 保存球队参赛人员
                    // 主队成员
                    if (isset($post['HomeMemberData']) && $post['HomeMemberData'] != "[]") {
                        $homeMember = json_decode($post['HomeMemberData'], true);
                        foreach ($homeMember as $k => $val) {
                            // 查询有无team_event_member原数据，有则更新原数据否则插入新数据
                            $hasMatchRecordMember = $matchS->getMatchRecordMember(['match_id' => $match['id'], 'match_record_id' => $recordData['id'], 'member_id' => $val['member_id']]);
                            if ($hasMatchRecordMember) {
                                $homeMember[$k]['id'] = $hasMatchRecordMember['id'];
                            }
                            $homeMember[$k]['match_id'] = $match['id'];
                            $homeMember[$k]['match'] = $match['name'];
                            $homeMember[$k]['team_id'] = $recordData['home_team_id'];
                            $homeMember[$k]['team'] = $recordData['home_team'];
                            $homeMember[$k]['match_record_id'] = $recordData['id'];
                            $homeMember[$k]['member_avatar'] = db('member')->where('id', $val['member_id'])->value('avatar');
                            $homeMember[$k]['status'] = 2;
                        }
                        $saveHomeTeamMemberRes = $matchS->saveAllMatchRecordMember($homeMember);
                        if ($saveHomeTeamMemberRes['code'] == 100) {
                            return json($saveHomeTeamMemberRes);
                        }
                    }
                    // 被剔除的成员名单
                    if (input('?HomeMemberDataDel') && $post['HomeMemberDataDel'] != "[]") {
                        $memberArr = json_decode($post['HomeMemberDataDel'], true);
                        foreach ($memberArr as $k => $member) {
                            // 查询有无team_event_member原数据，有则更新原数据否则插入新数据
                            $hasMatchRecordMember2 = $matchS->getMatchRecordMember(['match_id' => $match['id'], 'match_record_id' => $recordData['id'], 'member_id' => $member['member_id']]);
                            if ($hasMatchRecordMember2) {
                                $memberArr[$k]['id'] = $hasMatchRecordMember2['id'];
                            }
                            $memberArr[$k]['status'] = -1;
                        }
                        $resultsaveMatchRecordMember2 = $matchS->saveAllMatchRecordMember($memberArr);
                        /*if ($saveTeamEventMemberResult2['code'] == 100) {
                            return json(['code' => 100, 'msg' => '修改活动人员出错']);
                        }*/
                    }
                    // 保存球队参赛人员end
                    // 保存match_record数据
                    $resultSaveMatchRecord = $matchS->saveMatchRecord($recordData);
                    // 保存match_record数据失败 抛出提示
                    if ($resultSaveMatchRecord['code'] == 100) {
                        return json(['code' => 100, 'msg' => '保存比赛比分失败']);
                    } else {
                        // 更新match数据
                        $dataMatch = $post;
                        // 当前时间大于比赛时间 即比赛完成
                        $matchTimeStamp = strtotime($post['match_time']);
                        if ($nowTime > $matchTimeStamp) {
                            $dataMatch['finished_time'] = $matchTimeStamp;
                            $dataMatch['is_finished'] = 1;
                            //$dataMatch['id'] = $match['id'];
                        }
                        $resultSaveMatch = $matchS->saveMatch($dataMatch);
                        if ($resultSaveMatch['code'] == 100) {
                            return json(['code' => 100, 'msg' => '更新比赛信息失败']);
                        }
                        return json($resultSaveMatchRecord);
                    }
                }
            } else {
                // 插入比赛+比赛战绩数据
                // 组合保存match表数据
                $post['team'] = db('team')->where('id', $post['team_id'])->value('name');
                $post['member_id'] = $this->memberInfo['id'];
                $post['member'] = $this->memberInfo['member'];
                $post['member_avatar'] = $this->memberInfo['avatar'];
                if (isset($post['record']['away_team_id'])) {
                    $post['name'] = $post['record']['home_team'] . ' vs ' . $post['record']['away_team'] . '（友谊赛）';
                } else {
                    $post['name'] = $post['record']['home_team'] . '友谊赛（对手待定）';
                }
                // 当前时间大于比赛时间 即比赛完成
                $matchTimeStamp = strtotime($post['match_time']);
                if ($nowTime > $matchTimeStamp) {
                    $post['finished_time'] = $matchTimeStamp;
                    $post['is_finished'] = 1;
                }
//                dump($post);
                // 保存match表数据
                $resultSaveMatch = $matchS->saveMatch($post);
                //dump($resultddaveMatch);
                // 保存match表数据成功 保存match_record
                if ($resultSaveMatch['code'] == 200) {
                    // 组合match_record数据
                    $recordData = $post['record'];
                    $recordData['match_id'] = $resultSaveMatch['data'];
                    $recordData['match'] = $post['name'];
                    $recordData['match_time'] = $matchTimeStamp;
                    $recordData['team_id'] = $post['team_id'];
                    // 相册不为空保存数据
                    if (isset($post['album']) && $post['album'] != "[]") {
                        $recordData['album'] = $post['album'];
                    }
                    // 保存match_record数据
                    $resultSaveMatchRecord = $matchS->saveMatchRecord($recordData);
                    // 保存match_record数据失败 抛出提示
                    if ($resultSaveMatchRecord['code'] == 100) {
                        return json(['code' => 100, 'msg' => '保存比赛比分失败']);
                    }

                    // 保存球队参赛人员
                    // 有效显示成员名单
                    if (isset($post['HomeMemberData']) && $post['HomeMemberData'] != "[]") {
                        $homeMember = json_decode($post['HomeMemberData'], true);
                        foreach ($homeMember as $k => $val) {
                            $homeMember[$k]['match_id'] = $resultSaveMatch['data'];
                            $homeMember[$k]['match'] = $post['name'];
                            $homeMember[$k]['team_id'] = $recordData['team_id'];
                            $homeMember[$k]['team'] = $recordData['home_team'];
                            $homeMember[$k]['match_record_id'] = $resultSaveMatchRecord['data'];
                            $homeMember[$k]['member_avatar'] = db('member')->where('id', $val['member_id'])->value('avatar');
                            $homeMember[$k]['status'] = 2;
                        }
                        $saveHomeTeamMemberRes = $matchS->saveAllMatchRecordMember($homeMember);
                        if ($saveHomeTeamMemberRes['code'] == 100) {
                            return json($saveHomeTeamMemberRes);
                        }
                    }
                    // 保存球队参赛人员end
                }
                // 更新球队比赛场数、胜场数
                if ($post['record']['home_score'] > 0 && $post['record']['away_score'] > 0 ) {

                }
                // 返回结果
                return json($resultSaveMatch);
            }

        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 比赛列表（页码）+年份
    public function matchlistpage()
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
            unset($map['page']);
            $matchS = new MatchService();
            $result = $matchS->matchListPaginator($map);
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
            unset($map['page']);
            $matchS = new MatchService();
            $result = $matchS->matchList($map, $page);
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
            // 根据比赛当前状态(1上架,-1下架)+不允许操作条件
            // 根据action参数 editstatus执行上下架/del删除操作
            // 更新数据 返回结果
            switch ($match['status_num']) {
                case 1 : {
                    if ($action == 'editstatus') {
                        $response = $matchS->saveMatch(['id' => $match['id'], 'status' => -1]);
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
                        $response = $matchS->saveMatch(['id' => $match['id'], 'status' => 1]);
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
            // 友谊赛获取match_record数据
            if ($match['type_num'] == 1) {
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
                if ($match['record']['away_team_id'] > 0) {
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
                $hasJoinMatch = $matchS->getMatchRecordMember([
                    'match_id' => $match['id'],
                    'member_id' => $this->memberInfo['id'],
                    'status' => 1
                ]);
                if ($hasJoinMatch) {
                    return json(['code' => 100, 'msg' => '您已报名参加此比赛，无需再次报名']);
                }

                // 组合保存报名比赛信息
                $dataRecordMember = [
                    'match_id' => $match['id'],
                    'match' => $match['name'],
                    'match_record_id' => $match['record']['id'],
                    'member_id' => $this->memberInfo['id'],
                    'member' => $this->memberInfo['member'],
                    'member_avatar' => $this->memberInfo['avatar'],
                    'status' => 1
                ];
                if ($inHomeTeam) {
                    $dataRecordMember['team_id'] = $inHomeTeam['team_id'];
                    $dataRecordMember['team'] = $inHomeTeam['team'];
                } elseif ($inAwayTeam) {
                    $dataRecordMember['team_id'] = $inAwayTeam['team_id'];
                    $dataRecordMember['team'] = $inAwayTeam['team'];
                }
//                dump($dataRecordMember);
                // 保存报名比赛信息数据
                $result = $matchS->saveMatchRecordMember($dataRecordMember);
                return json($result);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 最新比赛记录

    // 球队历史对手

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
            if (input('?year')) {
                $year = input('year');
                if (is_numeric($year)) {
                    $tInterval = getStartAndEndUnixTimestamp($year);
                    $map['match_time'] = ['between', [$tInterval['start'], $tInterval['end']]];
                }
                unset($map['year']);
            }
            unset($map['page']);
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
                    $map['match_time'] = ['between', [$tInterval['start'], $tInterval['end']]];
                }
                unset($map['year']);
            }
            unset($map['page']);
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
}
