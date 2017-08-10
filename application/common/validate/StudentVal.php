<?php 
namespace app\common\validate;
use think\Validate;
class StudentVal extends Validate{


	protected $rule = [
        'student'  =>  'require|max:60',
        'member'  =>  'require|max:60',
        'member_id' =>'require',
        'emergency_telephone' =>'require|number|length:11';
    ];
    
    protected $message = [
        'student.require'  =>  '学生姓名必须',
        'emergency_telephone.length' =>'电话号码长度不正确',
        'emergency_telephone.number' =>'电话号码格式不正确',
        'member'    =>'关联用户名必须'
    ];
    
    protected $scene = [
        'add'   =>  ['member','emergency_telephone','member_id','student'],
        'edit'  =>  ['member','emergency_telephone','member_id','student'],
    ];    

}