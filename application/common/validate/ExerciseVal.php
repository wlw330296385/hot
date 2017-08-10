<?php
// 训练项目验证器
namespace app\common\validate;
use think\Validate;

class ExerciseVal extends Validate {
    protected $rule = [
        'exercise' => 'require',
        'pid' => 'require',
        'exercise_detail' => 'require'
    ];

    protected $message = [
        'exercise.require' => '请输入项目名称',
        'pid.require' => '请选择项目类型',
        'exercise_detail.require' => '请输入项目要领'
    ];
}