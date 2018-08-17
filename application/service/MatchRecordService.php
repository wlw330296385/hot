<?php

namespace app\service;
use app\model\Match;
use app\model\MatchRecord;
use think\Db;

class MatchRecordService {

    // 获取一条比赛战绩数据
    public function getMatchRecord($map) {
        return null;
    }

    // 获取一条比赛记录
    public function getAllMatchRecord($map, $order='id desc', $paginate=10) {

        $model = new Match();
        $result = $model
        ->field('match_record.*, match.type, match.match_org_id, match.match_org, match.name, match.is_finished, match.islive, match.status')
        ->join('match_record','match.id = match_record.match_id')
        ->where($map)
        ->order('match_record.match_id desc')
        ->paginate($paginate);;

        if (!$result) {
            return $result;
        } else {
            return $result;
        }
    }
}