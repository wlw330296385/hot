<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Student extends Model{
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $readonly = [
    						'member_id',
    						'total_lession',
    						'finished_total',
    					]
	 public function profile(){
    	// return $this->hasOne('member','member_id','id','memberinfo')->field('member,nickname,avatar,telephone,email');
    	return $this->hasOne('member','member_id','id','memberinfo');
    }
	
}