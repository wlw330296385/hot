<?php
namespace app\common\validate;
use think\Validate;

class MemberHonorVal extends Validate
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number',
        'name' => 'require|max:50|token',
        'member_id' => 'gt:0',
        'match' => 'require|max:50',
        'award_org' => 'require|max:50',
        'honor_time' => 'require',
        //'cover' => 'require'
    ];

    // 验证信息
    protected $message = [
        'id.require' => '请传入ID',
        'id.number' => 'ID格式不合法',
        'name.require' => '请输入奖项名称',
        'name.max' => '奖项名称不能超过50个字',
        'name.token' => '请不要重复提交',
        'match.require' => '请输入赛事名称',
        'match.max' => '赛事名称不能超过50个字',
        'award_org.require' => '请输入授奖单位',
        'award_org.max' => '授奖单位不能超过50个字',
        'honor_time.require' => '请输入授奖时间',
        //'cover.require' => '请输入荣誉证书'
    ];

    // 验证场景
    protected $scene = [
        'add' => ['name', 'match', 'award_org', 'honor_time'],
        'edit' => ['id', 'name', 'match', 'award_org', 'honor_time'],
    ];
}