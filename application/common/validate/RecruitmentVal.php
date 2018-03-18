<?php 
namespace app\common\validate;
use think\Validate;
class RecruitmentVal extends Validate{
	protected $rule = [
        'recruitment'  =>  'require|max:60|token',
        'member_id'	=> 'require',
        'province' => 'require',
        'telephone'=> 'require',
        'organization_id' =>'require',
        'organization_type'=>'require',
        'deadline'  =>'require',

    ];
    
    protected $message = [
        'recruitment.token'   =>'请不要重复提交',
<<<<<<< HEAD
        'recruitment.require'  =>  '请填写班级名称',
=======
        'recruitment.require'  =>  '请填写招募名称',
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        'member_id.require'	=> '会员信息过期,请重新登录平台',
        'province.require' => '请选择所属地区',
        'telephone.require'=> '请选择联系人',
        'organization_id.require' =>'organization_id.require',
        'organization_type.require'=>'organization_type.require',
        'deadline.require'  =>'请填写截止日期',
    ];
    
    protected $scene = [
        'add'   =>  ['member_id','recruitment','province','telephone','organization_id','organization_type','deadline'],
        'edit'  =>  ['member_id'],
    ];

}