<?php
// 球队模块
namespace app\frontend\controller;


use app\service\TeamService;

class Team extends Base {
    public $team_id;
    public $teamInfo;
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        // 获取球队详细信息 模块下全局赋值
        $team_id = input('team_id');
        $teamS = new TeamService();
        $teamInfo = $teamS->getTeam(['id' => $team_id]);
        /*if (!$teamInfo) {
            $this->error('没有球队信息');
        }*/
        $this->team_id = $team_id;
        $this->teamInfo = $teamInfo;
        $this->assign('team_id', $team_id);
        $this->assign('teamInfo', $teamInfo);
    }

    // 球队列表(平台展示)
    public function teamlist() {
        return view('Team/teamList');
    }

    // 创建球队
    public function createteam() {
        return view('Team/createTeam');
    }

    // 球队管理
    public function teammanage() {
        // 获取会员在球队角色身份
        $teamS = new TeamService();
        $teamrole = $teamS->checkMemberTeamRole($this->team_id, $this->memberInfo['id']);
        //dump($teamrole);
        $this->assign('teamrole', $teamrole);
        return view('Team/teamManage');
    }

    // 编辑球队
    public function teamedit() {
        // 获取球队有角色身份的会员列表
        $teamS = new TeamService();
        $rolemembers = $teamS->getTeamRoleMembers($this->team_id, 'team_member.member_id asc');
        //dump($rolemembers);
        // 教练、队委名单集合组合
        $roleslist = [
            'coach_ids' => '',
            'coach_names' => '',
            'committee_ids' => '',
            'committee_names' => ''
        ];
        foreach ($rolemembers as $rolemember) {
            if ($rolemember['type'] == 2) {
                $roleslist['coach_ids'] .= $rolemember['member_id'].',';
                $roleslist['coach_names'] .= $rolemember['member'].',';
            }
            if ($rolemember['type'] == 1 ) {
                $roleslist['committee_ids'] .= $rolemember['member_id'].',';
                $roleslist['committee_names'] .= $rolemember['member'].',';
            }
        }
        // 去掉结尾最后一个逗号
        $roleslist['coach_ids'] = rtrim($roleslist['coach_ids'], ',');
        $roleslist['coach_names'] = rtrim($roleslist['coach_names'], ',');
        $roleslist['committee_ids'] = rtrim($roleslist['committee_ids'], ',');
        $roleslist['committee_names'] = rtrim($roleslist['committee_names'], ',');

        $this->assign('rolemembers', $rolemembers);
        $this->assign('roleslist', $roleslist);
        return view('Team/teamEdit');
    }

    // 球队首页
    public function teaminfo() {
        // 球队胜率输出
        $this->teamInfo['win_rate'] = 0;
        if ($this->teamInfo['match_num']) {
            if ($this->teamInfo['match_win']) {
                $winrate = ($this->teamInfo['match_win']/$this->teamInfo['match_num']);
                $winrate = sprintf("%.2f", $winrate);
                $this->teamInfo['win_rate'] = $winrate*100;
            }  else {
                $this->teamInfo['win_rate'] = 0;
            }
        }
        return view('Team/teamInfo');
    }

    // 我的球队列表（会员所在球队列表）
    public function myteam() {
        $teamS = new TeamService();
        $myTeamList = $teamS->myTeamWithRole($this->memberInfo['id']);
        $this->assign('myTeamList', $myTeamList);
        return view('Team/myteam');
    }

    // 队员列表
    public function teammember() {
        return view('Team/teamMember');
    }

    // 队员档案
    public function teammemberinfo() {
        // 接收参数
        $team_id = input('team_id', 0);
        $member_id = input('member_id', 0);
        $teamS = new TeamService();
        // 获取队员在当前球队的数据信息
        $map = ['team_id' => $team_id, 'member_id' => $member_id];
        $teamMemberInfo = $teamS->getTeamMemberInfo($map);

        // 该队员的其他球队列表
        $memberOtherTeamMap = [ 'member_id' => $member_id, 'team_id' => ['neq', $team_id]];
        $memberOtherTeam = $teamS->getTeamMemberList($memberOtherTeamMap);

        $this->assign('teamMemberInfo', $teamMemberInfo);
        $this->assign('memberOtherTeam', $memberOtherTeam);
        return view('Team/teamMemberInfo');
    }

    // 申请加入列表
    public function teamapplylist() {
        return view('Team/teamApplyList');
    }

    // 申请加入详情
    public function teamapplyinfo() {
        $applyId = input('id');
        $teamS = new TeamService();
        $apply = $teamS->getApplyInfo(['id' => $applyId, 'organization_id' => $this->team_id]);

        $this->assign('applyInfo', $apply);
        return view('Team/teamApplyInfo');
    }

    // 粉丝列表
    public function fans() {
        return view('Team/fans');
    }

    // 消息列表
    public function messagelist() {
        return view('Team/messagelist');
    }

    // 消息详情
    public function messageinfo() {
        return view('Team/messageInfo');
    }

    // 发布球队消息（公告）
    public function createmessage() {
        return view('Team/createMessage');
    }

    // 相册列表
    public function album() {
        return view('Team/album');
    }

    // 比赛列表（球队参与的）
    public function competition() {
        return view('Team/competition');
    }

    // 添加活动
    public function createevent() {
        return view('Team/createEvent');
    }

    // 编辑活动&活动录入
    public function eventedit() {
        $event_id = input('event_id', 0);
        // $directentry 1为新增活动并录入活动
        $directentry = 0;
        // 如果有event_id参数即修改活动，没有就新增活动并录入活动（事后录活动）
        if ($event_id === 0) {
            $eventInfo = [
                'id' => 0,
                'send_message' => 0
            ];
            $directentry = 1;
            $memberlist = [];
        } else {
            $teamS = new TeamService();
            $eventInfo = $teamS->getTeamEventInfo(['id' => $event_id]);
            $memberlist = $teamS->teamEventMembers(['event_id' => $event_id]);
            if (!empty($eventInfo['album'])) {
                $eventInfo['album'] = json_decode($eventInfo['album'], true);
            }
        }

        $this->assign('event_id', $event_id);
        $this->assign('eventInfo', $eventInfo);
        $this->assign('directentry', $directentry);
        $this->assign('memberList', $memberlist);
        return view('Team/EventEdit');
    }

    // 活动列表管理
    public function eventlistofteam(){
        return view('Team/eventListOfTeam');
    }

    // 活动列表
    public function eventlist() {
        return view('Team/eventList');
    }

    // 活动详情
    public function eventinfo() {
        // 活动详情数据
        $event_id = input('param.event_id');
        $teamS = new TeamService();
        $eventInfo = $teamS->getTeamEventInfo(['id' => $event_id]);
        if (!empty($eventInfo['album'])) {
            $eventInfo['album'] = json_decode($eventInfo['album'], true);
        }
        // 获取会员在球队角色身份
        $teamrole = $teamS->checkMemberTeamRole($eventInfo['team_id'], $this->memberInfo['id']);
        $memberlist = $teamS->teamEventMembers(['event_id' => $event_id]);

        $this->assign('teamrole', $teamrole);
        $this->assign('eventInfo', $eventInfo);
        $this->assign('memberList', $memberlist);
        return view('Team/eventInfo');
    }

    // 活动报名人员名单
    public function eventsignuplist() {
        return view('Team/eventSignupList');
    }

}