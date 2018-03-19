<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class ItemCouponMember extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    // protected $readonly = [
    //                         'create_time',
    //                         'status',
    //                         'type',
    //                         ];

	public function itemCoupon(){
		return $this->hasOne('item_coupon','id','item_coupon_id',[],'LEFT JOIN');
	}
}