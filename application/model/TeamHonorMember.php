<?php
// 球队荣誉-会员关系
namespace app\model;

use think\Model;
use traits\model\SoftDelete;

class TeamHonorMember extends Model
{// 自动写入时间戳
    protected $autoWriteTimestamp = true;
    // 软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    public function TeamHonor() {
        return $this->belongsTo('teamHonor');
    }

    // 获取器
    public function getHonorTimeAttr($value) {
        return ($value>0) ? date("Y-m-d", $value) : '';
    }
}