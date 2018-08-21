<?php
// 球队service
namespace app\service;

use app\model\TeamEvent;

use think\Db;

class TeamEventService {

    // 球队活动列表
    public function teamEventList($map, $page = 1, $order = 'id desc', $limit = 10)
    {
        $model = new TeamEvent();
        $count = $model
        ->where($map)
        ->order($order)
        ->count();

        $result = $model
        ->where($map)
        ->order($order)->page($page,$limit)->select();

        $result = $result->toArray();

        foreach ($result as $k => $value) {
            $result[$k]["s_num"] = $count - $k - ($page-1)*$limit;
        }

        if (!$result) {
            return $result;
        } else {
            return $result;
        }
    }
}