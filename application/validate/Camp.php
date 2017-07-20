<?php 
namespace app\validate;
use think\Validate;
class Camp extends Validate{


	protected $rule = [
        'camp'  =>  'require|max:60',
        'member_id'	=> 'require',
        'member' =>  'require',
    ];
    
    protected $message = [
        'camp.require'  =>  '训练营名必须',
        'member_id.require'	=> '创建者必须',
        'member.require' =>  '创建者昵称必须',
    ];
    
    protected $scene = [
        'add'   =>  ['member','member_id','camp'],
    ];    

}