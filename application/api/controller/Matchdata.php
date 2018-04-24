<?php
// 比赛数据（球队、球员参加比赛所录入的技术数据统计）api
namespace app\api\controller;


use app\model\MatchStatistics;
use app\service\TeamService;

class Matchdata
{
    // 获取球员赛季数据
    public function playerseasondatastatis() {
        $data = input('param.');
        // 球员id必须传入
        if ( !array_key_exists('tm_id', $data) ) {
            return json(['code' => 100, 'msg' => __lang('MSG_402').'请选择球员']);
        }
        $teamS = new TeamService();
        // 获取球队成员数据
        $teamMemberInfo = $teamS->getTeamMemberInfo(['id' => $data['tm_id']]);
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
            ->field('round(avg(pts),1) as pts, round(avg(ast),1) as ast, round(avg(reb),1) as reb, round(avg(stl),1) as stl, round(avg(blk),1) as blk, round(avg(turnover),1) as turnover, round(avg(foul),1) as foul, round(avg(fg),1) as fg, round(avg(fga),1) as fga, round(avg(3pfg),1) as 3pfg, round(avg(3pfga),1) as 3pfga, round(avg(ft),1) as ft, round(avg(fta),1) as fta')
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
        $avgFg3pHitRate = ( $avgdata['3pfga'] ) ? $avgdata['3pfg']/$avgdata['3pfga'] : 0;
        $avgdata['3pfg_hitrate'] = round($avgFg3pHitRate*100, 1).'%';
        // 平均罚球命中率
        $avgFtHitRate = ( $avgdata['fta'] ) ? $avgdata['ft']/$avgdata['fta'] : 0;
        $avgdata['ft_hitrate'] = round($avgFtHitRate*100, 1).'%';
        // 平均命中率(综合2分与3分）
        $avgHitRate = ($avgdata['fga'] && $avgdata['3pfga']) ? ($avgdata['fg']+$avgdata['3pfg'])/($avgdata['fga']+$avgdata['3pfga']) : 0;
        $avgdata['hitrate'] = round($avgHitRate*100, 1).'%';
        // 数据总和
        $sumdata = [];
        $efficiency = 0;
        $sumdata = $model->where($data)
            ->field('sum(pts) as pts, sum(ast) as ast, sum(reb) as reb, sum(stl) as stl, sum(blk) as blk, sum(turnover) as turnover, sum(foul) as foul, sum(fg) as fg, sum(fga) as fga, sum(fg) as fg, sum(3pfg) as 3pfg, sum(3pfga) as 3pfga, sum(ft) as ft, sum(fta) as fta')
            ->find();
        if ($sumdata) {
            $sumdata = $sumdata->toArray();
        }
        // 效率值 公式：[(得分+篮板+助攻+抢断+封盖)-(出手次数-命中次数)-(罚球次数-罚球命中次数)-失误次数]/球员上场比赛的场次
        // 出手次数
        $sumFga = $sumdata['fga']+$sumdata['3pfga'];
        // 命中次数
        $sumFg = $sumdata['fg']+$sumdata['3pfg'];
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
    }
}