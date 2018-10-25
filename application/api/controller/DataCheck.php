<?php 
namespace app\api\controller;
use app\api\controller\Base;
use think\Db;

class DataCheck extends Base{
    
    // team表 member_num 的数据验证
    // public function checkTeamData() {
    //     $affectIds = [];
    //     $list = Db::table('team')->select();
    //     foreach ($list as $row) {
    //         $res = Db::table('team_member')->where(['team_id' => $row['id'],'status' => 1])->count();
            
    //         $count = empty($res) ? 0 : $res;
    //         if ($row['member_num'] != $count) {
    //             $update_res = Db::query("UPDATE `team`  SET `member_num`=:member_num  WHERE  `id` = :id", ['member_num'=>$count, 'id'=>$row['id']]);
    //             array_push($affectIds, $row['id']);
    //         }
    //     }
    //     return json_encode($affectIds);
    // }

    // public function checkName() {
    //     $list = Db::table('match_record_member')->where(['team_member_id' => ['neq', 0]])->select();
    //     foreach ($list as $row) {
    //         $res = Db::table('team_member')->where(['id' => $row['team_member_id']])->find();

    //         $update_res = Db::query("UPDATE `match_record_member`  SET `name`=:name  WHERE  `id` = :id", ['name'=>$res['name'], 'id'=>$row['id']]);
    //     }
    //     return 'ok';
    // }


    // public function checkMatchGroupTeam() {
    //     $list = Db::table('match_team')->where(['match_id' => 31])->select();
    //     foreach ($list as $row) {
    //         $res = Db::table('match_group_team')->where(['team_id' => $row['team_id']])->update(['team' => $row['team']]);

    //         // $update_res = Db::query("UPDATE `match_record_member`  SET `name`=:name  WHERE  `id` = :id", ['name'=>$res['name'], 'id'=>$row['id']]);
    //     }
    //     return 'ok';
    // }

    // 检查match_record_member未出席的人，如果match_statistics有得分/篮板等数据则设为出席
    // public function checkMatchRecordMember() {
    //     $idArray = [];
    //     $list = Db::table('match_record_member')->where(['match_id' => 31, 'is_attend' => -1])->select();
    //     foreach ($list as $row) {
    //         $map = [
    //             'match_id' => 31,
    //             'match_record_member_id' => $row['id'],
    //             'match_record_id' => $row['match_record_id'],
    //             'team_member_id' => $row['team_member_id']
    //         ];

    //         $res = Db::table('match_statistics')->where($map)->find();

    //         if (!empty($res)) {
    //             if ($res['pts'] || $res['ast'] || $res['reb'] || $res['stl'] || $res['blk'] || $res['turnover'] || $res['foul'] 
    //                 || $res['fga'] || $res['threepfga'] || $res['fta'] || $res['threepfga']) {

    //                 Db::table('match_record_member')->where('id', $row['id'])->update(['is_attend' => 1]);

    //                 array_push($idArray, $row['id']);
    //             }
    //         }

    //     }
    //     return json_encode($idArray);
    // }

    // public function checkTeamMember() {
        // $idStr = '194,254,272,224,212,260,266,218,206,188,194,188,272,266,206,212,218,224,254,260';

        // $res1 = Db::table('team_member')->where(['id' => ['in', $idStr]])->select();
        // $res2 = Db::table('match_statistics')->where(['team_member_id' => ['in', $idStr]])->select();
        // $res3 = Db::table('match_record_member')->where(['team_member_id' => ['in', $idStr]])->select();
        // $res4 = Db::table('match_team_member')->where(['team_member_id' => ['in', $idStr]])->select();
        // return json_encode(['res1' => count($res1), 'res2' => count($res2), 'res3' => count($res3), 'res4' => count($res4)]);

        // $del1 = Db::table('team_member')->where(['id' => ['in', $idStr]])->delete();
        // $del2 = Db::table('match_statistics')->where(['team_member_id' => ['in', $idStr]])->delete();
        // $del3 = Db::table('match_record_member')->where(['team_member_id' => ['in', $idStr]])->delete();
        // $del4 = Db::table('match_team_member')->where(['team_member_id' => ['in', $idStr]])->delete();
        // return json_encode(['del1' => $del1, 'del2' => $del2, 'del3' => $del3, 'del4' => $del4]);
    // }

    // 队伍人数
    // public function checkTeamNumber() {

    //     $list = Db::table('match_team')->where(['match_id' => 31])->select();
    //     foreach ($list as $row) {
    //         $res1 = Db::table('match_team_member')->where(['match_id' => 31, 'match_team_id' => $row['id']])->count();
    //         Db::table('match_team')->where('id', $row['id'])->update(['members_num' => $res1]);

    //         $res2 = Db::table('team_member')->where(['team_id' => $row['team_id']])->count();
    //         Db::table('team')->where('id', $row['team_id'])->update(['member_num' => $res2]);
    //     }
    //     return 'ok';
    // }

    // public function checkMatchRank() {

    //     $list = Db::table('match_rank')->where(['match_id' => 31])->select();
    //     foreach ($list as $row) {
    //         $res1 = Db::table('match_record')->where([
    //             'match_id' => 31, 
    //             'match_stage_id' => $row['match_stage_id'], 
    //             'win_team_id' => $row['team_id']
    //         ])->count();
    //         Db::table('match_rank')->where('id', $row['id'])->update(['score' => $res1]);

    //     }
    //     return 'ok';
    // }
}