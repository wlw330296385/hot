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
}