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

    // public function getTargetTypeAttr($value){
    //     $TargetType = [1=>'公开活动',2=>'营内活动',3=>'班内活动'];
    //     return $TargetType[$value];
    // }
   	
    public function getEndAttr($value){
        return date('Y-m-d',$value);           
    }
    

    public function getStartAttr($value){
        return date('Y-m-d',$value);    
    }  

    
   	public function getIsMaxAttr($value){
        $status = [1=>'正常',-1=>'已满人'];
        return $status[$value];
    }

    
}