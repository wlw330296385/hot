<?php
// 比赛记录api
namespace app\api\controller;
use app\service\TeamService;
use app\service\TeamMemberService;
use app\service\MatchRecordService;
use think\Db;

class MatchRecord extends Base
{ 
    public function getAllTypeMatch()
    {
        // 确保该球员是球队一员，并为在队状态
        $map["member_id"] = $this->memberInfo['id'];
        $map["status"] = 1;
        $map['team_id'] = intval(input('param.team_id'));
        $teamS = new TeamService();
        $teamMember = $teamS->getTeamMember($map);
        if (empty($teamMember)) {
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
        unset($map);

        $map["match_record.home_team_id|match_record.away_team_id"] = intval(input('param.team_id'));
        $map["is_finished"] = intval(input('param.is_finished'));
        if(!empty(input('param.islive'))) {
            $map["islive"] = intval(input('param.islive'));
        }

        $matchRecordS = new MatchRecordService();
        $result = $matchRecordS -> getAllMatchRecord($map);

        if ($result) {
            $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
        } else {
            $response = ['code' => 100, 'msg' => __lang('MSG_401')];
        }

        return json($response);
    }

    //根据member_id 列出自己所在各队的所有比赛带序号
    public function getAllTypeMatchWithSN()
    {
        if (empty($this->memberInfo['id'])) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }

        // 1.用户的所有球队比赛 2.用户其中一只球队的比赛
        if (!empty(input('param.team_id'))) {
            $map["team_id"] = intval(input('param.team_id'));
        }

        // 确保该球员是 在队 的状态
        $map["member_id"] = $this->memberInfo['id'];
        $map["status"] = 1;
        $teamMemberS = new TeamMemberService();
        $res = $teamMemberS->myTeamList($map);

        // 所在球队数组
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