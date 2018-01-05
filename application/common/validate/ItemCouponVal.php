<?php 
namespace app\common\validate;
use think\Validate;
class ItemCouponVal extends Validate{


   protected $rule = [
        'coupon'        =>  'require',
        'coupon_des' => 'require',
        'price'         => 'require',
        'member_id'=>'require',
        'max'=>'require|number',
        'start'        =>  'require',
        'end' => 'require',
        'organization'         => 'require',
        'organization_id'=>'require',
        'organization_type'=>'require',
    ];
    
    protected $message = [
        'coupon'        =>  '卡券名称不能为空',
        'coupon_des.require'    => '卡券描述不能为空',
        'member_id.unique'       =>'登陆过期,请先登录',
        'max.require'      =>  '最大发行数量不能为空',
        'start'        =>  '请填写有效期开始时间',
        'end.require'    => '请填写有效期结束时间',
        'organization_id.unique'       =>'请填写发行组织',
        'max.number'      =>  '最大发行数量只能为数字',
    ];
   
    protected $scene = [
        'add'   =>  ['member_id','coupon','coupon_des'],
        'edit'  =>  ['member_id','coupon','coupon_des'],
    ];    

}
