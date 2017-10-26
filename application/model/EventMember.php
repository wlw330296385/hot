<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class EventMember extends Model {
    use SoftDelete;
    protected $table = 'camp_member';
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;


}