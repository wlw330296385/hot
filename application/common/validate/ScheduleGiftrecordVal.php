<?php
//购买赠送课时验证器
namespace app\common\validate;
use think\Validate;

class ScheduleGiftrecordVal extends Validate
{
    protected $rule = [
        'camp_id' => 'require',
        'lesson_id' => 'require',
<<<<<<< HEAD
        'gift_schedule' => 'require|number',
=======
        'gift_schedule' => 'require|number|token',
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        'student_str' => 'require'
    ];

    protected $message = [
        'camp_id.require' => '缺少训练营信息，请选择训练营',
        'lesson_id.require' => '请选择课程',
        'gift_schedule.require' => '请填写人均赠送课时数量',
        'gift_schedule.number' => '人均赠送课时请填写数字',
<<<<<<< HEAD
=======
        'gift_schedule.token' => '无需重复提交',
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        'student_str.require' => '请勾选赠送对象'
    ];
}