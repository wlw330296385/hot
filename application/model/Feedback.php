<?php
// 建议反馈
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Feedback extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = true;
}