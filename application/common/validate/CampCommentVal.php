<?php 
namespace app\common\validate;
use think\Validate;
class CampCommentVal extends Validate{


	protected $rule = [
        'member_id'	=> 'require',
        'camp_id' =>  'require',
    ];
    
    protected $message = [
        'camp_id.require'  =>  '请输入训练营名称',
        'member_id.require'	=> '查不到会员信息',
    ];
    
    protected $scene = [
        'add'   =>  ['member_id','camp_id'],
        'edit' => ['member_id','camp_id'],
    ];    

}