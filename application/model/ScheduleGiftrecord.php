<?php
// 分配赠送课时
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class ScheduleGiftrecord extends Model
{
    protected $autoWriteTimestamp = true;
    use SoftDelete;
    protected $deleteTime = 'delete_time';
}