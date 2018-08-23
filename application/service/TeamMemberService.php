<?php
namespace app\service;

use app\model\Team;
use app\model\TeamMember;
use app\model\TeamMemberRole;
use think\Db;

class TeamMemberService
{
    public function myTeamList($map)
    {
        $model = new TeamMember();
        $res = $model->where($map)->select();
        if (!$res) {
            return $res;
        } else {
        	return $res->toArray();
        }
    }

    public function getTeamMemberAverage($map)
    {
        $res = Db::query("
            SELECT 
                round( sum(age) / sum(IF(age !=0,1,0)) ) AS `avg_age`,
                round( sum(height) / sum(IF(height !=0,1,0)) ) AS `avg_height`,
                round( sum(weight) / sum(IF(weight !=0,1,0)) ) AS `avg_weight`
            FROM `team_member` 
            WHERE `team_id` = :team_id 
            AND `status` = 1
        ",["team_id" => $map["team_id"]]);

        $final["avg_age"] = empty($res[0]["avg_age"]) ? 0 : $res[0]["avg_age"];
        $final["avg_height"] = empty($res[0]["avg_height"]) ? 0 : $res[0]["avg_height"];
        $final["avg_weight"] = empty($res[0]["avg_weight"]) ? 0 : $res[0]["avg_weight"];
        return $final;
    }
}