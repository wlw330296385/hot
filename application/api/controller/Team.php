<?php
// 球队模块 api
namespace app\api\controller;


use app\service\MatchService;
use app\service\MemberService;
use app\service\MessageService;
use app\service\StudentService;
use app\service\TeamService;
use think\Exception;

class Team extends Base
{
    // 创建球队
    public function createteam()
    {
        try {
            // 处理请求参数
            $data = input('param.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['leader_id'] = $this->memberInfo['id'];
            $data['leader'] = $this->memberInfo['member'];
            $data['captain_id'] = $this->memberInfo['id'];
            $data['captain'] = $this->memberInfo['member'];
            // 球队统计字段 初始值
//            $data['avg_age'] = 0;
//            $data['avg_height'] = $this->memberInfo['height'];
//            $data['avg_weight'] = $this->memberInfo['weight'];
            $data['member_num'] = 1;
            //dump($data);
            // 执行创建球队
            $teamS = new TeamService();
            $res = $teamS->createTeam($data);
            // 创建球队成功 保存创建者会员的球队-会员关系team_member
            if ($res['code'] !== 100) {
                $teamMemberData = [
                    'team_id' => $res['insid'],
                    'team' => $data['name'],
                    'member_id' => $this->memberInfo['id'],
                    'member' => $this->memberInfo['member'],
                    'name' => empty($this->memberInfo['realname']) ? $this->memberInfo['member'] : $this->memberInfo['realname'],
                    'telephone' => $this->memberInfo['telephone'],
                    'sex' => $this->memberInfo['sex'],
                    'avatar' => $this->memberInfo['avatar'],
                    'yearsexp' => $this->memberInfo['yearsexp'],
                    'height' => $this->memberInfo['height'],
                    'weight' => $this->memberInfo['weight'],
                    'position' => 0,
                    'status' => 1
                ];
                $saveTeamMemberRes = $teamS->saveTeamMember($teamMemberData);
                if ($saveTeamMemberRes['code'] == 100) {
                    return json($saveTeamMemberRes);
                }

                // 保存创建者会员（领队、队长）在球队角色信息team_member_role
                $team_id = $res['insid'];
                // 领队身份
                $teamMemberRoleData = [
                    'leader_id' => $this->memberInfo['id'],
                    'leader' => $this->memberInfo['member'],
                    'captain_id' => $this->memberInfo['id'],
                    'captain' => $this->memberInfo['member']
                ];
                $saveTeamMemberRoleRes1 = $teamS->setTeamMemberRole($teamMemberRoleData, $team_id);
                if ($saveTeamMemberRoleRes1['code'] != 200) {
                    return json($saveTeamMemberRoleRes1);
                }
            }
            return json($res);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 修改球队
    public function updateteam()
    {
        try {
            // 检测会员登录
            if ($this->memberInfo['id'] === 0) {
                return json(['code' => 100, 'msg' => '请先登录或注册会员']);
            }
            $data = input('post.');
            $team_id = input('post.id');
            $teamS = new TeamService();

            // 更新team_member_role
            $resSaveRole = $teamS->setTeamMemberRole($data, $team_id);
            // 更新team_member_role 失败返回
            if ($resSaveRole['code'] == 100) {
                return json($resSaveRole);
            }

            $result = $teamS->updateTeam($data, $team_id, 1);
            if ($result['code'] == 200) {
                // 更新team_member 球队名
                db('team_member')->where('team_id', $team_id)->update(['team' => $data['name']]);
            }
            return json($result);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队列表有分页页码
    public function teamlistpage()
    {
        try {
            $map = input('post.');
            $page = input('page', 1);
            // 根据访问模块查询球队type：frontend（培训）type=1|keeper（球队）type!=1
            if ( cookie('module') ) {
                $map['type'] = (cookie('module')=='frontend') ? ['eq', 1] : ['neq', 1];
            }
            $teamS = new TeamService();
            $result = $teamS->getTeamListPaginator($map);
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队列表
    public function teamlist()
    {
        try {
            $map = input('param.');
            $page = input('page', 1);

            // 根据访问模块查询球队type：frontend（培训）type=1|keeper（球队）type!=1
            if ( cookie('module') ) {
                $map['type'] = (cookie('module')=='frontend') ? ['eq', 1] : ['neq', 1];
            }

            unset($map['page']);
            $teamS = new TeamService();
            $result = $teamS->getTeamList($map, $page);
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 平台首页-搜索球队列表
    public function searchteamlist()
    {
        try {
            // 整合接收参数 组合查询条件
            $map = input('param.');
            $page = input('page', 1);
            // 默认查询city下所有记录
            if (empty($map['area'])) {
                unset($map['area']);
            }
            // 默认查询所有分类记录
            if (empty($map['type'])) {
                unset($map['type']);
            }
            // 关键字搜索
            $keyword = input('keyword');
            if ( !empty($keyword) ) {
                $map['name'] = ['like', "%$keyword%"];
                unset($map['keyword']);
            }
            // 排除值为null
            if ( $keyword == null ) {
                unset($map['keyword']);   
            }
            
            // 根据访问模块查询球队type：frontend（培训）type!=3
            if ( !input('?param.type') || empty($map['type']) ) {
                if ( cookie('module') =='frontend' ) {
                    $map['type'] = ['not in', [2,3]];
                } elseif (cookie('module') =='keeper') {
                    $map['type'] = 3;
                }
            }
            // 组合查询条件end

            if( input('?page') ) {
                unset($map['page']);
            }
            $teamS = new TeamService();
            $result = $teamS->getTeamList($map, $page);
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 搜索球队列表（有分页页码）
    public function searchteamlistpage()
    {
        try {
            // 整合接收参数 组合查询条件
            $map = input('param.');
            $page = input('page', 1);
            // 默认查询city下所有记录
            if (empty($map['area'])) {
                unset($map['area']);
            }
            // 默认查询所有分类记录
            if (empty($map['type'])) {
                unset($map['type']);
            }
            // 关键字搜索
            $keyword = input('keyword');
            if ( !empty($keyword) ) {
                $map['name'] = ['like', "%$keyword%"];
                unset($map['keyword']);
            }
            // 排除值为null
            if ( $keyword == null ) {
                unset($map['keyword']);
            }

            // 默认访问模块查询球队type：frontend（培训）type!=3
            if ( !input('?param.type') || empty($map['type']) ) {
                if ( cookie('module') =='frontend' ) {
                    $map['type'] = ['not in', [2,3]];
                } elseif (cookie('module') =='keeper') {
                    $map['type'] = 3;
                }
            }
            // 组合查询条件end

            if( input('?page') ) {
                unset($map['page']);
            }
            $teamS = new TeamService();
            $result = $teamS->getTeamListPaginator($map);
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 会员申请加入球队
    public function applyjointeam()
    {
        try {
            // 检测会员登录
            if ($this->memberInfo['id'] === 0) {
                return json(['code' => 100, 'msg' => '请先登录或注册会员']);
            }
            // 检查球队信息是否有传入
            if (!input('?post.team_id')) {
                return json(['code' => 100, 'msg' => __lang('MSG_402') . '请选择球队']);
            }
            // 处理接收参数
            $data = input('post.');
            $teamS = new TeamService();
            $teamInfo = $teamS->getTeam(['id' => $data['team_id']]);
            if (!$teamInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404') . '无此球队信息']);
            }
            //dump($teamInfo);
            // 会员有没在队信息
            $teamMember = $teamS->getTeamMemberInfo([
                'team_id' => $teamInfo['id'],
                'member_id' => $this->memberInfo['id'],
            ]);
            if ($teamMember && $teamMember['status_num'] == 1) {
                return json(['code' => 100, 'msg' => '你已经是球队的成员了，无需再次加入']);
            }
            // 有无申请记录
            $mapApplyinfo = [
                'type' => 1,
                'apply_type' => 1,
                'organization_id' => $teamInfo['id'],
                'member_id' => $this->memberInfo['id']
            ];
            // 插入申请记录
            $dataApply = [
                'member_id' => $this->memberInfo['id'],
                'member' => $this->memberInfo['member'],
                'organization_type' => 2,
                'organization' => $teamInfo['name'],
                'organization_id' => $teamInfo['id'],
                'type' => 1,
                'apply_type' => 1,
                'remarks' => $data['remarks'],
                'status' => 1
            ];
            $hasApply = $teamS->getApplyInfo($mapApplyinfo);
            if ($hasApply) {
//                if ($hasApply['status_num'] == 1) {
//                    return json(['code' => 100, 'msg' => '你已经提交了加入申请，请等待球队处理回复']);
//                } else {
                    $dataApply['id'] = $hasApply['id'];
                //}
            }
            $saveApply = $teamS->saveApply($dataApply);
            $remark = empty($data['remarks']) ? "" : '申请说明：'.$data['remarks'];
            //dump($saveApply);

            if ($saveApply['code'] == 200) {
                // 保存球员未审核(status=0)数据 会员有真实姓名记录真实姓名否则记录会员名
                $teamMemberData = [
                    'team_id' => $teamInfo['id'],
                    'team' => $teamInfo['name'],
                    'member_id' => $this->memberInfo['id'],
                    'member' => $this->memberInfo['member'],
                    'name' => (!empty($this->memberInfo['realname'])) ? $this->memberInfo['realname'] : $this->memberInfo['member'],
                    'telephone' => $this->memberInfo['telephone'],
                    'sex' => $this->memberInfo['sex'],
                    'avatar' => $this->memberInfo['avatar'],
                    'age' => getAgeByBirthday($this->memberInfo['birthday']),
                    'birthday' => $this->memberInfo['birthday'],
                    'yearsexp' => $this->memberInfo['yearsexp'],
                    'height' => $this->memberInfo['height'],
                    'weight' => $this->memberInfo['weight'],
                    'status' => 0
                ];
                if ($teamMember) {
                    $teamMemberData['id'] = $teamMember['id'];
                }
                $teamS->saveTeamMember($teamMemberData);

                $applyId = ($hasApply) ? $hasApply['id'] : $saveApply['data'];
                // 插入message数据
                // 发送加入申请消息给领队
                $messageData = [
                    'title' => '您好，会员' . $dataApply['member'] . '申请加入您的' . $teamInfo['name'] .'球队',
                    'content' => '您好，会员' . $dataApply['member'] . '申请加入您的' . $teamInfo['name'].'球队。'.$remark,
                    'url' => url('keeper/team/teamapplyinfo', ['id' => $applyId, 'team_id' => $teamInfo['id']], '', true),
                    'keyword1' => (!empty($this->memberInfo['realname'])) ? $this->memberInfo['realname'] : $this->memberInfo['member'],
                    'keyword2' => date('Y年m月d日 H:i', time()),
                    'remark' => '点击登录平台查看更多信息，对加入申请作同意或拒绝回复',
                    'steward_type' => 2
                ];
                //dump($messageData);
                $messageS = new MessageService();
                $messageS->sendMessageToMember($teamInfo['leader_id'], $messageData, config('wxTemplateID.successJoin'));
            }
            return json($saveApply);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 回复球队申请加入
    public function applyreply()
    {
        try {
            // 检测会员登录
            if ($this->memberInfo['id'] === 0) {
                return json(['code' => 100, 'msg' => '请先登录或注册会员']);
            }
            // 接收参数 判断正确有无传参
            $apply_id = input('apply_id');
            $status = input('status');
            $reply = input('reply');
            if (!$apply_id || !$status) {
                return json(['code' => 100, 'msg' => __lang('MSG_402') . '，请正确传参']);
            }
            if (!in_array($status, [2, 3])) {
                return json(['code' => 100, 'msg' => __lang('MSG_402') . '，请正确传参']);
            }
            // 查询apply数据
            $teamS = new TeamService();
            $applyInfo = $teamS->getApplyInfo(['id' => $apply_id]);
            if (!$applyInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404') . '，没有此申请记录']);
            }
            if ($applyInfo['status_num'] != 1) {
                return json(['code' => 100, 'msg' => '此申请记录已回复结果，无需重复操作']);
            }
            // 查询team_member_role 判断当前会员有无操作权限
            $checkRole = $teamS->checkMemberTeamRole($applyInfo['organization_id'], $this->memberInfo['id']);
            if (!$checkRole) {
                return json(['code' => 100, 'msg' => __lang('MSG_403') . '，您无法进行此操作']);
            }
            //dump($applyInfo);
            // 更新apply数据，$status=2同意，3拒绝
            $applySaveResult = $teamS->saveApply(['id' => $applyInfo['id'], 'status' => $status, 'reply' => $reply]);
            //dump($applySave);
            $replystr = '已被拒绝';
            // 获取球队信息
            $teamInfo = $teamS->getTeam(['id' => $applyInfo['organization_id']]);
            $url = url('keeper/team/teaminfo', ['team_id' => $teamInfo['id']], '', true);
            if ($status == 2) {
                if ($applySaveResult['code'] == 200) {
                    // 更新team_member
                    $dataTeamMember = [];
                    $teamMemberInfo = $teamS->getTeamMemberInfo(['team_id' => $applyInfo['organization_id'], 'member_id' => $applyInfo['member']['id']]);
                    if ($teamMemberInfo && $teamMemberInfo['status_num'] != 1) {
                        $dataTeamMember['id'] = $teamMemberInfo['id'];
                    }
                    $dataTeamMember['status'] = 1;
                    $teamS->saveTeamMember($dataTeamMember);
                    // 更新球队统计字段
                    $teamS->autoUpdateTeam($applyInfo['organization_id']);

                    // 查询有无关注数据保存关注数据
                    $followDb = db('follow');
                    $follow = $followDb->where(['type' => 4, 'follow_id' => $teamMemberInfo['team_id'], 'member_id' => $teamMemberInfo['member_id']])->find();
                    if ($follow) {
                        if ($follow['status'] != 1) {
                            $followDb->where('id', $follow['id'])->update(['status' => 1, 'update_time' => time()]);
                        }
                    } else {
                        $followDb->insert([
                            'type' => 4, 'follow_id' => $teamMemberInfo['team_id'], 'follow_name' => $teamMemberInfo['team'],
                            'follow_avatar' => ($teamInfo['logo']) ? $teamInfo['logo'] : '',
                            'member_id' => $teamMemberInfo['member_id'], 'member' => $teamMemberInfo['member'], 'member_avatar' => $teamMemberInfo['avatar'],
                            'status' => 1, 'create_time' => time()
                        ]);
                    }
                }
                $replystr = '已通过';
            }
            // 发送消息模板给申请人
            if (!empty($reply)) {
                $reply = '对方回复：'.$reply;
            }
            $messageData = [
                'title' => '您好，申请加入球队'. $applyInfo['organization'] . $replystr,
                'content' => '您好，申请加入球队'. $applyInfo['organization'] . $replystr . $reply,
                'url' => $url,
                'keyword1' => '申请加入球队：' . $applyInfo['organization'],
                'keyword2' => $replystr,
                'remark' => '点击登录平台查看更多信息',
                'steward_type' => 2
            ];
            //dump($messageData);
            $messageS = new MessageService();
            $messageS->sendMessageToMember($applyInfo['member']['id'], $messageData, config('wxTemplateID.applyResult'));
            return json($applySaveResult);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 我的球队列表
    public function myteamlist()
    {
        try {
            $map = input('param.');
            $map['member_id'] = $this->memberInfo['id'];
            $page = input('page', 1);
            $teamS = new TeamService();
            $result = $teamS->myTeamList($map, $page);
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队成员列表
    public function teammemberlist()
    {
        try {
            // 球队id比传
            $team_id = input('param.team_id');
            if (!$team_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402') . ',请选择球队']);
            }
            // 组合传入参数作查询条件
            $map = input('post.');
            $page = input('page', 1);
            if (isset($map['page'])) {
                unset($map['page']);
            }
            $teamS = new TeamService();
            $result = $teamS->getTeamMemberList($map, $page);
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 修改球队成员信息
    public function updateteammember()
    {
        try {
            // 检测会员登录
            if ($this->memberInfo['id'] === 0) {
                return json(['code' => 100, 'msg' => '请先登录或注册会员']);
            }
            $data = input('post.');
            $teamS = new TeamService();
            // 获取球员信息
            $teamMemberInfo = $teamS->getTeamMemberInfo(['id' => $data['id']]);
            if (!$teamMemberInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404').'无此球员信息']);
            }
            // 球衣号码可提交空值，有填入值时检查同队有重复号码的队员 提示号码不能重复
            if (empty($data['number'])) {
                $data['number'] = null;
            } else {
                $numberIsUsedMap = [
                    'id' => ['<>', $data['id']],
                    'team_id' => $data['team_id'],
                    'number' => $data['number'],
                    'status' => 1
                ];
                $numberIsUsed = $teamS->getTeamMemberInfo($numberIsUsedMap);
                if ($numberIsUsed) {
                    return json(['code' => 100, 'msg' => '输入的球衣号码已有同队成员使用了，请输入其他号码']);
                }
            }
            // 更新球员信息
            $res = $teamS->saveTeamMember($data);
            if ($res['code'] == 200) {
                // 改变了name字段 更新team_member_role
                if ($data['name'] != $teamMemberInfo['name']) {
                    db('team_member_role')->where([
                        'team_id' => $teamMemberInfo['team_id'],
                        'member_id' => $teamMemberInfo['member_id'],
                        'member' => $teamMemberInfo['member']
                    ])->update([
                        'name' => $data['name'],
                        'update_time' => time()
                    ]);
                }
                // 更新球队统计字段
                $teamS->autoUpdateTeam($data['team_id']);
            }

            return json($res);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 领队移除球队成员
    public function removeteammember()
    {
        try {
            // 检测会员登录
            if ($this->memberInfo['id'] === 0) {
                return json(['code' => 100, 'msg' => '请先登录或注册会员']);
            }
            // 判断必传参数
            $team_id = input('post.team_id', 0);
            if (!$team_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            $member_id = input('post.member_id');
            // 组合传入参数作查询条件
            $map = input('post.');
            $teamS = new TeamService();
            // 判断是否领队，领队成员才能操作
            $teamrole = $teamS->checkMemberTeamRole($team_id, $this->memberInfo['id']);
            if ($teamrole < 5) {
                return json(['code' => 100, 'msg' => __lang('MSG_403') . '，只有领队或经理成员才能操作']);
            }
            // 领队不能移除自己
            $teamInfo = $teamS->getTeam(['id' => $team_id]);
            if ($teamInfo['leader_id'] == $member_id) {
                return json(['code' => 100, 'msg' => '您是领队不能移除，若要移除请先更换领队']);
            }
            // 查询球队成员数据
            $teammember = $teamS->getTeamMemberInfo($map);
            if (!$teammember) {
                return json(['code' => 100, 'msg' => __lang('MSG_404')]);
            }
            // 成员已离队提示
            if ($teammember['status_num'] != 1) {
                return json(['code' => 100, 'msg' => '该成员已离队']);
            }
            // 删除球队成员数据
            $res = $teamS->delTeamMember($teammember);
            if ($res['code'] == 200) {
                // 更新球队的成员数统计-1
                db('team')->where('id', $team_id)->setDec('member_num', 1);
                // 发送消息通知给离队成员（平台会员）
                if ($member_id > 0) {
                    $messageS = new MessageService();
                    $messageData = [
                        'title' => '您已退出"' . $teammember['team'] . '"球队',
                        'content' => '您已退出"' . $teammember['team'] . '"球队',
                        'url' => url('keeper/message/index', '', '', true),
                        'keyword1' => $teammember['member'],
                        'keyword2' => date('Y年m月d日 H:i'),
                        'remark' => '点击进入查看详细信息',
                        'steward_type' => 2
                    ];
                    $messageS->sendMessageToMember($member_id, $messageData, config('wxTemplateID.memberQuit'));
                }
                // 更新球队统计字段
                $teamS->autoUpdateTeam($team_id);
            }
            // 返回结果
            return json($res);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队成员自己申请离队
    public function applyleaveteam()
    {
        try {
            // 检测会员登录
            if ($this->memberInfo['id'] === 0) {
                return json(['code' => 100, 'msg' => '请先登录或注册会员']);
            }
            // 判断必传参数
            $team_id = input('post.team_id');
            if (!$team_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            $member_id = input('post.member_id');
            // 组合传入参数作查询条件
            $map = input('post.');
            $teamS = new TeamService();
            // 只能成员自己操作
            if ($member_id != $this->memberInfo['id']) {
                return json(['code' => 100, 'msg' => __lang('MSG_403') . '只能球队成员自己操作']);
            }
            // 查询球队成员数据
            $teammember = $teamS->getTeamMemberInfo($map);
            if (!$teammember) {
                return json(['code' => 100, 'msg' => __lang('MSG_404')]);
            }
            // 获取球队信息
            $teamInfo = $teamS->getTeam(['id' => $team_id]);
            // 领队不能自己操作直接离队
            if ($member_id == $teamInfo['leader_id']) {
                return json(['code' => 100, 'msg' => '你是领队，不能离队喔']);
            }
            // 更新球队成员信息 设为离队（status=-1）
            $res = $teamS->delTeamMember($teammember);
            if ($res['code'] == 100) {
                return json($res);
            }

            // 发送消息通知给球队领队
            $messageS = new MessageService();
            $messageData = [
                'title' => '您好，球队成员' . $teammember['member'] . '离开' . $teammember['team'] . '球队',
                'content' => '您好，球队成员' . $teammember['member'] . '离开' . $teammember['team'] . '球队',
                'url' => url('keeper/team/teaminfo', ['team_id' => $teamInfo['id']], '', true),
                'keyword1' => '球队成员离队',
                'keyword2' => $teammember['member'],
                'keyword3' => date('Y年m月d日 H:i'),
                'remark' => '登录平台查看信息',
                'steward_type' => 2
            ];
            $messageS->sendMessageToMember($teamInfo['leader_id'], $messageData, config('wxTemplateID.checkPend'));
            return json($res);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 检查成员是否有球队-成员数据
    public function checkteammember() {
        try {
            // 输入变量
            $post = input('post.');
            // 必传参数
            if (!isset($post['team_id'])) {
                return json(['code' => 100, 'msg' => '请选择球队']);
            }
            if (!isset($post['member_id'])) {
                return json(['code' => 100, 'msg' => '请选择会员']);
            }
            // service
            $teamS = new TeamService();
            $memberS = new MemberService();
            $studentS = new StudentService();
            // 获取球队信息
            $teamInfo = $teamS->getTeam(['id' => $post['team_id']]);
            if (!$teamInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404') . '，请选择其他球队']);
            }
            // 获取会员信息
            $memberInfo = $memberS->getMemberInfo(['id' => $post['member_id']]);
            if (!$memberInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404') . '，请选择其他会员']);
            }
            //
            $teamMemberInfo = [];
            // 训练营球队: 记录学员信息
            if ($teamInfo['type'] == 1 && $teamInfo['camp_id'] > 0) {
                // 必须要student信息
                if (!isset($post['student_id'])) {
                    return json(['code' => 100, 'msg' => '请选择学员']);
                }
                // 获取学员数据
                $studentInfo = $studentS->getStudentInfo(['id' => $post['student_id'], 'member_id' => $post['member_id']]);
                if (!$studentInfo) {
                    return json(['code' => 100, 'msg' => __lang('MSG_404') . '，请选择其他学员']);
                }
                // 学员是否在球队的训练营
                $studentCamps = $studentS->getCamps(['camp_id' => $teamInfo['camp_id'], 'student_id' => $studentInfo['id']]);
                if (!$studentCamps) {
                    return json(['code' => 100, 'msg' => '该学员不在球队所属训练营，请选择其他学员']);
                }

                // 查询学员有无在队信息
                $teamMemberInfo = $teamS->getTeamMemberInfo(['team_id' => $post['team_id'], 'member_id' => $post['member_id'], 'student_id' => $post['student_id']]);
                
            } else {
                // 非训练营球队：查询会员有无在队信息
                $teamMemberInfo = $teamS->getTeamMemberInfo(['team_id' => $post['team_id'], 'member_id' => $post['member_id']]);

            }
            // 返回结果
            if ($teamMemberInfo) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $teamMemberInfo];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_000')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队添加成员（平台会员）
    public function addmember()
    {
        try {
            // 检测会员登录
            if ($this->memberInfo['id'] === 0) {
                return json(['code' => 100, 'msg' => '请先登录或注册会员']);
            }
            // 输入变量
            $post = input('post.');
            // 必传参数
            if (!isset($post['team_id'])) {
                return json(['code' => 100, 'msg' => '请选择球队']);
            }
            if (!isset($post['member_id'])) {
                return json(['code' => 100, 'msg' => '请选择会员']);
            }
            // service
            $teamS = new TeamService();
            $memberS = new MemberService();
            $studentS = new StudentService();
            // 获取球队信息
            $teamInfo = $teamS->getTeam(['id' => $post['team_id']]);
            if (!$teamInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404') . '，请选择其他球队']);
            }
            // 获取会员信息
            $memberInfo = $memberS->getMemberInfo(['id' => $post['member_id']]);
            if (!$memberInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404') . '，请选择其他会员']);
            }

            // 保存球队成员数据
            // 训练营球队: 记录学员信息
            if ($teamInfo['type'] == 1 && $teamInfo['camp_id'] > 0) {
                // 必须要student信息
                if (!isset($post['student_id'])) {
                    return json(['code' => 100, 'msg' => '请选择学员']);
                }
                // 获取学员数据
                $studentInfo = $studentS->getStudentInfo(['id' => $post['student_id'], 'member_id' => $post['member_id']]);
                if (!$studentInfo) {
                    return json(['code' => 100, 'msg' => __lang('MSG_404') . '，请选择其他学员']);
                }
                // 学员是否在球队的训练营
                $studentCamps = $studentS->getCamps(['camp_id' => $teamInfo['camp_id'], 'student_id' => $studentInfo['id']]);
                if (!$studentCamps) {
                    return json(['code' => 100, 'msg' => '该学员不在球队所属训练营，请选择其他学员']);
                }

                // 组合保存数据
                $data = [
                    'team_id' => $teamInfo['id'],
                    'team' => $teamInfo['name'],
                    'name' => $studentInfo['student'], // name是学生名
                    'member_id' => $memberInfo['id'],
                    'member' => $memberInfo['member'],
                    'telephone' => $memberInfo['telephone'],
                    'student_id' => $studentInfo['id'],
                    'student' => $studentInfo['student'],
                    'sex' => $studentInfo['student_sex'],
                    'avatar' => $memberInfo['avatar'],
                    'yearsexp' => $studentInfo['yearsexp'],
                    'birthday' => $studentInfo['student_birthday'],
                    'age' => $studentInfo['age'],
                    'height' => $studentInfo['student_height'],
                    'weight' => $studentInfo['student_weight'],
                    'shoe_size' => $studentInfo['student_shoe_code'],
                    'status' => 1,
                    'number' => null
                ];
                // 查询学员有无在队信息
                $teamMemberInfo = $teamS->getTeamMemberInfo(['team_id' => $post['team_id'], 'member_id' => $post['member_id'], 'student_id' => $post['student_id']]);
                if ($teamMemberInfo) {
                    $data['id'] = $teamMemberInfo['id'];
                }
                // 执行保存球队成员数据
                $resultSaveTeamMember = $teamS->saveTeamMember($data);
                if ($resultSaveTeamMember['code'] == 200) {
                    // 查询有无关注数据保存关注数据
                    $followDb = db('follow');
                    $follow = $followDb->where(['type' => 4, 'follow_id' => $teamInfo['id'], 'member_id' => $memberInfo['id']])->find();
                    if ($follow) {
                        if ($follow['status'] != 1) {
                            $followDb->where('id', $follow['id'])->update(['status' => 1, 'update_time' => time()]);
                        }
                    } else {
                        $followDb->insert([
                            'type' => 4, 'follow_id' => $teamInfo['id'], 'follow_name' => $teamInfo['name'],
                            'follow_avatar' => ($teamInfo['logo']) ? $teamInfo['logo'] : config('default_image.team_logo'),
                            'member_id' => $memberInfo['id'], 'member' => $memberInfo['member'], 'member_avatar' => $memberInfo['avatar'],
                            'status' => 1, 'create_time' => time()
                        ]);
                    }
                }
                // 返回结果
                return json($resultSaveTeamMember);
            } else {
                // 非训练营球队：记录会员信息
                // 组合保存数据
                $data = [
                    'team_id' => $teamInfo['id'],
                    'team' => $teamInfo['name'],
                    'name' => empty($memberInfo['realname']) ? $memberInfo['member'] : $memberInfo['realname'], // name是会员真实名或会员账号
                    'member_id' => $memberInfo['id'],
                    'member' => $memberInfo['member'],
                    'telephone' => $memberInfo['telephone'],
                    'sex' => $memberInfo['sex'],
                    'avatar' => $memberInfo['avatar'],
                    'yearsexp' => $memberInfo['yearsexp'],
                    'birthday' => $memberInfo['birthday'],
                    'age' => $memberInfo['age'],
                    'height' => $memberInfo['height'],
                    'weight' => $memberInfo['weight'],
                    'shoe_size' => $memberInfo['shoe_code'],
                    'status' => -2,
                    'number' => null
                ];
                // 查询会员有无在队信息
                $teamMemberInfo = $teamS->getTeamMemberInfo(['team_id' => $post['team_id'], 'member_id' => $post['member_id']]);
                if ($teamMemberInfo) {
                    $data['id'] = $teamMemberInfo['id'];
                }
                // 执行保存球队成员数据
                $resultSaveTeamMember = $teamS->saveTeamMember($data);
                // 保存成员数据成功
                if ($resultSaveTeamMember['code'] == 200) {
                    // 插入邀请apply 数据
                    $dataApply = [
                        'type' => 2,
                        'apply_type' => 2,
                        'organization_type' => 2,
                        'organization_id' => $teamInfo['id'],
                        'organization' => $teamInfo['name'],
                        'inviter' => $this->memberInfo['member'],
                        'inviter_id' => $this->memberInfo['id'],
                        'member' => $memberInfo['member'],
                        'member_id' => $memberInfo['id'],
                        'remarks' => '球队-'.$teamInfo['name'].'邀请您加入',
                        'status' => 1
                    ];
                    // 检查有无邀请apply记录
                    $hasApplyInfo = $teamS->getApplyInfo([
                        'type' => 2,
                        'apply_type' => 2,
                        'organization_type' => 2,
                        'organization_id' => $teamInfo['id'],
                        'member_id' => $memberInfo['id'],
                    ]);
                    if ($hasApplyInfo) {
                        $dataApply['id'] = $hasApplyInfo['id'];
                    }
                    $resultSaveApply = $teamS->saveApply($dataApply);
                    if ($resultSaveApply['code'] == 100) {
                        return json(['code' => 100, 'msg' => '发送邀请失败']);
                    }
                    //$applyId = ($hasApplyInfo) ? $hasApplyInfo['id'] : $resultSaveApply['data'];
                    $applyId = $resultSaveApply['data'];
                    // 发送邀请通知给会员
                    $messageData = [
                        'title' => '球队-'.$teamInfo['name'].'邀请您加入',
                        'content' => '球队-'.$teamInfo['name'].'邀请您加入',
                        'url' => url('keeper/team/memberapplyinfo', ['id' =>$applyId ], '', true),
                        'keyword1' => '球队邀请',
                        'keyword2' => $this->memberInfo['member'],
                        'keyword3' => date('Y年m月d日 H:i', time()),
                        'remark' => '点击登录平台查看更多信息',
                        'steward_type' => 2
                    ];
                    $messageS = new MessageService();
                    $messageS->sendMessageToMember($memberInfo['id'], $messageData, config('wxTemplateID.checkPend'));
                    // 发送邀请通知给会员 end
                }
                // 返回结果
                return json($resultSaveTeamMember);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 会员回复球队邀请
    public function replyteaminvitation() {
        try {
            // 检测会员登录
            if ($this->memberInfo['id'] === 0) {
                return json(['code' => 100, 'msg' => '请先登录或注册会员']);
            }
            $apply_id = input('apply_id');
            $status = input('status');
            $reply = input('reply');
            if (!$apply_id || !$status) {
                return json(['code' => 100, 'msg' => __lang('MSG_402') . '，请正确传参']);
            }
            if (!in_array($status, [2, 3])) {
                return json(['code' => 100, 'msg' => __lang('MSG_402') . '，请正确传参']);
            }
            // 查询apply数据
            $teamS = new TeamService();
            $applyInfo = $teamS->getApplyInfo(['id' => $apply_id, 'type' => 2, 'apply_type' => 2]);
            if (!$applyInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404') . '，没有此记录']);
            }
            if ($applyInfo['status_num'] != 1) {
                return json(['code' => 100, 'msg' => '此邀请记录已回复结果，无需重复操作']);
            }

            // 是否受邀会员
            if ($this->memberInfo['id'] === 0) {
                return json(['code' => 100, 'msg' => '请先登录或注册平台会员']);
            }
            if ($this->memberInfo['id'] != $applyInfo['member_id']) {
                return json(['code' => 100, 'msg' => '无法操作']);
            }

            // 更新apply数据，$reply=2同意，3拒绝
            $resultSaveApply = $teamS->saveApply(['id' => $applyInfo['id'], 'status' => $status, 'reply' => $reply]);
            $replystr = '拒绝加入';
            $url = url('keeper/message/index', '', '', true);
            if ($status == 2) {
                if ($resultSaveApply['code'] == 200) {
                    // 更新team_member信息status=1
                    $teammember = $teamS->getTeamMemberInfo(['team_id' => $applyInfo['organization_id'], 'member_id' => $applyInfo['member_id']]);
                    if (!$teammember) {
                        return json(['code' => 100, 'msg' => '没有队员信息']);
                    }
                    $updateTeamMember = $teamS->saveTeamMember(['id' => $teammember['id'], 'status' => 1]);
                    if ($updateTeamMember['code'] == 100) {
                        return json(['code' => 100, 'msg' => '更新球队队员信息失败']);
                    }
                    $url = url('keeper/team/teaminfo', ['team_id' => $applyInfo['organization_id']], '', true);
                }
                $replystr = '已加入';
                // 更新球队统计字段
                $teamS->autoUpdateTeam($applyInfo['organization_id']);
            }
            // 发送结果通知给邀请人
            if (!empty($reply)) {
                $reply = '对方回复：'.$reply;
            }
            $messageData = [
                'title' => '会员'. $applyInfo['member']['member'] . $replystr.'球队' . $applyInfo['organization'],
                'content' => '会员'. $applyInfo['member']['member'] . $replystr . '球队' . $applyInfo['organization'] . '。' . $reply,
                'url' => $url,
                'keyword1' => '会员'. $applyInfo['member']['member'] . $replystr . '球队' . $applyInfo['organization'],
                'keyword2' => $replystr,
                'remark' => '点击登录平台查看更多信息',
                'steward_type' => 2
            ];
            //dump($messageData);
            $messageS = new MessageService();
            $messageS->sendMessageToMember($applyInfo['inviter_id'], $messageData, config('wxTemplateID.applyResult'));
            return json($resultSaveApply);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 加入非平台会员进入球队
    public function addnoregmember() {
        try {
            // 检测会员登录
            if ($this->memberInfo['id'] === 0) {
                return json(['code' => 100, 'msg' => '请先登录或注册会员']);
            }
            // 接收输入变量，判断空值
            $data = input('post.');
            if (!isset($data['name']) || !isset($data['telephone'])) {
                return json(['code' => 100, 'msg' => '请填写完整信息']);
            }
            if (!isset($data['team_id'])) {
                return json(['code' => 100, 'msg' => '请选择球队']);
            }
            if (empty($data['name'])) {
                return json(['code' => 100, 'msg' => '请输入姓名']);
            }
            if (empty($data['telephone'])) {
                return json(['code' => 100, 'msg' => '请输入手机号']);
            }

            // 查找手机号有无注册会员
            $memberS = new MemberService();
            $isMember = $memberS->getMemberInfo(['telephone' => $data['telephone']]);
            if ($isMember) {
                return json(['code' => 100, 'msg' => '此手机号已注册会员，是否发出邀请信息', 'data' => $isMember]);
            }

            // 球队有无该成员信息
            $teamS = new TeamService();
            // 查询球队信息
            $teamInfo = $teamS->getTeam(['id' => $data['team_id']]);
            if (!$teamInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404').'请选择其他球队']);
            }
            // 队员号码非空
            if (!empty($data['number'])) {
                // 队员号码同球队内唯一
                $numberQnique = $teamS->getTeamMemberInfo([
                    'team_id' => $teamInfo['id'],
                    'number' => $data['number'],
                    'status' => 1
                ]);
                if ($numberQnique) {
                    return json(['code' => 100, 'msg' => '此球衣号码队内有队员使用了，请选择其他号码']);
                }
            }
            // 手机号码通球队内唯一
            $telephoneQnique = $teamS->getTeamMemberInfo([
                'team_id' => $teamInfo['id'],
                'telephone' => $data['telephone'],
                'status' => 1
            ]);
            if ($telephoneQnique) {
                return json(['code' => 100, 'msg' => '此手机号已注册，请填写其他手机号']);
            }


            // 组合保存team_member数据
            $member = $data['name'];
            $data['team'] = $teamInfo['name'];
            $data['member_id'] = -1;
            $data['member'] = $member;
            $data['avatar'] = config('default_image.member_avatar');
            $data['number'] = !empty($data['number']) ? $data['number'] : null;
            $data['status'] = 1;
            $resSaveTeamMember = $teamS->saveTeamMember($data);

            if ($resSaveTeamMember['code'] == 200) {
                // 处理球队职务
                if ($data['role']) {
                    switch ($data['role']) {
                        case 1 : {
                            // 后勤 保存team_role数据 type=1
                            $teamS->addTeamMemberRole([
                                'team_id' => $teamInfo['id'],
                                'member_id' => -1,
                                'member' => $member,
                                'name' => $member,
                                'type' => 1,
                                'status' => 1
                            ]);
                            break;
                        }
                        case 2 : {
                            // 副队长 保存team_role数据 type=2
                            if ( empty($teamInfo['vice_captain']) ) {
                                $teamS->addTeamMemberRole([
                                    'team_id' => $teamInfo['id'],
                                    'member_id' => -1,
                                    'member' => $member,
                                    'name' => $member,
                                    'type' => 2,
                                    'status' => 1
                                ]);
                                // 更新team表字段
                                $teamS->updateTeam([
                                    'vice_captain' => $member,
                                    'vice_captain_id' => -1
                                ], $teamInfo['id']);
                            } else {
                                // 已有副队长
                                $resSaveTeamMember['msg'] = $resSaveTeamMember['msg'] . '<br>球队已设置副队长，若要更换请前往球队编辑';
                            }
                            break;
                        }
                        case 3 : {
                            // 队长 保存team_role数据 type=3
                            if ( empty($teamInfo['captain']) ) {
                                $teamS->addTeamMemberRole([
                                    'team_id' => $teamInfo['id'],
                                    'member_id' => -1,
                                    'member' => $member,
                                    'name' => $member,
                                    'type' => 3,
                                    'status' => 1
                                ]);
                                // 更新team表字段
                                $teamS->updateTeam([
                                    'captain' => $member,
                                    'captain_id' => -1
                                ], $teamInfo['id']);
                            } else {
                                // 已有队长
                                $resSaveTeamMember['msg'] = $resSaveTeamMember['msg'] . '<br>球队已设置队长，若要更换请前往球队编辑';
                            }
                            break;
                        }
                        case 4 : {
                            // 教练 保存team_role数据 type=4
                            $teamS->addTeamMemberRole([
                                'team_id' => $teamInfo['id'],
                                'member_id' => -1,
                                'member' => $member,
                                'name' => $member,
                                'type' => 4,
                                'status' => 1
                            ]);
                            break;
                        }
                        case 5: {
                            // 经理 保存team_role数据 type=5
                            if ( empty($teamInfo['manager']) ) {
                                $teamS->addTeamMemberRole([
                                    'team_id' => $teamInfo['id'],
                                    'member_id' => -1,
                                    'member' => $member,
                                    'name' => $member,
                                    'type' => 5,
                                    'status' => 1
                                ]);
                                // 更新team表字段
                                $teamS->updateTeam([
                                    'manager' => $member,
                                    'manager_id' => -1
                                ], $teamInfo['id']);
                            } else {
                                // 已有队长
                                $resSaveTeamMember['msg'] = $resSaveTeamMember['msg'] . '<br>球队已设置队长，若要更换请前往球队编辑';
                            }
                            break;
                        }
                    }
                }
            }

            return json($resSaveTeamMember);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 离队成员回到球队中
    public function returnteamember() {
        try {
            // 检测会员登录
            if ($this->memberInfo['id'] === 0) {
                return json(['code' => 100, 'msg' => '请先登录或注册会员']);
            }
            $data = input('post.');
            // 提交参数验证
            if (!isset($data['id'])) {
                // 这id为team_member表id字段
                return json(['code' => 100, 'msg' => __lang('MSG_402') . '，请正确传入id']);
            }
            if (!isset($data['team_id'])) {
                return json(['code' => 100, 'msg' => __lang('MSG_402') . '，请正确传入team_id']);
            }
            $teamS = new TeamService();
            // 查询team_member数据
            $teamMemberInfo = $teamS->getTeamMemberInfo(['id' => $data['id']]);
            if (!$teamMemberInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404') . '，无此球队成员信息']);
            }
            // 获取球队信息
            $teamInfo = $teamS->getTeam(['id' => $data['team_id']]);
            if (!$teamInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404') . '，请选择其他球队']);
            }
            // 区分平台会员/非平台会员业务
            if ($teamMemberInfo['member_id'] > 0 ) {
                // 平台会员： 发送球队邀请
                // 获取会员信息
                $memberS = new MemberService();
                $memberInfo = $memberS->getMemberInfo(['id' => $teamMemberInfo['member_id']]);
                if (!$memberInfo) {
                    return json(['code' => 100, 'msg' => __lang('MSG_404') . '，请选择其他会员']);
                }
                // 更新球队成员信息
                $data = [
                    'id' => $teamMemberInfo['id'],
                    'team_id' => $teamInfo['id'],
                    'team' => $teamInfo['name'],
                    'name' => empty($memberInfo['realname']) ? $memberInfo['member'] : $memberInfo['realname'], // name是会员真实名或会员账号
                    'member_id' => $memberInfo['id'],
                    'member' => $memberInfo['member'],
                    'telephone' => $memberInfo['telephone'],
                    'sex' => $memberInfo['sex'],
                    'avatar' => $memberInfo['avatar'],
                    'yearsexp' => $memberInfo['yearsexp'],
                    'birthday' => $memberInfo['birthday'],
                    'age' => $memberInfo['age'],
                    'height' => $memberInfo['height'],
                    'weight' => $memberInfo['weight'],
                    'shoe_size' => $memberInfo['shoe_code'],
                    'status' => -2,
                    'number' => null
                ];
                // 执行保存球队成员数据
                $resultSaveTeamMember = $teamS->saveTeamMember($data);
                // 保存成员数据成功
                if ($resultSaveTeamMember['code'] == 200) {
                    // 插入邀请apply 数据
                    $dataApply = [
                        'type' => 2,
                        'apply_type' => 2,
                        'organization_type' => 2,
                        'organization_id' => $teamInfo['id'],
                        'organization' => $teamInfo['name'],
                        'inviter' => $this->memberInfo['member'],
                        'inviter_id' => $this->memberInfo['id'],
                        'member' => $memberInfo['member'],
                        'member_id' => $memberInfo['id'],
                        'remarks' => '球队-'.$teamInfo['name'].'邀请您回球队',
                        'status' => 1
                    ];
                    $resultSaveApply = $teamS->saveApply($dataApply);
                    if ($resultSaveApply['code'] == 100) {
                        return json(['code' => 100, 'msg' => '发送邀请失败']);
                    }
                    $applyId = $resultSaveApply['data'];
                    // 发送邀请通知给会员
                    $messageData = [
                        'title' => '球队-'.$teamInfo['name'].'邀请您回球队',
                        'content' => '球队-'.$teamInfo['name'].'邀请您回球队',
                        'url' => url('keeper/team/memberapplyinfo', ['id' =>$applyId ], '', true),
                        'keyword1' => '球队邀请',
                        'keyword2' => $this->memberInfo['member'],
                        'keyword3' => date('Y年m月d日 H:i', time()),
                        'remark' => '点击登录平台查看更多信息',
                        'steward_type' => 2
                    ];
                    $messageS = new MessageService();
                    $messageS->sendMessageToMember($memberInfo['id'], $messageData, config('wxTemplateID.checkPend'));
                }
            } else {
                // 非平台会员：更新team_member status=1
                $data = [
                    'id' => $teamMemberInfo['id'],
                    'status' => 1,
                ];
                // 执行保存球队成员数据
                $resultSaveTeamMember = $teamS->saveTeamMember($data);
            }
            return json($resultSaveTeamMember);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 获取球队最新比赛记录
    public function lastmatch()
    {
        try {
            // 接收请求参数作查询条件
            $map = input('param.');
            // serivce
            $matchS = new MatchService();
            $teamS = new TeamService();
            // 参数:球队team_id 组合复合查询 查询作为主队或客队
            if (input('?param.team_id')) {
                $team_id = input('param.team_id');
                $map['match_record.home_team_id|match_record.away_team_id|match_record.team_id'] = $team_id;
                unset($map['team_id']);
            }
//            else {
//                return json(['code' => 100, 'msg' => __lang('MSG_402') . '请选择球队']);
//            }
            // 参数：会员member_id 查询会员所在球队
            if (input('?param.member_id')) {
                // 获取会员所在球队集合
                $member_id = input('param.member_id');
                if ($member_id > 0) {
                    $memberInTeam = $teamS->myTeamAll($member_id);
                    if ($memberInTeam) {
                        $teamIds = [];
                        foreach ($memberInTeam as $team) {
                            array_push($teamIds, $team['team_id']);
                        }
                        $map['match_record.home_team_id|match_record.away_team_id|match_record.team_id'] = ['in', $teamIds];
                    }
                }
                unset($map['member_id']);
            }

            // 默认查询上架比赛(status=1)
            $map['status'] = input('param.status', 1);
            // 默认查询未完成比赛(is_finished=-1)
            $map['is_finished'] = input('param.is_finished', -1);
            // 查询条件组合end

            $lastMatch = $matchS->matchRecordListAll($map);
            // 如果没有未完成的活动记录，清理查询条件is_finished=-1，再次执行查询
            if (!$lastMatch) {
                unset($map['is_finished']);
                $lastMatch = $matchS->matchRecordListAll($map,'id desc');
                // 球队无比赛记录
                if (!$lastMatch) {
                    return json(['code' => 100, 'msg' => __lang('MSG_000')]);
                }
            }
            // 比赛成员名单+人数统计（列出当前球队）
            // 当前球队成员数
            foreach ($lastMatch as $k => $val) {
                $matchMembers = $matchS->getMatchRecordMemberList(['match_record_id' => $val['id'], 'team_id' => $val['team_id'], 'status' => ['>', 0]]);
                $teamInfo = $teamS->getTeam(['id' => $val['team_id']]);
                $lastMatch[$k]['memberlist'] = $matchMembers;
                $lastMatch[$k]['reg_number'] = count($matchMembers);
                $lastMatch[$k]['max'] = $teamInfo['member_num'];
            }

            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $lastMatch]);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 获取球队最新比赛记录
    public function lastmatchlist()
    {
        try {
            // 接收请求参数作查询条件
            $map = input('param.');
            $page = input('param.page', 1);
            // serivce
            $matchS = new MatchService();
            $teamS = new TeamService();
            // 参数:球队team_id 组合复合查询 查询作为主队或客队
            if (input('?param.team_id')) {
                $team_id = input('param.team_id');
                $map['match_record.home_team_id|match_record.away_team_id|match_record.team_id'] = $team_id;
                unset($map['team_id']);
            }
//            else {
//                return json(['code' => 100, 'msg' => __lang('MSG_402') . '请选择球队']);
//            }
            // 参数：会员member_id 查询会员所在球队
            if (input('?param.member_id')) {
                // 获取会员所在球队集合
                $member_id = input('param.member_id');
                if ($member_id > 0) {
                    $memberInTeam = $teamS->myTeamAll($member_id);
                    if ($memberInTeam) {
                        $teamIds = [];
                        foreach ($memberInTeam as $team) {
                            array_push($teamIds, $team['team_id']);
                        }
                        $map['match_record.home_team_id|match_record.away_team_id|match_record.team_id'] = ['in', $teamIds];
                    }
                }
                unset($map['member_id']);
            }

            // 默认查询上架比赛(status=1)
            $map['status'] = input('param.staus', 1);
            // 默认查询未完成比赛(is_finished=-1)
            $map['is_finished'] = input('param.is_finished', -1);
            // 查询条件组合end

            if (input('?param.page')) {
                unset($map['page']);
            }

            $lastMatch = $matchS->matchRecordList($map, $page);
            // 如果没有未完成的活动记录，清理查询条件is_finished=-1，再次执行查询
            if (!$lastMatch) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
            // 比赛成员名单+人数统计（列出当前球队）
            // 当前球队成员数
            foreach ($lastMatch as $k => $val) {
                $matchMembers = $matchS->getMatchRecordMemberList(['match_record_id' => $val['id'], 'team_id' => $val['team_id'], 'status' => ['>', 0]]);
                $teamInfo = $teamS->getTeam(['id' => $val['team_id']]);
                $lastMatch[$k]['memberlist'] = $matchMembers;
                $lastMatch[$k]['reg_number'] = count($matchMembers);
                $lastMatch[$k]['max'] = $teamInfo['member_num'];
            }

            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $lastMatch]);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 热门球队比赛
    public function hotmatch() {
        try {
            // 接收请求参数作查询条件
            $map = input('param.');
            $page = input('page', 1);
            // 必传参数:球队team_id 组合复合查询 查询作为主队或客队
            if (input('?param.team_id')) {
                $team_id = input('param.team_id');
                $map['match_record.home_team_id|match_record.away_team_id|match_record.team_id'] = $team_id;
                unset($map['team_id']);
            }
            // 默认查询上架比赛(status=1)
            $map['status'] = input('param.staus', 1);
            // 默认查询未完成比赛(is_finished=-1)
            $map['is_finished'] = input('param.is_finished', -1);
            // 默认查询热门比赛(hot=1)
            $map['hot'] = input('param.hot', 1);
            // 查询条件组合end

            if (input('?param.page')) {
                unset($map['page']);
            }

            // serivce
            $matchS = new MatchService();
            $teamS = new TeamService();
            $lastMatch = $matchS->matchRecordList($map, $page);
            // 如果没有未完成的比赛记录，清理查询条件is_finished=-1，再次执行查询
            if (!$lastMatch) {
                unset($map['is_finished']);
                $lastMatch = $matchS->matchRecordList($map, $page, 'id desc');
                // 球队无比赛记录
                if (!$lastMatch) {
                    return json(['code' => 100, 'msg' => __lang('MSG_000')]);
                }
            }
            // 比赛成员名单+人数统计（列出当前球队）
            // 当前球队成员数
            foreach ($lastMatch as $k => $val) {
                $matchMembers = $matchS->getMatchRecordMemberListAll(['match_record_id' => $val['id'], 'team_id' => $val['team_id'], 'status' => ['>', 0]]);
                $teamInfo = $teamS->getTeam(['id' => $val['team_id']]);
                $lastMatch[$k]['memberlist'] = $matchMembers;
                $lastMatch[$k]['reg_number'] = count($matchMembers);
                $lastMatch[$k]['max'] = $teamInfo['member_num'];
            }

            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $lastMatch]);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 获取球队最新活动记录（最新一条未发生的活动记录，若无未发生就列出最新一条活动）
    public function lastevent()
    {
        try {
            $teamS = new TeamService();
            $map = input('param.');
            // 参数：会员member_id 查询会员所在球队
            if (input('?param.member_id')) {
                // 获取会员所在球队集合
                $member_id = input('param.member_id');
                if ($member_id > 0) {
                    $memberInTeam = $teamS->myTeamAll($member_id);
                    if ($memberInTeam) {
                        $teamIds = [];
                        foreach ($memberInTeam as $team) {
                            array_push($teamIds, $team['team_id']);
                        }
                        $map['team_id'] = ['in', $teamIds];
                    }
                }
                unset($map['member_id']);
            }
            // 默认查询上架活动(status=1)
            $map['status'] = input('param.staus', 1);
            // 默认查询未完成活动(is_finished=-1)
            $map['is_finished'] = input('param.is_finished', -1);
            // 查询条件组合end

            $lastEvent = $teamS->teamEventList($map, $page);
            // 如果没有未发生的活动记录，清理查询条件is_finished=0，再次执行查询
            if (!$lastEvent) {
                unset($map['is_finished']);
                $lastEvent = $teamS->teamEventList($map, $page,'id desc');
                // 球队无活动记录
                if (!$lastEvent) {
                    return json(['code' => 100, 'msg' => __lang('MSG_000')]);
                }
            }
            // 球队活动成员名单
            foreach ($lastEvent as $k => $val) {
                $lastEvent[$k]['memberlist'] = $teamS->teamEventMembers(['event_id' => $val['id'], 'status' => ['>', 0]]);
            }
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $lastEvent]);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 获取球队最新活动记录
    public function lasteventlist()
    {
        try {
            $teamS = new TeamService();
            $map = input('param.');
            $page = input('page', 1);
            // 参数：会员member_id 查询会员所在球队
            if (input('?param.member_id')) {
                // 获取会员所在球队集合
                $member_id = input('param.member_id');
                if ($member_id > 0) {
                    $memberInTeam = $teamS->myTeamAll($member_id);
                    if ($memberInTeam) {
                        $teamIds = [];
                        foreach ($memberInTeam as $team) {
                            array_push($teamIds, $team['team_id']);
                        }
                        $map['team_id'] = ['in', $teamIds];
                    }
                }
                unset($map['member_id']);
            }
            // 默认查询上架活动(status=1)
            $map['status'] = input('param.staus', 1);
            // 默认查询未完成活动(is_finished=-1)
            $map['is_finished'] = input('param.is_finished', -1);
            // 查询条件组合end

            if (input('?param.page')) {
                unset($map['page']);
            }

            $lastEvent = $teamS->teamEventList($map, $page);
            // 如果没有未发生的活动记录，清理查询条件is_finished=0，再次执行查询
            if (!$lastEvent) {
                return json(['code' => 100, 'msg' => __lang('MSG_000')]);
            }
            // 球队活动成员名单
            foreach ($lastEvent as $k => $val) {
                $lastEvent[$k]['memberlist'] = $teamS->teamEventMembers(['event_id' => $val['id'], 'status' => ['>', 0]]);
            }
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $lastEvent]);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 热门球队活动
    public function hotevent()
    {
        try {
            $teamS = new TeamService();
            // 最新一条未发生的活动记录，若无未发生就列出最新一条活动
            $map = input('param.');
            $page = input('page', 1);
            // 默认查询上架活动(status=1)
            $map['status'] = input('param.staus', 1);
            // 默认查询未完成活动(is_finished=-1)
            $map['is_finished'] = input('param.is_finished', -1);
            // 默认查询热门活动(hot=1)
            $map['hot'] = input('param.hot', 1);
            // 查询条件组合end

            if (input('?param.page')) {
                unset($map['page']);
            }

            $lastEvent = $teamS->teamEventList($map, $page);
            // 如果没有未发生的活动记录，清理查询条件is_finished=0，再次执行查询
            if (!$lastEvent) {
                unset($map['is_finished']);
                $lastEvent = $teamS->teamEventList($map, $page,'id desc');
                // 球队无活动记录
                if (!$lastEvent) {
                    return json(['code' => 100, 'msg' => __lang('MSG_000')]);
                }
            }
            // 球队活动成员名单
            foreach ($lastEvent as $k => $val) {
                $lastEvent[$k]['memberlist'] = $teamS->teamEventMembers(['event_id' => $val['id'], 'status' => ['>', 0]]);
            }
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $lastEvent]);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 创建球队活动
    public function createteamevent()
    {
        try {
            // 检测会员登录
            if ( $this->memberInfo['id'] === 0) {
                return json(['code' => 100, 'msg' => '请先登录或注册会员']);
            }
            // 接收传参
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            // 时间格式转换类型
            // 检查开始时间和结束时间与当前时间比较是否合法
            $nowTime = time();
            if (input('?start_time')) {
                $data['start_time'] = strtotime(input('start_time'));
                if ($nowTime > $data['start_time']) {
                    return json(['code' => 100, 'msg' => '开始时间必须大于当前时间']);
                }
            }
            if (input('?end_time')) {
                $data['end_time'] = strtotime(input('end_time'));
                if ($nowTime > $data['end_time']) {
                    return json(['code' => 100, 'msg' => '结束时间必须大于当前时间']);
                }
            }
            $teamS = new TeamService();
            $res = $teamS->createTeamEvent($data);
            return json($res);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 修改球队活动
    public function updateteamevent()
    {
        try {
            // 检测会员登录
            if ($this->memberInfo['id'] === 0) {
                return json(['code' => 100, 'msg' => '请先登录或注册会员']);
            }
            // 接收传参
            $request = input('post.');
            $teamS = new TeamService();
            $event_id = $request['id'];
            $team_id = $request['team_id'];
            // 获取球队活动数据
            $event = $teamS->getTeamEventInfo(['id' => $event_id]);
            if (!$event) {
                return json(['code' => 100, 'msg' => __lang('MSG_404')]);
            }
            // 活动人员状态修改值
            $memberStatus = 1;
            // 时间格式转化时间戳
            if (input('?start_time')) {
                $request['start_time'] = strtotime(input('start_time'));
            }
            if (input('?end_time')) {
                $request['end_time'] = strtotime(input('end_time'));
            }
            // 活动完成标识
            if (isset($request['is_finished'])) {
                if ($request['is_finished'] == 1) {
                    $memberStatus = 3;
                }
            }
            // 保存球队活动-会员 保留显示的数据
            if (input('?memberData') && !empty($request['memberData'])) {
                $memberArr = json_decode($request['memberData'], true);
                $request['reg_number'] = count($memberArr);
                foreach ($memberArr as $k => $member) {
                    // 查询有无team_event_member原数据，有则更新原数据否则插入新数据
                    $hasTeamEventMember = $teamS->getMemberTeamEvent(['event_id' => $event_id, 'member_id' => $member['member_id'], 'member' => $member['member']]);
                    if ($hasTeamEventMember) {
                        $memberArr[$k]['id'] = $hasTeamEventMember['id'];
                    } else {
                        // 获取球队成员数据
                        $teamMemberInfo = $teamS->getTeamMemberInfo(['team_id' => $team_id, 'member_id' => $member['member_id'], 'member' => $member['member']]);
                        $memberArr[$k]['event_id'] = $event_id;
                        $memberArr[$k]['event'] = $request['event'];
                        $memberArr[$k]['avatar'] = ($teamMemberInfo) ? $teamMemberInfo['avatar'] : config('default_image.member_avatar');
                    }
                    $memberArr[$k]['status'] = $memberStatus;
                }
                $saveTeamEventMemberResult1 = $teamS->saveAllTeamEventMember($memberArr);
                /*if ($saveTeamEventMemberResult1['code'] == 100) {
                    return json(['code' => 100, 'msg' => '修改活动人员出错']);
                }*/
            }
            // 保存球队活动-会员 被剔除的数据
            if (input('?memberDataDel') && $request['memberDataDel'] != "[]") {
                $memberArr = json_decode($request['memberDataDel'], true);

                foreach ($memberArr as $k => $member) {
                    // 查询有无team_event_member原数据，有则更新原数据否则插入新数据
                    $hasTeamEventMember = $teamS->getMemberTeamEvent(['event_id' => $event_id, 'member_id' => $member['member_id'], 'member' => $member['member']]);
                    if ($hasTeamEventMember) {
                        $memberArr[$k]['id'] = $hasTeamEventMember['id'];
                    }
                    $memberArr[$k]['status'] = -1;
                }
                $saveTeamEventMemberResult2 = $teamS->saveAllTeamEventMember($memberArr);
                /*if ($saveTeamEventMemberResult2['code'] == 100) {
                    return json(['code' => 100, 'msg' => '修改活动人员出错']);
                }*/
            }
            // 修改球队活动主表数据
            $resUpdateTeamEvent = $teamS->updateTeamEvent($request);
            return json($resUpdateTeamEvent);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 直接创建并录入活动
    public function directcreateteamevent()
    {
        try {
            // 接收传参
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            // 活动人员状态修改值
            $memberStatus = 1;
            // 时间格式转化时间戳
            if (input('?start_time')) {
                $data['start_time'] = strtotime(input('start_time'));
            }
            if (input('?end_time')) {
                $data['end_time'] = strtotime(input('end_time'));
            }
            // 活动完成标识
            if (isset($data['is_finished'])) {
                if ($data['is_finished'] == 1) {
                    $memberStatus = 3;
                }
            }
            $teamS = new TeamService();
            $resCreateTeamEvent = $teamS->createTeamEvent($data);
            if ($resCreateTeamEvent['code'] == 200) {
                if (input('?memberData')) {
                    $memberArr = json_decode($data['memberData'], true);
                    foreach ($memberArr as $k => $member) {
                        // 获取球队成员数据
                        $teamMemberInfo = $teamS->getTeamMemberInfo(['team_id' => $data['team_id'], 'member_id' => $member['member_id'], 'member' => $member['member']]);
                        $memberArr[$k]['event_id'] = $resCreateTeamEvent['data'];
                        $memberArr[$k]['event'] = $data['event'];
                        $memberArr[$k]['event'] = $data['event'];
                        $memberArr[$k]['avatar'] = ($teamMemberInfo) ? $teamMemberInfo['avatar'] : config('default_image.member_avatar');
                        $memberArr[$k]['status'] = $memberStatus;
                    }
                    $teamS->saveAllTeamEventMember($memberArr);
                }
            }
            return json($resCreateTeamEvent);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队活动列表（有页码）
    public function teameventlistpage()
    {
        try {
            // 传递参数作为查询条件
            $map = input('param.');
            $page = input('page', 1);
            // 如果有传入年份 查询条件 create_time在区间内
            if (input('?year')) {
                $year = input('year');
                if (is_numeric($year)) {
                    $tInterval = getStartAndEndUnixTimestamp($year);
                    $map['create_time'] = ['between', [$tInterval['start'], $tInterval['end']]];
                }
                unset($map['year']);
            }
            // 活动类型为空 查询所有类型数据
            if (input('?event_type')) {
                $event_type = input('event_type');
                if (empty($event_type)) {
                    unset($map['event_type']);
                }
            }
            // 关键字搜索
            if (input('?keyword')) {
                $keyword = input('keyword');
                if ($keyword == null) {
                    unset($map['keyword']);
                } else {
                    if (!empty($keyword)) {
                        if (!ctype_space($keyword)){
                            $map['event'] = ['like', "%$keyword%"];
                        }
                    }
                }

                unset($map['keyword']);
            }
            if (input('?param.page')) {
                unset($map['page']);
            }
            // 查询条件组合 end
            
            $teamS = new TeamService();
            $result = $teamS->teamEventPaginator($map);
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队活动列表
    public function teameventlist()
    {
        try {
            // 传递参数作为查询条件
            $map = input('param.');
            $page = input('param.page', 1);
            // 如果有传入年份 查询条件 create_time在区间内
            if (input('?year')) {
                $year = input('year');
                if (is_numeric($year)) {
                    $tInterval = getStartAndEndUnixTimestamp($year);
                    $map['create_time'] = ['between', [$tInterval['start'], $tInterval['end']]];
                }
                unset($map['year']);
            }
            // 活动类型为空 查询所有类型数据
            if (input('?event_type')) {
                $event_type = input('event_type');
                if (empty($event_type)) {
                    unset($map['event_type']);
                }
            }
            // 关键字搜索
            if (input('?keyword')) {
                $keyword = input('keyword');
                if ($keyword == null) {
                    unset($map['keyword']);
                } else {
                    if (!empty($keyword)) {
                        if (!ctype_space($keyword)){
                            $map['event'] = ['like', "%$keyword%"];
                        }
                    }
                }

                unset($map['keyword']);
            }
            if (input('?param.page')) {
                unset($map['page']);
            }
            // 查询条件组合 end

            $teamS = new TeamService();
            $result = $teamS->teamEventList($map, $page);
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队活动管理操作
    public function removeevent()
    {
        try {
            // 检测会员登录
            if ($this->memberInfo['id'] === 0) {
                return json(['code' => 100, 'msg' => '请先登录或注册会员']);
            }
            // 接收参数
            $event_id = input('post.eventid');
            $action = input('post.action');
            if (!$event_id || !$action) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            $teamS = new TeamService();
            $event = $teamS->getTeamEventInfo(['id' => $event_id]);
            if (!$event) {
                return json(['code' => 100, 'msg' => __lang('MSG_404') . '，没有球队活动信息']);
            }
            // 检查当前会员有无操作权限
            $role = $teamS->checkMemberTeamRole($event['team_id'], $this->memberInfo['id']);
            if (!$role) {
                return json(['code' => 100, 'msg' => __lang('MSG_403') . '，你在球队只是普通成员不能操作']);
            }
            // 根据活动当前状态(1上架,-1下架)+不允许操作条件
            // 根据action参数 editstatus执行上下架/del删除操作
            // 更新数据 返回结果
            switch ($event['status_num']) {
                case 1 : {
                    if ($action == 'editstatus') {
                        $response = $teamS->updateTeamEvent(['id' => $event['id'], 'status' => -1], 1);
                    } else {
                        $delRes = $teamS->deleteTeamEvent($event['id']);
                        if ($delRes) {
                            // 球队活动数统计-1
                            db('team')->where(['id' => $event['team_id']])->setDec('event_num', 1);
                            $response = ['code' => 200, 'msg' => __lang('MSG_200')];
                        } else {
                            $response = ['code' => 100, 'msg' => __lang('MSG_400')];
                        }
                    }
                    return json($response);
                    break;
                }
                case -1 : {
                    if ($action == 'editstatus') {
                        $response = $teamS->updateTeamEvent(['id' => $event['id'], 'status' => 1], 1);
                    } else {
                        $delRes = $teamS->deleteTeamEvent($event['id']);
                        if ($delRes) {
                            // 球队活动数统计-1
                            db('team')->where(['id' => $event['team_id']])->setDec('event_num', 1);
                            $response = ['code' => 200, 'msg' => __lang('MSG_200')];
                        } else {
                            $response = ['code' => 100, 'msg' => __lang('MSG_400')];
                        }
                    }
                    return json($response);
                    break;
                }
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 报名参加球队活动
    public function jointeamevent()
    {
        try {
            // 检测会员登录
            if ( $this->memberInfo['id'] === 0) {
                return json(['code' => 100, 'msg' => '请先登录或注册会员']);
            }
            // 接收参数
            $event_id = input('post.event_id');
            if (!$event_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402') . '，请选择球队活动']);
            }
            $teamS = new TeamService();
            // 查询球队活动数据，检查活动是否下架、已结束、已满人提示信息
            $event = $teamS->getTeamEventInfo(['id' => $event_id]);
            if (!$event) {
                return json(['code' => 100, 'msg' => __lang('MSG_404') . '，请选择其他球队活动']);
            }
            // 会员是否发布活动的球队成员
            $teammemberinfo = $teamS->getTeamMemberInfo(['team_id' => $event['team_id'], 'member_id' => $this->memberInfo['id']]);
            if (!$teammemberinfo) {
                return json(['code' => 100, 'msg' => '您不是此活动的球队成员，请选择其他球队活动']);
            }
            if ($event['status_num'] === -1) {
                return json(['code' => 100, 'msg' => '此活动已' . $event['status'] . '，请选择其他球队活动']);
            }
            if ($event['is_finished_num'] === 1) {
                return json(['code' => 100, 'msg' => '此活动' . $event['is_finished'] . '，请选择其他球队活动']);
            }
            if ($event['is_max_num'] === -1) {
                return json(['code' => 100, 'msg' => '此活动' . $event['is_max'] . '，请选择其他球队活动']);
            }
            //dump($event);
            // 会员是否已报名活动
            $memberhadjoin = $teamS->getMemberTeamEvent(['event_id' => $event_id, 'member_id' => $this->memberInfo['id']]);
            if ($memberhadjoin) {
                return json(['code' => 100, 'msg' => '您已报名参加此活动，无需再次报名']);
            }
            // 保存报名参加活动记录
            $data = [
                'event_id' => $event['id'],
                'event' => $event['event'],
                'member_id' => $teammemberinfo['member_id'],
                'member' => $teammemberinfo['member'],
                'avatar' => $teammemberinfo['avatar'],
                'contact_tel' => $teammemberinfo['telephone'],
                'student_id' => !empty($teammemberinfo['student_id']) ? teammemberinfo['student_id'] : 0,
                'student' => !empty($teammemberinfo['student']) ? $teammemberinfo['student'] : '',
                'is_pay' => 1,
                'is_sign' => 1,
                'status' => 1,
            ];
            $joineventResult = $teamS->saveTeamEventMember($data);;
            return json($joineventResult);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队活动-会员关联列表（有页码）
    public function teameventmemberlistpage()
    {
        try {
            $map = input('post.');
            $page = input('page', 1);
            $teamS = new TeamService();
            $result = $teamS->teamEventMemberPaginator($map);
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队活动-会员关联列表
    public function teameventmemberlist()
    {
        try {
            $map = input('post.');
            $page = input('page', 1);
            $teamS = new TeamService();
            $result = $teamS->teamEventMemberList($map, $page);
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队活动-会员列表（无分页）
    public function teameventmemberall()
    {
        try {
            $map = input('post.');
            $teamS = new TeamService();
            $map['status'] = ['>', 0];
            $result = $teamS->teamEventMembers($map);
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队模块评论列表
    public function teamcommentlist()
    {
        try {
            // 判断必传参数
            // 评论类型
            $comment_type = input('post.comment_type');
            // 被评论实体id
            $commented_id = input('post.commented_id');
            if (!$comment_type || !$commented_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            // 组合传参作查询条件
            $map = input('post.');
            // 页码参数
            $page = input('page', 1);
            unset($map['page']);
            $teamS = new TeamService();
            // 返回结果
            $result = $teamS->getCommentList($map, $page);
            if ($result) {
                // 返回点赞数
                $thumbupCount = $teamS->getCommentThumbCount($map);
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队模块评论列表（有页码）
    public function teamcommentlistpage()
    {
        try {
            // 判断必传参数
            // 评论类型
            $comment_type = input('post.comment_type');
            // 被评论实体id
            $commented_id = input('post.commented_id');
            if (!$comment_type || !$commented_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            // 组合传参作查询条件
            $page = input('page', 1);
            $map = input('post.');
            $teamS = new TeamService();
            // 返回结果
            $result = $teamS->getCommentPaginator($map);
            if ($result) {
                // 返回点赞数
                $thumbupCount = $teamS->getCommentThumbCount($map);
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result, 'thumbsup_count' => $thumbupCount];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 发布球队模块评论
    public function addteamcomment()
    {
        try {
            // 检测会员登录
            if ( $this->memberInfo['id'] === 0) {
                return json(['code' => 100, 'msg' => '请先登录或注册会员']);
            }
            // 将接收参数作提交数据
            $data = input('post.');
            // 判断必传参数
            // 评论类型
            $comment_type = input('post.comment_type');
            // 被评论实体id
            $commented_id = input('post.commented_id');
            if (!$comment_type || !$commented_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            $teamS = new TeamService();
            // 查询会员有无评论记录
            $map = [
                'comment_type' => $comment_type,
                'commented_id' => $commented_id,
                'member_id' => $this->memberInfo['id'],
            ];
            $hasCommented = $teamS->getCommentInfo($map);
            if ($hasCommented) {
                // 只能发表一次文字评论
                if (!is_null($hasCommented['comment'])) {
                    return json(['code' => 100, 'msg' => '只能发表一次评论']);
                } else {
                    $data['id'] = $hasCommented['id'];
                }
            }
            // 防止有传入thumbup参数 过滤掉
            if (isset($data['thumbup'])) {
                unset($data['thumbup']);
            }
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['member_avatar'] = $this->memberInfo['avatar'];
            // 发表文字评论时间
            $data['comment_time'] = time();
            $res = $teamS->saveComment($data);
            return json($res);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队模块点赞
    public function dianzan()
    {
        try {
            // 检测会员登录
            if ( $this->memberInfo['id'] === 0) {
                return json(['code' => 100, 'msg' => '请先登录或注册会员']);
            }
            // 将接收参数作提交数据
            $data = input('post.');
            // 判断必传参数
            // 评论类型
            $comment_type = input('post.comment_type');
            // 被评论实体id
            $commented_id = input('post.commented_id');
            if (!$comment_type || !$commented_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            $teamS = new TeamService();
            // 查询会员有无评论记录
            $map = [
                'comment_type' => $comment_type,
                'commented_id' => $commented_id,
                'member_id' => $this->memberInfo['id'],
            ];
            $hasCommented = $teamS->getCommentInfo($map);
            // 有评论记录就更新记录的thumbsup字段
            if ($hasCommented) {
                $data['id'] = $hasCommented['id'];
            }
            // 防止有传入comment参数 过滤掉
            if (isset($data['comment'])) {
                unset($data['comment']);
            }
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['member_avatar'] = $this->memberInfo['avatar'];
            $data['thumbsup'] = ($hasCommented && ($hasCommented['thumbsup'] == 1)) ? 0 : 1;
            $result = $teamS->saveComment($data);
            if ($result['code'] == 200) {
                // 返回最新的点赞数统计
                $thumbsupCount = $teamS->getCommentThumbCount([
                    'comment_type' => $comment_type,
                    'commented_id' => $commented_id,
                ]);
                $result['thumbsup_count'] = $thumbsupCount;
            }
            return json($result);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 获取会员在球队模块活动、比赛当前点赞信息
    public function isthumbup()
    {
        try {
            // 判断必传参数
            // 评论类型
            $comment_type = input('post.comment_type');
            // 被评论实体id
            $commented_id = input('post.commented_id');
            if (!$comment_type || !$commented_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            $teamS = new TeamService();
            // 查询会员有无评论记录
            $map = [
                'comment_type' => $comment_type,
                'commented_id' => $commented_id,
                'member_id' => $this->memberInfo['id'],
            ];
            $commentInfo = $teamS->getCommentInfo($map);
            // 点赞字段值
            $thumbsup = ($commentInfo) ? $commentInfo['thumbsup'] : 0;
            // 点赞数统计
            $thumbupCount = $teamS->getCommentThumbCount([
                'comment_type' => $comment_type,
                'commented_id' => $commented_id,
            ]);
            return json(['code' => 200, 'msg' => __lang('MSG_200'), 'thumbsup' => $thumbsup, 'thumbsup_count' => $thumbupCount]);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队公告信息列表分页
    public function teammessagepage()
    {
        try {
            $map = input('param.');
            if (input('?param.page')) {
                unset($map['page']);
            }
            $teamS = new TeamService();
            $result = $teamS->teamEventMemberPaginator($map);
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队公告信息列表
    public function teammessagelist()
    {
        try {
            $map = input('param.');
            $page = input('page', 1);
            if (input('?param.page')) {
                unset($map['page']);
            }
            $teamS = new TeamService();
            $result = $teamS->teamEventMemberList($map, $page);
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }


}