<?php
// 私密课程可购买会员关系表model
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class Hotcoin extends Model {
    protected $table="hotcoin_finance";
    protected $autoWriteTimestamp = true;
    use SoftDelete;
    protected $deleteTime = 'delete_time';
}