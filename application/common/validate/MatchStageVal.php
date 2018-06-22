<?php
namespace app\common\validate;
use think\Validate;

class MatchStageVal extends Validate
{
    protected $rule = [
        'id' => 'require|number',
        'match_id' => 'require|number',
        'type' => 'require|number',
        'name' => 'require|token',
        'advance_number' => 'number'
    ];

    protected $message = [
        'id.require' => '请选择比赛阶段ID',
        'id.number' => '比赛阶段ID不合法',
        'match_id.require' => '请选择联赛ID',
        'match_id.number' => '联赛ID不合法',
        'type.require' => '请选择比赛阶段',
        'type.number' => '比赛阶段不合法',
        'name.require' => '请输入阶段别名',
        'name.token' => '不要重复提交',
        'advance_number.number' => '晋级球队数量请输入数字'
    ];

    protected $scene = [
        'add' => [ 'match_id', 'type', 'name', 'advance_number' ],
        'edit' => [ 'id', 'match_id', 'type', 'name', 'advance_number' ]
    ];
}