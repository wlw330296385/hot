<?php
// 比赛api
namespace app\api\controller;

use app\service\MatchService;
use app\service\TeamService;
use think\Exception;

class Match extends Base {
    // 创建比赛
    public function creatematch() {
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
                if (!$data['team_id']) {
                    return json(['code' => 100, 'msg' => __lang('MSG_402').'请选择主队球队']);
                }
                $homeTeamId = $data['team_id'];
                $homeTeam = $teamS->getTeam(['id' => $homeTeamId]);
                //dump($homeTeam);
                $data['team'] = $homeTeam['name'];
                $dataHometeam = [
                    'home_team_id' => $homeTeam['id'],
                    'home_team' => $homeTeam['name'],
                    'home_team_logo' => $homeTeam['logo'],
                    'home_team_color' => $data['home_team_color'],
                    'home_team_colorstyle' => $data['home_team_colorstyle']
                ];
                $dataMatchRecord = array_merge($dataMatchRecord, $dataHometeam);
                // 客队信息保存数据组合
                if (!empty($data['opponent_id'])) {
                    if ($data['opponent_id'] == $data['team_id']) {
                        return json(['code' => 100, 'msg' => '请选择其他球队']);
                    }
                    $awayTeam = $teamS->getTeam(['id' => $data['opponent_id']]);
                    $dataAwayteam = [
                        'away_team_id' => $awayTeam['id'],
                        'away_team' => $awayTeam['name'],
                        'away_team_logo' => $awayTeam['logo'],
                        //'away_team_color' => $data['away_team_color'],
                        //'away_team_colorstyle' => $data['away_team_colorstyle']
                    ];
                    $dataMatchRecord = array_merge($dataMatchRecord, $dataAwayteam);
                }
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

    // 编辑比赛信息
    public function updatematch() {
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
    public function updatematchrecord() {
        try {
            // 接收输入变量
            $data = input('post.');
            $matchS = new MatchService();
            // 当前时间大于输入的比赛时间 记录比赛完成时间和完成状态
            $now = time();
            $matchTimeStamp = strtotime($data['match_time']);
            if ($now > $matchTimeStamp) {
                $data['is_finished'] = 1;
                $data['finished_time'] = 1;
            }
            // 保存比赛战绩数据
            $res = $matchS->saveMatchRecord($data);
            return json($res);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 直接创建录入比赛战绩
    public function creatematchrecord() {
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
                 if (!$data['team_id']) {
                     return json(['code' => 100, 'msg' => __lang('MSG_402').'请选择主队球队']);
                 }
                 $homeTeamId = $data['team_id'];
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
                 if (!$data['opponent_id']) {
                     return json(['code' => 100, 'msg' => '请选择客队球队']);
                 }
                 if (!empty($data['opponent_id'])) {
                     if ($data['opponent_id'] == $data['team_id']) {
                         return json(['code' => 100, 'msg' => '请选择其他球队']);
                     }
                     $awayTeam = $teamS->getTeam(['id' => $data['opponent_id']]);
                     $dataAwayteam = [
                         'away_team_id' => $awayTeam['id'],
                         'away_team' => $awayTeam['name'],
                         'away_team_logo' => $awayTeam['logo'],
                         'away_team_color' => $data['away_team_color'],
                         'away_team_colorstyle' => $data['away_team_colorstyle'],
                         'away_score' => $data['home_score']
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
                 if ($now > $matchTimeStamp) {
                     $dataMatchRecord['finished_time'] = $matchTimeStamp;
                     $dataMatchRecord['is_finished'] = 1;
                     $data['is_finished'] = 1;
                     $data['finished_time'] = 1;
                 }
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
         } catch(Exception $e) {
             return json(['code' => 100, 'msg' => $e->getMessage()]);
         }
    }

    // 比赛列表（页码）+年份
    public function matchlistpage() {
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
    public function matchlist() {
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
    public function matchlistall() {
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

    // 最新比赛记录

    // 球队历史对手

    // 球队比赛列表（页码）+年份
    public function matchteamlistpage() {
        try {

        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队比赛列表+年份

    // 球队比赛列表（所有数据）

    // 球队战绩列表（页码）+年份
    public function matchrecordlistpage() {
        try {
            // 传入变量作为查询条件
            $map = input('param.');
            // 有传入查询年份
            if (input('?year')) {
                $year = input('year');
                if (is_numeric($year)) {
                    $tInterval = getStartAndEndUnixTimestamp($year);
                    $map['finished_time'] = ['between', [$tInterval['start'], $tInterval['end']]];
                }
                unset($map['year']);
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

    // 球队战绩列表+年份
    public function matchrecordlist() {
        try {
            // 传入变量作为查询条件
            $map = input('param.');
            $page = input('page', 1);
            // 有传入查询年份
            if (input('?year')) {
                $year = input('year');
                if (is_numeric($year)) {
                    $tInterval = getStartAndEndUnixTimestamp($year);
                    $map['finished_time'] = ['between', [$tInterval['start'], $tInterval['end']]];
                }
                unset($map['year']);
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

    // 球队战绩列表（所有数据）
    public function matchrecordlistall() {
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
}