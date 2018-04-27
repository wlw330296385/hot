<?php
// 比赛数据（球队、球员参加比赛所录入的技术数据统计）api
namespace app\api\controller;


use app\model\MatchStatistics;
use app\service\MatchService;
use app\service\TeamService;
use think\Exception;

class Matchdata
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
                ->field('round(avg(pts),1) as pts, round(avg(ast),1) as ast, round(avg(reb),1) as reb, round(avg(stl),1) as stl, round(avg(blk),1) as blk, round(avg(turnover),1) as turnover, round(avg(foul),1) as foul, round(avg(fg),1) as fg, round(avg(fga),1) as fga, round(avg(threepfg),1) as threepfg, round(avg(threepfga),1) as threepfga, round(avg(ft),1) as ft, round(avg(fta),1) as fta')
                ->find();
            if ($avgdata) {
                $avgdata = $avgdata->toArray();
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
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
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
        // 比赛时间格式转化
        $data['match_time'] = checkDatetimeIsValid($data['match_time']) ? strtotime($data['match_time']) : $data['match_time'];
        $model = new MatchStatistics();
        $matchS = new MatchService();
        // 球员名单数据列表
        if ( array_key_exists('members', $data) && !empty($data['members']) && $data['members'] != "[]" ) {
            $recordMembers = json_decode($data['members'], true);
            foreach ($recordMembers as $k => $member) {
                // 组合补充保存数据字段
                $recordMembers[$k]['match_id'] = $data['match_id'];
                $recordMembers[$k]['match'] = $data['match'];
                $recordMembers[$k]['match_record_id'] = $data['match_record_id'];
                $recordMembers[$k]['match_time'] = $data['match_time'];
                $recordMembers[$k]['team_id'] = $data['team_id'];
                $recordMembers[$k]['team'] = $data['team'];
                $recordMembers[$k]['status'] = 1;
                // 球员得分和
                $recordMembers[$k]['pts'] = 2*$member['fg']+3*$member['threepfg']+1*$member['ft'];
                // 查询有无已有数据记录
                $memberMatchStatisticsInfo = $model->where([
                    'match_id' => $data['match_id'],
                    'match_record_id' => $data['match_record_id'],
                    //'match_record_member_id' => $member['match_record_member_id'],
                    'team_member_id' => $member['team_member_id'],
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
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result]);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => __lang('MSG_401')]);
        }
    }
}