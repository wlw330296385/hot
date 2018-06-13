<?php
namespace app\common\validate;


use think\Validate;

class MatchScheduleVal extends Validate
{
    protected $rule = [
        'id' => 'number',
        'match_id' => 'require|number',
        'member_id' => 'gt:0',
    ];

    protected $message = [
        'id.number' => '赛程id不合法',
        'match_id.require' => '传入比赛id',
        'match_id.number' => '比赛id不合法',
        'member_id.gt' => '请先登录或注册会员',
    ];

    protected $scene = [
        'add' => ['match_id', 'member_id'],
        'edit' => ['id', 'match_id', 'member_id']
    ];
}