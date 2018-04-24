<?php
// 比赛技术数据统计
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class MatchStatistics extends Model
{
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
    // 软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';
}