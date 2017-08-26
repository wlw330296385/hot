<?php 
namespace app\common\validate;
use think\Validate;
class CoachVal extends Validate{


	protected $rule = [
        'coach'  =>  'require|max:60',
        'member_id'  =>  'require|max:60',
    ];
    
    protected $message = [
        'coach.require'  =>  '用户名必须',
        'telephone.length' =>'电话号码格式不正确',
        'member_id'     =>'用户名ID必须',
    ];
    
    protected $scene = [
        'add'   =>  ['coach'],
        'edit'  =>  ['coach'],
    ];    

}