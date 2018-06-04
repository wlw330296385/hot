<?php 
namespace app\common\validate;
use think\Validate;
class PunchVal extends Validate{


	protected $rule = [
		'member_id'		=>'require|egt:1',
		'punch_time'		=>'require',
		'punch'		=>'require',
		'punch_category'		=>'require',
		'name'		=>'require',
		'is_anonymous'		=>'require',
		'image_url'		=>'require',
		'name'		=>'require',
    ];
    
    protected $message = [
		'member_id'		=>'请先登录',
		'punch_time'		=>'打卡时间必填',
		'punch'		=>'打卡名称必填',
		'punch_category'		=>'打卡类型必填',
		'name'		=>'运动项目必须',
		'is_anonymous'		=>'是否匿名必填',
		'image_url'		=>'图片必填',
    ];
    
    protected $scene = [
       
    ];    

}