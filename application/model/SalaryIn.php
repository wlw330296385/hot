<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class SalaryIn extends Model{
	use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $type = [
        
    ];
    protected $autoWriteTimestamp = true;

    protected $readonly = ['create_time'];

    public function lesson(){
    	return $this->hasOne('lesson','id','lesson_id',[],'left join');
    } 

}

