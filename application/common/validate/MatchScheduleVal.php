<?php
namespace app\common\validate;


use think\Validate;

class MatchScheduleVal extends Validate
{
    protected $rule = [
        'id' => 'require|number',
        'match_id' => 'require|number',
        'member_id' => 'gt:0',
        'match_stage_id' => 'require|number|gt:0',
        'match_stage' => 'require',
    ];

    protected $message = [
        'id.require' => '请输入赛程id',
        'id.number' => '赛程id不合法',
        'match_id.require' => '传入比赛id',
        'match_id.number' => '比赛id不合法',
        'member_id.gt' => '请先登录或注册会员',
        'match_stage_id.require' => '请选择比赛阶段',
        'match_stage_id.number' => '比赛阶段id不合法',
        'match_stage_id.gt' => '请选择比赛阶段',
        'match_stage.require' => '请选择比赛阶段'
    ];

    protected $scene = [
        'add' => ['match_id', 'member_id', 'match_stage_id', 'match_stage'],
        'edit' => ['id', 'match_id', 'member_id', 'match_stage_id', 'match_stage']
    ];
}