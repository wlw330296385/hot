<?php 
namespace app\validate;
use think\Validate;
class Member extends Validate{


	protected $rule = [
        'member'  =>  'require|max:60',
        'nickname'	=> 'require|max:60',
        'email' =>  'email',
        'telephone' => 'length:11',
        'password'=>'require|confirm'
    ];
    
    protected $message = [
        'member.require'  =>  '用户名必须',
        'nickname.require'	=> '昵称必须',
        'email' =>  'email格式不正确',
        'telephone.length' =>'电话号码格式不正确',
        'password.confirm'	=>'两次密码不一致'
    ];
    
    protected $scene = [
        'add'   =>  ['member','nickname'],
        'edit'  =>  ['email','telephone','password'],
    ];    

}