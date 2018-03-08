<?php

namespace app\model;

use think\Model;
use traits\model\SoftDelete;

class CampCancell extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = true;
    
    public function getStatusTextAttr($value, $data) {
        $status = [
            1 => '已受理',
            2 => '不通过',
            -1 => '已撤回',
            0 => '未处理'
        ];
        return $status[$data['status']];
    }
}