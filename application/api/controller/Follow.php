<?php
namespace app\api\controller;
use app\service\CampService;
use app\service\FollowService;
use app\service\GradeService;
use app\service\MemberService;
use app\service\TeamService;
use think\Exception;

class Follow extends Base {
    // 添加关注/取消关注
    public function focus() {
        try {
            $type = input('param.type');
            if (!$type) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            if ($this->memberInfo['id'] === 0) {
                return json(['code' => 100, 'msg' => '请先登录平台或注册会员']);
            }
            $followData = [];
            switch ($type) {
                case 1: {
                    //关注会员
                    $member_id = input('param.member_id');
                    if (!$member_id) {
                        return json(['code' => 100, 'msg' => '关注会员'.__lang('MSG_402')]);
                    }
                    if ($member_id == $this->memberInfo['id']) {
                        return json(['code' => 100, 'msg' => '自己不能关注自己']);
                    }
                    $memberS = new MemberService();
                    $followMemberInfo = $memberS->getMemberInfo(['id' => $member_id]);
                    if (!$followMemberInfo) {
                        return json(['code' => 100, 'msg' => '没有会员信息']);
                    }

                    $followData = [
                        'type' => $type,
                        'follow_id' => $followMemberInfo['id'],
                        'follow_name' => $followMemberInfo['member'],
                        'follow_avatar' => $followMemberInfo['avatar'],
                        'member_id' => $this->memberInfo['id'],
                        'member' => $this->memberInfo['member'],
                        'member_avatar' => $this->memberInfo['avatar'],
                    ];
                    break;
                }
                case 2: {
                    //关注训练营
                    $camp_id = input('param.camp_id');
                    if (!$camp_id) {
                        return json(['code' => 100, 'msg' => '关注训练营'.__lang('MSG_402')]);
                    }
                    $campS = new CampService();
                    $followCampInfo = $campS->getCampInfo($camp_id);
                    if (!$followCampInfo) {
                        return json(['code' => 100, 'msg' => '没有训练营信息']);
                    }
                    $followData = [
                        'type' => $type,
                        'follow_id' => $followCampInfo['id'],
                        'follow_name' => $followCampInfo['camp'],
                        'follow_avatar' => $followCampInfo['logo'],
                        'member_id' => $this->memberInfo['id'],
                        'member' => $this->memberInfo['member'],
                        'member_avatar' => $this->memberInfo['avatar'],
                        'camp_id' => $followCampInfo['id']
                    ];
                    break;
                }
                case 3: {
                    // 关注班级
                    $grade_id = input('param.grade_id');
                    if (!$grade_id) {
                        return json(['code' => 100, 'msg' => '关注班级'.__lang('MSG_402')]);
                    }
                    $gradeS = new GradeService();
                    $followGradeInfo = $gradeS->getGradeInfo(['id' => $grade_id]);
                    if (!$followGradeInfo) {
                        return json(['code' => 100, 'msg' => '没有班级信息']);
                    }
                    $followData = [
                        'type' => $type,
                        'follow_id' => $followGradeInfo['id'],
                        'follow_name' => $followGradeInfo['grade'],
                        'follow_avatar' => $followGradeInfo['logo'],
                        'member_id' => $this->memberInfo['id'],
                        'member' => $this->memberInfo['member'],
                        'member_avatar' => $this->memberInfo['avatar'],
                        'camp_id' => $followGradeInfo['camp_id']
                    ];
                    break;
                }
                case 4: {
                    // 关注球队
                    $team_id = input('param.team_id');
                    if (!$team_id) {
                        return json(['code' => 100, 'msg' => '关注球队'.__lang('MSG_402')]);
                    }
                    $teamS = new TeamService();
                    $followTeamInfo = $teamS->getTeam(['id' => $team_id]);
                    if (!$followTeamInfo) {
                        return json(['code' => 100, 'msg' => '没有球队信息']);
                    }
                    $followData = [
                        'type' => $type,
                        'follow_id' => $followTeamInfo['id'],
                        'follow_name' => $followTeamInfo['name'],
                        'follow_avatar' => $followTeamInfo['logo'],
                        'member_id' => $this->memberInfo['id'],
                        'member' => $this->memberInfo['member'],
                        'member_avatar' => $this->memberInfo['avatar'],
                    ];
                    break;
                }
            }
            $followS = new FollowService();
            $res = $followS->saveFollow($followData);
            return json($res);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 我（会员）的关注列表
    public function myfollow() {
        try {
            $page = input('param.page', 1);
            $map = input('post.');
            $map['member_id'] = $this->memberInfo['id'];
            $followS = new FollowService();
            $res = $followS->getfollowlist($map);
            if ($res) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $res];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_400')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 粉丝（被关注）的列表
    public function myfans() {
        try {
            $map = input('param.');
            $page = input('param.page', 1);
            $keyword = input('param.keyword');
            if (!isset($map['type'])) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }

            switch ($map['type']) {
                case 1: {
                    $map['follow_id'] = $this->memberInfo['id'];
                    break;
                }
                case 2: {
                    $camp_id = input('param.camp_id');
                    if (!$camp_id) {
                        return json(['code' => 100, 'msg' => '训练营'.__lang('MSG_402')]);
                    }
                    $map['follow_id'] = $camp_id;
                    unset($map['camp_id']);
                    break;
                }
                case 3: {
                    $grade_id = input('param.grade_id');
                    if (!$grade_id) {
                        return json(['code' => 100, 'msg' => '班级'.__lang('MSG_402')]);
                    }
                    $map['follow_id'] = $grade_id;
                    unset($map['grade_id']);
                    break;
                }
                case 4: {
                    $team_id = input('param.team_id');
                    if (!$team_id) {
                        return json(['code' => 100, 'msg' => '球队'.__lang('MSG_402')]);
                    }
                    $map['follow_id'] = $team_id;
                    unset($map['team_id']);
                    break;
                }
            }
            if (input('?param.keyword')) {
                unset($map['keyword']);
                // 关键字内容
                if ($keyword != null) {
                    if (!empty($keyword) || !ctype_space($keyword)) {
                        $map['member'] = ['like', "%$keyword%"];
                    }
                }
            }
            // 关键字null情况处理
            if ($keyword == null) {
                unset($map['keyword']);
            }
            if (isset($map['page'])) {
                unset($map['page']);
            }
            $map['status'] = 1;
            $followS = new FollowService();
            $res = $followS->getfollowlist($map);
            if ($res) {
                // 并入当前会员有无关注实体粉丝的信息
                foreach ($res['data'] as $k => $val) {
                    $hasFollow = $followS->getfollow(['type' => 1,'follow_id' => $val['member_id'], 'member_id' => $this->memberInfo['id'], 'status' => 1]);
                    $res['data'][$k]['follow_status'] = ($hasFollow) ? 1 : 0;
                }

                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $res];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_400')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 获取当前关注状态
    public function getfollow() {
        try {
            // 接收参数 type（1会员|2训练营|3班级|4球队），member_id会员、camp_id训练营、grade_id班级、team_id球队。type必传 没有抛出错误
            $type = input('param.type');
            if (!$type) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            // 根据type 区分follow实体
            // 组合查询条件
            $map = [];
            $map['type'] = $type;
            $map['member_id'] = $this->memberInfo['id'];
            switch ($type) {
                case 1 :{
                    // 会员个人（包括教练）
                    $member_id = input('param.member_id');
                    if (!$member_id) {
                        return json(['code' => 100, 'msg' => '会员'.__lang('MSG_402')]);
                    }
                    if ($member_id == $this->memberInfo['id']) {
                        return json(['code' => 100, 'msg' => '自己不能关注自己']);
                    }
                    $memberS = new MemberService();
                    $followMemberInfo = $memberS->getMemberInfo(['id' => $member_id]);
                    if (!$followMemberInfo) {
                        return json(['code' => 100, 'msg' => '没有会员信息']);
                    }
                    $map['follow_id'] = $member_id;
                    break;
                }
                case 2: {
                    //关注训练营
                    $camp_id = input('param.camp_id');
                    if (!$camp_id) {
                        return json(['code' => 100, 'msg' => '训练营'.__lang('MSG_402')]);
                    }
                    $campS = new CampService();
                    $campInfo = $campS->getCampInfo($camp_id);
                    if (!$campInfo) {
                        return json(['code' => 100, 'msg' => '没有训练营信息']);
                    }

                    $map['follow_id'] = $campInfo['id'];
                    break;
                }
                case 3: {
                    // 关注班级
                    $grade_id = input('param.grade_id');
                    if (!$grade_id) {
                        return json(['code' => 100, 'msg' => '班级'.__lang('MSG_402')]);
                    }
                    $gradeS = new GradeService();
                    $gradeInfo = $gradeS->getGradeInfo(['id' => $grade_id]);
                    if (!$gradeInfo) {
                        return json(['code' => 100, 'msg' => '没有班级信息']);
                    }
                    $map['follow_id'] = $gradeInfo['id'];
                    break;
                }
                case 4: {
                    // 关注球队
                    $team_id = input('param.team_id');
                    if (!$team_id) {
                        return json(['code' => 100, 'msg' => '球队'.__lang('MSG_402')]);
                    }
                    $teamS = new TeamService();
                    $teamInfo = $teamS->getTeam(['id' => $team_id]);
                    if (!$teamInfo) {
                        return json(['code' => 100, 'msg' => '没有球队信息']);
                    }
                    $map['follow_id'] = $teamInfo['id'];
                    break;
                }
            }
            $followS = new FollowService();
            $res = $followS->getfollow($map);
            if ($res) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $res['status']];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }
}