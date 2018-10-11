<?php
// 比赛记录api
namespace app\api\controller;
use app\service\TeamService;
use app\service\TeamMemberService;
use app\service\MatchRecordService;
use think\Db;
use app\model\Match;
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

        // 对手创建的比赛，需要认领后才会出现在列表
        $team_id = intval(input('param.team_id'));
        $sql = "
        (`match_org_id` = 0 AND (`match_record`.`home_team_id` = %s OR  (`match_record`.`away_team_id` = %s AND `match_record`.`claim_status` = 1)))
        OR
        (`match_org_id` != 0 AND (`match_record`.`home_team_id` = %s OR `match_record`.`away_team_id` = %s))
        ";

        $ext_sql = str_replace('%s', $team_id, $sql);

        if(!empty(input('param.islive'))) {
            $map["islive"] = intval(input('param.islive'));
        }

        $is_finished = intval(input('param.is_finished'));
        $ext_sql2 = $is_finished == 1 ? "(`match_org_id` = 0 AND `is_finished` = 1) OR `is_record` = 1" : "`match_org_id` = 0 AND `is_finished` = -1";

        $model = new Match();
        $result = $model
        ->field('match_record.*, match.type, match.match_org_id, match.match_org, match.name, match.is_finished, match.islive, match.status')
        ->join('match_record','match.id = match_record.match_id')
        ->where($map)
        ->where($ext_sql)
        ->where($ext_sql2)
        ->order('match_record.match_id desc')
        ->paginate(10);

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

        // 所在球队数组
        $myTeamIdArray  = array();

        // 1.用户的所有球队比赛 2.一只球队的比赛
        if (!empty(input('param.team_id'))) {
            array_push($myTeamIdArray, intval(input('param.team_id')));
        } else {
            // 确保该球员是 在队 的状态
            $map["member_id"] = $this->memberInfo['id'];
            $map["status"] = 1;
            $teamMemberS = new TeamMemberService();
            $res = $teamMemberS->myTeamList($map);
            if (empty($res)) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }

            // 所在球队数组
            $myTeamIdArray  = array();
            foreach($res as $k => $row) {
                array_push($myTeamIdArray, $row["team_id"]);
            }
            unset($map);
        }

        //有无传入年份
        if (!empty(input('param.year'))) {
            $year = input('param.year');
            $tInterval = getStartAndEndUnixTimestamp($year);
            $map['match_record.match_time'] = ['between', [$tInterval['start'], $tInterval['end']]];
            unset($map['year']);
        }

        // 默认输出最近全部，若有传入 已完成，则输出最近已完成
        if (!empty(input('param.is_finished'))) {
            $map['is_finished'] = intval(input('param.is_finished'));
        }

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