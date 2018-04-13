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
        'match_org' => 'require',
        'cover' => 'require',
        'name' => 'require',
        'type' => 'require',
        'province' => 'require',
        'city' => 'require',
        'area' => 'require',
        'status' => 'number',
        'start_time' => 'require',
        'end_time' => 'require',
        'reg_start_time' => 'require',
        'reg_end_time' => 'require',
        'charge_name' => 'require',
        'teams_max' => 'require|number',
        'entry_fees' => 'number',
        'deposit' => 'number',
    ];

    // 提示信息
    protected $message = [
        'id' => 'ID不规范',
        'match_org.require' => '请输入联赛组织',
        'member_id.require' => '请先注册会员或重新登录平台',
        'member_id.gt' => '请先注册会员或重新登录平台',
        'cover.require' => '请上传封面图片',
        'name.require' => '请输入比赛名称',
        'type.require' => '请选择比赛类型',
        'province.require' => '请选择地区',
        'city.require' => '请选择地区',
        'area.require' => '请选择地区',
        'status.number' => '状态格式不规范',
        'start_time.require' => '请输入开始时间',
        'end_time.require' => '请输入结束时间',
        'reg_start_time.require' => '请输入报名开始时间',
        'reg_end_time.require' => '请输入报名结束时间',
        'teams_max.require' => '请输入最多参赛队伍数',
        'teams_max.number' => '最多参赛队伍数请输入数字',
        'entry_fees.number' => '参赛费用请输入数字',
        'deposit.number' => '保证金请输入数字',
        'charge_name.require' => '请输入负责人姓名'
    ];

    // 验证场景
    protected $scene = [
        // 球队比赛
        'add' => [ 'member_id', 'type', 'province', 'city', 'area' ],
        'edit' => [ 'type', 'province', 'city', 'area' ],
        'status' => ['id', 'status'],
        // 联赛
        'league_add' => [ 'name', 'cover', 'match_org', 'member_id', 'type', 'province', 'city', 'area', 'format', 'teams_max', 'entry_fees', 'deposit', 'start_time', 'end_time', 'reg_start_time', 'reg_end_time', 'charge_name'],
        'league_edit' => [ 'id', 'name', 'cover', 'type', 'province', 'city', 'area', 'format', 'teams_max', 'entry_fees', 'deposit', 'start_time', 'end_time', 'charge_name'],
    ];
}