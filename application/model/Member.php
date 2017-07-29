<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Member extends Model{
	use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $readonly = [
							'create_time',
							'openid',
							'member',
							'balance',
							'score',
							'level',
							'pid',
							'flow',
							];
	public function coach(){
		return $this->hasOne('coach','member_id','id',[],'LEFT');
	}
}