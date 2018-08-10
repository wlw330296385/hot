<?php 
namespace app\common\validate;
use think\Validate;
class StudentVal extends Validate{


	protected $rule = [
        'student'  =>  'require|max:60|token',
        'member'  =>  'require|max:60',
        'member_id' =>'require|egt:1',
        'emergency_telephone' =>'require|number|length:11',
    ];
    
    protected $message = [
        'student.require'  =>  '学生姓名必须',
        'student.token'=>'请不要重复提交',
        'emergency_telephone.length' =>'电话号码长度不正确',
        'emergency_telephone.number' =>'电话号码格式不正确',
        'member'    =>'关联用户名必须',
        'member_id.egt'    => '请先注册',
    ];
    
    protected $scene = [
        'add'   =>  ['member','emergency_telephone','member_id','student'],
        'edit'  =>  ['member','emergency_telephone','member_id'],
    ];    

}