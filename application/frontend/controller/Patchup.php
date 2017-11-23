<?php
namespace app\frontend\controller;


use think\Db;

class Patchup {

    public function campmembertofollow() {
        // 遍历camp_member type<4 status=1数据，生成对应且不重复的follow数据
        $camp_members = db('camp_member')->where(['type' => ['lt', 4], 'status' => 1])->distinct(true)->select();
        foreach ($camp_members as $camp_member) {
            $campInfo = db('camp')->where(['id' => $camp_member['camp_id']])->find();
            $memberInfo = db('member')->where(['id' => $camp_member['member_id']])->find();
            $data = [
                'follow_id' => $campInfo['id'],
                'follow_name' => $campInfo['camp'],
                'follow_avatar' => $campInfo['logo'],
                'member_id' => $memberInfo['id'],
                'member' => $memberInfo['member'],
                'member_avatar' => $memberInfo['avatar'],
                'status' => 1,
                'type' => 2
            ];
            $hasfollow =  db('follow')->where(['type' => 2,'follow_id' => $campInfo['id'], 'member_id' => $memberInfo['id'], 'status' => 1])->find();
            if (!$hasfollow) {
                db('follow')->insert($data);
            }
        }
    }
}