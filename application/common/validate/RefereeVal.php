<?php 
namespace app\common\validate;
use think\Validate;
class RefereeVal extends Validate{


    protected $rule = [
        'referee'  =>  'require|max:60',
        'member_id'  =>  'require|max:60',
    ];
    
    protected $message = [
        'referee.require'  =>  '用户名必须',
        'member_id'     =>'用户名ID必须',
    ];
    
    protected $scene = [
        'add'   =>  ['referee'],
        'edit'  =>  ['referee'],
    ];    

}