<?php
// 联赛参赛（球队）球员验证器
namespace app\common\validate;
use think\Validate;

class MatchTeamMemberVal extends Validate
{
    protected $rule = [
        'match_id' => 'require|number|token',
        'team_id' => 'require|number',
        'match_apply_id' => 'require|number',
    ];

    protected $message = [
        'match_id.require' => '缺少联赛ID',
        'match_id.number' => '联赛ID格式无效',
        'match_id.token' => '请不要重复提交',
        'team_id.require' => '缺少球队ID',
        'team_id.number' => '球队ID格式无效',
        'match_apply_id.require' => '缺少联赛报名ID',
        'match_apply_id.number' => '联赛报名ID格式无效',
    ];
}