<?php 
namespace app\common\validate;
use think\Validate;
class CoachVal extends Validate{


	protected $rule = [
        'parent'  =>  'require|max:60',
        'emergency_telephone' =>'require|number|length:11';
    ];
    
    protected $message = [
        'coach.require'  =>  '用户名必须',
        'emergency_telephone.length' =>'电话号码长度不正确',
        'emergency_telephone.number' =>'电话号码格式不正确',
    ];
    
    protected $scene = [
        'add'   =>  ['parent','emergency_telephone'],
        'edit'  =>  ['parent','emergency_telephone'],
    ];    

}