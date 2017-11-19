<?php 
namespace app\common\validate;
use think\Validate;
class PlanVal extends Validate{


	protected $rule = [
        'camp_id'  =>  'gt:0',
        'member'	=> 'require',
        'member_id'    => 'require',
        'camp' =>  'require',
        'outline' => 'require',
        'exercise'=>'require',
    ];
    
    protected $message = [
        'camp_id'  =>  'camp_id 必须大于0',
        'member_id'    => 'require',
        'member'  => 'require',
        'camp' =>  'camp require',
        'outline' => 'outline require',
        'exercise'=>' exercise require',
    ];
    
    protected $scene = [
        'add'   =>  ['member','camp','member_id','outline','camp_id','exercise'],
        'edit'  =>  ['member','camp','member_id','outline','camp_id','exercise'],
    ];    

}