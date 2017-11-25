<?php 
namespace app\common\validate;
use think\Validate;
class RecruitmentVal extends Validate{
	protected $rule = [
        'memebr'  =>  'require|max:60|token',
        'member_id'	=> 'require',
        'organization' => 'require',
        'organization_id' =>'require',
        'organization_type'=>'require',
    ];
    
    protected $message = [
        'memebr.token'   =>'请不要重复提交',
        'member_id.require'	=> '缺少申请|被邀请人',
        'organization_id.require' =>'organization_id.require',
        'organization_type.require'=>'organization_type.require',
        'organization.require' => 'organization.require',
    ];
    
    protected $scene = [
        'add'   =>  ['member_id','organization_id','organization_type','organization'],
        'edit'  =>  ['member_id'],
    ];

}