<?php
// 球队service
namespace app\service;

use app\model\Apply;
use app\model\Team;
use app\model\TeamComment;
use app\model\TeamEvent;
use app\model\TeamEventMember;
use app\model\TeamMember;
use app\model\TeamMemberRole;
use app\model\TeamMessage;
use think\Db;

class TeamService
{
    // 我的球队列表（与会员有关联的球队）
    public function myTeamList($map = [], $page = 1, $order = 'id desc', $limit = 10)
    {
        $model = new TeamMember();
        $res = $model->with('team')->where($map)->order($order)->page($page)->limit($limit)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 我的球队列表（带输出在队职位角色）
    public function myTeamWithRole($member_id)
    {
        $model = new TeamMember();
        $map['member_id'] = $member_id;
        $map['status'] = 1;
        $res = $model->with('team')->where($map)->select();
        if ($res) {
            // 遍历获取成员在球队的角色身份
            $teammembers = $res->toArray();
            $roleModel = new TeamMemberRole();
            foreach ($teammembers as $k => $teammember) {
                $teammembers[$k]['role_text'] = '';
                $memberRole = $roleModel->where(['member_id' => $teammember['member_id'], 'team_id' => $teammember['team_id'], 'status' => 1])->select();
                foreach ($memberRole as $val) {
                    $teammembers[$k]['role_text'] .= $val['type_text'] . ',';
                }
            }
            return $teammembers;
        } else {
            return $res;
        }
    }

    // 我的球队列表（与会员有关联的球队）所有数据
    public function myTeamAll($member_id) {
        $model = new TeamMember();
        $map['member_id'] = $member_id;
        $map['status'] = 1;
        $res = $model->with('team')->where($map)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 创建球队
    public function createTeam($data)
    {
        $model = new Team();
        // 验证数据
        $validate = validate('TeamVal');
        if (!$validate->scene('add')->check($data)) {
            return ['code' => 100, 'msg' => $validate->getError()];
        }
        // 保存数据，成功返回自增id，失败记录错误信息
        $res = $model->data($data)->allowField(true)->save();
        if ($res) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'insid' => $model->id];
        } else {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 获取球队详情
    public function getTeam($map)
    {
        $model = new Team();
        $res = $model->where($map)->find();
        if ($res) {
            // 详情数据数组组合需要的元素
            $result = $res->getData();
            $result['status_text'] = $res->status;
            $result['type_text'] = $res->type;
            // 计算球队胜率
            if ($result['match_num'] > 0) {
                $result['match_lose'] = $result['match_num'] - $result['match_win'];
                $winrate = ($result['match_win'] / $result['match_num']) * 100;
                $result['win_rate'] = intval($winrate) . '%';
            } else {
                $result['win_rate'] = 0;
            }
            // 球衣颜色
            if (!empty($result['colors'])) {
                $colors = json_decode($result['colors'], true);
                $result['colors'] = $colors;
            }
            // 球队特点 字符串转数组输出
            $result['charater_arr'] = explode(',', $result['charater']);
            $result['fans_num'] = getfansnum($result['id'], 4);
            return $result;
        } else {
            return $res;
        }
    }

    // 球队列表
    public function getTeamList($map = [], $page = 1, $order = 'id desc', $limit = 10)
    {
        $model = new Team();
        $res = $model->where($map)->order($order)->page($page)->limit($limit)->select();
        if ($res) {
            $result = $res->toArray();
            foreach ($result as $k => $val) {
                $result[$k]['fans_num'] = getfansnum($val['id'], 4);
            }
            return $result;
        } else {
            return $res;
        }
    }

    // 球队列表带分页页码
    public function getTeamListPaginator($map = [], $order = 'id desc', $paginate = 10)
    {
        $model = new Team();
        $res = $model->where($map)->order($order)->paginate($paginate);
        if ($res) {
            $result = $res->toArray();
            foreach ($result['data'] as $k => $val) {
                $result['data'][$k]['fans_num'] = getfansnum($val['id'], 4);
            }
            return $result;
        } else {
            return $res;
        }
    }

    // 修改球队信息
    public function updateTeam($data, $id)
    {
        $model = new Team();
        // 验证数据
        $validate = validate('TeamVal');
        if (!$validate->scene('edit')->check($data)) {
            return ['code' => 100, 'msg' => $validate->getError()];
        }
        // 保存数据，区分是否修改数据。成功返回true，失败记录错误信息
        //$res = $model->allowField(true)->update($data);
        $res = $model->allowField(true)->save($data, ['id' => $id]);
        if ($res || ($res === 0)) {
            return ['code' => 200, 'msg' => __lang('MSG_200')];
        } else {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 自动更新球队字段值
    public function autoUpdateTeam($team_id) {
        // 获取现在球队队员的平均年龄、身高、体重
        $avgMap['team_id'] = $team_id;
        $avgMap['age'] = ['gt', 0];
        $avgMap['height'] = ['gt', 0];
        $avgMap['weight'] = ['gt', 0];
        $avgMap['status'] = ['neq', -1];
        $avg = db('team_member')->where($avgMap)->field('avg(age) avg_age, avg(height) avg_height, avg(weight) avg_weight')->select();

        $memberNumMap['team_id'] = $team_id;
        $memberNumMap['status'] = ['neq', -1];
        $membernum = db('team_member')->where($memberNumMap)->count();
        // 更新team统计字段:队员数，更新平均年龄、身高、体重
        db('team')->where('id', $team_id)
            ->data([
                'avg_age' => $avg[0]['avg_age'],
                'avg_height' => $avg[0]['avg_height'],
                'avg_weight' => $avg[0]['avg_weight'],
                'member_num' => $membernum
            ])
            ->update();
    }

    // 保存team_member球队-会员关系信息
    public function saveTeamMember($data=[], $condition=[])
    {
        $model = new TeamMember();
        // 带更新条件更新数据
        if (!empty($condition)) {
            $res = $model->allowField(true)->save($data, $condition);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
        // 有传入team_member表id 更新数据
        if (isset($data['id'])) {
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
        // 新增数据
        $res = $model->allowField(true)->save($data);
        if ($res) {
            // 球队成员数+1
            //db('team')->where('id', $data['team_id'])->setInc('member_num', 1);

            return ['code' => 200, 'msg' => __lang('MSG_200'), 'insid' => $model->id];
        } else {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 批量保存team_member 数据
    public function saveAllTeamMember($data)
    {
        $model = new TeamMember();
        $query = $model->saveAll($data);
        if ($query || ($query === 0)) {
            return ['code' => 200, 'msg' => __lang('MSG_200')];
        } else {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 移除球队-成员关联（team_member)
    public function delTeamMember($teamMember=[]) {
        $where = [
            'team_id' => $teamMember['team_id'],
            'member_id' => $teamMember['member_id'],
            'member' => $teamMember['member']
        ];
        $data = [
            'status' => -1,
            //'delete_time' => time()
        ];
        // 清理team_mebmer_role
        $modelRole = new TeamMemberRole();
        $delTeamRole = $modelRole->save($data, $where);
        if (false === $delTeamRole) {
            trace('error:' . $modelRole->getError() . ', \n sql:' . $modelRole->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
        // team_member数据更新
        $model = new TeamMember();
        $delTeamMember = $model->save($data, $where);
        if ($delTeamMember || ($delTeamMember === 0)) {
            return ['code' => 200, 'msg' => __lang('MSG_200')];
        } else {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 获取球队成员列表
    public function getTeamMemberList($map = [], $page = 1, $order = 'id asc', $limit = 10)
    {
        $model = new TeamMember();
        $res = $model->with('team')->where($map)->order($order)->page($page)->limit($limit)->select();
        if ($res) {
            // 遍历获取成员在球队的角色身份
            $teammembers = $res->toArray();
            $roleModel = new TeamMemberRole();
            foreach ($teammembers as $k => $teammember) {
                $teammembers[$k]['role_text'] = '';
                $teammembers[$k]['role_arr'] = [];
                $memberRole = $roleModel->where([
                    'member_id' => $teammember['member_id'],
                    'member' => $teammember['member'],
                    'name' => $teammember['name'],
                    'team_id' => $teammember['team_id'],
                    'status' => 1
                ])->order('type desc')->select();
                foreach ($memberRole as $val) {
                    $teammembers[$k]['role_text'] .= $val['type_text'] . ',';
                    array_push($teammembers[$k]['role_arr'], $val['type_text']);
                }
            }
            return $teammembers;
        } else {
            return $res;
        }
    }

    // 获取球队-队员详细
    public function getTeamMemberInfo($map)
    {
        $model = new TeamMember();
        $res = $model->where($map)->find();
        if ($res) {
            $result = $res->toArray();
            $result['status_num'] = $res->getData('status');
            $result['position_num'] = $res->getData('position');
            // 获取成员在球队的角色身份
            $roleModel = new TeamMemberRole();
            $result['role_text'] = '';
            $memberRole = $roleModel->where([
                'member_id' => $result['member_id'],
                'name' => $result['name'],
                'team_id' => $result['team_id'],
                'status' => 1
            ])->select();
            foreach ($memberRole as $val) {
                $result['role_text'] .= $val['type_text'] . ',';
            }
            return $result;
        } else {
            return $res;
        }
    }

    // 获取球队-队员统计数
    public function getTeamMemberCount($map)
    {
        $model = new TeamMember();
        $query = $model->where($map)->count();
        return $query;
    }

    // 插入team_member_role 会员-球队角色关联信息（自由组合内容）
    public function addTeamMemberRole($data) {
        $model = new TeamMemberRole();
        $res = $model->allowField(true)->save($data);
        if ($res) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
        } else {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 保存team_member_role 会员-球队角色关联信息（接收teamEdit页提交的数据)
    public function saveTeamMemberRole($data, $team_id)
    {
        // 提交数据验证
        // "领队"不能为空
        if (empty($data['leader_id'])) {
            return ['code' => 100, 'msg' => '必须填写领队'];
        }
        // "队长"、"副队长"不能同一人
        if ( !empty($data['captain_id']) && !empty($data['vice_captain_id']) ) {
            if ( $data['captain_id'] == $data['vice_captain_id'] && $data['captain'] == $data['vice_captain'] ) {
                return ['code' => 100, 'msg' => '队长，副队长不允许同一人'];
            }
        }
        // 提交数据验证 end

        $model = new TeamMemberRole();
        // 获取team数据
        $teamInfo = $this->getTeam(['id' => $team_id]);
        // 修改数组定义
        $saveAlldata = [];

        // 查询当前"领队"数据（领队一个）
        $roleLeader = $model->where(['team_id' => $team_id, 'member_id' => $data['leader_id'], 'member' => $data['leader'], 'type' => 6])->find();
        if (!$roleLeader) {
            // 直接插入新数据
            array_push($saveAlldata, [
                'type' => 6,
                'team_id' => $team_id,
                'member_id' => $data['leader_id'],
                'member' => $data['leader'],
                'name' => $data['leader'],
                'status' => 1
            ]);
        } else {
            $roleLeader = $roleLeader->toArray();
            // 领队有改变 组合修改数组
            if ($roleLeader['member_id'] != $data['leader_id']) {
                array_push($saveAlldata, [
                    'id' => $roleLeader['id'],
                    'member_id' => $data['leader_id'],
                    'member' => $data['leader'],
                    'name' => $data['leader']
                ]);
            }
        }

        // 提交"经理"为空
        if (empty($data['manager_id'])) {
            // 如原有"经理"数据 则删除数据关系|无数据 不操作
            if ( $teamInfo['manager_id'] && !empty($teamInfo['manager']) ) {
                $roleManager = $model->where(['team_id' => $team_id, 'member_id' => $teamInfo['manager_id'], 'name' => $teamInfo['manager'], 'type' => 5])->find();
                if ($roleManager) {
                    $roleManager = $roleManager->toArray();
                    if ($roleManager['member_id'] != $data['manager_id']) {
                        array_push($saveAlldata, [
                            'id' => $roleLeader['id'],
                            'status' => -1
                        ]);
                    }
                }
            }
        } else {
            // 查询当前"经理"数据
            $roleManager = $model->where(['team_id' => $team_id,'type' => 5])->find();
            if (!$roleManager) {
                // 直接插入新数据
                array_push($saveAlldata, [
                    'type' => 5,
                    'team_id' => $team_id,
                    'member_id' => $data['manager_id'],
                    'member' => $data['manager'],
                    'name' => $data['manager'],
                    'status' => 1
                ]);
            } else {
                $roleManager = $roleManager->toArray();
                // "经理"有改变 组合修改数组
                if ($roleManager['member_id'] != $data['manager_id']) {
                    array_push($saveAlldata, [
                        'id' => $roleLeader['id'],
                        'member_id' => $data['manager_id'],
                        'member' => $data['manager'],
                        'name' => $data['manager']
                    ]);
                }
            }
        }


        // 查询当前"队长"数据（队长一个）
        if (!empty($data['captain'])) {
            $roleCaptain = $model->where(['team_id' => $team_id, 'type' => 3])->find();
            if (!$roleCaptain) {
                // 直接插入新数据
                array_push($saveAlldata, [
                    'type' => 3,
                    'team_id' => $team_id,
                    'member_id' => $data['captain_id'],
                    'member' => $data['captain'],
                    'name' => $data['captain'],
                    'status' => 1
                ]);
            } else {
                $roleCaptain = $roleCaptain->toArray();
                // 队长有改变 组合修改数组
                if ($roleCaptain['name'] != $data['captain']) {
                    array_push($saveAlldata, [
                        'id' => $roleCaptain['id'],
                        'member_id' => $data['captain_id'],
                        'member' => $data['captain'],
                        'name' => $data['captain']
                    ]);
                }
            }
        } else {
            // 清理球队-"队长"数据关系
            $model->where([
                'team_id' => $team_id,
                'type' => 3
            ])->update(['status' => -1]);
        }


        // 查询当前"副队长"数据（队长一个）
        if (!empty($data['vice_captain'])) {
            $roleViceCaptain = $model->where(['team_id' => $team_id, 'type' => 2])->find();
            if (!$roleViceCaptain) {
                // 直接插入新数据
                array_push($saveAlldata, [
                    'type' => 2,
                    'team_id' => $team_id,
                    'member_id' => $data['vice_captain_id'],
                    'member' => $data['vice_captain'],
                    'name' => $data['vice_captain'],
                    'status' => 1
                ]);
            } else {
                $roleViceCaptain = $roleViceCaptain->toArray();
                // 队长有改变 组合修改数组
                if ($roleViceCaptain['name'] != $data['vice_captain']) {
                    array_push($saveAlldata, [
                        'id' => $roleViceCaptain['id'],
                        'member_id' => $data['vice_captain_id'],
                        'member' => $data['vice_captain'],
                        'name' => $data['vice_captain']
                    ]);
                }
            }
        } else {
            // 清理球队-"副队长"数据关系
            $model->where([
                'team_id' => $team_id,
                'type' => 2
            ])->update(['status' => -1]);
        }


        // 处理提交的coach_id
        if (!empty($data['coach_id'])) {
            // 查询当前教练数据member_id集合（教练可多个）
            $roleCoachs = $model->where(['team_id' => $team_id, 'type' => 4, 'status' => 1])->column('member_id');
            // 拆分遍历提交的coach_id是否在当前球队教练数据member_id集合中
            $coach_ids = explode(',', $data['coach_id']);
            $coach_members = explode(',', $data['coach_member']);
            foreach ($coach_ids as $k => $val) {
                // 不在集合中
                if (!in_array($val, $roleCoachs)) {
                    // 有无team_member_role教练数据
                    $hasCoach = $model->where(['team_id' => $team_id, 'type' => 4, 'member_id' => $val, 'name' => $coach_members[$k]])->find();
                    if (!$hasCoach) {
                        // 插入新的team_member_role教练数据
                        array_push($saveAlldata, [
                            'team_id' => $team_id,
                            'member_id' => $val,
                            'member' => $coach_members[$k],
                            'name' => $coach_members[$k],
                            'type' => 4,
                            'status' => 1
                        ]);
                    } else {
                        // 更新新的team_member_role教练数据
                        $coach = $hasCoach->toArray();
                        $status = $hasCoach->getData('status');
                        array_push($saveAlldata, [
                            'id' => $coach['id'],
                            'status' => ($status == 1) ? -1 : 1
                        ]);
                    }
                }
            }
            // 将不在提交的coach_id中 其他的球队教练更新status=-1
            $model->where([
                'team_id' => $team_id,
                'type' => 4,
                'member_id' => ['not in', $coach_ids],
            ])->update(['status' => -1]);
        } else {
            // 清理球队所有教练关系
            $model->where([
                'team_id' => $team_id,
                'type' => 4
            ])->update(['status' => -1]);
        }

        // 处理提交的committee_id
        if (!empty($data['committee_id'])) {
            // 查询当前队委数据member_id集合（可多个）
            $roleCommittees = $model->where(['team_id' => $team_id, 'type' => 1, 'status' => 1])->column('member_id');
            // 拆分遍历提交的committee_id是否在当前球队队委数据member_id集合中
            $committee_ids = explode(',', $data['committee_id']);
            $committee_members = explode(',', $data['committee_member']);
            foreach ($committee_ids as $k1 => $val) {
                // 不在集合中
                if (!in_array($val, $roleCommittees)) {
                    // 有无team_member_role队委数据
                    $hascommittee = $model->where(['team_id' => $team_id, 'type' => 1, 'member_id' => $val, 'name' => $committee_members[$k1]])->find();
                    if (!$hascommittee) {
                        // 插入新的team_member_role队委数据
                        array_push($saveAlldata, [
                            'team_id' => $team_id,
                            'member_id' => $val,
                            'member' => $committee_members[$k1],
                            'name' => $committee_members[$k1],
                            'type' => 1,
                            'status' => 1
                        ]);
                    } else {
                        // 更新新的team_member_role队委数据
                        $committee = $hascommittee->toArray();
                        $status = $hascommittee->getData('status');
                        array_push($saveAlldata, [
                            'id' => $committee['id'],
                            'status' => ($status == 1) ? -1 : 1
                        ]);
                    }
                }
            }
            // 将不在提交的committee_id中 其他的球队队委更新status=-1
            $model->where([
                'team_id' => $team_id,
                'type' => 1,
                'member_id' => ['not in', $committee_ids],
            ])->update(['status' => -1]);
        } else {
            // 清理球队所有后勤-会员关系
            $model->where([
                'team_id' => $team_id,
                'type' => 1,
            ])->update(['status' => -1]);
        }

        if (!empty($saveAlldata)) {
            $res = $model->saveAll($saveAlldata);
            if ($res) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
    }


    // 获取球队有角色身份的会员列表
    public function getTeamRoleMembers($team_id, $order = 'type desc')
    {
        $list = Db::view('team_member')
            ->view('team_member_role',
                'type, status as role_status',
                'team_member_role.member_id=team_member.member_id and team_member_role.team_id=team_member.team_id and team_member_role.name=team_member.name',
                'left')
            ->where([
                'team_member.team_id' => $team_id,
                'team_member.status' => 1,
                'team_member_role.status' => 1
            ])
            ->where('team_member.delete_time', null)
            ->where('team_member_role.delete_time', null)
            ->order($order)
            ->select();
        return $list;
    }

    // 获取会员在球队的最大身份角色
    public function checkMemberTeamRole($team_id, $member_id)
    {
        $model = new TeamMemberRole();
        $res = $model->where(['team_id' => $team_id, 'member_id' => $member_id])
            ->where(['status' => 1])
            ->order('type desc')
            ->value('type');
        return $res ? $res : 0;
    }

    // 查看会员加入球队申请记录
    public function getApplyInfo($map)
    {
        $model = new Apply();
        $res = $model->with('member')->where($map)->find();
        if ($res) {
            $result = $res->toArray();
            $getData = $res->getData();
            $result['status_num'] = $getData['status'];
            return $result;
        } else {
            return $res;
        }
    }

    // 保存加入球队申请数据
    public function saveApply($data)
    {
        $model = new Apply();
        // 如果有带更新条件记录id就更新数据
        if (isset($data['id'])) {
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        } else {
            // 插入一条加入球队申请数据
            $res = $model->allowField(true)->save($data);
            if ($res) {
                return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
    }

    // 创建球队活动
    public function createTeamEvent($data)
    {
        $model = new TeamEvent();
        // 验证数据
        $validate = validate('TeamEventVal');
        if (!$validate->scene('add')->check($data)) {
            return ['code' => 100, 'msg' => $validate->getError()];
        }
        // 保存数据，成功返回自增id，失败记录错误信息
        $res = $model->allowField(true)->data($data)->save();
        if ($res) {
            // 球队活动数统计+1
            $teamModel = new Team();
            $teamModel->where('id', $data['team_id'])->setInc('event_num', 1);
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
        } else {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 修改球队活动
    public function updateTeamEvent($data, $noval = 0)
    {
        $model = new TeamEvent();
        // 传入$noval=1 忽略验证器
        if ($noval === 0) {
            // 验证数据
            $validate = validate('TeamEventVal');
            if (!$validate->scene('edit')->check($data)) {
                return ['code' => 100, 'msg' => $validate->getError()];
            }
        }
        // 保存数据，成功返回，失败记录错误信息
        $res = $model->allowField(true)->isUpdate(true)->save($data);
        if ($res || ($res === 0)) {
            return ['code' => 200, 'msg' => __lang('MSG_200')];
        } else {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 软删除球队活动
    public function deleteTeamEvent($id)
    {
        $res = TeamEvent::destroy($id);
        return $res;
    }

    // 球队活动列表分页
    public function teamEventPaginator($map, $order = 'id desc', $paginate = 10)
    {
        $model = new TeamEvent();
        $res = $model->where($map)->order($order)->paginate($paginate);
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 球队活动列表
    public function teamEventList($map, $page = 1, $order = 'id desc', $limit = 10)
    {
        $model = new TeamEvent();
        $res = $model->where($map)->order($order)->page($page, $limit)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 球队活动列表（无分页)
    public function teamEventListAll($map, $order = 'id desc')
    {
        $model = new TeamEvent();
        $res = $model->where($map)->order($order)->select();
        if ($res) {
            $list = $res->toArray();
            foreach ($list as $k => $val) {
                // 获取原始数据
                $origData = $model::get($val['id'])->getData();
                $list[$k]['start_time_stamp'] = $origData['start_time'];
                $list[$k]['is_finished_num'] = $origData['is_finished'];
            }
            return $list;
        } else {
            return $res;
        }
    }

    // 球队活动详情
    public function getTeamEventInfo($map, $order = '')
    {
        $model = new TeamEvent();
        if ($order) {
            $res = $model->where($map)->order($order)->find();
        } else {
            $res = $model->where($map)->find();
        }
        if ($res) {
            $result = $res->toArray();
            $result['start_time_stamp'] = $res->getData('start_time');
            $result['event_type_num'] = $res->getData('event_type');
            $result['is_max_num'] = $res->getData('is_max');
            $result['is_finished_num'] = $res->getData('is_finished');
            $result['status_num'] = $res->getData('status');
            return $result;
        } else {
            return $res;
        }
    }

    // 获取会员-球队活动关联
    public function getMemberTeamEvent($map)
    {
        $model = new TeamEventMember();
        $res = $model->where($map)->find();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 保存球队活动-会员关联数据
    public function saveTeamEventMember($data, $map = [])
    {
        $model = new TeamEventMember();
        if (!empty($map)) {
            // 更新数据
            $res = $model->allowField(true)->save($data, $map);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        } else {
            // 新增数据
            $res = $model->allowField(true)->save($data);
            if ($res) {
                // 更新球队活动统计字段
                $eventModel = new TeamEvent();
                $event_id = $data['event_id'];
                $eventInfo = $eventModel->get($event_id)->toArray();
                // 活动报名人数+1
                $eventModel->where('id', $event_id)->setInc('reg_number', 1);
                // 活动is_max字段更新
                $nowEventMemberCount = $model->where(['event_id' => $event_id])->count();
                if ($nowEventMemberCount == $eventInfo['max']) {
                    $eventModel->where('id', $event_id)->update(['is_max' => -1]);
                }
                return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
    }

    // 更新球队活动-会员关联数据
    public function saveAllTeamEventMember($data = [])
    {
        //dump($data);die;
        $model = new TeamEventMember();
        $res = $model->saveAll($data);
        if ($res || ($res === 0)) {
            return ['code' => 200, 'msg' => __lang('MSG_200')];
        } else {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 球队活动-会员关联列表分页
    public function teamEventMemberPaginator($map, $order = 'id desc', $paginate = 10)
    {
        $model = new TeamEventMember();
        $res = $model->where($map)->order($order)->paginate($paginate);
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 球队活动-会员关联列表
    public function teamEventMemberList($map, $page = 1, $order = 'id desc', $limit = 10)
    {
        $model = new TeamEventMember();
        $res = $model->where($map)->order($order)->page($page, $limit)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 球队活动-会员关联列表（无分页）
    public function teamEventMembers($map, $order = 'id desc')
    {
        $model = new TeamEventMember();
        $res = $model->where($map)->order($order)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 球队模块评论列表分页
    public function getCommentPaginator($map, $order = 'id desc', $paginate = 10)
    {
        $model = new TeamComment();
        // 只列出有评论文字内容的数据
        $res = $model->where($map)->whereNotNull('comment')->order($order)->paginate($paginate);
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 球队模块评论列表
    public function getCommentList($map, $page = 1, $order = 'id desc', $limit = 10)
    {
        $model = new TeamComment();
        // 只列出有评论文字内容的数据
        $res = $model->where($map)->whereNotNull('comment')->order($order)->page($page, $limit)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 球队模块点赞数统计
    public function getCommentThumbCount($map)
    {
        $model = new TeamComment();
        $map['thumbsup'] = 1;
        $res = $model->where($map)->count();
        return $res;
    }

    // 保存球队模块评论、点赞数据
    public function saveComment($data)
    {
        $model = new TeamComment();
        // 根据传参 有id字段更新数据否则新增数据
        if (isset($data['id'])) {
            // 更新数据
            $res = $model->allowField(true)->save($data, ['id' => $data['id']]);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        } else {
            // 新增数据
            $res = $model->allowField(true)->save($data);
            if ($res) {
                return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
            } else {
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
    }

    // 获取球队模块评论详情
    public function getCommentInfo($map)
    {
        $model = new TeamComment();
        $res = $model->where($map)->find();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 保存球队公告信息
    public function saveTeamMessage($data)
    {
        $model = new TeamMessage();
        $res = $model->allowField(true)->save($data);
        if ($res) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
        } else {
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 球队公告信息列表分页
    public function getTeamMessagePaginator($map, $order = 'id desc', $paginate = 10)
    {
        $model = new TeamMessage();
        $res = $model->where($map)->order($order)->paginate($paginate);
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 球队公告信息列表
    public function getTeamMessageList($map, $page = 1, $order = 'id desc', $limit = 10)
    {
        $model = new TeamMessage();
        $res = $model->where($map)->order($order)->page($page, $limit)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }
}