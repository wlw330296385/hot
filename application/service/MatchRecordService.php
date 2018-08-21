<?php

namespace app\service;
use app\model\Match;
use app\model\MatchRecord;
use app\service\TeamMemberService;
use think\Db;

class MatchRecordService {

    // 获取一条比赛战绩数据
    public function getMatchRecord($map) {
        return null;
    }

    // 获取所有比赛记录
    public function getAllMatchRecord($map, $order='match_time desc', $paginate=10) {

        $ext_sql = $map["is_finished"] == 1 ? "(`match_org_id` = 0 AND `is_finished` = 1) OR `is_record` = 1" : "`match_org_id` = 0 AND `is_finished` = -1";
        unset($map["is_finished"]);

        $model = new Match();
        $result = $model
        ->field('match_record.*, match.type, match.match_org_id, match.match_org, match.name, match.is_finished, match.islive, match.status')
        ->join('match_record','match.id = match_record.match_id')
        ->where($map)
        ->where($ext_sql)
        ->order('match_record.match_id desc')
        ->paginate($paginate);

        if (!$result) {
            return $result;
        } else {
            return $result;
        }
    }

    // 获取最近比赛记录和序号
    public function getAllMatchRecordWithSN($map, $page=1, $limit=10) {

        //已完成 输出最近已完成所有比赛，包括联赛中已完成的一场
        //未完成 输出最近未完成所有比赛，但不包括未完成的联赛
        //没传 默认输出最近所有比赛，但不包括未完成的联赛
        if (!empty($map["is_finished"])) {
            if ($map["is_finished"] == 1) {
                $ext_sql = '(`match_org_id` = 0 AND `is_finished` = 1) OR `is_record` = 1';
            } else {
                $ext_sql = '`match_org_id` = 0 AND `is_finished` = -1';
            }
        } else {
            $ext_sql = '`match_org_id` = 0 OR `is_record` = 1';
        }
        unset($map["is_finished"]);

        $model = new Match();
        $count = $model
        ->join('match_record','match.id = match_record.match_id')
        ->where($map)
        ->where($ext_sql)
        ->order('match_record.match_time desc')
        ->count();

        $result = $model
        ->field('match_record.*, match.type, match.match_org_id, match.match_org, match.name, match.is_finished, match.islive, match.status')
        ->join('match_record','match.id = match_record.match_id')
        ->where($map)
        ->where($ext_sql)
        ->order('match_record.match_time desc')->page(sprintf('%s,%s',$page,$limit))->select();

        $result = $result->toArray();

        foreach ($result as $k => $value) {
            $result[$k]["s_num"] = $count - $k - ($page-1)*$limit;
        }

        if (!$result) {
            return $result;
        } else {
            return $result;
        }
    }

}