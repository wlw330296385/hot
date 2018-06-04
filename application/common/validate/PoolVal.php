<?php 
namespace app\common\validate;
use think\Validate;
class PoolVal extends Validate{


	protected $rule = [
		'member_id'		=>'require|egt:1',
		'group_id'		=>'require',
		'start'		=>'require',
		'end'		=>'require',
		'stake'		=>'require|member',
    ];
    
    protected $message = [

		'member_id'		=>'请先登录',
		'group_id'		=>'必须选择一个社群',
		'start'		=>'开始时间必须',
		'end'		=>'结束时间必须',
		'stake'		=>'打卡金额必须且只能为数字',
    ];
    
    protected $scene = [
       
    ];    

}