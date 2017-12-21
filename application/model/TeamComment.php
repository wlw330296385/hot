<?php
//球队模块评论记录model
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class TeamComment extends Model {
    protected $autoWriteTimestamp = true;
    use SoftDelete;
    protected $deleteTime = 'delete_time';
}