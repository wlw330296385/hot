<?php
// 球队参加比赛申请

namespace app\model;

use think\Model;
use traits\model\SoftDelete;

class MatchApply extends Model {
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
    // 软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    // status（申请状态）获取器
    /*public function getStatusAttr($value) {
        $status = [1=> '未处理', 2 => '已同意', '3' => '已拒绝'];
        return $status[$value];
    }*/

    // 一对一关联球队
    public function team() {
        return $this->belongsTo('team');
    }

    // 一对一关联比赛
    public function match() {
        return $this->belongsTo('match');
    }
}