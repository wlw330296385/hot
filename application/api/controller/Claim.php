<?php
// 联赛api
namespace app\api\controller;

use app\model\TeamMember;
use app\model\MatchTeamMember;
use app\model\MatchStatistics;
use app\model\MatchRecordMember;
use think\Db;
use think\Exception;
use think\Validate;

class Claim extends Base
{
    public function teamMember() {

        $team_member_id = input("post.team_member_id");
        if (empty($this->memberInfo['id'])) {
            return json(['code' => 100, 'msg' => __lang('MSG_001')]);
        }

        if (empty($this->memberInfo['telephone'])) {
            return json(['code' => 100, 'msg' => "请先填写手机号"]);
        }

        $memberInfo = $this->memberInfo;
        $teamMember = TeamMember::get(["id" => $team_member_id, "member_id" => -1, "telephone" => $this->memberInfo['telephone']]);
        if (empty($teamMember)) {
            return json(['code' => 100, 'msg' => "认领的数据与您不匹配"]);
        }
        $teamMemberIdStr = $teamMember['id'];
        
        $matchTeamMemberList = MatchTeamMember::all(["team_member_id" => $teamMember["id"]]);
        if (!empty($matchTeamMemberList)) {
            $matchTeamMemberIdArray = [];
            foreach($matchTeamMemberList as $row) {
                array_push($matchTeamMemberIdArray, $row['id']);
            }
            $matchTeamMemberIdStr = implode($matchTeamMemberIdArray, ',');
        }

        $matchStatisticsList = MatchStatistics::all(["team_member_id" => $teamMember["id"]]);
        if (!empty($matchStatisticsList)) {
            $matchStatisticsIdArray = [];
            foreach($matchStatisticsList as $row) {
                array_push($matchStatisticsIdArray, $row['id']);
            }
            $matchStatisticsIdStr = implode($matchStatisticsIdArray, ',');
        }

        $matchRecordMemberList = MatchRecordMember::all(["team_member_id" => $teamMember["id"]]);
        if (!empty($matchTeamMemberList)) {
            $matchRecordMemberIdArray = [];
            foreach($matchRecordMemberList as $row) {
                array_push($matchRecordMemberIdArray, $row['id']);
            }
            $matchRecordMemberIdStr = implode($matchRecordMemberIdArray, ',');
        }

        Db::startTrans();
        try {
            $res1 = Db::table('team_member')->where('id', $teamMemberIdStr)->update([
                'member_id' => $memberInfo['id'],
                'member' => $memberInfo['member'],
            ]);

            if (!empty($matchTeamMemberList)) {
                $res2 = Db::table('match_team_member')->where('id', $matchTeamMemberIdStr)->update([
                    'member_id' => $memberInfo['id'],
                    'member' => $memberInfo['member'],
                    'avatar' => $memberInfo['avatar']
                ]);
            }

            if (!empty($matchStatisticsList)) {
                $res3 = Db::table('match_statistics')->where('id', $matchStatisticsIdStr)->update([
                    'member_id' => $memberInfo['id'],
                    'member' => $memberInfo['member'],
                ]);
            }

            if (!empty($matchRecordMemberList)) {
                $res4 = Db::table('match_record_member')->where('id', $matchRecordMemberIdStr)->update([
                    'member_id' => $memberInfo['id'],
                    'member' => $memberInfo['member'],
                    'avatar' => $memberInfo['avatar']
                ]);
            }

            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            trace('error:' . $e->getMessage(), 'error');
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }

        return json(['code' => 200, 'data' => ""]);
        
    }

}