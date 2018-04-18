<?php
// 球队荣誉
namespace app\common\validate;

use think\Validate;

class TeamHonorVal extends Validate
{
    // 验证规则
    protected $rule = [
        'name' => 'require|max:50|token',
        'member_id' => 'gt:0',
        'match' => 'require|max:50',
        'match_id' => 'number',
        'award_org' => 'require|max:50',
        'award_org_id' => 'number',
        'honor_time' => 'require',
        'prize_team_member' => 'require',
        //'cover' => 'require'
    ];

    // 验证信息
    protected $message = [
        'name.require' => '请输入奖项名称',
        'name.max' => '奖项名称不能超过50个字',
        'name.token' => '请不要重复提交',
        'match.require' => '请输入赛事名称',
        'match.max' => '赛事名称不能超过50个字',
        'matcn_id.number' => '赛事ID格式不正确',
        'award_org.require' => '请输入授奖单位',
        'award_org.max' => '授奖单位不能超过50个字',
        'award_org_id.require' => '授奖单位ID格式不正确',
        'honor_time.require' => '请输入授奖时间',
        'prize_team_member.require' => '请选择授奖人',
        //'cover.require' => '请输入荣誉证书'
    ];

    // 验证场景
    protected $scene = [
        'add' => ['name', 'match', 'award_org', 'honor_time', 'prize_team_member'],
        'edit' => ['name', 'match', 'award_org', 'honor_time', 'prize_team_member'],
    ];
}