<?php
// 比赛数据统计service
namespace app\service;
use app\model\MatchStatistics;

class MatchDataService
{
    // 获取比赛技术数据均值
    public function getMatchStaticAvg($map) {
        $model = new MatchStatistics();
        $res = $model->where($map)
            ->field('avg(pts) as pts, avg(ast) as ast, avg(reb) as reb, avg(stl) as stl, avg(blk) as blk, avg(turnover) as turnover, avg(foul) as foul, avg(fg) as fg, avg(fga) as fga, avg(threepfg) as threepfg, avg(threepfga) as threepfga, avg(ft) as ft, avg(fta) as fta')
            ->find();
        $result = $res->toArray();
        // 返回字段为null设为0
        $result['pts'] = is_null($result['pts']) ? 0 : round($result['pts'], 1);
        $result['ast'] = is_null($result['ast']) ? 0 : round($result['ast'], 1);
        $result['reb'] = is_null($result['reb']) ? 0 : round($result['reb'], 1);
        $result['stl'] = is_null($result['stl']) ? 0 : round($result['stl'], 1);
        $result['blk'] = is_null($result['blk']) ? 0 : round($result['blk'], 1);
        $result['turnover'] = is_null($result['turnover']) ? 0 : round($result['turnover'], 1);
        $result['foul'] = is_null($result['foul']) ? 0 : round($result['foul'], 1);
        $result['fg'] = is_null($result['fg']) ? 0 : round($result['fg'], 1);
        $result['fga'] = is_null($result['fga']) ? 0 : round($result['fga'], 1);
        $result['threepfg'] = is_null($result['threepfg']) ? 0 : round($result['threepfg'], 1);
        $result['threepfga'] = is_null($result['threepfga']) ? 0 : round($result['threepfga'], 1);
        $result['ft'] = is_null($result['ft']) ? 0 : round($result['ft'], 1);
        $result['fta'] = is_null($result['fta']) ? 0 : round($result['fta'], 1);
        // 平均2分命中率
        $fgHitRate = ( $result['fga'] ) ? $result['fg']/$result['fga'] : 0;
        $result['fg_hitrate'] = round($fgHitRate*100,1).'%';
        // 平均3分命中率
        $fg3pHitRate = ( $result['threepfga'] ) ? $result['threepfg']/$result['threepfga'] : 0;
        $result['threepfg_hitrate'] = round($fg3pHitRate*100, 1).'%';
        // 平均罚球命中率
        $ftHitRate = ( $result['fta'] ) ? $result['ft']/$result['fta'] : 0;
        $result['ft_hitrate'] = round($ftHitRate*100, 1).'%';
        // 平均命中率(综合2分与3分）
        $hitRate = ($result['fga'] && $result['threepfga']) ? ($result['fg']+$result['threepfg'])/($result['fga']+$result['threepfga']) : 0;
        $result['hitrate'] = round($hitRate*100, 1).'%';
        return $result;
    }

