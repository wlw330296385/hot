<?php
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class TeamEventMember extends Model {
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
    use SoftDelete;
    protected $deleteTime = 'delete_time';
}