<?php
// 比赛 赛事
namespace app\keeper\controller;

use app\model\MatchRefereeApply;
use app\service\ArticleService;
use app\service\CertService;
use app\service\LeagueService;
use app\service\MatchService;
use app\service\MemberService;
use app\service\TeamService;
use app\service\RefereeService;
use think\Exception;

class Match extends Base {
    protected $league_id;
    protected $leagueInfo;
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $league_id = input('league_id', 0, 'intval');
        if ($league_id) {
            //$matchS = new MatchService();
            $leagueS = new LeagueService();
            $leagueInfo = $leagueS->getLeaugeInfoWithOrg(['id' => $league_id]);
            $this->assign('league_id', $league_id);
            $this->assign('leagueInfo', $leagueInfo);
            $this->league_id = $league_id;
            $this->leagueInfo = $leagueInfo;
        }
    }

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

    // 发布约战比赛列表
    public function friendlylistOfTeam() {
        // 获取球队详细信息 模块下全局赋值
        $team_id = input('team_id');
        $teamS = new TeamService();
        $teamInfo = $teamS->getTeam(['id' => $team_id]);
        $this->assign('team_id', $team_id);
        $this->assign('teamInfo', $teamInfo);
        return view('Match/friendlylistOfTeam');
    }

    // 约战列表 (机构版)
    public function friendlylistOfOrganization() {
        return view('Match/friendlylistOfOrganization');
    }

    // 约战比赛详情
    public function friendlyinfo() {
        $matchId = input('match_id');
        $matchS = new MatchService();
        $refereeS = new RefereeService();
        // 比赛详情
        $matchInfo = $matchS->getMatch(['id' => $matchId]);
        $matchRecordInfo = $matchS->getMatchRecord(['match_id' => $matchInfo['id']]);
        if ($matchRecordInfo) {
            if (!empty($matchRecordInfo['album'])) {
                $matchRecordInfo['album'] = json_decode($matchRecordInfo['album'], true);
            }
            if (empty($matchRecordInfo['away_team'])) {
                $matchRecordInfo['away_team_logo'] = config('default_image.team_logo');
            }
            // 裁判字段数据为空
            $emptyRefereeArr = [
                'referee_id' => 0, 'referee' => '', 'referee_cost' => ''
            ];
            if ( empty($matchRecordInfo['referee1']) ) {
                $matchRecordInfo['referee1'] = $emptyRefereeArr;
            }
            if ( empty($matchRecordInfo['referee2']) ) {
                $matchRecordInfo['referee2'] = $emptyRefereeArr;
            }
            if ( empty($matchRecordInfo['referee3']) ) {
                $matchRecordInfo['referee3'] = $emptyRefereeArr;
            }
            $matchInfo['record'] = $matchRecordInfo;
        }

        // 裁判列表： 获取已同意的裁判比赛申请|邀请的裁判名单
        $modelMatchRefereeApply = new MatchRefereeApply();
        $refereeList = $modelMatchRefereeApply->where([
            'match_id' => $matchRecordInfo['match_id'],
            'match_record_id' => $matchRecordInfo['id'],
            'status' => ['neq', 3]
        ])->select();


        // 比赛发布球队信息
        $teamS = new TeamService();
        $teamInfo = $teamS->getTeam(['id' => $matchInfo['team_id']]);

        // 获取会员的已审核裁判员信息
        $memberRefereeInfo = $refereeS->getRefereeInfo(['member_id' => $this->memberInfo['id'], 'status' => 1]);

        $this->assign('match_id', $matchId);
        $this->assign('matchInfo', $matchInfo);
        $this->assign('teamInfo', $teamInfo);
        $this->assign('memberRefereeInfo', $memberRefereeInfo);
        $this->assign('refereeList', $refereeList);
        return view('Match/friendlyinfo');
    }

    // 联赛组织创建
    public function createorganization() {
        // 视图页
        $step = input('step', 1, 'intval');
        $view = 'Match/organization/createOrganization'.$step;

        // 有联赛组织
        $id = input('org_id', 0, 'intval');
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
        return view('Match/organization/createOrgSuccess', [
            'org_id' => $orgId
        ]);
    }

    // 联赛组织编辑
    public function organizationSetting() {
        // 视图页
        $step = input('step', 1, 'intval');
        $view = 'Match/organization/organizationSetting'.$step;

        // 有联赛组织
        $orgId = input('org_id', 0, 'intval');
        $leagueS = new LeagueService();
        if (!$orgId) {
           $this->error(__lang('MSG_402'));
        }
        $matchOrgInfo = $leagueS->getMatchOrg(['id' => $orgId]);
        if (!$matchOrgInfo) {
            $this->error(__lang('MSG_404'));
        }

        // 证件信息
        $certS = new CertService();
        $orgCert = $leagueS->getOrgCert($orgId);
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
        $leagueS = new LeagueService();
        $map["match_id"] = $this->league_id;
        $map["custom_role"] = array('exp','is not null');
        $customMemberInfo = $leagueS->getMatchMember($map);
        $this->assign('customMemberInfo', $customMemberInfo);
        return view('Match/leagueMatchEdit');
    }

    // 联赛管理
    public function leagueManage() {
        // 获取当前会员的联赛人员关系数据
        $leagueS = new LeagueService();
        $matchMemberInfo = $leagueS->getMatchMember([
            'match_id' => $this->league_id,
            'member_id' => $this->memberInfo['id'],
            'status' => 1
        ]);
        if (!$matchMemberInfo) {
            $this->error(__lang('MSG_403'));
        }

        $this->assign('matchMemberInfo', $matchMemberInfo);
        return view('Match/leagueManage');
    }

    // 我的联赛
    public function myLeague() {
        $id = input('org_id', 0, 'intval');
        $leagueS = new LeagueService();
        $matchS = new MatchService();
        // 获取联赛组织详情
        $leagueOrg = $leagueS->getMatchOrg(['id' =>$id]);
        // 获取该联赛组织的联赛列表
        $leagueList = $matchS->matchListAll(['match_org_id' => $id]);

        return view('Match/myLeague', [
            'orgInfo' => $leagueOrg,
            'leagueList' => $leagueList
        ]);
    }

    // 联赛主页
    public function leagueInfo() {
        // 工作人员类型
        $leagueS = new LeagueService();
        $types = $leagueS->getMatchMemberTypes();
        
        // 检查他是否为管理员
        $is_manager = 0;
        $matchMember = $leagueS->getMatchMember(['match_id' => $this->league_id, 'member_id' => $this->memberInfo['id'], 'status' => 1]);

        // 申请联赛工作人员按钮显示：查询联赛工作人员无数据就显示
        // if (!$matchmember || $matchmember['status'] != 1) {
        //     $btnApplyWorkerShow = 1;
        // }

        if ( !empty($matchMember) && $matchMember['type'] >= 9) {
            $is_manager = 1;
        }

        // 联赛可报名状态标识：
        // 1 当前时间在报名开始时间与报名结束时间
        // 2 联赛报名状态字段apply_status：1可报名|2结束报名
        // 3 联赛无赛程记录
        $cansignup = 1;
        $nowtime = time();
        // $leagueScheduleCount = $leagueS->getMatchScheduleCount(['match_id' => $this->league_id]);

        if ( $nowtime < $this->leagueInfo['reg_start_timestamp'] ) {
            // 等待报名（未到联赛报名时间）
            $cansignup = -1;
        } else if ($nowtime >= $this->leagueInfo['reg_start_timestamp'] && 
            $nowtime <= $this->leagueInfo['reg_end_timestamp']) {
            // 可报名
            $cansignup = 0;
        } else if ( $nowtime > $this->leagueInfo['start_timestamp'] && 
            $nowtime <= $this->leagueInfo['end_timestamp']) {
            // 正在进行
            $cansignup = 1;
        } else if ( $nowtime > $this->leagueInfo['end_timestamp']) {
            // 结束报名
            $cansignup = 2;
        }

        $this->assign('types', $types);
        $this->assign('is_manager', $is_manager);
        $this->assign('cansignup', $cansignup);
        return view('Match/leagueInfo');
    }

    // 联赛章程
    public function leagueregulation() {

         // 以下是wayen加的内容，用于输出btnApplyWorkerShow变量，供前端页面显示。明辉有空整理一下这个代码///start//////////////
         // 工作人员类型
         $leagueS = new LeagueService();
         $types = $leagueS->getMatchMemberTypes();
         // 申请联赛工作人员按钮显示：查询联赛工作人员无数据就显示
         $btnApplyWorkerShow = 0;
         $matchmember = $leagueS->getMatchMember(['match_id' => $this->league_id, 'member_id' => $this->memberInfo['id']]);
         if (!$matchmember || $matchmember['status'] != 1) {
             $btnApplyWorkerShow = 1;
         }
         
         $this->assign('types', $types);
         $this->assign('btnApplyWorkerShow', $btnApplyWorkerShow);
         //////////////////////////end//////////////////////////

        return view('Match/regulation/leagueRegulation');
    }
     // 联赛章程编辑
     public function regulationofleague() {
        return view('Match/regulation/regulationOfLeague');
    }

    // 联赛赛程详情页
    public function leaguescheduleinfo() {
        $id = input('param.id', 0, 'intval');
        $leagueS = new LeagueService();
        $matchScheduleInfo = $leagueS->getMatchSchedule(['id' => $id]);

        $this->assign('matchScheduleInfo', $matchScheduleInfo);
        return view('Match/schedule/leagueScheduleInfo');
    }

    // 联赛赛程
    public function leagueSchedule() {
        $id = input('param.id', 0, 'intval');
        $leagueS = new LeagueService();
        // $matchScheduleInfo = $leagueS->getMatchSchedule(['id' => $id]);
        $matchGroupInfo = $leagueS->getMatchGroups(['match_id' => $this->league_id], 'name asc');

        $this->assign('matchGroupInfo', $matchGroupInfo);
        return view('Match/schedule/leagueSchedule');
    }

    // 联赛战绩
    public function leagueRecord() {

        return view('Match/record/leagueRecord');
    }

    // 联赛战绩详情
    public function leaguerecordinfo() {
        $id = input('param.id', 0, 'intval');
        $matchS = new MatchService();
        $matchRecordInfo = $matchS->getMatchRecord(['id' => $id]);

        $this->assign('matchRecordInfo', $matchRecordInfo);
        return view('Match/record/recordInfo');
    }

    // 联赛数据
    public function leagueData() {
        return view('Match/data/leagueData');
    }

    // 联赛球队
    public function leagueTeam() {
        return view('Match/team/leagueTeam');
    }
 
     // 联赛花絮
     public function leagueTidbit() {
        return view('Match/leagueTidbit');
    }


    /*=======以上是外部展示页，以下是管理操作页=======*/

    // 联赛球队
    public function teamListOfLeague() {
        return view('Match/team/teamListOfLeague');
    }

    // 联赛球队详情
    public function teaminfoofleague() {
        $league_id = input('league_id', 0, 'intval');
        $team_id = input('team_id', 0, 'intval');

        // 获取联赛球队信息
        $leagueService = new LeagueService();
        $matchTeam = $leagueService->getMatchTeamInfoSimple([
            'match_id' => $league_id,
            'team_id' => $team_id
        ]);
        if (!$matchTeam) {
            $this->error(__lang('MSG_404'));
        }
        // 球队详情信息
        $teamS = new TeamService();
        $teamInfo = $teamS->getTeam(['id' => $matchTeam['team_id']]);
        // 获取球队提交的参加联赛球员信息
        $matchTeamMembers = $leagueService->getMatchTeamMembers([
            'match_id' => $league_id,
            'team_id' => $team_id
        ]);

        $this->assign('teamInfo', $teamInfo);
        $this->assign('matchTeamMembers', $matchTeamMembers);
        return view('Match/team/teamInfoOfLeague');
    }

    // 联赛报名球队详情
    public function teaminfosignupleague() {
        $league_id = input('league_id', 0, 'intval');
        $team_id = input('team_id', 0, 'intval');

        // 获取联赛申请球队信息
        $matchService = new MatchService();
        $matchApply = $matchService->getMatchApply([
            'match_id' => $league_id,
            'team_id' => $team_id
        ]);
        if (!$matchApply) {
            $this->error(__lang('MSG_404'));
        }

        // 获取球队详细信息
        $teamS = new TeamService();
        $teamInfo = $teamS->getTeam(['id' => $team_id]);

        return view('Match/team/teamInfoSignupLeague', [
            'matchApplyInfo' => $matchApply,
            'teamInfo' => $teamInfo
        ]);
    }

    // 联赛比赛
    public function matchListOfLeague() {
        return view('Match/match/matchListOfLeague');
    }

    // 比赛技术数据创建
    public function matchInfoOfLeague() {
        $id = input('id', 0, 'intval');
        $matchS = new MatchService();
        $matchRecordInfo = $matchS->getMatchRecord(['id' => $id]);

        $this->assign('matchRecordInfo',$matchRecordInfo);
        return view('Match/match/matchInfoOfLeague');
    }

    // 比赛技术数据编辑
    public function editMatchOfLeague() {
        $id = input('id', 0, 'intval');
        $matchS = new MatchService();
        $matchRecordInfo = $matchS->getMatchRecord(['id' => $id]);

        $this->assign('matchRecordInfo',$matchRecordInfo);
        return view('Match/match/editMatchOfLeague');
    }

    // 联赛编辑比赛
    public function matchEditOfLeague() {
        return view('Match/match/matchEditOfLeague');
    }

   

    // 报名联赛
    public function signUpLeague() {
        $league_id = input('league_id');
        return view('Match/signUpLeague', [
            'league_id' => $league_id
        ]);
    }

    // 联赛球队报名回复
    public function teamApplyListOfLeague() {
        return view('Match/teamApplyListOfLeague');
    }

    // 组织管理员列表
    public function adminListOfOrganization() {
        $org_id = input('org_id');
        // 查询联赛组织
        $leagueService = new LeagueService();
        $leagueOrgInfo = $leagueService->getMatchOrg(['id' => $org_id]);

        return view('Match/organization/adminListOfOrganization', [
            'org_id' => $org_id,
            'leagueOrgInfo' => $leagueOrgInfo
        ]);
    }

    //  邀请会员-组织管理员
    public function addorgmemberoforg() {
        $org_id = input('org_id');
        // 查询联赛组织
        $leagueService = new LeagueService();
        $leagueOrgInfo = $leagueService->getMatchOrg(['id' => $org_id]);

        return view('Match/organization/addOrgMemberOfOrg', [
            'org_id' => $org_id,
            'leagueOrgInfo' => $leagueOrgInfo
        ]);
    }

    // 会员查看联赛组织邀请详情
    public function orginvitation() {
        // apply表id
        $id = input('id', 0, 'intval');
        // 查询联赛组织邀请信息
        $leagueS = new LeagueService();
        $matchS = new MatchService();
        $applyInfo = $leagueS->getApplyByLeague([
            'id' => $id,
            'organization_type' => 5
        ]);
        if (!$applyInfo) {
            $this->error(__lang('MSG_404'));
        }
        // 查询联赛组织信息、联赛信息
        $orgInfo = $leagueS->getMatchOrg(['id' => $applyInfo['organization_id']]);
        $leagueInfo = $matchS->getMatch(['match_org_id' => $applyInfo['organization_id']]);
        // 更新apply阅读状态为已读
        try {
            if ($this->memberInfo['id'] == $applyInfo['member_id']) {
                $leagueS->saveApplyByLeague([
                    'id' => $applyInfo['id'],
                    'isread' => 1
                ]);
            }
        } catch (Exception $e) {
            trace('error:'.$e->getMessage(), 'error');
            $this->error($e->getMessage());
        }

        return view('Match/orgInvitation', [
            'applyInfo' => $applyInfo,
            'orgInfo' => $orgInfo,
            'leagueInfo' => $leagueInfo
        ]);
    }

    // 联赛工作人员列表
    public function workListOfLeague() {
         // 工作人员类型
         $leagueS = new LeagueService();
         $types = $leagueS->getMatchMemberTypes();
         return view('Match/work/workListOfLeague', [
             'types' => $types
         ]);
    }

    // 联赛工作人员详情
    public function workMemberInfo() {
        // 工作人员类型
        $leagueS = new LeagueService();
        $types = $leagueS->getMatchMemberTypes();
        return view('Match/work/workMemberInfo', [
            'types' => $types
        ]);
   }

    // 邀请联赛工作人员
    public function addworkerofleague() {
        // 工作人员类型
        $leagueS = new LeagueService();
        $types = $leagueS->getMatchMemberTypes();
        return view('Match/work/addWorkerOfLeague', [
            'types' => $types
        ]);
    }

    // 会员查看联赛工作人员邀请详情
    public function workerinvitation() {
        // apply表id
        $id = input('id', 0, 'intval');
        // 查询联赛组织邀请信息
        $leagueS = new LeagueService();
        $matchS = new MatchService();
        $applyInfo = $leagueS->getApplyByLeague([
            'id' => $id,
            'organization_type' => 4,
            'apply_type' => 2
        ]);
        if (!$applyInfo) {
            $this->error(__lang('MSG_404'));
        }
        // 查询联赛联赛信息 因organization_type = 4 所以 organization_id 代表 联赛ID
        $leagueInfo = $leagueS->getLeaugeInfoWithOrg(['id' => $applyInfo['organization_id']]);
        // 更新apply阅读状态为已读
        try {
            if ($this->memberInfo['id'] == $applyInfo['member_id']) {
                $leagueS->saveApplyByLeague([
                    'id' => $applyInfo['id'],
                    'isread' => 1
                ]);
            }
        } catch (Exception $e) {
            trace('error:'.$e->getMessage(), 'error');
            $this->error($e->getMessage());
        }

        return view('Match/work/workerInvitation', [
            'applyInfo' => $applyInfo,
            'leagueInfo' => $leagueInfo
        ]);
    }

    // 联赛工作人员申请列表
    public function workerapplylist() {
        return view('Match/work/workerApplyList');
    }

    // 查看联赛工作人员申请详情
    public function workerapplyinfo() {
        $apply_id = input('apply_id', 0, 'intval');
        // 获取联赛工作人员申请数据
        $leagueS = new LeagueService();
        $applyInfo = $leagueS->getApplyByLeague([
            'id' => $apply_id,
            'organization_type' => 4,
            'apply_type' => 1
        ]);

        if (!$applyInfo) {
            $this->error(__lang('MSG_404'));
        }

        // 申请职位文案
        switch ($applyInfo['type']) {
            case 3:
                $applyInfo['type_text'] = '管理员';
                break;  // 管理员
            case 8:
                $applyInfo['type_text'] = '记分员';
                break;  // 记分员
            case 6:
                $applyInfo['type_text'] = '裁判员';
                break;  // 裁判员
            default:
                $applyInfo['type_text'] = '工作人员';
        }
        // 查询联赛联赛信息
        $leagueInfo = $leagueS->getLeaugeInfoWithOrg(['id' => $applyInfo['organization_id']]);
        // 查询联赛工作人员信息
        $matchMemberInfo = $leagueS->getMatchMember([
            'match_id' => $applyInfo['organization_id'],
            'member_id' => $applyInfo['member_id']
        ]);

        $memberS = new MemberService();
        $applyInfo['member'] = $memberS->getMemberInfo(['id' => $applyInfo['member_id']]);
        $applyInfo['member']['fans'] = getfansnum($applyInfo['member_id'], 1);
        // 若是裁判员读取裁判员数据
        $refereeS = new RefereeService();
        if ($applyInfo['type'] == 6) {
            $refereeInfo = $refereeS->getRefereeInfo(['member_id' => $applyInfo['member_id']]);
            $this->assign('refereeInfo', $refereeInfo);
        }

        // 更新apply阅读状态为已读
        try {
            // 联赛工作人员查看更新阅读状态
            $matchOrgMember = $leagueS->getMatchOrgMember([
                'match_org_id' => $leagueInfo['match_org_id'],
                'member_id' => $this->memberInfo['id'],
                'status' => 1
            ]);
            if ($matchOrgMember && $matchOrgMember['status'] == 1) {
                $leagueS->saveApplyByLeague([
                    'id' => $applyInfo['id'],
                    'isread' => 1
                ]);
            }
        } catch (Exception $e) {
            trace('error:'.$e->getMessage(), 'error');
            $this->error($e->getMessage());
        }
// dump($applyInfo);exit;
// dump($leagueInfo);
// dump($matchMemberInfo);exit;
        $this->assign('applyInfo', $applyInfo);
        $this->assign('leagueInfo', $leagueInfo);
        $this->assign('matchMemberInfo', $matchMemberInfo);
        return view('Match/work/workerApplyInfo');
    }

    // 联赛消息
    public function messageListOfLeague() {
        return view('Match/message/messageListOfLeague');
    }
    
    // 联赛战绩管理
    public function recordListOfLeague() {
        return view('Match/record/recordListOfLeague');
    }

    // 联赛数据管理
    public function dataListOfLeague() {
        return view('Match/data/dataListOfLeague');
    }

    // 联赛分组列表
    public function groupsListOfLeague() {
        // 获取联赛有无分组数据
        $leagueS = new LeagueService();
        // 创建/编辑分组 控制标识：0创建/1编辑
        $btnEditAction = 0;
        $matchGroups = $leagueS->getMatchGroups(['match_id' => $this->league_id]);
        if ($matchGroups) {
            $btnEditAction = 1;
        }
        return view('Match/group/groupsListOfLeague', [
            'btnEditAction' => $btnEditAction
        ]);
    }
    
    // 联赛创建分组
    public function createGroups() {
        // 联赛正式球队数
        $leagueS = new LeagueService();
        $teamCount = $leagueS->getMatchTeamCount(['match_id' => $this->league_id]);

        return view('Match/group/createGroups', [
            'teamCount' => $teamCount
        ]);
    }

    // 联赛创建分组
    public function createCustomGroups() {
        // 联赛正式球队数
        $leagueS = new LeagueService();
        $teamCount = $leagueS->getMatchTeamCount(['match_id' => $this->league_id]);

        return view('Match/group/createCustomGroups', [
            'teamCount' => $teamCount
        ]);
    }

    // 编辑联赛某个分组
    public function editgroups() {
        // 联赛正式球队数
        $leagueS = new LeagueService();
        // 联赛正式球队数
        $teamCount = $leagueS->getMatchTeamCount(['match_id' => $this->league_id]);
        // 联赛分组数
        $groupCount = $leagueS->getMatchGroupCount(['match_id' => $this->league_id]);

        return view('Match/group/editGroups', [
            'teamCount' => $teamCount,
            'groupCount' => $groupCount
        ]);
    }

    // 球队登记联赛参赛球员
    public function completeplayerbyteam() {
        $team_id = input('team_id', 0, 'intval');
        $apply_id = input('apply_id', 0, 'intval');
        $teamS = new TeamService();
        $leagueS = new LeagueService();
        $matchS = new MatchService();
        // 查询联赛数据（已初始化）
        // 查询球队申请参加联赛数据
        if ($apply_id) {
            $matchApplyInfo = $matchS->getMatchApply(['id' => $apply_id]);
        } else {
            $matchApplyInfo = $matchS->getMatchApply(['match_id' => $this->league_id, 'team_id' => $team_id]);
        }
        if (!$matchApplyInfo) {
            $this->error('无报名联赛数据');
        }
        // 查询球队-联赛关系数据
        $matchTeamInfo = $leagueS->getMatchTeamInfoSimple(['team_id' => $team_id, 'match_id' => $this->league_id]);
        // 获取球队数据
        $teamInfo = $teamS->getTeam(['id' => $team_id]);

        return view('Match/team/completePlayerByTeam', [
            'matchApplyInfo' => $matchApplyInfo,
            'matchTeamInfo' => $matchTeamInfo,
            'teamInfo' => $teamInfo
        ]);
    }

    // 赛程列表管理
    public function schedulelistofleague() {
        $leagueS = new LeagueService();
        // 获取联赛分组记录数
        $groupCount = $leagueS->getMatchGroupCount(['match_id' => $this->league_id]);
        // 获取系统添加的联赛赛程记录数
        $scheduleCount = $leagueS->getMatchScheduleCount(['match_id' => $this->league_id, 'add_mode' => 1]);
        // 获取自填的联赛赛程记录数
        $scheduleCustomCount = $leagueS->getMatchScheduleCount(['match_id' => $this->league_id, 'add_mode' => 2]);
        // 获取是小组阶段的赛程记录数
        $scheduleCountHasGroupId = $leagueS->getMatchScheduleCount([
            'match_id' => $this->league_id,
            'match_group_id' => ['>', 0]
        ]);
        // 根据分组、赛程数 控制按钮显示
        $showBtn = 0;
        if ( !$groupCount && !$scheduleCount ) {
            // 没分组
            $showBtn = 1;
        } else if ( $groupCount && !$scheduleCount ) {
            // 有分组&没赛程
            $showBtn = 2;
        } else if ( $groupCount && $scheduleCustomCount ) {
            // 有分组&有自填赛程
            $showBtn = 3;
        } else if ( $groupCount && $scheduleCountHasGroupId && $scheduleCount ) {
            // 有分组&有系统添加赛程
            $showBtn = 4;
        } else if ( $groupCount && $scheduleCountHasGroupId && $scheduleCustomCount) {
            // 有分组的赛程信息
            $showBtn = 5;
        }
        $groups = $leagueS->getMatchGroups([
            'match_id' => $this->league_id
        ]);

        $this->assign('groups', $groups);
        
        $this->assign('showBtn', $showBtn);
        return view('Match/schedule/scheduleListOfLeague');
    }   

    // 创建赛程（选择对阵球队排排赛程操作）
    public function createSchedule() {
        // 获取联赛分组列表
        $leagueS = new LeagueService();
        $groups = $leagueS->getMatchGroups([
            'match_id' => $this->league_id
        ]);
        $matchStageGroupInfo = $leagueS->getMatchStage([
            'match_id' => $this->league_id,
            'type' => 1
        ]);

        $orderby = ['match_time' => 'asc', 'id' => 'asc'];
        $matchScheduleInfo = $leagueS->getMatchSchedules(['match_id' => $this->league_id, 'match_stage_id' => $matchStageGroupInfo['id']], $orderby);

        $finalArray = array();
        if (!empty($matchScheduleInfo)){
            foreach ($matchScheduleInfo as $row) {
                // dump($row);exit;
                $temp = date("Y-m-d", $row['match_timestamp']);
                if (!array_key_exists($temp, $finalArray)) {
                    $finalArray[$temp] = array();
                }
                array_push($finalArray[$temp], $row);
            }
        }

        $this->assign('groups', $groups);
        $this->assign('matchStageGroupInfo', $matchStageGroupInfo);
        $this->assign('matchScheduleInfo', $finalArray);
        return view('Match/schedule/createSchedule');
    }


    // 创建赛程
    public function createscheduleofleague() {
        // 获取联赛分组列表
        $leagueS = new LeagueService();
        $groups = $leagueS->getMatchGroups([
            'match_id' => $this->league_id
        ]);
        $matchStageGroupInfo = $leagueS->getMatchStage([
            'match_id' => $this->league_id,
            'type' => 1
        ]);

        $this->assign('groups', $groups);
        $this->assign('matchStageGroupInfo', $matchStageGroupInfo);
        return view('Match/schedule/createScheduleOfLeague');
    }

    // 手动创建赛程
    public function createscheduleofleague1() {
        // 获取联赛分组列表
        $leagueS = new LeagueService();
        $groups = $leagueS->getMatchGroups([
            'match_id' => $this->league_id
        ]);
        $hasGroup = ($groups) ? 1 : 0;

        // 通道预览赛程保存的小组赛阶段赛程记录数
        $sysbuildMatchScheduleCount = $leagueS->getMatchScheduleCount([
            'match_id' => $this->league_id,
            'match_group_id' => ['>', 0],
            'add_mode' => 1,
        ]);
        $showMatchStageType1 = ($sysbuildMatchScheduleCount) ? 0 : 1;

        $this->assign('groups', $groups);
        $this->assign('showMatchStageType1', $showMatchStageType1);
        $this->assign('hasGroup', $hasGroup);
        return view('Match/schedule/createScheduleOfLeague1');
    }

    // 编辑赛程
    public function editScheduleOfLeague() {
        $id = input('id', 0, 'intval');
        // 获取赛程详情
        $leagueS = new LeagueService();
        $matchscheduleInfo = $leagueS->getMatchSchedule(['id' => $id]);
        if (!$matchscheduleInfo) {
            $this->error(__lang('MSG_404'));
        }
        // 获取联赛分组列表
        $groups = $leagueS->getMatchGroups([
            'match_id' => $this->league_id
        ]);
        // 有无联赛分组信息标识
        $hasGroup = ($groups) ? 1 : 0;
        // 获取赛程的比赛阶段信息中所设上一个阶段id
        $parentMatchStageInfo = $leagueS->getMatchStage(['id' => $matchscheduleInfo['match_stage_id']]);
        $pstageid = ($parentMatchStageInfo) ? $parentMatchStageInfo['pstage_id'] : 0;

        $this->assign('matchScheduleInfo', $matchscheduleInfo);
        $this->assign('hasGroup', $hasGroup);
        $this->assign('pstageid', $pstageid);
        return view('Match/schedule/editScheduleOfLeague');
    }

    // 比赛阶段创建
    public function createMatchStage() {
        $leagueS = new LeagueService();
        // 比赛阶段类型选择
        $matchTypeSelect = $leagueS->getMatchStageTypes();
        // 获取联赛有无小组赛比赛阶段信息，若已有小组赛（type=1)比赛阶段不能选择
        $matchStageInfoType1 = $leagueS->getMatchStage([
            'match_id' => $this->league_id,
            'type' => 1
        ]);
        if ($matchStageInfoType1) {
            unset($matchTypeSelect[$matchStageInfoType1['type']]);
        }

        $this->assign('matchTypeSelect', $matchTypeSelect);
        return view('Match/stage/createMatchStage');
    }

    // 比赛阶段编辑
    public function editmatchstage() {
        $id = input('id', 0, 'intval');
        // 获取比赛阶段详情
        $leagueS = new LeagueService();
        $stageInfo = $leagueS->getMatchStage(['id' => $id]);
        $matchTypeSelect = $leagueS->getMatchStageTypes();

        $this->assign('matchStageInfo', $stageInfo);
        $this->assign('matchTypeSelect', $matchTypeSelect);
        return view('Match/stage/editMatchStage');
    }

    // 比赛阶段管理列表
    public function matchstageListofleague() {
        return view('Match/stage/matchStageListOfLeague');
    }

      // 联赛比赛阶段出线（晋级）球队预览页
      public function stagePromotionList() {
        return view('Match/stage/promotionList');
    }


    // 联赛对阵积分表
    public function integralTableList() {
        // 判断有无小组赛晋级数据 显示提交数据按钮
        $showBtn = 1;
        $leagueS = new LeagueService();
        $matchStageAdvteams = $leagueS->getMatchStageAdvteams([
            'match_id' => $this->league_id,
            'match_group_id' => ['>', 0]
        ]);
        // 不显示按钮
        if ($matchStageAdvteams) {
            $showBtn = 0;
        }

        // 控制能否提交排名数据：小组赛阶段赛程无完成，已发布的小组赛阶段比赛结果记录数等于已完成小组赛阶段赛程记录数
        $canSubmit = 0;
        // 未完成分组赛程记录数
        $normalMatchScheduleCount = $leagueS->getMatchScheduleCount([
            'match_id' => $this->league_id,
            'status' => 1,
            'match_group_id' => ['>', 0]
        ]);
        // 已完成分组赛程记录数
        $finishMatchScheduleCount = $leagueS->getMatchScheduleCount([
            'match_id' => $this->league_id,
            'status' => 2,
            'match_group_id' => ['>', 0]
        ]);
        // 未发布的分组比赛结果
        $normalMatchRecordCount = $leagueS->getMatchRecordCount([
            'match_id' => $this->league_id,
            'match_group_id' => ['>', 0],
            'is_record' => 0
        ]);
        // 已发布的分组比赛结果
        $isRecordMatchRecordCount = $leagueS->getMatchRecordCount([
            'match_id' => $this->league_id,
            'match_group_id' => ['>', 0],
            'is_record' => 1
        ]);
        if ( !$normalMatchScheduleCount && $finishMatchScheduleCount && $isRecordMatchRecordCount && $finishMatchScheduleCount == $isRecordMatchRecordCount) {
            $canSubmit = 1;
        }

        $this->assign('showBtn', $showBtn);
        $this->assign('canSubmit', $canSubmit);
        return view('Match/record/integralTableList');
    }

    // 比赛结果录入
    public function recordScoreOfLeague() {
        // 获取比赛比分数据，没有则获取赛程数据
        $id = input('match_id', 0, 'intval');
        $leagueId = input('league_id', 0,'intval');
        $leagueS = new LeagueService();
        $matchS = new MatchService();
        $matchScheduleInfo = $leagueS->getMatchSchedule([
            'id' => $id,
            'match_id' => $leagueId
        ]);

        $this->assign('matchScheduleInfo', $matchScheduleInfo);
        return view('Match/record/recordScoreOfLeague');
    }

    // 比赛结果详情
    public function recordInfo() {
        // 获取比赛比分数据，没有则获取赛程数据
        $id = input('id', 0, 'intval');
        $leagueId = input('league_id', 0,'intval');
        $leagueS = new LeagueService();
        $matchS = new MatchService();
        $matchRecordInfo = $matchS->getMatchRecord([
            'id' => $id,
            'match_id' => $leagueId
        ]);

        $this->assign('matchRecordInfo', $matchRecordInfo);
        return view('Match/record/recordInfo');
    }

    // 比赛结果编辑
    public function editRecordScoreOfLeague() {
        // 获取比赛比分数据，没有则获取赛程数据
        $id = input('id', 0, 'intval');
        $leagueId = input('league_id', 0,'intval');
        $leagueS = new LeagueService();
        $matchS = new MatchService();
        $matchRecordInfo = $matchS->getMatchRecord([
            'id' => $id,
            'match_id' => $leagueId
        ]);

        $this->assign('matchRecordInfo', $matchRecordInfo);
        return view('Match/record/editRecordScoreOfLeague');
    }
    
    // 联赛荣誉列表
    public function honorListOfLeague() {
        return view('Match/honor/listOfLeague');
    }
    // 联赛创建荣誉
    public function createHonorOfLeague() {
        return view('Match/honor/createOfLeague');
    }
     // 联赛荣誉详情（外部展示）
     public function honorInfo() {
        return view('Match/honor/info');
    }
    // 联赛荣誉详情
    public function honorInfoOfLeague() {
        return view('Match/honor/infoOfLeague');
    }
    // 联赛编辑荣誉
    public function honotEditOfLeague() {
        return view('Match/honor/editOfLeague');
    }
    // 联赛荣誉
    public function leagueHonor() {
        return view('Match/honor/leagueHonor');
    }


    // 联赛动态列表
    public function dynamicListOfLeague() {
        return view('Match/dynamic/listOfLeague');
    }

    // 联赛创建动态
    public function dynamicCreateOfLeague() {
        return view('Match/dynamic/createOfLeague');
    }

    // 联赛动态详情（外部展示）
    public function dynamicinfo() {
        $id = input('param.article_id');
        $articleS = new ArticleService();
        $articleInfo = $articleS->getArticleInfo([
            'id' => $id,
            'organization_type' => 4,
            'category' => 3
        ]);
        if(!$articleInfo){
            $this->error('找不到文章信息');
        }
        //点击率+1;
        $articleS->incArticle([ 'id' => $articleInfo['id'] ],'hit');

        //收藏列表
        $isCollect = $articleS->getCollectInfo([ 'article_id'=> $articleInfo['id'],' member_id'=>$this->memberInfo['id'] ]);
        $isLikes = $articleS->getLikesInfo([ 'article_id' => $articleInfo['id'], 'member_id'=>$this->memberInfo['id'] ]);

        $this->assign('articleInfo', $articleInfo);
        $this->assign('isLikes',$isLikes);
        $this->assign('isCollect',$isCollect);
        return view('Match/dynamic/info');
    }

    // 联赛动态详情
    public function dynamicInfoOfLeague() {
        $id = input('param.article_id');
        $articleS = new ArticleService();
        $articleInfo = $articleS->getArticleInfo([
            'id' => $id,
            'organization_type' => 4,
            'category' => 3
        ]);
        if(!$articleInfo){
            $this->error('找不到文章信息');
        }

        $this->assign('articleInfo', $articleInfo);
        return view('Match/dynamic/InfoOfLeague');
    }
    // 联赛编辑动态
    public function dynamicEditOfLeague() {
        $id = input('param.article_id');
        $articleS = new ArticleService();
        $articleInfo = $articleS->getArticleInfo([
            'id' => $id,
            'organization_type' => 4,
            'category' => 3
        ]);
        if(!$articleInfo){
            $this->error('找不到文章信息');
        }

        $this->assign('articleInfo', $articleInfo);
        return view('Match/dynamic/editOfLeague');
    }
    // 联赛展示列表
    public function dynamicList() {
        return view('Match/dynamic/list');
    }
    // 联赛比赛动态列表
    public function leagueDynamicList() {
        return view('Match/dynamic/leagueDynamicList');
    }

    // 联赛球员数据
    public function teamMemberData() {
        return view('Match/data/teamMemberData');
    }

    // 联赛球队数据
    public function teamData() {
        return view('Match/data/teamData');
    }

    // 联赛-创建球队
    public function createTeamOfLeague() {
        return view('Match/team/createTeamOfLeague');
    }

    // 联赛-编辑球队（未产生赛程之前可以修改）
    public function updateTeamOfLeague() {
        $team_id = intval(input('param.team_id'));
        $league_id = intval(input('param.league_id'));

        if (empty($team_id) || empty($league_id)) {
            $this->error(__lang('MSG_200'));
        }
        $teamS = new TeamService();
        $teamInfo = $teamS -> getTeamOnly(['id' => $team_id]);

        $this->assign('teamInfo', $teamInfo);
        $this->assign('league_id', $league_id);
        return view('Match/team/updateTeamOfLeague');
    }
   // 联赛操作指南
   public function leagueGuide() {
    return view('Match/leagueGuide');
}
}