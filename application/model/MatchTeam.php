<?php
// 比赛-球队关系model
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class MatchTeam extends Model {
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
    // 软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    // 一对一关联球队
    public function team() {
        return $this->belongsTo('Team');
    }

    // 一对一关联比赛
    public function match() {
        return $this->belongsTo('Match');
    }
}