<?php
namespace app\model;

use think\Model;
use traits\model\SoftDelete;

class MessageMember extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    protected $autoWriteTimestamp = true;

    public function getStatusAttr($value){
        $status = [1=>'未读',2=>'已读'];
        return $status[$value];
    }

}