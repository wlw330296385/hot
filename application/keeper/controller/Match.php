<?php
// 比赛 赛事
namespace app\keeper\controller;


use app\service\MatchService;
use app\service\TeamService;
use app\service\RefereeService;

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
        $refereeS = new RefereeService();
        // 比赛详情
        $matchInfo = $matchS->getMatch(['id' => $id]);
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


        // 比赛发布球队信息
        $teamS = new TeamService();
        $teamInfo = $teamS->getTeam(['id' => $matchInfo['team_id']]);

        // 获取会员的已审核裁判员信息
        $memberRefereeInfo = $refereeS->getRefereeInfo(['member_id' => $this->memberInfo['id'], 'status' => 1]);

        $this->assign('matchInfo', $matchInfo);
        $this->assign('teamInfo', $teamInfo);
        $this->assign('memberRefereeInfo', $memberRefereeInfo);
        return view('Match/friendlyinfo');
    }

    // 联赛组织创建1
    public function createOrganization1() {
        return view('Match/createOrganization1');
    }

    // 联赛组织创建2
    public function createOrganization2() {
        return view('Match/createOrganization2');
    }

    // 联赛组织创建3
    public function createOrganization3() {
        return view('Match/createOrganization3');
    }

    // 联赛组织编辑1
    public function organizationSetting1() {
        return view('Match/organizationSetting1');
    }

    // 联赛组织编辑2
    public function organizationSetting2() {
        return view('Match/organizationSetting2');
    }

    // 联赛列表
    public function leagueList() {
        return view('Match/leagueList');
    }

    // 联赛主页
    public function leagueInfo() {
        return view('Match/leagueInfo');
    }
}