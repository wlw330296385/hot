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

    // 获取器
    public function getHonorTimeAttr($value) {
        return ($value>0) ? date("Y-m-d", $value) : '';
    }
}