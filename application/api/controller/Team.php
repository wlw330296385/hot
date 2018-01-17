<?php
// 球队模块 api
namespace app\api\controller;


use app\service\MessageService;
use app\service\TeamService;
use think\Exception;

class Team extends Base {
    // 创建球队
    public function createteam() {
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
                    'captain_id' => $this->memberInfo['id']
                ];
                $saveTeamMemberRoleRes1 = $teamS->saveTeamMemberRole($teamMemberRoleData, $team_id);
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
    public function updateteam() {
        try {
            $data = input('post.');
            $team_id = input('post.id');
            $data['member_id'] = $this->memberInfo['id'];
            $teamS = new TeamService();
            //$teamS->saveTeamMemberRole($data, $team_id);
            $result = $teamS->updateTeam($data, $team_id);
            if ($result['code'] == 200) {
                $teamS->saveTeamMemberRole($data, $team_id);
            }
            return json($result);
        }catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队列表有分页页码
    public function teamlistpage() {
        try {
            $map = input('post.');
            $page = input('page', 1);
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
    public function teamlist() {
        try {
            $map = input('param.');
            $page = input('page', 1);
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
    public function searchteamlist() {
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
            if (!empty($map['keyword'])) {
                $keyword = $map['keyword'];
                $map['name'] = ['like', "%$keyword%"];
            }
            unset($map['keyword']);
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

    // 搜索球队列表（有分页页码）
    public function searchteamlistpage() {
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
            if (!empty($map['keyword'])) {
                $keyword = $map['keyword'];
                $map['name'] = ['like', "%$keyword%"];

            }
            unset($map['keyword']);
            unset($map['page']);
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
    public function applyjointeam() {
        try {
            // 检查球队信息是否有传入
            if (!input('?post.team_id')) {
                return json(['code' => 100, 'msg' => __lang('MSG_402').'请选择球队']);
            }
            // 处理接收参数
            $data = input('post.');
            $teamS = new TeamService();
            $teamInfo = $teamS->getTeam(['id' => $data['team_id']]);
            if (!$teamInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404').'无此球队信息']);
            }
            //dump($teamInfo);
            // 会员有没在队信息
            $teamMemberMap = [
                'team_id' => $teamInfo['id'],
                'member_id' => $this->memberInfo['id'],
                'status' => 1
            ];
            $teamMember = $teamS->getTeamMemberInfo($teamMemberMap);
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
                'remarks' => $data['remarks']
            ];
            $hasApply = $teamS->getApplyInfo($mapApplyinfo);
            if ($hasApply) {
                if ($hasApply['status'] == 1) {
                    return json(['code' => 100, 'msg' => '你已经提交了加入申请，请等待球队处理回复']);
                } else {
                    $dataApply['id'] = $hasApply['id'];
                }
            }
            $saveApply = $teamS->saveApply($dataApply);
            //dump($saveApply);
            if ($saveApply['code'] == 200) {
                // 插入message数据
                // 发送加入申请消息给领队
                $messageData = [
                    'title' => '加入球队申请',
                    'content' => '您好，会员'.$dataApply['member'].'申请加入您的'.$teamInfo['name'],
                    'url' => url('frontend/message/index', '', '', true),
                    'keyword1' => (!empty($this->memberInfo['realname'])) ? $this->memberInfo['realname'] : $this->memberInfo['member'],
                    'keyword2' => date('Y年m月d日 H:i', time()),
                    'remark' => '点击登录平台查看更多信息，对加入申请作同意或拒绝回复'
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
    public function applyreply() {
        try {
            // 接收参数 判断正确有无传参
            $apply_id = input('apply_id');
            $reply = input('reply');
            if (!$apply_id && !$reply) {
                return json(['code' => 100, 'msg' => __lang('MSG_402').'，请正确传参']);
            }
            if ( !in_array($reply, [2,3]) ) {
                return json(['code' => 100, 'msg' => __lang('MSG_402').'，请正确传参']);
            }
            // 查询apply数据
            $teamS = new TeamService();
            $applyInfo = $teamS->getApplyInfo(['id' => $apply_id]);
            if (!$applyInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404').'，没有此申请记录']);
            }
            if ($applyInfo['status'] != 1) {
                return json(['code' => 100, 'msg' => '此申请记录已回复结果，无需重复操作']);
            }
            // 查询team_member_role 判断当前会员有无操作权限
            $checkRole = $teamS->checkMemberTeamRole($applyInfo['organization_id'], $this->memberInfo['id']);
            if (!$checkRole) {
                return json(['code' => 100, 'msg' => __lang('MSG_403').'，您无法进行此操作']);
            }
            //dump($applyInfo);
            // 更新apply数据，$reply=2同意，3拒绝
            $applySaveResult = $teamS->saveApply(['id' => $applyInfo['id'], 'status' => $reply]);
            //dump($applySave);
            $replystr = '已拒绝';
            if ($reply == 2) {
                if ($applySaveResult['code'] == 200) {
                    // 保存球队-会员信息，会员有真实姓名记录真实姓名否则记录会员名
                    $dataTeamMember = [
                        'team_id' => $applyInfo['organization_id'],
                        'team' => $applyInfo['organization'],
                        'member_id' => $applyInfo['member']['id'],
                        'member' => (!empty($applyInfo['member']['realname'])) ? $applyInfo['member']['realname'] : $applyInfo['member']['member'],
                        'sex' => $applyInfo['member']['sex'],
                        'avatar' => $applyInfo['member']['avatar'],
                        'age' => getMemberAgeByBirthday($applyInfo['member']['id']),
                        'yearsexp' => $applyInfo['member']['yearsexp'],
                        'height' => $applyInfo['member']['height'],
                        'weight' => $applyInfo['member']['weight'],
                        'status' => 1
                    ];
                    // 查询会员在球队有无原数据记录 有就更新数据/否则插入新数据
                    $teamMemberInfo = $teamS->getTeamMemberInfo(['team_id' => $applyInfo['organization_id'], 'member_id' => $applyInfo['member']['id']]);
                    if ($teamMemberInfo && $teamMemberInfo['status_num'] != 1) {
                        $dataTeamMember['id'] = $teamMemberInfo['id'];
                    }
                    $teamS->saveTeamMember($dataTeamMember);
                    // 获取现在球队队员的平均年龄、身高、体重
                    $avgMap['team_id'] = $applyInfo['organization_id'];
                    $avgMap['age'] = ['gt', 0];
                    $avgMap['height'] = ['gt', 0];
                    $avgMap['weight'] = ['gt', 0];
                    $avg = db('team_member')->where($avgMap)->field('avg(age) avg_age, avg(height) avg_height, avg(weight) avg_weight')->select();
                    // 更新team统计字段:队员数+1，更新平均年龄、身高、体重
                    db('team')->where('id', $applyInfo['organization_id'])
                        ->data([
                            'avg_age' => $avg[0]['avg_age'],
                            'avg_height' => $avg[0]['avg_height'],
                            'avg_weight' => $avg[0]['avg_weight']
                        ])
                        ->inc('member_num', 1)
                        ->update();
                }
                $replystr = '已通过';
            }
            // 发送消息模板给申请人
            $messageData = [
                'title' => '加入球队申请结果通知',
                'content' => '加入球队'. $applyInfo['organization'] .'申请结果通知：'.$replystr,
                'url' => url('frontend/message/index', '', '', true),
                'keyword1' => '加入球队，队名：'.$applyInfo['organization'],
                'keyword2' => $replystr,
                'remark' => '点击登录平台查看更多信息'
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
    public function myteamlist() {
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
    public function teammemberlist() {
        try {
            // 球队id比传
            $team_id = input('param.team_id');
            if (!$team_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402').',请选择球队']);
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
    public function updateteammember() {
        try {
            $data = input('post.');
            $teamS = new TeamService();
            // 球衣号码可提交空值，有填入值时检查同队有重复号码的队员 提示号码不能重复
            if (empty($data['number'])) {
                $data['number'] = null;
            } else {
                $numberIsUsedMap = [
                    'team_id' => $data['team_id'],
                    'number' => $data['number'],
                    'member' => ['<>', $data['member']],
                    'status' => 1
                ];
                $numberIsUsed = $teamS->getTeamMemberInfo($numberIsUsedMap);
                if ($numberIsUsed) {
                    return json(['code' => 100, 'msg' => '输入的球衣号码已有同队成员使用了，请输入其他号码']);
                }
            }
            $res = $teamS->saveTeamMember($data, $data['id']);
            return json($res);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 领队移除球队成员
    public function removeteammember() {
         try {
             // 判断必传参数
             $team_id = input('post.team_id');
             $member_id = input('post.member_id');
             if (!$team_id || !$member_id) {
                 return json(['code' => 100, 'msg' => __lang('MSG_402')]);
             }
             // 组合传入参数作查询条件
             $map = input('post.');
             $teamS = new TeamService();
             // 判断是否领队，领队成员才能操作
             $teamrole = $teamS->checkMemberTeamRole($team_id, $this->memberInfo['id']);
             if ($teamrole != 4) {
                 return json(['code' => 100, 'msg' => __lang('MSG_403').'，只有领队成员才能操作']);
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
             // 更新成员数据
             $res = $teamS->saveTeamMember(['id' => $teammember['id'], 'status' => -1], $teammember['id']);
             if ($res['code'] == 200) {
                 // 更新成员的team_member_role表所有相关数据status=-1
                 db('team_member_role')->where(['team_id' => $team_id, 'member_id' => $member_id])->update(['status' => -1, 'update_time' => time()]);
                 // 更新球队的成员数统计-1
                 db('team')->where('id', $team_id)->setDec('member_num', 1);
                 // 发送消息通知给离队成员
                 $messageS = new MessageService();
                 $messageData = [
                     'title' => '您已退出"'. $teammember['team'] .'"球队',
                     'content' => '您已退出"'. $teammember['team'] .'"球队',
                     'url' => url('frontend/message/index', '', '', true),
                     'keyword1' => $teammember['member'],
                     'keyword2' => date('Y年m月d日 H:i'),
                     'remark' => '点击进入查看详细信息'
                 ];
                 $messageS->sendMessageToMember($member_id, $messageData, config('wxTemplateID.memberQuit'));
             }
             // 返回结果
             return json($res);
         } catch (Exception $e) {
             return json(['code' => 100, 'msg' => $e->getMessage()]);
         }
    }

    // 球队成员自己申请离队
    public function applyleaveteam() {
        try {
            // 判断必传参数
            $team_id = input('post.team_id');
            $member_id = input('post.member_id');
            if (!$team_id || !$member_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            // 组合传入参数作查询条件
            $map = input('post.');
            $teamS = new TeamService();
            // 只能成员自己操作
            if ($member_id != $this->memberInfo['id']) {
                return json(['code' => 100, 'msg' => __lang('MSG_403').'只能球队成员自己操作']);
            }
            // 查询球队成员数据
            $teammember = $teamS->getTeamMemberInfo($map);
            if (!$teammember) {
                return json(['code' => 100, 'msg' => __lang('MSG_404')]);
            }
            // 成员已离队提示
            if ($teammember['status_num'] != 1) {
                return json(['code' => 100, 'msg' => '您已离队']);
            }
            // 发送消息通知给球队领队
            $teamInfo = $teamS->getTeam(['id' => $team_id]);
            $messageS = new MessageService();
            $messageData = [
                'title' => '您好，有球队成员申请离队',
                'content' => '您好，球队成员'.$teammember['member'].'申请离开"'.$teammember['team'].'"球队',
                'url' => url('frontend/message/index', '', '', true),
                'keyword1' => '球队成员申请离队',
                'keyword2' => $teammember['member'],
                'keyword3' => date('Y年m月d日 H:i'),
                'remark' => '请及时处理'
            ];
            $res = $messageS->sendMessageToMember($teamInfo['leader_id'], $messageData, config('wxTemplateID.checkPend'));
            if ($res) {
                $response = ['code' => 200, 'msg' => __lang('MSG_200').'，请等待球队领队审核'];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_400').'，请重试'];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 获取球队最新活动记录
    public function lastevent() {
        try {
            // 球队id比传
            $team_id = input('param.team_id');
            if (!$team_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402').',请选择球队']);
            }
            $teamS = new TeamService();
            // 最新一条未发生的活动记录，若无未发生就列出最新一条活动
            // $lastEventMap = ['team_id' => $this->team_id, 'status' => 1, 'is_finished' => 0];
            $map = input('post.');
            // 默认查询上架活动(status=1)
            if (!isset($map['status'])) {
                $map['status'] = 1;
            }
            // 默认查询未完成活动(is_finished=0)
            if (!isset($map['is_finished'])) {
                $map['is_finished'] = 0;
            }
            $lastEvent = $teamS->teamEventListAll($map);
            // 如果没有未发生的活动记录，清理查询条件is_finished=0，再次执行查询
            if (!$lastEvent) {
                unset($map['is_finished']);
                $lastEvent = $teamS->teamEventListAll($map, 'id desc');
                // 球队无活动记录
                if (!$lastEvent) {
                    return json(['code' => 100, 'msg' => __lang('MSG_000')]);
                }
            }
            // 球队活动成员名单
            foreach ($lastEvent as $k => $val) {
                $lastEvent[$k]['memberlist'] = $teamS->teamEventMembers(['event_id' => $val['id']]);
            }
            return json(['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $lastEvent]);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 创建球队活动
    public function createteamevent() {
        try {
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
    public function updateteamevent() {
        try {
            // 接收传参
            $data = input('post.');
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
            $event_id = $data['id'];
            // 保存球队活动-会员 保留显示的数据
            if ( input('?memberData') && !empty($data['memberData']) ) {
                $memberArr = json_decode($data['memberData'], true);
                $data['reg_number'] = count($memberArr);
                foreach ($memberArr as $k => $member) {
                    // 查询有无team_event_member原数据，有则更新原数据否则插入新数据
                    $hasTeamEventMember = $teamS->getMemberTeamEvent([ 'event_id' => $data['id'], 'member_id' => $member['member_id'] ]);
                    if ($hasTeamEventMember) {
                        $memberArr[$k]['id'] = $hasTeamEventMember['id'];
                    } else {
                        $memberArr[$k]['event_id'] = $event_id;
                        $memberArr[$k]['event'] = $data['event'];
                        $memberArr[$k]['avatar'] = db('member')->where('id', $member['member_id'])->value('avatar');
                    }
                    $memberArr[$k]['status'] = $memberStatus;
                }
                $saveTeamEventMemberResult1 = $teamS->saveAllTeamEventMember($memberArr);
                /*if ($saveTeamEventMemberResult1['code'] == 100) {
                    return json(['code' => 100, 'msg' => '修改活动人员出错']);
                }*/
            }
            // 保存球队活动-会员 被剔除的数据
            if ( input('?memberDataDel') && $data['memberDataDel'] != "[]" ) {
                $memberArr = json_decode($data['memberDataDel'], true);
                
                foreach ($memberArr as $k => $member) {
                    // 查询有无team_event_member原数据，有则更新原数据否则插入新数据
                    $hasTeamEventMember = $teamS->getMemberTeamEvent([ 'event_id' => $event_id, 'member_id' => $member['member_id'] ]);
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
            $resUpdateTeamEvent = $teamS->updateTeamEvent($data);
            return json($resUpdateTeamEvent);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 直接创建并录入活动
    public function directcreateteamevent() {
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
                        $memberArr[$k]['event_id'] = $resCreateTeamEvent['data'];
                        $memberArr[$k]['event'] = $data['event'];
                        $memberArr[$k]['event'] = $data['event'];
                        $memberArr[$k]['avatar'] = db('member')->where('id', $member['member_id'])->value('avatar');
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
    public function teameventlistpage() {
        try {
            // 传递参数作为查询条件
            $map = input('post.');
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
    public function teameventlist() {
        try {
            // 传递参数作为查询条件
            $map = input('post.');
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
    public function removeevent() {
        try {
            // 接收参数
            $event_id = input('post.eventid');
            $action = input('post.action');
            if (!$event_id || !$action) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            $teamS = new TeamService();
            $event = $teamS->getTeamEventInfo(['id' => $event_id]);
            if (!$event) {
                return json(['code' => 100, 'msg' => __lang('MSG_404').'，没有球队活动信息']);
            }
            // 检查当前会员有无操作权限
            $role = $teamS->checkMemberTeamRole($event['team_id'], $this->memberInfo['id']);
            if (!$role) {
                return json(['code' => 100, 'msg' => __lang('MSG_403').'，你在球队只是普通成员不能操作']);
            }
            // 根据活动当前状态(1上架,2下架)+不允许操作条件
            // 根据action参数 editstatus执行上下架/del删除操作
            // 更新数据 返回结果
            switch ( $event['status_num'] ) {
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
    public function jointeamevent() {
        try {
            // 接收参数
            $event_id = input('post.event_id');
            if (!$event_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402').'，请选择球队活动']);
            }
            $teamS = new TeamService();
            // 查询球队活动数据，检查活动是否下架、已结束、已满人提示信息
            $event = $teamS->getTeamEventInfo(['id' => $event_id]);
            if (!$event) {
                return json(['code' => 100, 'msg' => __lang('MSG_404').'，请选择其他球队活动']);
            }
            // 会员是否发布活动的球队成员
            $checkteammember = $teamS->getTeamMemberInfo(['team_id' => $event['team_id'], 'member_id' => $this->memberInfo['id']]);
            if (!$checkteammember) {
                return json(['code' => 100, 'msg' => '您不是此活动的球队成员，请选择其他球队活动']);
            }
            if ($event['status_num'] === 2) {
                return json(['code' => 100, 'msg' => '此活动已'.$event['status'].'，请选择其他球队活动']);
            }
            if ($event['is_finished_num'] === 1) {
                return json(['code' => 100, 'msg' => '此活动'.$event['is_finished'].'，请选择其他球队活动']);
            }
            if ($event['is_max_num'] === -1) {
                return json(['code' => 100, 'msg' => '此活动'.$event['is_max'].'，请选择其他球队活动']);
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
                'member_id' => $this->memberInfo['id'],
                'member' => $this->memberInfo['member'],
                'avatar' => $this->memberInfo['avatar'],
                'contact_tel' => $this->memberInfo['telephone'],
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
    public function teameventmemberlistpage() {
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
    public function teameventmemberlist() {
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
    public function teameventmemberall() {
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
    public function teamcommentlist() {
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
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result, 'thumbup_count' => $thumbupCount];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch(Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队模块评论列表（有页码）
    public function teamcommentlistpage() {
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
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result, 'thumbup_count' => $thumbupCount];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch(Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 发布球队模块评论
    public function addteamcomment() {
        try {
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
        } catch(Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 球队模块点赞
    public function dianzan() {
        try {
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
            $data['thumbsup'] = ($hasCommented && ($hasCommented['thumbsup'] == 1) ) ? 0 : 1;
            $result = $teamS->saveComment($data);
            if ($result['code'] == 200) {
                // 返回最新的点赞数统计
                $thumbupCount = $teamS->getCommentThumbCount([
                    'comment_type' => $comment_type,
                    'commented_id' => $commented_id,
                ]);
                $result['thumbup_count'] = $thumbupCount;
            }
            return json($result);
        } catch(Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 获取会员在球队模块活动、比赛当前点赞信息
    public function isthumbup() {
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
            return json(['code' => 200, 'msg' => __lang('MSG_200'), 'thumbsup' => $thumbsup]);
        } catch(Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }
}