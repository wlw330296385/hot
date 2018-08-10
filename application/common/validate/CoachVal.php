<?php 
namespace app\common\validate;
use think\Validate;
class CoachVal extends Validate{


    protected $rule = [
        'coach'  =>  'require|max:60',
        'member_id'  =>  'require|max:60|egt:1',
    ];
    
    protected $message = [
        'coach.require'  =>  '用户名必须',
        'member_id.require'     =>'用户名ID必须',
        'member_id.egt'    => '请先注册',
    ];
    
    protected $scene = [
        'add'   =>  ['coach'],
        'edit'  =>  ['coach'],
    ];    

}