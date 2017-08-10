<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Bill extends Model{
	use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $type = [
        
    ];
    protected $autoWriteTimestamp = true;

    protected $readonly = ['create_time','is_pay','callback_str','pay_time','update_time','status'];

    public function lesson(){
    	return $this->hasOne('lesson','id','lesson_id',[],'left join');
    } 

}

