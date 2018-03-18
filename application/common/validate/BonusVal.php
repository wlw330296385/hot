<?php 
namespace app\common\validate;
use think\Validate;
class BonusVal extends Validate{


   protected $rule = [
        'bonus'        =>  'require|unique:bonus|token',
        'bonus_type'    => 'require',
        'title'         => 'require',
        'description'         =>'require',
    ];
    
    protected $message = [
        'bonus.require'        =>  '礼包名称必须',
        'bonus.unique'        =>  '礼包名称重复',
        'bonus.token'        =>  '礼包重复提交',
        'bonus_type.unique'        =>  '礼包条件必须',
        'title' => '活动标语必须',
        'description'      =>  '礼包描述必须',
    ];
    
    protected $scene = [
        'add'   =>  [],
        'edit'  =>  [],
    ];     

}
