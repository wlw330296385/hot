<?php
// 比赛积分记录
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class MatchRank extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = true;

}