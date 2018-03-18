<?php
// 会员申请离营
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class CampLeaveapply extends Model
{
    protected $autoWriteTimestamp = true;
    use SoftDelete;
    protected $deleteTime = 'delete_time';
}