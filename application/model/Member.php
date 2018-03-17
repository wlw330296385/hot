<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Member extends Model{
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = true;
	protected $readonly = [
//							'create_time',
							'openid',
							'member',
							'balance',
							'score',
							'level',
							'pid',
							'flow',
							];
	public function getHpAttr($value)
    {        
        if($value>=0){
        	$result = 1;
        }
        if($value>500){
        	$result = 2;
        }
        if($value>1000){
        	$result = 3;
        }
        if($value>2000){
        	$result = 4;
        }
        if($value>5000){
        	$result = 5;
        }

        return $result;
    }
	public function coach(){
		return $this->hasOne('coach','member_id','id',[],'LEFT');
	}
}