<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class ItemCoupon extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    // protected $readonly = [
    //                         'create_time',
    //                         'status',
    //                         'type',
    //                         ];

	public function getEndAttr($value){
        return date('Y-m-d',$value);           
    }
    

    public function getStartAttr($value){
        return date('Y-m-d',$value);    
    }

    public function getPublishEndAttr($value){
        return date('Y-m-d',$value);           
    }
    

    public function getPublishStartAttr($value){
        return date('Y-m-d',$value);    
    }



    public function itemCouponMember(){
        return $this->hasOne('item_coupon_member');
    }
}