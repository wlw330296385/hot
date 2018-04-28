<?php
// 比赛数据（球队、球员参加比赛所录入的技术数据统计）api
namespace app\api\controller;


use app\model\MatchStatistics;
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
            // 球员id必须传入
            if ( !array_key_exists('team_member_id', $data) ) {
                return json(['code' => 100, 'msg' => __lang('MSG_402').'请选择球员']);
            }
            $teamS = new TeamService();
            // 获取球队成员数据
            $teamMemberInfo = $teamS->getTeamMemberInfo(['id' => $data['team_member_id']]);
            if (!$teamMemberInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404').'无此球员信息']);
            }
            // 赛季时间(年)
            if (input('?param.year')) {
                $year = input('year');
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

            // 查询数据
            $model = new MatchStatistics();

            // 比赛次数
            $matchNumber = $model->where($data)->count();
            // 平均数据
            $avgdata = [];
            $avgdata = $model->where($data)
                ->field('avg(pts) as pts, avg(ast) as ast, avg(reb) as reb, avg(stl) as stl, avg(blk) as blk, avg(turnover) as turnover, avg(foul) as foul, avg(fg) as fg, avg(fga) as fga, avg(threepfg) as threepfg, avg(threepfga) as threepfga, avg(ft) as ft, avg(fta) as fta')
                ->find();
            // 查无赛季均值数据
            if (!$avgdata) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
            if ($avgdata) {
                $avgdata = $avgdata->toArray();
                // 整理字段返回
                $avgdata['pts'] = is_null($avgdata['pts']) ? 0 : round($avgdata['pts'], 1);
                $avgdata['ast'] = is_null($avgdata['ast']) ? 0 : round($avgdata['ast'], 1);
                $avgdata['reb'] = is_null($avgdata['reb']) ? 0 : round($avgdata['reb'], 1);
                $avgdata['stl'] = is_null($avgdata['stl']) ? 0 : round($avgdata['stl'], 1);
                $avgdata['blk'] = is_null($avgdata['blk']) ? 0 : round($avgdata['blk'], 1);
                $avgdata['turnover'] = is_null($avgdata['turnover']) ? 0 : round($avgdata['turnover'], 1);
                $avgdata['foul'] = is_null($avgdata['foul']) ? 0 : round($avgdata['foul'], 1);
                $avgdata['fg'] = is_null($avgdata['fg']) ? 0 : round($avgdata['fg'], 1);
                $avgdata['fga'] = is_null($avgdata['fga']) ? 0 : round($avgdata['fga'], 1);
                $avgdata['threepfg'] = is_null($avgdata['threepfg']) ? 0 : round($avgdata['threepfg'], 1);
                $avgdata['threepfga'] = is_null($avgdata['threepfga']) ? 0 : round($avgdata['threepfga'], 1);
                $avgdata['ft'] = is_null($avgdata['ft']) ? 0 : round($avgdata['ft'], 1);
                $avgdata['fta'] = is_null($avgdata['fta']) ? 0 : round($avgdata['fta'], 1);
            }
            // 首发次数
            $avgdata['avg_lineup'] = $model->where($data)->where('lineup',1)->count();
            // 平均2分命中率
            $avgFgHitRate = ( $avgdata['fga'] ) ? $avgdata['fg']/$avgdata['fga'] : 0;
            $avgdata['fg_hitrate'] = round($avgFgHitRate*100,1).'%';
            // 平均3分命中率
            $avgFg3pHitRate = ( $avgdata['threepfga'] ) ? $avgdata['threepfg']/$avgdata['threepfga'] : 0;
            $avgdata['threepfg_hitrate'] = round($avgFg3pHitRate*100, 1).'%';
            // 平均罚球命中率
            $avgFtHitRate = ( $avgdata['fta'] ) ? $avgdata['ft']/$avgdata['fta'] : 0;
            $avgdata['ft_hitrate'] = round($avgFtHitRate*100, 1).'%';
            // 平均命中率(综合2分与3分）
            $avgHitRate = ($avgdata['fga'] && $avgdata['threepfga']) ? ($avgdata['fg']+$avgdata['threepfg'])/($avgdata['fga']+$avgdata['threepfga']) : 0;
            $avgdata['hitrate'] = round($avgHitRate*100, 1).'%';
            // 数据总和
            $sumdata = [];
            $efficiency = 0;
            $sumdata = $model->where($data)
                ->field('sum(pts) as pts, sum(ast) as ast, sum(reb) as reb, sum(stl) as stl, sum(blk) as blk, sum(turnover) as turnover, sum(foul) as foul, sum(fg) as fg, sum(fga) as fga, sum(fg) as fg, sum(threepfg) as threepfg, sum(threepfga) as threepfga, sum(ft) as ft, sum(fta) as fta')
                ->find();
            if ($sumdata) {
                $sumdata = $sumdata->toArray();
            }
            // 效率值 公式：[(得分+篮板+助攻+抢断+封盖)-(出手次数-命中次数)-(罚球次数-罚球命中次数)-失误次数]/球员上场比赛的场次
            // 出手次数
            $sumFga = $sumdata['fga']+$sumdata['threepfga'];
            // 命中次数
            $sumFg = $sumdata['fg']+$sumdata['threepfg'];
            if ($matchNumber) {
                $efficiency = (($sumdata['pts']+$sumdata['reb']+$sumdata['ast']+$sumdata['stl']+$sumdata['blk']) - ($sumFga-$sumFg) - ($sumdata['fta']-$sumdata['ft']) - $sumdata['turnover']) / $matchNumber ;
            }
            $result = [
                'code' => 200,
                'msg' => __lang('MSG_201'),
                'data' => [
                    'match_number' => $matchNumber,
                    'efficiency' => $efficiency,
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
                if (empty($member['number'])) {
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

                // 组合补充保存数据字段
                $recordMembers[$k]['match_id'] = $data['match_id'];
                $recordMembers[$k]['match'] = $data['match'];
                $recordMembers[$k]['match_record_id'] = $data['match_record_id'];
                $recordMembers[$k]['match_time'] = $data['match_time'];
                $recordMembers[$k]['team_id'] = $data['team_id'];
                $recordMembers[$k]['team'] = $data['team'];
                $recordMembers[$k]['status'] = 1;
                // 球员得分和
                $recordMembers[$k]['pts'] = 2*$val['fg']+3*$val['threepfg']+1*$val['ft'];

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
            return json(['code' => 200, 'msg' => __lang('MSG_200')]);
        }
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
}