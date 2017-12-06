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
            1 => '青少年训练营',
            2 => '企事业单位',
            3 => '同事朋友',
            4 => '同乡会',
            5 => '校友会',
            6 => '大学生',
            7 => '高中生',
            8 => '初中生',
            9 => '小学生',
        ];
        return $type[$value];
    }

    // status 获取器
    public function getStatusAttr($value) {
        $status = [1=> '上架', -1 => '下架'];
        return $status[$value];
    }
}