<?php 
namespace app\common\validate;
use think\Validate;
class CourtVal extends Validate{


	protected $rule = [
        'court'  =>  'require|max:60',
        'member_id'	=> 'require',
        'location' =>  'require',
    ];
    
    protected $message = [
        'court.require'  =>  '场地名必须',
        'member_id.require'	=> '创建者必须',
        'location.require' =>  '地址必须',
    ];
    
    protected $scene = [
        'add'   =>  ['location','member_id','court'],
        'edit'  =>  ['location','member_id','court'],
    ];    

}