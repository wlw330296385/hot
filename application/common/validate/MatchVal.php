<?php
// 比赛验证器
namespace app\common\validate;
use think\Validate;

class MatchVal extends Validate {
    // 验证规则
    protected $rule = [
        //'member_id' => 'require|gt:0|token',
        'member_id' => 'require|gt:0',
        'type' => 'require',
        'province' => 'require',
        'city' => 'require',
        'area' => 'require',
    ];

    // 提示信息
    protected $message = [
        'member_id.require' => '请先注册会员或重新登录平台',
        'member_id.gt' => '请先注册会员或重新登录平台',
        'type.require' => '请选择比赛类型',
        'member_id.token' => '请不要重复点击提交',
        'province.require' => '请选择地区',
        'city.require' => '请选择地区',
        'area.require' => '请选择地区',
    ];

    // 验证场景
    protected $scene = [
        'add' => [ 'member_id', 'type', 'province', 'city' ],
        'edit' => [ 'type', 'province', 'city' ]
    ];
}