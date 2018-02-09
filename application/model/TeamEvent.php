<?php
// 球队活动表model
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class TeamEvent extends Model {
    protected $autoWriteTimestamp = true;
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    // 字段类型转换
    protected $type = [
        'start_time' => 'timestamp:Y-m-d H:i',
        'end_time' => 'timestamp:Y-m-d H:i',
        'event_time' => 'timestamp:Y-m-d H:i',
    ];

    // event_type（活动类型）获取器
    public function getEventTypeAttr($value) {
        $event_type = [ 1 => '队内训练', 2 => '团队建设', 3 => '日常活动' ];
        return $event_type[$value];
    }

    // is_max（是否满人）获取器
    public function getIsMaxAttr($value) {
        $is_max = [ 1 => '未满人', -1 => '已满人' ];
        return $is_max[$value];
    }

    // is_finished(是否完成)获取器
    public function getIsFinishedAttr($value) {
        $is_finished = [ -1 => '未开始', 1 => '已结束' ];
        return $is_finished[$value];
    }

    // status 获取器
    public function getStatusAttr($value) {
        $status = [1=> '上架', -1 => '下架'];
        return $status[$value];
    }
}