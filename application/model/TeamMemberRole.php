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

    // type(球队角色)获取器
    public function getTypeAttr($value) {
        $type = [
            1 => '队委',
            2 => '教练',
            3 => '队长',
            4 => '领队',
            0 => '无'
        ];
        return $type[$value];
    }

    // status字段获取器
    public function getStatusAttr($value) {
        $status = [1 => '正常', -1=>'失效',];
        return $status[$value];
    }
}