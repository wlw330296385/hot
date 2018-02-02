<?php
// 球队模型
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class Team extends Model {
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
    // 软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    // 球队类型获取器
    public function getTypeAttr($value) {
        $type = [
            1 => '训练营',
            2 => '企事业单位',
            3 => '业余组织',
            4 => '大学生',
            5 => '高中生',
            6 => '初中生',
            7 => '小学生',
        ];
        return $type[$value];
    }

    // status 获取器
    public function getStatusAttr($value) {
        $status = [1=> '上架', -1 => '下架'];
        return $status[$value];
    }
}