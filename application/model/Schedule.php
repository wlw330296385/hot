<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Schedule extends Model{
	use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $type = [
        'status'    =>  'integer',
    ];
    protected $autoWriteTimestamp = true;

    protected $readonly = ['create_time'];

    public function getLessonTimeAttr($value){
        return date('Y-m-d H:i',$value);
    }

    public function scheduleComment(){
    	return $this->hasMany('schedule_comment','schedule_id');
    }
}
