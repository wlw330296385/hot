<?php
// 比赛历史对手
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class MatchHistoryTeam extends Model
{
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
    // 软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    // 对手球队一对一 关联球队
    public function opponentTeam() {
        return $this->belongsTo('team', 'opponent_team_id', 'id', 'left');
    }
}