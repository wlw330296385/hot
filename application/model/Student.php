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
    					];
    protected $autoWriteTimestamp = true;



	 public function member(){
    	return $this->belongsTo('member','member_id','id',[],'left join');
    }
	

    public function grade(){
        return $this->hasOne('grade','grade_id','id',[],'left join');
    }
}