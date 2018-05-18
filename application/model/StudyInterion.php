<?php
// 学习意向
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class StudyInterion extends Model
{
    protected $autoWriteTimestamp = true;
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    // 一对一关系会员
    public function member() {
        return $this->belongsTo('member');
    }
}