<?php 
namespace app\common\validate;
use think\Validate;
class BonusVal extends Validate{


   protected $rule = [
        'bonus'        =>  'require|unique:bonus|token',
        'bonus_type'    => 'require',
        'title'         => 'require',
        'description'         =>'require',
        'coupon_type'           =>'require',
        'coupon_id'           =>'require',
    ];
    
    protected $message = [
        'bonus.require'        =>  '礼包名称必须',
        'bonus.unique'        =>  '礼包名称重复',
        'bonus.token'        =>  '礼包名称重复',
        'bonus_type.unique'        =>  '礼包条件必须',
        'title' => '活动标语必须',
        'description'      =>  '礼包描述必须',
        'coupon_type'                  =>'礼包类型必须',
        'coupon_id'                 =>'礼包必须',
    ];
    
    protected $scene = [
        'add'   =>  [],
        'edit'  =>  [],
    ];     

}
