<?php
// 比赛 赛事
namespace app\frontend\controller;


use app\service\MatchService;

class Match extends Base {
    // 赛事列表（平台展示）
    public function matchlist() {
        return view('Match/matchList');
    }

    // 赛事详情
    public function matchinfo() {
        return view('Match/matchInfo');
    }

    // 创建比赛
    public function creatematch() {
        // 从球队模块进入页面 带team_id处理
        $homeTeamId = input('team_id', 0);
        $this->assign('homeTeamId', $homeTeamId);
        return view('Match/createMatch');
    }

    // 编辑比赛
    public function matchedit() {
        return view('Match/matchEdit');
    }
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
        $matchInfo = $matchS->getMatch(['id' => $id]);
        if ($matchInfo['type_num'] == 1) {
            $matchRecordInfo = $matchS->getMatchRecord(['match_id' => $matchInfo['id']]);
            if ($matchRecordInfo) {
                if (!empty($matchRecordInfo['album'])) {
                    $matchRecordInfo['album'] = json_decode($matchRecordInfo['album'], true);
                }
                if (empty($matchRecordInfo['away_team'])) {
                    $matchRecordInfo['away_team_logo'] = '/static/frontend/images/basketball.jpg';
                }
                $matchInfo['record'] = $matchRecordInfo;
            }
        }
        //dump($matchInfo);
        $this->assign('matchInfo', $matchInfo);
        return view('Match/friendlyinfo');
    }
}