<?php
// 比赛赛程
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class MatchStage extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = true;

    // type文案 获取器
    public function getTypeTextAttr($value, $data) {
        $type = [
            '1' => '小组赛',
            '2' => '热身赛',
            '3' => '全明星赛',
            '4' => '淘汰赛',
            '5' => '决赛',
            '0' => '其他'
        ];
        return $type[$data['type']];
    }
}