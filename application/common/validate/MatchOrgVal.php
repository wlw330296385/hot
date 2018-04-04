<?php
// 联赛组织验证器
namespace app\common\validate;
use think\Validate;

class MatchOrgVal extends Validate
{
    // 验证规则
    protected $rule = [
        'name' => 'require|max:50|token|chsAlphaNum',
        'member_id' => 'gt:0',
        'type' => 'require',
        'realname' => 'require|chsAlphaNum',
        'contact_tel' => 'require',
        'province' => 'require',
        'city' => 'require',
        'area' => 'require',
        'logo' => 'require',
        'cover' => 'require',
        'descri' => 'max:100'
    ];

    // 提示信息
    protected $message = [
        'name.require' => '请填写组织名称',
        'name.max' => '组织名称不超过50个字符',
        'name.token' => '请不要重复点击提交',
        'name.chsAlphaNum' => '组织名称只能填写汉字、英文、数字',
        'member_id.gt' => '请先登录或注册会员',
        'type.require' => '请选择组织类型',
        'realname.require' => '请填写负责人姓名',
        'contact_tel.require' => '请填写联系电话',
        'province.require' => '请选择所属地区',
        'city.require' => '请选择所属地区',
        'area.require' => '请选择所属地区',
        'logo.require' => '请上传球队logo图',
        'cover.require' => '请上传球队封面图',
        'descri.max' => '简介不能超过100个字'
    ];

    // 验证场景
    protected $scene = [
        'add' => ['name', 'member_id', 'type', 'realname', 'contact_tel', 'province', 'city', 'area', 'logo', 'cover', 'descri'],
        'edit' => ['name', 'member_id', 'type', 'realname', 'contact_tel', 'province', 'city', 'area', 'logo', 'cover', 'descri'],
    ];
}