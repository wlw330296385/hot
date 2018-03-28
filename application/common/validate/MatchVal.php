<?php
// 比赛验证器
namespace app\common\validate;
use think\Validate;

class MatchVal extends Validate {
    // 验证规则
    protected $rule = [
        //'member_id' => 'require|gt:0|token',
        'id' => 'number',
        'member_id' => 'require|gt:0',
        'type' => 'require',
        'province' => 'require',
        'city' => 'require',
        'area' => 'require',
        'status' => 'number',
    ];

    // 提示信息
    protected $message = [
        'id' => 'ID不规范',
        'member_id.require' => '请先注册会员或重新登录平台',
        'member_id.gt' => '请先注册会员或重新登录平台',
        'type.require' => '请选择比赛类型',
        'member_id.token' => '请不要重复点击提交',
        'province.require' => '请选择地区',
        'city.require' => '请选择地区',
        'area.require' => '请选择地区',
        'status' => '状态格式不规范',
    ];

    // 验证场景
    protected $scene = [
        'add' => [ 'member_id', 'type', 'province', 'city' ],
        'edit' => [ 'type', 'province', 'city' ],
        'status' => ['id', 'status']
    ];
}