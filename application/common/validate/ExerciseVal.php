<?php
// 训练项目验证器
namespace app\common\validate;
use think\Validate;

class ExerciseVal extends Validate {
    protected $rule = [
        'exercise' => 'require',
        'pid' => 'require',
        'camp_id'=>'require'
    ];

    protected $message = [
        'exercise.require' => '请输入项目名称',
        'pid.require' => '请选择项目类型',
        'camp_id'=>'找不到训练营'
    ];


}