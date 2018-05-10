<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class EventMember extends Model {
    use SoftDelete;
    protected $table = 'event_member';
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;

	public function getStatusAttr($value){
        $status = [1=>'已报名',2=>'已签到',3=>'已参与',4=>'中途退出'];
        return $status[$value];
    }


    public function eventInfo(){
        return $this->hasOne('event','id','event_id',[],'eventinfo');
    }

}