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
}