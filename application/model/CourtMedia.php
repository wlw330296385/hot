<?php
// 证书model
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class CourtMedia extends Model {
	use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
}