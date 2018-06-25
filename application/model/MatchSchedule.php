<?php
// 比赛赛程
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class MatchSchedule extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = true;

    public function getMatchTimeAttr($value) {
        return ($value > 0) ? date('Y-m-d H:i', $value) : '';
    }
}