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
        //'match_time' => 'timestamp:Y-m-d H:i',
        'start_time' => 'timestamp:Y-m-d H:i',
        'end_time' => 'timestamp:Y-m-d H:i',
        'reg_start_time' => 'timestamp:Y-m-d H:i',
        'reg_end_time' => 'timestamp:Y-m-d H:i',
    ];

    // match_time （比赛时间）获取器 时间戳转换日期格式
    public function getMatchTimeAttr($value) {
        return ($value>0) ? date('Y-m-d H:i', $value) : 0;
    }
    
    // type（活动类型）获取器
    public function getTypeAttr($value) {
        $type = [ 1 => '练习赛', 2 => '友谊赛', 3=> '积分赛', 4=>'公开赛' ];
        return $type[$value];
    }

    // is_finished(是否完成)获取器
    public function getIsFinishedAttr($value) {
        $is_finished = [ -1 => '未完成', 1 => '已完成' ];
        return $is_finished[$value];
    }

    // apply_status(约战申请)获取器
    public function getApplyStatusAttr($value) {
        $apply_status = [ -1 => '接收约战', 1 => '约战匹配中', '2' => '约战已完成' ];
        return $apply_status[$value];
    }

    // status 获取器
    public function getStatusAttr($value) {
        $status = [1=> '公开', -1 => '不公开'];
        return $status[$value];
    }


}