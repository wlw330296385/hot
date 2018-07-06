<?php
namespace app\common\validate;
use think\Validate;

class MatchRecordVal extends Validate
{
    protected $rule = [
        'id' => 'require|number',
        'match_id' => 'require|number',
        'match_schedule_id' => 'require|number',
        'match_stage_id' => 'require|number',
        'court_id' => 'number',
        'home_team_id' => 'number',
        'home_team_score' => 'number',
        'away_team_id' => 'number',
        'away_team_score' => 'number',
    ];

    protected $message = [
        'id.number' => '比赛结果ID不合法',
        'match_id.require' => '请输入比赛ID',
        'match_id.number' => '比赛ID不合法',
        'match_id.token' => '请不要重复提交',
        'match_schedule_id.require' => '请输入比赛赛程ID',
        'match_schedule_id.number' => '比赛赛程ID不合法',
        'match_stage_id.require' => '请输入比赛阶段ID',
        'match_stage_id.number' => '比赛阶段ID不合法',
        'court_id.number' => '场地ID不合法',
        'home_team_id.number' => '主队ID不合法',
        'home_team_score.number' => '主队得分不合法',
        'away_team_id.number' => '客队ID不合法',
        'away_team_score.number' => '客队得分不合法'
    ];

    protected $scene = [
        'league_add' => [ 'match_id', 'match_schedule_id', 'match_stage_id', 'court_id', 'home_team_id', 'home_team_score', 'away_team_id', 'away_team_score' ],
        'league_edit' => [ 'id','match_id', 'court_id', 'home_team_id', 'home_team_score', 'away_team_id', 'away_team_score' ]
    ];
}