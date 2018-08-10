<?php 
namespace app\common\validate;
use think\Validate;
class ScheduleCommentVal extends Validate{


	protected $rule = [
	    'member_id' => 'require|egt:1',
        'comment' => 'max:100'
    ];
    
    protected $message = [
        'member_id.require' => '请先登录会员',
        'member_id.egt'    => '请先注册',
        'comment.max' => '评价意见请不要超过100个字'
    ];
    
    protected $scene = [
        'add'   =>  [],
    ];    

}