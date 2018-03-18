<?php
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class Follow extends Model {
    protected $autoWriteTimestamp = true;
    use SoftDelete;
    protected $deleteTime = 'delete_time';
}