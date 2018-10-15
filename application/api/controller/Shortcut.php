<?php
// 联赛api
namespace app\api\controller;

use app\service\MemberService;
use app\service\MessageService;
use app\model\Match;
use app\model\MatchApply;
use app\model\MatchMember;
use app\model\MatchTeamMember;
use app\model\Member;
use app\model\Team;
use app\model\TeamMember;
use app\model\TeamMemberRole;
use think\Db;
use think\Exception;
use think\Validate;

class Shortcut extends Base
{
    /*
    {
        "league_id" : 31,
        "telephone" : 13513513500,
        "smscode" :  123456,
        "realname" : "肖某",
        "sex" : 1,
        "team": "初二一班队",
        "team_type": 3,
        "team_member_list" : [
            {"realname":"肖某"},
            {"realname":"陈一"},
            {"realname":"周二"},
            {"realname":"李三"}
        ]
    }
    */
    public function leaderApplyLeagueTeam() {
        
        // 验证数据，重复提交
        if (empty(input('league_id')) || empty(input('telephone')) || empty(input('smscode')) || empty(input('realname')) || empty(input('sex')) 
            || empty(trim(input('team'))) || empty(input('team_type')) || empty(input('team_member_list')) ) {
            return json(['code' => 100, 'msg' => __lang('MSG_402')]);
        }

        $now = time();

        $match_id = input('league_id');
        $matchInfo = Match::get($match_id);

        if ( empty($matchInfo) ) {
            return json(['code' => 100, 'msg' => "未找到该联赛"]);
        } else if ( $now > strtotime($matchInfo['reg_end_time']) || $now < strtotime($matchInfo['reg_start_time']) ) {
            return json(['code' => 100, 'msg' => "不在该联赛的报名时间内"]);
        }

        // 短信验证
        $telephone = input('telephone');
        $smscode = input('smscode');
        $smsverify = db('smsverify')->where([ 'phone' => $telephone, 'smscode' => $smscode, 'status' => 0 ])->find();
        if (empty($smsverify)) {
            return json(['code' => 100, 'msg' => '短信验证码无效,请重试' ]);
        }
        if ($now - $smsverify['create_time'] > 300) {
            return json([ 'code' => 100, 'msg' => '短信验证码已过期,请重新获取' ]);
        }

        // 注册账号
        $sessionMemberInfo = session('memberInfo', '', 'think');
        $memberS = new MemberService();

        // 如果有微信授权信息
        if (!empty($memberInfo['openid']) ) {
            $memberInfo = Member::get(['openid' => $sessionMemberInfo['openid']]);
            if ($memberInfo) {
                return json(['code' => 100, 'msg' => '您的微信号已注册成为会员']);
            } else {
                $data['openid'] = $sessionMemberInfo['openid'];
                $data['nickname'] = $sessionMemberInfo['nickname'];
                // 下载微信头像文件到本地
                $data['avatar'] = $memberS->downwxavatar($sessionMemberInfo['avatar']);
            }
        }

        $data['realname'] = input('realname');
        $data['member'] = !empty($sessionMemberInfo['nickname']) ? $sessionMemberInfo['nickname'] : $data['realname'];

        $data['telephone'] = input('telephone');
        $data['sex'] = (input('sex') == 2) ? 2 : 1;

        // 注册送积分;
        $setting = db('setting')->find();
        $json_score = json_decode($setting['score_rule'],true);
        $register_score = $json_score['register'];
        $data['score'] = $register_score;

        // 保存用户
        $response = $memberS->saveMemberInfo($data);
        if ($response['code'] != 200) {
            return json(['code' => 100, 'msg' => $response['msg']]);
        }
        // 保存登录记录
        $result = $memberS->saveLogin($response['id']);

        // 创建球队
        $dataTeam['logo'] = config('default_image.team_logo');
        $dataTeam['member_id'] = $this->memberInfo['id'];
        $dataTeam['member'] = $this->memberInfo['member'];
        $dataTeam['leader_id'] = $this->memberInfo['id'];
        $dataTeam['leader'] = $this->memberInfo['member'];
        $dataTeam['captain_id'] = $this->memberInfo['id'];
        $dataTeam['captain'] = $this->memberInfo['member'];
        $dataTeam['member_num'] = 1;

        // 执行创建球队
        $dataTeam['name'] = trim(input('team'));
        $dataTeam['type'] = input('team_type');
        $teamModel = new Team();
        $teamInfo = Team::get(['name' => $dataTeam['name']]);
        if ($teamInfo) {
            return json(['code' => 100, 'msg' => '球队名重复']);
        }

        $res1 = $teamModel->allowField(true)->isUpdate(false)->save($dataTeam);
        if (empty($res1)) {
            return json(['code' => 100, 'msg' => '创建球队失败']);
        }

        // 短信验证更新
        db('smsverify')->where(['id' => $smsverify['id']])->setField('status', 1);

        // 创建球队成功 保存创建者会员的球队-会员关系team_member
        $finalTeamMemberArray = [];
        $myTeamMemberInfo = [
            'team_id' => $teamModel->id,
            'team' => $teamModel->name,
            'member_id' => $this->memberInfo['id'],
            'member' => $this->memberInfo['member'],
            'name' => empty($this->memberInfo['realname']) ? $this->memberInfo['member'] : $this->memberInfo['realname'],
            'telephone' => $this->memberInfo['telephone'],
            'position' => 0,
            'status' => 1,
            'create_time' => $now,
            'update_time' => $now
        ];
        array_push($finalTeamMemberArray, $myTeamMemberInfo);

        $team_member_list = json_decode(input('team_member_list'), true);
        foreach ($team_member_list as $row) {
            if (!empty($row['realname']) && $row['realname'] != $this->memberInfo['realname']) {
                $temp = [
                    'team_id' => $teamModel->id,
                    'team' => $teamModel->name,
                    'name' => $row['realname'],
                    'member_id' => -1,
                    'member' => $row['realname'],
                    'telephone' => '',
                    'position' => 0,
                    'status' => 1,
                    'create_time' => $now,
                    'update_time' => $now
                ];
                array_push($finalTeamMemberArray, $temp);
            }
        }

        $teamMemberModel = new TeamMember();
        $res2 = $teamMemberModel->allowField(true)->insertAll($finalTeamMemberArray);;
        if (empty($res2)) {
            return json(['code' => 100, 'msg' => '创建球队队员失败']);
        }

        // 保存创建者会员（领队、队长）在球队角色信息team_member_role
        $myTeamMemberRole1 = $myTeamMemberRole2 =[
            'team_id' => $teamModel->id,
            'member_id' => $this->memberInfo['id'],
            'member' => $this->memberInfo['member'],
            'name' => empty($this->memberInfo['realname']) ? $this->memberInfo['member'] : $this->memberInfo['realname'],
            'create_time' => $now,
            'update_time' => $now
        ];
        $myTeamMemberRole1['type'] = 6;
        $myTeamMemberRole2['type'] = 3;
        $finalTeamMemberRoleArray = [$myTeamMemberRole1, $myTeamMemberRole2];

        $teamMemberRoleModel = new TeamMemberRole();
        $res3 = $teamMemberRoleModel->allowField(true)->insertAll($finalTeamMemberRoleArray);
        if (empty($res3)) {
            return json(['code' => 100, 'msg' => '设置球队队长失败']);
        }

        // 报名联赛

        // 检查球队有无申请报名联赛数据
        $matchApplyModel = new MatchApply();
        $matchApplyInfo = $matchApplyModel->get([
            'match_id' => $match_id,
            'team_id' => $teamModel->id
        ]);
        // 有申请联赛数据并已同意 提示已报名
        if ($matchApplyInfo) {
            return json(['code' => 100, 'msg' => '您的球队已经报名联赛，无须再次操作']);
        }
        // 保存球队-联赛报名申请数据
        $dataMatchApply = [
            'match_id' => $matchInfo['id'],
            'match' => $matchInfo['name'],
            'is_league' => 1,
            'team_id' => $teamModel->id,
            'team' => $teamModel->name,
            'telephone' => $this->memberInfo['telephone'],
            'contact' => empty($this->memberInfo['realname']) ? $this->memberInfo['member'] : $this->memberInfo['realname'],
            'member_id' => $this->memberInfo['id'],
            'member' => $this->memberInfo['member'],
            'member_avatar' => $this->memberInfo['avatar'],
            'status' => 1
        ];

        $res4 = $matchApplyModel->allowField(true)->isUpdate(false)->save($dataMatchApply);
        if (empty($res4)) {
            return json(['code' => 100, 'msg' => '报名联赛失败']);
        }

        $finalMatchTeamMemberArray = [];
        $list = TeamMember::all(['team_id' => $teamModel->id]);
        foreach ($list as $row) {
            $temp = [
                'match_team_id' => 0,
                'match_apply_id' => $matchApplyModel->id,
                'match_id' => $matchInfo['id'],
                'match' => $matchInfo['name'],
                'team_id' => $teamModel->id,
                'team' => $teamModel->name,
                'team_logo' => $teamModel->logo,
                'team_member_id' => $row['id'],
                'member_id' => $row['member_id'],
                'member' => $row['member'],
                'name' => $row['name'],
                'avatar' => $row['avatar'],
                'position' => 0,
                'status' => 1,
                'create_time' => $now,
                'update_time' => $now
            ];
            array_push($finalMatchTeamMemberArray, $temp);
        }

        $matchTeamMemberModel = new MatchTeamMember();
        $res5 = $matchTeamMemberModel->allowField(true)->insertAll($finalMatchTeamMemberArray);;
        if (empty($res5)) {
            return json(['code' => 100, 'msg' => '联赛队员报名失败']);
        }

        // 发送消息通知给联赛组织管理员
        // 获取联赛组织人员列表
        $matchMemberModel = new MatchMember();
        $matchMemberList = $matchMemberModel->all(['match_id' => $matchInfo['id'], 'type' => ['>=', 9]]);
        $memberIds = [];
        if (!empty($matchMemberList)) {
            foreach ($matchMemberList as $k => $val) {
                $memberIds[$k]['id'] = $val['member_id'];
            }
        }
        $message = [
            'title' => '您好，球队' . $teamModel->name . '申请报名联赛' . $matchInfo['name'],
            'content' => '您好，球队' . $teamModel->name . '申请报名联赛' . $matchInfo['name'],
            'url' => url('keeper/match/teamlistofleague', ['league_id' => $matchInfo['id']], '', true),
            'keyword1' => '球队报名参加联赛',
            'keyword2' => $data['realname'],
            'keyword3' => date('Y-m-d H:i', time()),
            'remark' => '点击进入查看更多',
            'steward_type' => 2
        ];
        $messageS = new MessageService();
        $res6 = $messageS->sendMessageToMembers($memberIds, $message, config('wxTemplateID.checkPend'));

        return json(['code' => 200, 'msg' => __lang('MSG_200')]);
    }
}