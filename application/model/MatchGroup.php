<?php
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class MatchGroup extends Model
{
// 自动写入时间戳
    protected $autoWriteTimestamp = true;
    // 软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    // 分组下球队（一对多）
    public function teams() {
        return $this->hasMany('match_group_team', 'group_id', 'id');
    }
}