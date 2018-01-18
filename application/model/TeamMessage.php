<?php
// 球队公告信息model
namespace app\model;

use think\Model;
use traits\model\SoftDelete;

class TeamMessage extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    protected $autoWriteTimestamp = true;


}