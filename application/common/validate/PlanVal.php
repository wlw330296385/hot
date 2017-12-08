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
        // 'exercise'=>'require',
    ];
    
    protected $message = [
        'camp_id'  =>  'camp_id 必须大于0',
        'member_id'    => 'require',
        'member'  => 'require',
        'camp' =>  '训练营必须',
        'outline' => 'outline必须',
        // 'exercise'=>' exercise必须',
    ];
    
    protected $scene = [
        'add'   =>  ['member','camp','member_id','outline','camp_id',],
        'edit'  =>  ['member','camp','member_id','outline','camp_id',],
    ];    

}