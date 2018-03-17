<?php 
namespace app\common\validate;
use think\Validate;
class SalaryOutVal extends Validate{


	protected $rule = [
        'member_id'           =>'require',
        'salary'             =>'require',
        'bank_card'          =>'require',
        'bank'              =>'require',
        'bank_type'             =>'require',
        'tid'             =>'require',
    ];
    
    protected $message = [
        'member_id'           =>'查不到用户信息',
        'salary'             =>'金额必须',
        'bank_card'          =>'账号必须',
        'bank'              =>'账号平台必须',
        'bank_type'             =>'账号类型必须',
        'tid'             =>'订单号必须',
    ];
    
    protected $scene = [
        'add'   =>  ['member_id','salary','bank_card','bank_type','bank','tid'],
        'edit'  =>  ['member_id','salary'],
    ];    

}