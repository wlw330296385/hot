<?php
// 比赛记录api
namespace app\api\controller;
use app\service\TeamMemberService;
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

    //根据member_id 列出自己所在各队的所有比赛
    public function getAllTypeMatchWithSN()
    {
        if (empty($this->memberInfo['id'])) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }

        // 确保该球员是 在队 的状态
        $map["member_id"] = $this->memberInfo['id'];
        $map["status"] = 1;
        $teamMemberS = new TeamMemberService();
        $res = $teamMemberS->myTeamList($map);

        $myTeamIdArray  = array();
        foreach($res as $k => $row) {
            array_push($myTeamIdArray, $row["team_id"]);
        }
        unset($map);

        $map["match_record.home_team_id|match_record.away_team_id"] = array('in',implode(',',$myTeamIdArray));
        $page = empty(input('param.page')) ? 1 : input('param.page');

        $matchRecordS = new MatchRecordService();
        $result = $matchRecordS -> getAllMatchRecordWithSN($map, $page);

        if ($result) {
            $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
        } else {
            $response = ['code' => 100, 'msg' => __lang('MSG_401')];
        }

        return json($response);
    }
}