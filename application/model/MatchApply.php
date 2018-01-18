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
}