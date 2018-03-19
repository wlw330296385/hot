<?php 
namespace app\common\validate;
use think\Validate;
class ScheduleCommentVal extends Validate{


	protected $rule = [
	    'member_id' => 'require',
        'comment' => 'max:100'
    ];
    
    protected $message = [
        'member_id.require' => '请先登录会员',
        'comment.max' => '评价意见请不要超过100个字'
    ];
    
    protected $scene = [
        'add'   =>  [],
    ];    

}