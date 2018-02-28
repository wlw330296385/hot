<?php
// 球队validate
namespace app\common\validate;
use think\Validate;

class TeamVal extends Validate {
    // 验证规则
    protected $rule = [
        'logo' => 'require',
        // 球队名称：必填|字段值长度2-16字符|值只能是汉字、字母、数字和下划线_及破折号-|名称team表唯一|表单token
//        'name' => 'require|length:2,16|chsDash|unique:team|token',
        'name' => 'require|length:2,16|chsDash|token',
        // 会员id大于0表示已注册或登录会员
        'member_id' => 'gt:0',
        'type' => 'require',
        // type（球队类型）值为1（即青少年训练营）时camp_id必填
        'camp_id' => 'requireIf:type,1',
        'province' => 'require',
        'city' => 'require',
        'area' => 'require',
        'leader_id' => 'require',
        // 平均年龄、身高、体重非必填，值只能是整型数字
        'avg_age' => 'number',
        'avg_height' => 'number',
        'avg_weight' => 'number',
        'cover' => 'require',
        'descri' => 'max:100'
    ];

    // 提示信息
    protected $message = [
        'logo.require' => '请上传球队logo图',
        'name.require' => '请填写球队名称',
        'name.length' => '球队名称长度只能2-16个字符',
        'name.chsDash' => '球队名称只能填写汉字、英文、数字和下划线_及破折号-',
        'name.unique' => '填写的球队名称已存在，请填写其他名称',
        'name.token' => '请不要重复点击提交',
        'member_id.gt' => '请先注册会员或重新登录平台',
        'type.require' => '请选择球队类型',
        'camp_id.requireIf' => '请选择所属训练营',
        'province.require' => '请选择所属地区',
        'city.require' => '请选择所属地区',
        'area.require' => '请选择所属地区',
        'leader_id.require' => '请选择领队',
        'avg_age.number' => '平均年龄填写数字',
        'avg_height.number' => '平均身高填写数字',
        'avg_weight.number' => '平均体重填写数字',
        'cover.require' => '请上传球队封面图',
        'descri.max' => '简介不能超过100个字'
    ];

    // 验证场景
    protected $scene = [
        'add' => [
            'name' => 'require|length:2,16|chsDash|unique:team|token',
            'member_id', 'type', 'camp_id','province', 'city', 'leader_id', 'avg_age', 'avg_height', 'avg_weight', 'logo', 'cover', 'descri'],
        'edit' => ['name', 'member_id', 'type', 'camp_id','province', 'city', 'leader_id', 'avg_age', 'avg_height', 'avg_weight', 'logo', 'cover', 'descri']
    ];
}