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
        $status = [1=>'正常',2=>'下架',3=>'过期',4=>'满人'];
        return $status[$value];
    }
   
}