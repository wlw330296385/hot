<?php
// 比赛api
namespace app\api\controller;

use app\service\MatchRecordService;
use think\Db;

class MatchRecord extends Base
{ 
    public function getAllTypeMatch()
    {
        $map["match_record.home_team_id|match_record.away_team_id"] = intval(input('param.team_id'));
        $map["is_finished"] = intval(input('param.is_finished'));
        $map["islive"] = intval(input('param.islive'));

        $matchRecordS = new MatchRecordService();
        $result = $matchRecordS -> getAllMatchRecord($map);

        if ($result) {
            $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
        } else {
            $response = ['code' => 100, 'msg' => __lang('MSG_401')];
        }

        return json($response);
    }
}