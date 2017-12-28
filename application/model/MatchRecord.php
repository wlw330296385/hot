<?php
// 比赛成绩model
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class MatchRecord extends Model {
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
    // 软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    
    public function match() {
        return $this->belongsTo('match');
    }
}