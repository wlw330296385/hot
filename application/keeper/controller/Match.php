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
        // 联赛组织id
        $orgId = input('org_id', 0, 'intval');
        $leagueS = new LeagueService();
        if ($orgId) {
            $matchOrgInfo = $leagueS->getMatchOrg(['id' => $orgId]);
            $this->assign('matchOrgInfo', $matchOrgInfo);
        }
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
    public function createOrganization() {
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
        $certS = new CertService();
        $certs = $certS->getCertList(['member_id' => $this->memberInfo['id']]);
        $idCard = [];
        if (!empty($certs['data'])) {
            foreach ($certs['data'] as $cert) {
                if ($cert['cert_type'] == 1 && $cert['camp_id'] == 0) {
                    $idCard[] = $cert;
                }
            }
        }

        return view($view, [
            'idCard' => $idCard
        ]);
    }

    // 注册联赛组织成功页
    public function createorgsuccess() {
        $orgId = input('org_id', 0, 'intval');
        return view('match/createOrgSuccess', [
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

        // 认证信息
        $certS = new CertService();
        $certs = $certS->getCertList(['match_org_id' => $id, 'camp_id' => 0]);
        $idCard = $frIdCard = $cert = $otherCert= [];

        return view($view, [
            'matchOrgInfo'=> $matchOrgInfo,
            'idCard' => $idCard,
            'frIdCard' => $frIdCard,
            'cert' => $cert,
            'otherCert' => $otherCert
        ]);
    }

    // 联赛列表
    public function leagueList() {
        return view('Match/leagueList');
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
    
}