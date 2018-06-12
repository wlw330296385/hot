<?php 
namespace app\common\validate;
use think\Validate;
class GroupVal extends Validate{


	protected $rule = [
		'group'		=>'require',
		'member_id'	=>'require|egt:1',
		'logo'		=>'require',
		'max'	=>'require',
		'group'		=>'require',
		// 'tenet'	=>'require',
		'rule'		=>'require',
    ];
    
    protected $message = [
    	'group'		=>'群名必须',
    	'member_id'		=>'请先登录',
    	'logo'		=>'logo必须',
    	'group'		=>'群名必须',
    	// 'tenet'		=>'宗旨必须',
    	'rule'		=>'规则必须',

    ];
    
    protected $scene = [
       
    ];    

}