<?php
namespace app\model;

use think\Model;
use traits\model\SoftDelete;

class Message extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    protected $autoWriteTimestamp = true;

    public function getStatusAttr($value){
        $status = [0=>'过期',1=>'正常'];
        return $status[$value];
    }

}