<?php 
namespace app\common\validate;
use think\Validate;
class CampVal extends Validate{


	protected $rule = [
        'camp'  =>  'require|max:60',
        'member_id'	=> 'require',
        'realname' =>  'require',
    ];
    
    protected $message = [
        'camp.require'  =>  '训练营名必须',
        'member_id.require'	=> '创建者必须',
        'realname.require' =>  '创建者必须实名认证',
    ];
    
    protected $scene = [
        'add'   =>  ['realname','member_id','camp'],
    ];    

}