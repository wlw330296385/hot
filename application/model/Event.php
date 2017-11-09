<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Event extends Model{
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = true;
    //protected $readonly = ['create_time'];
    public function getStatusAttr($value){
        $status = [1=>'正常',2=>'下架'];
        return $status[$value];
    }
   	
   	public function getIsMaxAttr($value){
        $status = [1=>'正常',-1=>'已满人'];
        return $status[$value];
    }

    public function getIsOverdueAttr($value){
        $status = [1=>'正常',-1=>'已过期'];
        return $status[$value];
    }
}