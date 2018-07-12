<?php
// 比赛数据（球队、球员参加比赛所录入的技术数据统计）api
namespace app\api\controller;


use app\model\MatchStatistics;
use app\service\LeagueService;
use app\service\MatchDataService;
use app\service\MatchService;
use app\service\MemberService;
use app\service\TeamService;
use think\Exception;

class Matchdata extends Base
{
    // 获取球员赛季数据
    public function playerseasonstatis() {
        try {
            $data = input('param.');
            // 传入球员id
            if ( array_key_exists('team_member_id', $data) ) {
                // 获取球队成员信息
                $teamS = new TeamService();
                $teamMemberInfo = $teamS->getTeamMemberInfo(['id' => $data['team_member_id']]);
                if (!$teamMemberInfo) {
                    return json(['code' => 100, 'msg' => __lang('MSG_404').'无此球员信息']);
                }
            }
            // 传入会员id
            if ( array_key_exists('member_id', $data) ) {
                // 获取会员信息
                $memberS = new MemberService();
                $memberInfo = $memberS->getMemberInfo(['id' => $data['member_id']]);
                if (!$memberInfo) {
                    return json(['code' => 100, 'msg' => __lang('MSG_404').'无此会员信息']);
                }
            }
            // 赛季时间(年)
            if (input('?param.year')) {
                $year = input('year', date('Y', time()));
                // 比赛时间在赛季年
                $when = getStartAndEndUnixTimestamp($year);
                $data['match_time'] = ['between',
                    [ $when['start'], $when['end'] ]
                ];
                unset($data['year']);
            }
            // 有效数据
            $data['status'] = 1;
            // 组合查询条件 end

            $matchDataS = new MatchDataService();
            // 比赛次数
            $matchNumber = $matchDataS->getMatchStaticCount($data);
            // 获取比赛技术统计数据均值
            $avgdata = $matchDataS->getMatchStaticAvg($data);
            // 首发次数
            $avgdata['avg_lineup'] = $matchDataS->getMatchStaticLineUpCount($data);
            // 获取比赛技术统计数据总和
            $sumdata = $matchDataS->getMatchStaticSum($data);
            // 效率值 公式：[(得分+篮板+助攻+抢断+封盖)-(出手次数-命中次数)-(罚球次数-罚球命中次数)-失误次数]/球员上场比赛的场次
            $efficiency = 0;
            if ($matchNumber) {
                $efficiency = (($sumdata['pts']+$sumdata['reb']+$sumdata['ast']+$sumdata['stl']+$sumdata['blk']) - (($sumdata['fga']+$sumdata['threepfga'])-($sumdata['fg']+$sumdata['threepfg'])) - ($sumdata['fta']-$sumdata['ft']) - $sumdata['turnover']) / $matchNumber ;
            }
            $result = [
                'code' => 200,
                'msg' => __lang('MSG_201'),
                'data' => [
                    'match_number' => $matchNumber,
                    'efficiency' => round($efficiency, 1),
                    'avgdata' => $avgdata,
                    //'sumdata' => $sumdata
                ]
            ];
            return json($result);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => __lang('MSG_000')]);
        }
    }

    // 球队录入球队比赛技术数据
    public function savematchstatisticsbyteam() {
        $data = input('post.');
        // 验证数据字段
        if ( !array_key_exists('match_id', $data) ) {
            return json(['code' => 100, 'msg' => '请输入比赛id']);
        }
        if ( !array_key_exists('match_record_id', $data) ) {
            return json(['code' => 100, 'msg' => '请输入比赛战绩id']);
        }
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        // 比赛时间格式转化
        $data['match_time'] = checkDatetimeIsValid($data['match_time']) ? strtotime($data['match_time']) : $data['match_time'];
        $model = new MatchStatistics();
        $matchS = new MatchService();
        $teamS = new TeamService();
        $memberS = new MemberService();
        // 删除球员技术统计数据
        if ( array_key_exists('delMembers', $data) && !empty($data['delMembers']) && $data['delMembers'] != '[]' ) {
            $delIds = json_decode($data['delMembers'], true);
            foreach ($delIds as $k => $val) {
                $matchStaticInfo = $model->where('id', $val['id'])->find();
                if ($matchStaticInfo) {
                    // 记录删除比赛技术数据日志
                    db('log_match_statistics')->insert([
                        'member_id' => $this->memberInfo['id'],
                        'member' => $this->memberInfo['member'],
                        'action' => 'delete',
                        'more' => json_encode($matchStaticInfo->toArray(), JSON_UNESCAPED_UNICODE),
                        'referer' => input('server.http_referer'),
                        'create_time' => date('Ymd H:i', time())
                    ]);
                }
                try {
                    $model::destroy($val['id'], true);
                }  catch (Exception $e) {
                    return json(['code' => 100, 'msg' => '删除球员数据'.__lang('MSG_400')]);
                }
            }
        }
        // 球员名单技术统计数据
        if ( array_key_exists('members', $data) && !empty($data['members']) && $data['members'] != "[]" ) {
            $recordMembers = json_decode($data['members'], true);
            foreach ($recordMembers as $k => $val) {
                // 球衣号码可为空
                if (empty($val['number'])) {
                    $recordMembers[$k]['number'] = null;
                }
                // 提交了无参赛信息的球员（会员）数据 需要保存出赛会员(match_record_member)信息
                if (!$val['match_record_member_id']) {
                    $matchRecordMemberData = [];
                    $matchRecordMemberData['match_id'] = $data['match_id'];
                    $matchRecordMemberData['match'] = $data['match'];
                    $matchRecordMemberData['match_record_id'] = $data['match_record_id'];
                    $matchRecordMemberData['match_time'] = $data['match_time'];
                    $matchRecordMemberData['is_apply'] = -1;
                    $matchRecordMemberData['is_attend'] = 1;
                    $matchRecordMemberData['is_checkin'] = 1;
                    $matchRecordMemberData['status'] = 1;
                    if ($val['team_member_id']) {
                        // 获取球员(team_member)数据
                        $teamMemberInfo = $teamS->getTeamMemberInfo(['id' => $val['team_member_id']]);
                        if (!$teamMemberInfo) {
                            return json(['code' => 100, 'msg' => __lang('MSG_404').'球队里没有'.$val['name'].'这个人喔']);
                        }
                        $matchRecordMemberData['team_id'] = $teamMemberInfo['team_id'];
                        $matchRecordMemberData['team'] = $teamMemberInfo['team'];
                        $matchRecordMemberData['team_member_id'] = $teamMemberInfo['id'];
                        $matchRecordMemberData['member'] = $teamMemberInfo['member'];
                        $matchRecordMemberData['member_id'] = $teamMemberInfo['member_id'];
                        $matchRecordMemberData['name'] = $teamMemberInfo['name'];
                        $matchRecordMemberData['number'] = empty($val['number']) ? null : $val['number'];
                        $matchRecordMemberData['avatar'] = $teamMemberInfo['avatar'];
                        $matchRecordMemberData['contact_tel'] = $teamMemberInfo['telephone'];
                    } else {
                        if (isset($val['member_id'])) {
                            // 获取会员(member)数据
                            $memberInfo = $memberS->getMemberInfo(['id'=>$val['member_id']]);
                            if (!$memberInfo) {
                                return json(['code' => 100, 'msg' => __lang('MSG_404').$val['name'].'不是会员喔']);
                            }
                            $matchRecordMemberData['member'] = $memberInfo['member'];
                            $matchRecordMemberData['member_id'] = $memberInfo['id'];
                            $matchRecordMemberData['name'] = $memberInfo['member'];
                            $matchRecordMemberData['number'] = empty($val['number']) ? null : $val['number'];
                            $matchRecordMemberData['avatar'] = $memberInfo['avatar'];
                            $matchRecordMemberData['contact_tel'] = $memberInfo['telephone'];
                        } else {
                            // 非注册会员
                            $matchRecordMemberData['member'] = $val['name'];
                            $matchRecordMemberData['member_id'] = 0;
                            $matchRecordMemberData['name'] = $val['name'];
                            $matchRecordMemberData['number'] = empty($val['number']) ? null : $val['number'];
                            $matchRecordMemberData['avatar'] = config('default_image.member_avatar');
                            $matchRecordMemberData['contact_tel'] = 0;
                        }
                        $matchRecordMemberData['team_id'] = $data['team_id'];
                        $matchRecordMemberData['team'] =  $data['team'];
                        $matchRecordMemberData['team_member_id'] = 0;
                    }
                    // 有无比赛战绩原数据
                    $hasMatchRecordMember = $matchS->getMatchRecordMember([
                        'match_id' => $data['match_id'],
                        'match_record_id' => $data['match_record_id'],
                        'team_member_id' => $val['team_member_id'],
                        'name' => $val['name']
                    ]);
                    if ($hasMatchRecordMember) {
                        $matchRecordMemberData['id'] = $hasMatchRecordMember['id'];
                    }
                    // 保存比赛出赛球员关系数据
                    try {
                        $resMatchRecordMember = $matchS->saveMatchRecordMember($matchRecordMemberData);
                    } catch (Exception $e) {
                        return json(['code' => 100, 'msg' => '保存该球员出赛信息出错']);
                    }
                    if ($hasMatchRecordMember) {
                        $recordMembers[$k]['match_record_member_id'] = $hasMatchRecordMember['id'];
                        $val['match_record_member_id'] = $hasMatchRecordMember['id'];
                    } else {
                        $recordMembers[$k]['match_record_member_id'] = $resMatchRecordMember['data'];
                        $val['match_record_member_id'] = $resMatchRecordMember['data'];
                    }
                }
                // 更新球员参赛信息球衣号码
                if ($val['match_record_member_id'] && !empty($val['number'])) {
                    $matchS->saveMatchRecordMember([
                        'id' => $val['match_record_member_id'],
                        'number' => $val['number']
                    ]);
                }

                // 组合补充保存数据字段
                $recordMembers[$k]['match_id'] = $data['match_id'];
                $recordMembers[$k]['match'] = $data['match'];
                $recordMembers[$k]['match_record_id'] = $data['match_record_id'];
                $recordMembers[$k]['match_time'] = $data['match_time'];
                $recordMembers[$k]['team_id'] = $data['team_id'];
                $recordMembers[$k]['team'] = $data['team'];
                $recordMembers[$k]['status'] = 1;
                // 球员得分和
                $fg = ($val['fg']) ? $val['fg'] : 0;
                $threepfg = ($val['threepfg']) ? $val['threepfg'] : 0;
                $ft = ($val['ft']) ? $val['ft'] : 0;
                $recordMembers[$k]['pts'] = 2*$fg+3*$threepfg+1*$ft;

                // 查询有无已有数据记录
                $memberMatchStatisticsInfo = $model->where([
                    'match_id' => $data['match_id'],
                    'match_record_id' => $data['match_record_id'],
                    'match_record_member_id' => $val['match_record_member_id'],
                    'team_member_id' => $val['team_member_id'],
                ])->find();
                if ($memberMatchStatisticsInfo) {
                    $memberMatchStatisticsInfo = $memberMatchStatisticsInfo->toArray();
                    $recordMembers[$k]['id'] = $memberMatchStatisticsInfo['id'];
                }
            }
            // 保存球员比赛技术数据入库
            try {
                $res = $model->allowField(true)->saveAll($recordMembers);
            } catch (Exception $e) {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return json(['code' => 100, 'msg' => __lang('MSG_400')]);
            }
            if (!$res) {
                return json(['code' => 100, 'msg' => __lang('MSG_400')]);
            }
            // 更新比赛战绩 已录入技术统计标识
            $matchS->saveMatchRecord([
                'id' => $data['match_record_id'],
                'has_statics' => 1,
                'statics_time' => time()
            ]);
            // 球队录入比赛统计数据次数+1
            db('team')->where('id', $data['team_id'])->setInc('statics_num', 1);
            return json(['code' => 200, 'msg' => __lang('MSG_200')]);
        }
    }

    // 删除比赛技术统计数据
    public function delmatchstatics() {
        $matchRecordId = input('match_record_id', 0, 'intval');
        if (!$matchRecordId) {
            return json(['code' => 100, 'msg' => __lang('MSG_402')]);
        }
        // 获取比赛数据
        $matchS = new MatchService();
        $matchRecordInfo = $matchS->getMatchRecord(['id' => $matchRecordId]);
        if (!$matchRecordInfo) {
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
        // 当前会员有无操作权限：查询比赛所属球队team_member_role
        $teamS = new TeamService();
        $teamrole = $teamS->checkMemberTeamRole($matchRecordInfo['team_id'], $this->memberInfo['id']);
        if (!$teamrole) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        // 查询比赛的技术统计数据记录
        $matchStaticsList = $matchS->getMatchStatisticsAll([
            'match_record_id' => $matchRecordInfo['id'],
            'match_id' => $matchRecordInfo['match_id']
        ]);
        if ($matchStaticsList) {
            foreach ($matchStaticsList as $val) {
                // 记录删除比赛技术数据日志
                db('log_match_statistics')->insert([
                    'member_id' => $this->memberInfo['id'],
                    'member' => $this->memberInfo['member'],
                    'action' => 'delete',
                    'more' => json_encode($val, JSON_UNESCAPED_UNICODE),
                    'referer' => input('server.http_referer'),
                    'create_time' => date('Ymd H:i', time())
                ]);
                // 真实删除数据
                try {
                    MatchStatistics::destroy($val['id'], true);
                } catch (\Exception $e) {
                    trace($e->getMessage(), 'error');
                    return json(['code' => 100, 'msg' => __lang('MSG_400')]);
                }
            }
        }
        // 更新比赛战绩数据为无登记技术统计
        try {
            $matchS->saveMatchRecord([
                'id' => $matchRecordInfo['id'],
                'has_statics' => 0,
                'statics_time' => null
            ]);
            // 球队录入比赛统计数据次数-1
            db('team')->where('id', $matchRecordInfo['team_id'])->setDec('statics_num', 1);
        } catch (\Exception $e) {
            trace($e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }

        return json(['code' => 200, 'msg' => __lang('MSG_200')]);
    }

    // 获取球员在某场比赛的技术统计数据
    public function getplayermatchstatis() {
        try {
            $data = input('param.');
            // 必须team_member_id
            if (!array_key_exists('team_member_id', $data)) {
                return json(['code' => 100, 'msg' => __lang('MSG_402').'传入球员ID']);
            }
            // 必须match_id
            if (!array_key_exists('match_id', $data)) {
                return json(['code' => 100, 'msg' => __lang('MSG_402').'传入比赛ID']);
            }
            // 必须match_record_id
            if (!array_key_exists('match_record_id', $data)) {
                return json(['code' => 100, 'msg' => __lang('MSG_402').'传入比赛战绩ID']);
            }
            // 获取球员比赛技术统计数据
            $matchS = new MatchService();
            $result = $matchS->getMatchStatistics($data);
            // 返回无数据结果
            if (!$result) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
            // 计算单场技术数据效率值:(得分+篮板+助攻+抢断+封盖)-(出手次数-命中次数)-(罚球次数-罚球命中次数)-失误次数
            $result['efficiency'] = ($result['pts']+$result['reb']+$result['ast']+$result['stl']+$result['blk']) - ( ($result['fga']+$result['threepfga'])-($result['fg']+$result['threepfg']) ) - ($result['fta']-$result['ft']) - $result['turnover'];
            // 2分命中率
            $fgHitRate = ( $result['fga'] ) ? $result['fg']/$result['fga'] : 0;
            $result['fg_hitrate'] = round($fgHitRate*100,1).'%';
            // 3分命中率
            $fg3pHitRate = ( $result['threepfga'] ) ? $result['threepfg']/$result['threepfga'] : 0;
            $result['threepfg_hitrate'] = round($fg3pHitRate*100, 1).'%';
            // 罚球命中率
            $ftHitRate = ( $result['fta'] ) ? $result['ft']/$result['fta'] : 0;
            $result['ft_hitrate'] = round($ftHitRate*100, 1).'%';
            // 平均命中率(综合2分与3分）
            $hitRate = ($result['fga'] && $result['threepfga']) ? ($result['fg'] + $result['threepfg']) / ($result['fga'] + $result['threepfga']) : 0;
            $result['hitrate'] = round($hitRate*100, 1).'%';
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => __lang('MSG_401')]);
        }
    }

    // 保存（联赛）单场比赛双方球队的统计数据+球员出席比赛数据
    public function savematchstatisticsbyleague() {
        $data = input('post.');
        // 验证数据字段
        if ( !array_key_exists('match_id', $data) ) {
            return json(['code' => 100, 'msg' => '请输入比赛id']);
        }
        if ( !array_key_exists('match_record_id', $data) ) {
            return json(['code' => 100, 'msg' => '请输入比赛战绩id']);
        }
        $model = new MatchStatistics();
        $matchS = new MatchService();
        $teamS = new TeamService();
        $memberS = new MemberService();
        $leagueS = new LeagueService();
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }
        $power = $leagueS->getMatchMemberType([
            'match_id' => $data['match_id'],
            'member_id' => $this->memberInfo['id'],
            'status' => 1
        ]);
        // 需要联赛记分员以上
        if (!$power || $power < 8) {
            return json(['code' => 100, 'msg' => __lang('MSG_403')]);
        }
        // 比赛时间格式转化
        $data['match_time'] = checkDatetimeIsValid($data['match_time']) ? strtotime($data['match_time']) : $data['match_time'];
        // 球员名单技术统计数据
        if ( array_key_exists('members', $data) && !empty($data['members']) && $data['members'] != "[]" ) {
            $recordMembers = json_decode($data['members'], true);
            foreach ($recordMembers as $k => $val) {
                // 球衣号码可为空
                if (empty($val['number'])) {
                    $recordMembers[$k]['number'] = null;
                }
                // 提交了无参赛信息的球员（会员）数据 需要保存出赛会员(match_record_member)信息
                if (!$val['match_record_member_id']) {
                    $matchRecordMemberData = [];
                    $matchRecordMemberData['match_id'] = $data['match_id'];
                    $matchRecordMemberData['match'] = $data['match'];
                    $matchRecordMemberData['match_record_id'] = $data['match_record_id'];
                    $matchRecordMemberData['match_time'] = $data['match_time'];
                    $matchRecordMemberData['is_apply'] = -1;
                    $matchRecordMemberData['is_attend'] = $val['is_attend'];
                    $matchRecordMemberData['is_checkin'] = 1;
                    $matchRecordMemberData['status'] = 1;
                    if ($val['team_member_id']) {
                        // 获取球员(team_member)数据
                        $teamMemberInfo = $teamS->getTeamMemberInfo(['id' => $val['team_member_id']]);
                        if (!$teamMemberInfo) {
                            return json(['code' => 100, 'msg' => __lang('MSG_404').'球队里没有'.$val['name'].'这个人喔']);
                        }
                        $matchRecordMemberData['team_id'] = $teamMemberInfo['team_id'];
                        $matchRecordMemberData['team'] = $teamMemberInfo['team'];
                        $matchRecordMemberData['team_member_id'] = $teamMemberInfo['id'];
                        $matchRecordMemberData['member'] = $teamMemberInfo['member'];
                        $matchRecordMemberData['member_id'] = $teamMemberInfo['member_id'];
                        $matchRecordMemberData['name'] = $teamMemberInfo['name'];
                        $matchRecordMemberData['number'] = empty($val['number']) ? null : $val['number'];
                        $matchRecordMemberData['avatar'] = $teamMemberInfo['avatar'];
                        $matchRecordMemberData['contact_tel'] = $teamMemberInfo['telephone'];
                    } else {
                        if (isset($val['member_id'])) {
                            // 获取会员(member)数据
                            $memberInfo = $memberS->getMemberInfo(['id'=>$val['member_id']]);
                            $matchRecordMemberData['member'] = $memberInfo['member'];
                            $matchRecordMemberData['member_id'] = $memberInfo['id'];
                            $matchRecordMemberData['name'] = $memberInfo['member'];
                            $matchRecordMemberData['number'] = empty($val['number']) ? null : $val['number'];
                            $matchRecordMemberData['avatar'] = $memberInfo['avatar'];
                            $matchRecordMemberData['contact_tel'] = $memberInfo['telephone'];
                        } else {
                            // 非注册会员
                            $matchRecordMemberData['member'] = $val['name'];
                            $matchRecordMemberData['member_id'] = 0;
                            $matchRecordMemberData['name'] = $val['name'];
                            $matchRecordMemberData['number'] = empty($val['number']) ? null : $val['number'];
                            $matchRecordMemberData['avatar'] = config('default_image.member_avatar');
                            $matchRecordMemberData['contact_tel'] = 0;
                        }
                        $matchRecordMemberData['team_id'] = $data['team_id'];
                        $matchRecordMemberData['team'] =  $data['team'];
                        $matchRecordMemberData['team_member_id'] = 0;
                    }
                    // 有无比赛战绩原数据
                    $hasMatchRecordMember = $matchS->getMatchRecordMember([
                        'match_id' => $data['match_id'],
                        'match_record_id' => $data['match_record_id'],
                        'team_member_id' => $val['team_member_id'],
                        'name' => $val['name']
                    ]);
                    if ($hasMatchRecordMember) {
                        $matchRecordMemberData['id'] = $hasMatchRecordMember['id'];
                    }
                    // 保存比赛出赛球员关系数据
                    try {
                        $resMatchRecordMember = $matchS->saveMatchRecordMember($matchRecordMemberData);
                    } catch (Exception $e) {
                        return json(['code' => 100, 'msg' => '保存该球员出赛信息出错']);
                    }
                    if ($hasMatchRecordMember) {
                        $recordMembers[$k]['match_record_member_id'] = $hasMatchRecordMember['id'];
                        $val['match_record_member_id'] = $hasMatchRecordMember['id'];
                    } else {
                        $recordMembers[$k]['match_record_member_id'] = $resMatchRecordMember['data'];
                        $val['match_record_member_id'] = $resMatchRecordMember['data'];
                    }
                }

                // 组合补充保存数据字段
                $recordMembers[$k]['match_id'] = $data['match_id'];
                $recordMembers[$k]['match'] = $data['match'];
                $recordMembers[$k]['match_record_id'] = $data['match_record_id'];
                $recordMembers[$k]['match_time'] = $data['match_time'];
                $recordMembers[$k]['team_id'] = $data['team_id'];
                $recordMembers[$k]['team'] = $data['team'];
                $recordMembers[$k]['status'] = 1;
                // 球员得分和
                $fg = ($val['fg']) ? $val['fg'] : 0;
                $threepfg = ($val['threepfg']) ? $val['threepfg'] : 0;
                $ft = ($val['ft']) ? $val['ft'] : 0;
                $recordMembers[$k]['pts'] = 2*$fg+3*$threepfg+1*$ft;

                // 查询有无已有数据记录
                $memberMatchStatisticsInfo = $model->where([
                    'match_id' => $data['match_id'],
                    'match_record_id' => $data['match_record_id'],
                    'match_record_member_id' => $val['match_record_member_id'],
                    'team_member_id' => $val['team_member_id'],
                ])->find();
                if ($memberMatchStatisticsInfo) {
                    $memberMatchStatisticsInfo = $memberMatchStatisticsInfo->toArray();
                    $recordMembers[$k]['id'] = $memberMatchStatisticsInfo['id'];
                }
            }
            // 保存球员比赛技术数据入库
            try {
                $res = $model->allowField(true)->saveAll($recordMembers);
            } catch (Exception $e) {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return json(['code' => 100, 'msg' => __lang('MSG_400')]);
            }
            if (!$res) {
                return json(['code' => 100, 'msg' => __lang('MSG_400')]);
            }
            // 更新比赛战绩 已录入技术统计标识
            $matchS->saveMatchRecord([
                'id' => $data['match_record_id'],
                'has_statics' => 1,
                'statics_time' => time()
            ]);
            // 球队录入比赛统计数据次数+1
            return json(['code' => 200, 'msg' => __lang('MSG_200')]);
        } else {
            return json(['code' => 100, 'msg' => __lang('MSG_402')]);
        }
    }

}