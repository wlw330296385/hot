<?php 
namespace app\common\validate;
use think\Validate;
class CampBankcardVal extends Validate{


   protected $rule = [
        'bank_card'        =>  'require',
        'bank' => 'require',
        'member_id'=>'require|egt:1',
        'account'=>'require',
        'telephone'=>'require',
        'camp_id'=>'require'
    ];
    
    protected $message = [
        'member_id.egt'    => '请先注册',
        'bank'        =>  '银行必须',
        'bank_card.require'    => '账户号码必须',
        'member_id.unique'       =>'查询不到用户信息',
        'account'        =>  '开户名必须',
        'telephone.require'    => '预留号码必须',
        'camp_id'      =>  '训练营必须',
    ];
   
    protected $scene = [
        'add'   =>  ['member_id','bank_card','bank','account','telephone','camp_id'],
        'edit'  =>  ['member_id','bank_card','bank_type']
    ];    

}
