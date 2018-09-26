<?php

namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class MatchHonor extends Model
{
    // 时间戳
    protected $autoWriteTimestamp = true;
    // 软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';

}