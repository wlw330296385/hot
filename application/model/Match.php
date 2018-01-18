<?php
// 比赛（赛事）model
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class Match extends Model {
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
    // 软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    // 字段类型转换
    protected $type = [
        'match_time' => 'timestamp:Y-m-d H:i',
        'start_time' => 'timestamp:Y-m-d H:i',
        'end_time' => 'timestamp:Y-m-d H:i',
        'reg_start_time' => 'timestamp:Y-m-d H:i',
        'reg_end_time' => 'timestamp:Y-m-d H:i',
    ];

    // type（活动类型）获取器
    public function getTypeAttr($value) {
        $type = [ 1 => '友谊赛', 2 => '联赛' ];
        return $type[$value];
    }

    // is_finished(是否完成)获取器
    public function getIsFinishedAttr($value) {
        $is_finished = [ 0 => '未完成', 1 => '已完成' ];
        return $is_finished[$value];
    }

    // apply_status(约战申请)获取器
    public function getApplyStatusAttr($value) {
        $apply_status = [ 0 => '接收约战', 1 => '约战匹配中', '2' => '约战已完成' ];
        return $apply_status[$value];
    }

    // status 获取器
    public function getStatusAttr($value) {
        $status = [1=> '公开', -1 => '不公开'];
        return $status[$value];
    }


}