<?php 
namespace app\common\validate;
use think\Validate;
class PlanVal extends Validate{


	protected $rule = [
        'camp_id'  =>  'require',
        'member'	=> 'require',
        'camp' =>  'reqiure',
        'outline' => 'require',
        'exercise'=>'require',
        'type'=>'require'
    ];
    
    protected $message = [
        'camp_id'  =>  'require',
        'member'  => 'require',
        'camp' =>  'reqiure',
        'outline' => 'require',
        'exercise'=>'require',
        'type'=>'require'
    ];
    
    protected $scene = [
        'add'   =>  ['member','camp_id','exercise'],
        'edit'  =>  ['member','camp_id','exercise'],
    ];    

}