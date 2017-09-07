<?php 
namespace app\common\validate;
use think\Validate;
class PlanVal extends Validate{


	protected $rule = [
        'camp_id'  =>  'gt:1',
        'member'	=> 'require',
        'member_id'    => 'require',
        'camp' =>  'reqiure',
        'outline' => 'require',
        'exercise'=>'require',
    ];
    
    protected $message = [
        'camp_id'  =>  'require',
        'member_id'    => 'require',
        'member'  => 'require',
        'camp' =>  'reqiure',
        'outline' => 'require',
        'exercise'=>'require',
    ];
    
    protected $scene = [
        'add'   =>  ['member','camp','member_id','outline','camp_id','exercise'],
        'edit'  =>  ['member','camp','member_id','outline','camp_id','exercise'],
    ];    

}