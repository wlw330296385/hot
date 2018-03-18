<?php
// 比赛 赛事
namespace app\frontend\controller;


<<<<<<< HEAD
=======
use app\service\MatchService;
use app\service\TeamService;

>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
class Match extends Base {
    // 赛事列表（平台展示）
    public function matchlist() {
        return view('Match/matchList');
    }
<<<<<<< HEAD
=======

>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
    // 赛事详情
    public function matchinfo() {
        return view('Match/matchInfo');
    }

    // 创建比赛
    public function creatematch() {
<<<<<<< HEAD
=======
        // 从球队模块进入页面 带team_id处理
        $homeTeamId = input('team_id', 0);
        $this->assign('homeTeamId', $homeTeamId);
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        return view('Match/createMatch');
    }

    // 编辑比赛
    public function matchedit() {
        return view('Match/matchEdit');
    }
<<<<<<< HEAD
=======
    // 比赛管理列表
    public function matchlistofteam() {
        return view('Match/matchlistofteam');
    }

    // 约战比赛列表
    public function friendlylist() {
        return view('Match/friendlylist');
    }

    // 约战比赛详情
    public function friendlyinfo() {
        $id = input('match_id');
        $matchS = new MatchService();
        // 比赛详情
        $matchInfo = $matchS->getMatch(['id' => $id]);
        if ($matchInfo['type_num'] == 1) {
            $matchRecordInfo = $matchS->getMatchRecord(['match_id' => $matchInfo['id']]);
            if ($matchRecordInfo) {
                if (!empty($matchRecordInfo['album'])) {
                    $matchRecordInfo['album'] = json_decode($matchRecordInfo['album'], true);
                }
                if (empty($matchRecordInfo['away_team'])) {
                    $matchRecordInfo['away_team_logo'] = config('default_image.team_logo');
                }
                $matchInfo['record'] = $matchRecordInfo;
            }
        }

        // 比赛发布球队信息
        $teamS = new TeamService();
        $teamInfo = $teamS->getTeam(['id' => $matchInfo['team_id']]);

        $this->assign('matchInfo', $matchInfo);
        $this->assign('teamInfo', $teamInfo);
        return view('Match/friendlyinfo');
    }
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
}