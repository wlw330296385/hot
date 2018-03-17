<?php 
namespace app\common\validate;
use think\Validate;
class ApplyVal extends Validate{
	protected $rule = [
        'member'  =>  'require|max:60|token',
        'member_id'	=> 'require',
        'organization' => 'require',
        'organization_id' =>'require',
        'organization_type'=>'require',
        'apply_type'=>'require|number'
    ];
    
    protected $message = [
        'member.token'   =>'请不要重复提交',
        'member_id.require'	=> '缺少申请|被邀请人',
        'organization_id.require' =>'organization_id.require',
        'organization_type.require'=>'organization_type.require',
        'organization.require' => 'organization.require',
        'apply_type.require'=>'类型不能为空',
        'apply_type.number'=>'类型只能为数字',
    ];
    
    protected $scene = [
        'add'   =>  ['member_id','member','organization_id','organization_type','organization','apply_type'],
        'edit'  =>  ['member_id','member'],
    ];

}