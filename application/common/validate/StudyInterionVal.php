<?php
namespace app\common\validate;
use think\Validate;

class StudyInterionVal extends Validate
{
    protected $rule = [
        'member_id' => 'require|gt:0|token',
        'name' => 'require',
        'age' => 'require|number',
        'school' => 'require',
        'address' => 'require',
        'telephone' => 'require'
    ];

    protected $message = [
        'member_id.require' => '请传入会员ID',
        'member_id.gt' => '请先登录或注册会员',
        'member_id.token' => '不要重复点击提交',
        'name.require' => '请填写姓名',
        'age.require' => '请填写年龄',
        'age.number' => '年龄只能填写数字',
        'school.require' => '请填写学校',
        'address.require' => '请填写住所',
        'telephone.require' => '请填写电话'
    ];
}