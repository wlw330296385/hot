<?php
// 比赛历史对手
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class MatchHistoryTeam extends Model
{
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
    // 软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';
}