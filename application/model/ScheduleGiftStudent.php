<?php
// 赠课-学员记录

namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class ScheduleGiftStudent extends Model {
    protected $autoWriteTimestamp = true;
    use SoftDelete;
    protected $deleteTime = 'delete_time';
}