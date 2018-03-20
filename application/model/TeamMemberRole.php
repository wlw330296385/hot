<?php
//会员-球队角色一对多关联model
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class TeamMemberRole extends Model {
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
    // 软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    // type(球队角色)中文获取器
    // 球队角色:1队委|2副队长|3队长|4教练|5领队(经理)
    public function getTypeTextAttr($value, $data) {
        $type = [
            1 => '队委',
            2 => '副队长',
            3 => '队长',
            4 => '教练',
            5 => '经理',
            6 => '领队',
            0 => '无'
        ];
        return $type[$data['type']];
    }

    // status字段获取器
    public function getStatusAttr($value) {
        $status = [1 => '正常', -1=>'失效',];
        return $status[$value];
    }
}