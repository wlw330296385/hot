<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class MatchRefereeApply extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;

}