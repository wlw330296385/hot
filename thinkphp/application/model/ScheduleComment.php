<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class ScheduleComment extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    protected $readonly = [
                            'create_time',
                            'status',
                            'type',
                            ];

    public function schedule()
    {
        return $this->belongsTo('schedule');
    }                        
}