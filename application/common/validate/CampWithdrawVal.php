<?php 
namespace app\common\validate;
use think\Validate;
class CampWithdrawVal extends Validate{


   protected $rule = [
        'withdraw'        =>  'require',
        'bank_id' => 'require',
        'member_id'=>'require',
        'camp_id'=>'require'
    ];
    
    protected $message = [
        'withdraw'        =>  '银行必须',
        'bank_id.require'    => '账户号码必须',
        'member_id.unique'       =>'查询不到用户信息',
        'camp_id'      =>  '训练营必须',
    ];
   
    protected $scene = [
        'add'   =>  ['member_id','bank_id','withdraw','camp_id'],
        'edit'  =>  ['member_id']
    ];    

}
