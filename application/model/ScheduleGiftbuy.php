<?php
// 购买赠送课时
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class ScheduleGiftbuy extends Model
{
    protected $autoWriteTimestamp = true;
    use SoftDelete;
    protected $deleteTime = 'delete_time';
}