<?php 
namespace app\common\validate;
use think\Validate;
class GradeVal extends Validate{


	protected $rule = [
        'grade'  =>  'require|max:60',
        'member_id'	=> 'require',
    ];
    
    protected $message = [
        'grade.require'  =>  '训练营名必须',
        'member_id.require'	=> '创建者必须',
    ];
    
    protected $scene = [
        'add'   =>  ['member_id','grade'],
        'edit'  =>  ['member_id','grade'],
    ];    

}