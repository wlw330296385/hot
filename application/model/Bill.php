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

    protected $readonly = ['create_time'];
    // public function getStatusAttr($value){
	   //     $status = [0=>'未付款',1=>'已付款','-1'=>'申请退款','-2'=>'已退款'];
	   // return $status[$value];
    // }
    public function getIsPayAttr($value){
           $status = [0=>'未付款',1=>'已付款'];
       return $status[$value];
    }

    public function getGoodsTypeAttr($value){
           $status = [1=>'课程',2=>'活动'];
       return $status[$value];
    }
    
    public function lesson(){
    	return $this->hasOne('lesson','id','goods_id',[],'left join');
    } 

    public function refund(){
      return $this->hasOne('refund','bill_id','id');
    }
}

