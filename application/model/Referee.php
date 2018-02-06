<?php
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Referee extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    protected $readonly = [
                            'create_time',
                            ];



    public function member(){
        return $this->hasOne('member','id','member_id',[],'left join');
    }
}