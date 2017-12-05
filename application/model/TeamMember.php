<?php
// 球队-会员关系model
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class TeamMember extends Model {
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
    // 软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    // position（司职位置）字段获取器
    public function getPositionAttr($value) {
        $position = [0 => '暂无', 1 => '控球后卫', 2 => '得分后卫', 3 => '小前锋', 4 => '大前锋', 5=> '中锋'];
        return $position[$value];
    }

    // status字段获取器
    public function getStatusAttr($value) {
        $status = [1 => '在队', -1=>'离队', 0 => '加入申请未通过'];
        return $status[$value];
    }

    // 关联team主表
    public function team() {
        return $this->hasOne('Team', 'id', 'team_id');
    }
}