<?php
namespace app\service;

use app\model\TeamMember;
use think\Db;

class TeamMemberService
{
    public function myTeamList($map)
    {
        $model = new TeamMember();
        $res = $model->where($map)->order('id asc')->select();
        if (!$res) {
            return $res;
        } else {
        	return $res->toArray();
        }
    }

    // public function getTeamMemberList($map) {
    //     $teamMemberModel = new TeamMember();
    //     $result = $teamMemberModel
    //     ->field('member.member, member.nickname, member.avatar, member.realname')
    //     ->join('member','member.id = team_member.member_id')
    //     ->where('team_member.status = 1')
    //     ->where($map)
    //     ->order('team_member.id desc')
    //     ->select();

    //     if (!$result) {
    //         return $result;
    //     } else {
    //         return $result->toArray();
    //     }
    // }

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