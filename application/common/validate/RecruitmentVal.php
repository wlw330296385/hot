<?php 
namespace app\common\validate;
use think\Validate;
class RecruitmentVal extends Validate{
	protected $rule = [
        'recruitment'  =>  'require|max:60|token',
        'member_id'	=> 'require',
        'province' => 'require',
    ];
    
    protected $message = [
        'recruitment.token'   =>'请不要重复提交',
        'recruitment.require'  =>  '请填写班级名称',
        'member_id.require'	=> '会员信息过期,请重新登录平台',
        
        'province.require' => '请选择所属地区',
        
    ];
    
    protected $scene = [
        'add'   =>  ['member_id','recruitment','province'],
        'edit'  =>  ['member_id','province'],
    ];

}