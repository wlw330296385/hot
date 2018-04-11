<?php
// 比赛 赛事
namespace app\keeper\controller;


use app\service\CertService;
use app\service\LeagueService;
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

    // 约战列表 (机构版)
    public function friendlylistOfOrganization() {
        return view('Match/friendlylistOfOrganization');
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

    // 联赛组织创建
    public function createorganization() {
        // 视图页
        $step = input('step', 1, 'intval');
        $view = 'Match/createOrganization'.$step;

        // 有联赛组织
        $id = input('id', 0, 'intval');
        $leagueS = new LeagueService();
        if ($id) {
            $matchOrgInfo = $leagueS->getMatchOrg(['id' => $id]);
            $this->assign('matchOrgInfo', $matchOrgInfo);
        }

        // 认证信息
        // 身份证
        $idCard = db('cert')->where([
            'cert_type' => 1,
            'member_id' => $this->memberInfo['id'],
            'camp_id' => 0,
            'match_org_id' => 0
        ])->find();

        return view($view, [
            'idCard' => $idCard
        ]);
    }

    // 注册联赛组织成功页
    public function createorgsuccess() {
        $orgId = input('org_id', 0, 'intval');
        return view('Match/createOrgSuccess', [
            'org_id' => $orgId
        ]);
    }

    // 联赛组织编辑
    public function organizationSetting() {
        // 视图页
        $step = input('step', 1, 'intval');
        $view = 'Match/organizationSetting'.$step;

        // 有联赛组织
        $id = input('id', 0, 'intval');
        $leagueS = new LeagueService();
        if (!$id) {
           $this->error(__lang('MSG_402'));
        }
        $matchOrgInfo = $leagueS->getMatchOrg(['id' => $id]);
        if (!$matchOrgInfo) {
            $this->error(__lang('MSG_404'));
        }

        // 证件信息
        $certS = new CertService();
        $orgCert = $leagueS->getOrgCert($id);
        // 创建人身份证
        $idCard = db('cert')->where([
            'cert_type' => 1,
            'member_id' => $matchOrgInfo['creater_member_id'],
            'camp_id' => 0,
            'match_org_id' => 0
        ])->find();

        return view($view, [
            'matchOrgInfo'=> $matchOrgInfo,
            'orgCert' => $orgCert,
            'idCard' => $idCard
        ]);
    }

    // 联赛列表
    public function leagueList() {
        $leagueS = new LeagueService();
        $matchOrgList = $leagueS->getMemberInMatchOrgs($this->memberInfo['id']);
        // 会员有无联赛组织标识
        $hasMatchOrg = ($matchOrgList) ? 1 : 0;
        return view('Match/leagueList', [
            'hasMatchOrg' => $hasMatchOrg
        ]);
    }

    // 创建联赛信息
    public function createleaguematch() {
        $leagueS = new LeagueService();
        // 传入联赛组织id
        $orgId = input('org_id', 0, 'intval');
        if (!$orgId) {
            // 获取会员所在联赛组织，若无组织数据 跳转至创建联赛组织
            $matchOrgList = $leagueS->getMemberInMatchOrgs($this->memberInfo['id']);
            $this->assign('matchOrgList', $matchOrgList);
        } else {
            $matchOrgInfo = $leagueS->getMatchOrg(['id' => $orgId]);
            $this->assign('matchOrgInfo', $matchOrgInfo);
        }

        return view('Match/createLeagueMatch', [
            'orgId' => $orgId
        ]);
    }

    // 修改联赛信息
    public function leaguematchedit() {
        $leagueId = input('league_id', 0, 'intval');
        if (!$leagueId) {
            $this->error('请选择联赛');
        }
        $matchS = new MatchService();
        $matchInfo = $matchS->getMatch(['id' => $leagueId]);
        return view('Match/leagueMatchEdit', [
            'matchInfo' => $matchInfo
        ]);
    }

    // 联赛管理
    public function leagueManage() {
        $leagueId = input('league_id', 0, 'intval');
        $matchS = new MatchService();
        $matchInfo = $matchS->getMatch(['id' => $leagueId]);
        return view('Match/leagueManage', [
            'matchInfo' => $matchInfo
        ]);
    }

    // 我的联赛
    public function myLeague() {
        return view('Match/myLeague');
    }

    // 联赛主页
    public function leagueInfo() {
        return view('Match/leagueInfo');
    }

    // 联赛章程
    public function leagueGulations() {
        return view('Match/leagueGulations');
    }

    // 联赛赛程
    public function leagueSchedule() {
        return view('Match/leagueSchedule');
    }

    // 联赛战绩
    public function leagueRecord() {
        return view('Match/leagueRecord');
    }

    // 联赛数据
    public function leagueData() {
        return view('Match/leagueData');
    }

    // 联赛比赛动态列表
    public function leagueDynamicList() {
        return view('Match/leagueDynamicList');
    }

    // 联赛球队
    public function teamListOfLeague() {
        return view('Match/teamListOfLeague');
    }

    // 联赛比赛
    public function matchListOfLeague() {
        return view('Match/matchListOfLeague');
    }

    // 联赛创建比赛
    public function createMatchOfLeague() {
        return view('Match/createMatchOfLeague');
    }

    // 联赛比赛详情
    public function matchInfoOfLeague() {
        return view('Match/matchInfoOfLeague');
    }

    // 联赛编辑比赛
    public function matchEditOfLeague() {
        return view('Match/matchEditOfLeague');
    }

    // 报名联赛
    public function signUpLeague() {
        return view('Match/signUpLeague');
    }
    
}