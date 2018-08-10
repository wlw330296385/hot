<?php
//购买赠送课时验证器
namespace app\common\validate;
use think\Validate;

class ScheduleGiftbuyVal extends Validate
{
    protected $rule = [
        'camp_id' => 'require',
        'lesson_id' => 'require',
        'member_id' => 'require|egt:1',
        'quantity' => 'require|number'
    ];

    protected $message = [
        'member_id.egt'    => '请先注册',
        'camp_id.require' => '缺少训练营信息，请选择训练营',
        'lesson_id.require' => '请选择课程',
        'member_id.require' => '缺少会员信息，请重新登录平台',
        'quantity.require' => '请填写购买数量',
        'quantity.number' => '请填写数字'
    ];
}