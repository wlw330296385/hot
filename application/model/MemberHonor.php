<?php
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

// 会员荣誉
class MemberHonor extends Model
{
    protected $autoWriteTimestamp = true;
    use SoftDelete;
    protected $deleteTime = 'delete_time';
}