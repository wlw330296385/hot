<?php
// 比赛球队登记球员名单
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class MatchTeamMember extends Model {
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

    // 一对一关联球队成员
    public function teamMember() {
        return $this->belongsTo('TeamMember', 'id', 'team_member_id', [], 'left');
    }
}