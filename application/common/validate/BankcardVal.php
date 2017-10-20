<?php 
namespace app\common\validate;
use think\Validate;
class BankcardVal extends Validate{


	protected $rule = [
        'bank_card'        =>  'require|unique:bankcard,bank_card',
        'bank'	=> 'require',
        'bank_type'         => 'require',
        'member_id'=>'require'
    ];
    
    protected $message = [
        'bank_card'        =>  '账户为空',
        'bank_card.require'	=> '账户号码必须',
        'member_id.unique'       =>'查询不到用户信息',
        'bank_type'      =>  '账户类型必须',
    ];
    
    protected $scene = [
        'add'   =>  ['member_id','bank_card','bank_type'],
        'edit'  =>  ['member_id','bank_card','bank_type']
    ];    

}