<?php 
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
use app\admin\model\ItemCounpon;
class Bonus extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    // protected $readonly = [
    //                         'create_time',
    //                         'status',
    //                         'type',
    //                         ];

	public function ItemCounpon(){
		return $this->hasMany('app\model\ItemCoupon','target_id','id');
	}

	// public function ItemCounpon(){
	// 	return $this->hasOne('app\model\ItemCoupon','id','coupon_id');
	// }
}