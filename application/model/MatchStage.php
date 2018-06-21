<?php
// 比赛赛程
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class MatchStage extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = true;
}