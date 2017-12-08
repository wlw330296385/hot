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
            $data['avg_age'] = 0;
            $data['avg_height'] = $this->memberInfo['height'];
            $data['avg_weight'] = $this->memberInfo['weight'];
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
                    'member_sex' => $this->memberInfo['sex'],
                    'member_avatar' => $this->memberInfo['avatar'],
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

                // 保存创建者会员在球队角色信息team_member_role
                // 领队身份
                $teamMemberRoleData1 = [
                    'team_id' => $res['insid'],
                    'member_id' => $this->memberInfo['id'],
                    'type' => 4,
                    'status' => 1
                ];
                // 队长身份
                $teamMemberRoleData2 = [
                    'team_id' => $res['insid'],
                    'member_id' => $this->memberInfo['id'],
                    'type' => 3,
                    'status' => 1
                ];
                $saveTeamMemberRoleRes1 = $teamS->saveTeamMemberRole($teamMemberRoleData1);
                $saveTeamMemberRoleRes2 = $teamS->saveTeamMemberRole($teamMemberRoleData2);
                if ($saveTeamMemberRoleRes1['code'] == 100 || $saveTeamMemberRoleRes2['code'] ==100) {
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
            $result = $teamS->updateTeam($data, $team_id);
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
            if ($teamMember) {
                return json(['code' => 100, 'msg' => '你已经是球队的成员了，无需再次加入']);
            }
            // 有无申请记录
            $mapApplyinfo = [
                'type' => 1,
                'apply_type' => 1,
                'organization_id' => $teamInfo['id'],
                'member_id' => $this->memberInfo['id']
            ];
            $hasApply = $teamS->getApplyInfo($mapApplyinfo);
            if ($hasApply) {
                return json(['code' => 100, 'msg' => '你已经提交了加入申请，请等待球队处理回复']);
            }
            // 插入申请记录
            $dataApply = [
                'member_id' => $this->memberInfo['id'],
                'member' => $this->memberInfo['member'],
                'organization_type' => 2,
                'organization' => $teamInfo['name'],
                'organization_id' => $teamInfo['id'],
                'type' => 1,
                'apply_type' => 1,
                'remarks' => input('post.remarks')
            ];
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

    // 球队查看申请加入列表
    public function applylist() {

    }

    // 我的球队列表
    public function myteamlist() {
        try {
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
            $team_id = input('param.team_id');
            if (!$team_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402').',请选择球队']);
            }
            $page = input('page', 1);
            $teamS = new TeamService();
            $map['team_id'] = $team_id;
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

}