<?php 
namespace app\common\validate;
use think\Validate;
class MemberVal extends Validate{


	protected $rule = [
        'member'  =>  'require|max:60|unique:member,member',
        'nickname'	=> 'max:60',
        'email' =>  'email',
        'telephone' => 'length:11',
        'password'=>'require|confirm:repassword'
    ];
    
    protected $message = [
        'member.require'  =>  '用户名必须',
        'member.unique'  =>  '用户名被占用',
        'nickname.require'	=> '昵称必须',
        'email' =>  'email格式不正确',
        'telephone.length' =>'电话号码格式不正确',
        'password.confirm'	=>'两次密码不一致'
    ];
    
    protected $scene = [
        'add'   =>  ['member'],
        'edit'  =>  ['email','telephone','password'],
    ];    

}