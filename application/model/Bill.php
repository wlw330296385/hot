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
    public function getStatusAttr($value){
	       $status = [0=>'过期',1=>'正常'];
	   return $status[$value];
    }
    public function getIsPayAttr($value){
           $status = [0=>'未付款',1=>'已付款','-1'=>'申请退款','-2'=>'已退款'];
       return $status[$value];
    }

    public function getGoodsTypeAttr($value){
           $status = [1=>'课程',2=>'普通商品'];
       return $status[$value];
    }
    public function lesson(){
    	return $this->hasOne('lesson','id','goods_id',[],'left join');
    } 

}