    // 获取比赛技术数据总和
    public function getMatchStaticSum($map) {
        $model = new MatchStatistics();
        $res = $model->where($map)
            ->field('sum(pts) as pts, sum(ast) as ast, sum(reb) as reb, sum(stl) as stl, sum(blk) as blk, sum(turnover) as turnover, sum(foul) as foul, sum(fg) as fg, sum(fga) as fga, sum(fg) as fg, sum(threepfg) as threepfg, sum(threepfga) as threepfga, sum(ft) as ft, sum(fta) as fta')
            ->find();
        $result = $res->toArray();
        // 返回字段为null设为0
        $result['pts'] = is_null($result['pts']) ? 0 : round($result['pts'], 1);
        $result['ast'] = is_null($result['ast']) ? 0 : round($result['ast'], 1);
        $result['reb'] = is_null($result['reb']) ? 0 : round($result['reb'], 1);
        $result['stl'] = is_null($result['stl']) ? 0 : round($result['stl'], 1);
        $result['blk'] = is_null($result['blk']) ? 0 : round($result['blk'], 1);
        $result['turnover'] = is_null($result['turnover']) ? 0 : round($result['turnover'], 1);
        $result['foul'] = is_null($result['foul']) ? 0 : round($result['foul'], 1);
        $result['fg'] = is_null($result['fg']) ? 0 : round($result['fg'], 1);
        $result['fga'] = is_null($result['fga']) ? 0 : round($result['fga'], 1);
        $result['threepfg'] = is_null($result['threepfg']) ? 0 : round($result['threepfg'], 1);
        $result['threepfga'] = is_null($result['threepfga']) ? 0 : round($result['threepfga'], 1);
        $result['ft'] = is_null($result['ft']) ? 0 : round($result['ft'], 1);
        $result['fta'] = is_null($result['fta']) ? 0 : round($result['fta'], 1);
        // 平均2分命中率
        $fgHitRate = ($result['fga']) ? $result['fg'] / $result['fga'] : 0;
        $result['fg_hitrate'] = round($fgHitRate * 100, 1) . '%';
        // 平均3分命中率
        $fg3pHitRate = ($result['threepfga']) ? $result['threepfg'] / $result['threepfga'] : 0;
        $result['threepfg_hitrate'] = round($fg3pHitRate * 100, 1) . '%';
        // 平均罚球命中率
        $ftHitRate = ($result['fta']) ? $result['ft'] / $result['fta'] : 0;
        $result['ft_hitrate'] = round($ftHitRate * 100, 1) . '%';
        // 平均命中率(综合2分与3分）
        $hitRate = ($result['fga'] && $result['threepfga']) ? ($result['fg'] + $result['threepfg']) / ($result['fga'] + $result['threepfga']) : 0;
        $result['hitrate'] = round($hitRate * 100, 1) . '%';
        return $result;
    }

    // 获取数据记录数
    public function getMatchStaticCount($map) {
        $model = new MatchStatistics();
        $res = $model->where($map)->count();
        return ($res) ? $res : 0;
    }

    // 获取比赛首发次数
    public function getMatchStaticLineUpCount($map) {
        $model = new MatchStatistics();
        if ( !array_key_exists('lineup', $map) ) {
            $map['lineup'] = 1;
        }
        $res = $model->where($map)->count();
        return ($res) ? $res : 0;
    }

    // 根据球员id作分组，获取单个技术统计字段的总和
    public function getMatchStaticSumListByFieldGroupByTmId($map=[], $field='pts')
    {
        $model = new MatchStatistics();
        $res = $model->where($map)->field(['team_member_id', 'name', "sum($field)" => $field])->group('team_member_id')->select();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        return $result;
    }

    // 根据球员id作分组，获取多个技术统计字段的总和
    public function getMatchStaticALLSumListByFieldGroupByTmId($map=[]) {
        $model = new MatchStatistics();
        $res = $model->where($map)
            ->field([
            'team_member_id', 'name', 'sum(pts)' => 'pts', 'sum(reb)' => 'reb', 'sum(ast)' => 'ast', 'sum(stl)' => 'stl', 'sum(blk)' => 'blk', 'sum(threepfg)' => 'threepfg'
            ])
            ->group('team_member_id')->select();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        return $result;
    }

    // 根据球队id作分组，获取单个技术统计字段的总和
    public function getMatchStaticSumListByFieldGroupByTeamId($map=[], $field='pts') {
        $model = new MatchStatistics();
        $res = $model->where($map)->field(['team_id', 'team', "sum($field)" => $field])->group('team_id')->select();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        return $result;
    }

    // 根据球队id作分组，获取多个技术统计字段的总和
    public function getMatchStaticSumAllListByFieldGroupByTeamId($map=[]) {
        $model = new MatchStatistics();
        $res = $model->where($map)
            ->field(['team_id', 'team', 'sum(pts)' => 'pts', 'sum(reb)' => 'reb', 'sum(ast)' => 'ast', 'sum(stl)' => 'stl', 'sum(blk)' => 'blk', 'sum(threepfg)' => 'threepfg'
            ])
            ->group('team_id')->select();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        return $result;
    }
}