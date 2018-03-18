<?php
// 球队service
namespace app\service;
<<<<<<< HEAD
=======

>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
use app\model\Apply;
use app\model\Team;
use app\model\TeamComment;
use app\model\TeamEvent;
use app\model\TeamEventMember;
use app\model\TeamMember;
use app\model\TeamMemberRole;
<<<<<<< HEAD
use think\Db;

class TeamService {
    // 我的球队列表（与会员有关联的球队）
    public function myTeamList($map=[], $page=1, $order='id desc', $limit=10) {
=======
use app\model\TeamMessage;
use think\Db;

class TeamService
{
    // 我的球队列表（与会员有关联的球队）
    public function myTeamList($map = [], $page = 1, $order = 'id desc', $limit = 10)
    {
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        $model = new TeamMember();
        $res = $model->with('team')->where($map)->order($order)->page($page)->limit($limit)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 我的球队列表（带输出在队职位角色）
<<<<<<< HEAD
    public function myTeamWithRole($member_id) {
=======
    public function myTeamWithRole($member_id)
    {
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
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
<<<<<<< HEAD
                $memberRole = $roleModel->where(['member_id' => $teammember['member_id'], 'team_id' => $teammember['team_id'], 'status' => 1])->select()->toArray();
                foreach ($memberRole as $val) {
                    $teammembers[$k]['role_text'] .= $val['type'].',';
=======
                $memberRole = $roleModel->where(['member_id' => $teammember['member_id'], 'team_id' => $teammember['team_id'], 'status' => 1])->select();
                foreach ($memberRole as $val) {
                    $teammembers[$k]['role_text'] .= $val['type_text'] . ',';
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
                }
            }
            return $teammembers;
        } else {
            return $res;
        }
    }

<<<<<<< HEAD
    // 创建球队
    public function createTeam($data) {
=======
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
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        $model = new Team();
        // 验证数据
        $validate = validate('TeamVal');
        if (!$validate->scene('add')->check($data)) {
<<<<<<< HEAD
           return ['code' => 100, 'msg' => $validate->getError()];
=======
            return ['code' => 100, 'msg' => $validate->getError()];
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        }
        // 保存数据，成功返回自增id，失败记录错误信息
        $res = $model->data($data)->allowField(true)->save();
        if ($res) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'insid' => $model->id];
        } else {
<<<<<<< HEAD
            trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
=======
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 获取球队详情
<<<<<<< HEAD
    public function getTeam($map) {
=======
    public function getTeam($map)
    {
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        $model = new Team();
        $res = $model->where($map)->find();
        if ($res) {
            // 详情数据数组组合需要的元素
            $result = $res->getData();
            $result['status_text'] = $res->status;
            $result['type_text'] = $res->type;
<<<<<<< HEAD
=======
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
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
            return $result;
        } else {
            return $res;
        }
    }

    // 球队列表
<<<<<<< HEAD
    public function getTeamList($map=[], $page=1, $order='id desc', $limit=10) {
        $model = new Team();
        $res = $model->where($map)->order($order)->page($page)->limit($limit)->select();
        if ($res) {
            return $res->toArray();
=======
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
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        } else {
            return $res;
        }
    }

    // 球队列表带分页页码
<<<<<<< HEAD
    public function getTeamListPaginator($map=[], $order='id desc', $paginate=10) {
        $model = new Team();
        $res = $model->where($map)->order($order)->paginate($paginate);
        if ($res) {
            return $res->toArray();
=======
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
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        } else {
            return $res;
        }
    }

    // 修改球队信息
<<<<<<< HEAD
    public function updateTeam($data, $id) {
        $model = new Team();
        // 验证数据
        $validate = validate('TeamVal');
        if (!$validate->scene('edit')->check($data)) {
            return ['code' => 100, 'msg' => $validate->getError()];
=======
    public function updateTeam($data, $id, $validate=0)
    {
        $model = new Team();
        if ($validate) { //$validate=1 启用验证器
            // 验证数据
            $validate = validate('TeamVal');
            if (!$validate->scene('edit')->check($data)) {
                return ['code' => 100, 'msg' => $validate->getError()];
            }
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        }
        // 保存数据，区分是否修改数据。成功返回true，失败记录错误信息
        //$res = $model->allowField(true)->update($data);
        $res = $model->allowField(true)->save($data, ['id' => $id]);
        if ($res || ($res === 0)) {
            return ['code' => 200, 'msg' => __lang('MSG_200')];
        } else {
<<<<<<< HEAD
            trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
=======
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

<<<<<<< HEAD

    // 保存team_member球队-会员关系信息
    public function saveTeamMember($data, $teamMember_id=0) {
        $model = new TeamMember();
        // 有传入team_member表id 更新关系数据，否则新增关系数据
        if ($teamMember_id) {
            $res = $model->allowField(true)->save($data, ['id' => $data['id']]);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        } else {
            $res = $model->allowField(true)->save($data);
            if ($res) {
                return ['code' => 200, 'msg' => __lang('MSG_200'), 'insid' => $model->id];
            } else {
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
    }

    // 获取球队成员列表
    public function getTeamMemberList($map=[], $page=1, $order='id asc', $limit=10) {
=======
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
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        $model = new TeamMember();
        $res = $model->with('team')->where($map)->order($order)->page($page)->limit($limit)->select();
        if ($res) {
            // 遍历获取成员在球队的角色身份
            $teammembers = $res->toArray();
            $roleModel = new TeamMemberRole();
            foreach ($teammembers as $k => $teammember) {
                $teammembers[$k]['role_text'] = '';
<<<<<<< HEAD
                $memberRole = $roleModel->where(['member_id' => $teammember['member_id'], 'team_id' => $teammember['team_id'], 'status' => 1])->select()->toArray();
                foreach ($memberRole as $val) {
                    $teammembers[$k]['role_text'] .= $val['type'].',';
=======
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
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
                }
            }
            return $teammembers;
        } else {
            return $res;
        }
    }

    // 获取球队-队员详细
<<<<<<< HEAD
    public function getTeamMemberInfo($map) {
=======
    public function getTeamMemberInfo($map)
    {
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        $model = new TeamMember();
        $res = $model->where($map)->find();
        if ($res) {
            $result = $res->toArray();
            $result['status_num'] = $res->getData('status');
            $result['position_num'] = $res->getData('position');
            // 获取成员在球队的角色身份
            $roleModel = new TeamMemberRole();
            $result['role_text'] = '';
<<<<<<< HEAD
            $memberRole = $roleModel->where(['member_id' => $result['member_id'], 'team_id' => $result['team_id'], 'status' => 1])->select()->toArray();
            foreach ($memberRole as $val) {
                $result['role_text'] .= $val['type'].',';
=======
            $memberRole = $roleModel->where([
                'member_id' => $result['member_id'],
                'name' => $result['name'],
                'team_id' => $result['team_id'],
                'status' => 1
            ])->select();
            foreach ($memberRole as $val) {
                $result['role_text'] .= $val['type_text'] . ',';
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
            }
            return $result;
        } else {
            return $res;
        }
    }

<<<<<<< HEAD
    // 保存team_member_role 会员-球队角色关联信息
    public function saveTeamMemberRole($data, $team_id) {
        $model = new TeamMemberRole();
        // 修改数组定义
        $saveAlldata = [];
        // 查询当前领队数据（领队一个）
        $roleLeader = $model->where([ 'team_id' => $team_id, 'type' => 4 ])->find();
        if (!$roleLeader) {
            // 直接插入新数据
            array_push($saveAlldata, [
                'type' => 4,
                'team_id' => $team_id,
                'member_id' => $data['leader_id'],
                'status' => 1
            ]);
        } else {
            $roleLeader = $roleLeader->toArray();
            // 领队有改变 组合修改数组
            if ($roleLeader['member_id'] != $data['leader_id']) {
                array_push($saveAlldata, [
                    'id' => $roleLeader['id'],
                    'member_id' => $data['leader_id']
                ]);
            }
        }
        // 查询当前队长数据（队长一个）
        $roleCaptain = $model->where([ 'team_id' => $team_id, 'type' => 3 ])->find();
        if (!$roleCaptain) {
            // 直接插入新数据
            array_push($saveAlldata, [
                'type' => 3,
                'team_id' => $team_id,
                'member_id' => $data['leader_id'],
                'status' => 1
            ]);
        } else {

            $roleCaptain = $roleCaptain->toArray();
            // 队长有改变 组合修改数组
            if ($roleCaptain['member_id'] != $data['captain_id']) {
                array_push($saveAlldata, [
                    'id' => $roleCaptain['id'],
                    'member_id' => $data['captain_id']
                ]);
            }
        }
        // 处理提交的coach_id
        if (isset($data['coach_id'])) {
            // 查询当前教练数据member_id集合（教练可多个）
            $roleCoachs = $model->where([ 'team_id' => $team_id, 'type' => 2, 'status' => 1])->column('member_id');
            // 拆分遍历提交的coach_id是否在当前球队教练数据member_id集合中
            $coach_ids = explode(',', $data['coach_id']);
            foreach ($coach_ids as $val) {
                // 不在集合中
                if (!in_array($val, $roleCoachs)) {
                    // 有无team_member_role教练数据
                    $hasCoach = $model->where([ 'team_id' => $team_id, 'type' => 2, 'member_id' => $val ])->find();
                    if (!$hasCoach) {
                        // 插入新的team_member_role教练数据
                        array_push($saveAlldata, [
                            'team_id' => $team_id,
                            'member_id' => $val,
                            'type' => 2,
                            'status' => 1
                        ]);
                    } else {
                        // 更新新的team_member_role教练数据
                        $coach = $hasCoach->toArray();
                        $status = $hasCoach->getData('status');
                        array_push($saveAlldata, [
                            'id' => $coach['id'],
                            'status' => ( $status == 1) ? -1 : 1
                        ]);
                    }
                }
            }
            // 将不在提交的coach_id中 其他的球队教练更新status=-1
            $model->where([ 'team_id' => $team_id, 'type' => 2, 'member_id' => ['not in', $coach_ids] ])->update(['status' => -1]);
        }
        // 拆分提交的committee_id
        if (isset($data['committee_id'])) {
            // 查询当前队委数据member_id集合（可多个）
            $roleCommittees = $model->where([ 'team_id' => $team_id, 'type' => 1, 'status' => 1 ])->column('member_id');
            // 拆分遍历提交的committee_id是否在当前球队队委数据member_id集合中
            $committee_ids = explode(',', $data['committee_id']);
            foreach ($committee_ids as $val) {
                // 不在集合中
                if (!in_array($val, $roleCommittees)) {
                    // 有无team_member_role队委数据
                    $hascommittee = $model->where([ 'team_id' => $team_id, 'type' => 1, 'member_id' => $val ])->find();
                    if (!$hascommittee) {
                        // 插入新的team_member_role队委数据
                        array_push($saveAlldata, [
                            'team_id' => $team_id,
                            'member_id' => $val,
                            'type' => 1,
                            'status' => 1
                        ]);
                    } else {
                        // 更新新的team_member_role队委数据
                        $committee = $hascommittee->toArray();
                        $status = $hascommittee->getData('status');
                        array_push($saveAlldata, [
                            'id' => $committee['id'],
                            'status' => ( $status == 1) ? -1 : 1
                        ]);
                    }
                }
            }
            // 将不在提交的committee_id中 其他的球队队委更新status=-1
            $model->where([ 'team_id' => $team_id, 'type' => 1, 'member_id' => ['not in', $committee_ids] ])->update(['status' => -1]);
        }
        $res = $model->saveAll($saveAlldata);
        if ($res || ($res === 0)) {
            return ['code' => 200, 'msg' => __lang('MSG_200')];
        } else {
            trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 获取球队有角色身份的会员列表
    public function getTeamRoleMembers($team_id, $order='type desc')
    {
        $list = Db::view('team_member_role', '*, status as role_status')
            ->view('team_member', '*', 'team_member.member_id=team_member_role.member_id', 'left')
            ->where(['team_member.team_id' => $team_id, 'team_member_role.status' => 1, 'team_member.status' => 1])
=======
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
    public function setTeamMemberRole($data, $team_id)
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

        // 查询当前"领队"数据（一个）
        $roleLeader = $model->where(['team_id' => $team_id, 'type' => 6])->find();
        // 获取成员对应team_member数据
        $leaderTm = $this->getTeamMemberInfo(['team_id' => $team_id, 'member_id' => $data['leader_id'], 'member|name' => $data['leader']]);
        if ($roleLeader) {
            $roleLeader = $roleLeader->toArray();
            // 领队发生改变 更新领队team_member_role数据
            if ($roleLeader['member'] != $leaderTm['member']) {
                array_push($saveAlldata, [
                    'id' => $roleLeader['id'],
                    'member_id' => $leaderTm['member_id'],
                    'member' => $leaderTm['member'],
                    'name' => $leaderTm['name']
                ]);
            }
        } else {
            // 插入新的领队team_member_role数据
            array_push($saveAlldata, [
                'type' => 6,
                'team_id' => $team_id,
                'member_id' => $leaderTm['member_id'],
                'member' => $leaderTm['member'],
                'name' => $leaderTm['name'],
                'status' => 1
            ]);
        }

        if (!empty($data['manager'])) {
            // 查询当前"经理"数据（一个）
            $roleManager = $model->where(['team_id' => $team_id, 'type' => 5])->find();
            // 获取成员对应team_member数据
            $managerTm = $this->getTeamMemberInfo(['team_id' => $team_id, 'member_id' => $data['manager_id'], 'member|name' => $data['manager']]);
            if ($roleManager) {
                $roleManager = $roleManager->toArray();
                // 经理发生改变 更新经理team_member_role数据
                if ($roleManager['member'] != $managerTm['member']) {
                    array_push($saveAlldata, [
                        'id' => $roleManager['id'],
                        'member_id' => $managerTm['member_id'],
                        'member' => $managerTm['member'],
                        'name' => $managerTm['name']
                    ]);
                }
            } else {
                // 插入新的经理team_member_role数据
                array_push($saveAlldata, [
                    'type' => 5,
                    'team_id' => $team_id,
                    'member_id' => $managerTm['member_id'],
                    'member' => $managerTm['member'],
                    'name' => $managerTm['name'],
                    'status' => 1
                ]);
            }
        } else {
            // 提交"经理"为空 team_member_role经理(type=5)status=-1
            $model->where([
                'team_id' => $team_id,
                'type' => 5
            ])->update(['status' => -1]);
        }

        if (!empty($data['captain'])) {
            // 查询当前"队长"数据（一个）
            $roleCaptain = $model->where(['team_id' => $team_id, 'type' => 3])->find();
            // 获取成员对应team_member数据
            $captainTm = $this->getTeamMemberInfo(['team_id' => $team_id, 'member_id' => $data['captain_id'], 'member|name' => $data['captain']]);
            if ($roleCaptain) {
                $roleCaptain = $roleCaptain->toArray();
                // 队长发生改变 更新队长team_member_role数据
                if ($roleCaptain['member'] != $captainTm['member']) {
                    array_push($saveAlldata, [
                        'id' => $roleCaptain['id'],
                        'member_id' => $captainTm['member_id'],
                        'member' => $captainTm['member'],
                        'name' => $captainTm['name']
                    ]);
                }
            } else {
                // 插入新的队长team_member_role数据
                array_push($saveAlldata, [
                    'type' => 3,
                    'team_id' => $team_id,
                    'member_id' => $captainTm['member_id'],
                    'member' => $captainTm['member'],
                    'name' => $captainTm['name'],
                    'status' => 1
                ]);
            }
        } else {
            // 提交"队长"为空 team_member_role队长(type=3)status=-1
            $model->where([
                'team_id' => $team_id,
                'type' => 3
            ])->update(['status' => -1]);
        }

        if (!empty($data['vice_captain'])) {
            // 查询当前"副队长"数据（一个）
            $roleViceCaptain = $model->where(['team_id' => $team_id, 'type' => 2])->find();
            // 获取成员对应team_member数据
            $viceCaptainTm = $this->getTeamMemberInfo(['team_id' => $team_id, 'member_id' => $data['vice_captain_id'], 'member|name' => $data['vice_captain']]);
            if ($roleViceCaptain) {
                $roleViceCaptain = $roleViceCaptain->toArray();
                // 副队长发生改变 更新副队长team_member_role数据
                if ($roleViceCaptain['member'] != $viceCaptainTm['member']) {
                    array_push($saveAlldata, [
                        'id' => $roleViceCaptain['id'],
                        'member_id' => $viceCaptainTm['member_id'],
                        'member' => $viceCaptainTm['member'],
                        'name' => $viceCaptainTm['name']
                    ]);
                }
            } else {
                // 插入新的副队长team_member_role数据
                array_push($saveAlldata, [
                    'type' => 2,
                    'team_id' => $team_id,
                    'member_id' => $viceCaptainTm['member_id'],
                    'member' => $viceCaptainTm['member'],
                    'name' => $viceCaptainTm['name'],
                    'status' => 1
                ]);
            }
        } else {
            // 提交"副队长"为空 team_member_role副队长(type=2)status=-1
            $model->where([
                'team_id' => $team_id,
                'type' => 2
            ])->update(['status' => -1]);
        }

        if ( !empty($data['coachMemberList']) && $data['coachMemberList'] != '[]' ) {
            // 先将球队的"教练"status=-1为无效. 根据提交的"教练"数据覆盖或新增数据
            $model->where([
                'team_id' => $team_id,
                'type' => 4
            ])->update(['status' => -1]);
            // 转化提交"教练"数据
            $coachsData = json_decode($data['coachMemberList'], true);
            // 提交"教练"数据有无 team_member_role教练（type=4)数据
            foreach ($coachsData as $coach) {
                $hasRoleCoach = $model->where(['team_id' => $team_id, 'member_id' => $coach['member_id'], 'member' => $coach['member'], 'name' => $coach['name'], 'type' => 4])->find();
                if ($hasRoleCoach) {
                    $hasRoleCoach = $hasRoleCoach->toArray();
                    // 覆盖原"教练"team_member_role
                    array_push($saveAlldata, [
                        'id' => $hasRoleCoach['id'],
                        'member_id' => $coach['member_id'],
                        'member' => $coach['member'],
                        'name' => $coach['name'],
                        'status' => 1
                    ]);
                } else {
                    // 插入新的教练team_member_role数据
                    array_push($saveAlldata, [
                        'type' => 4,
                        'team_id' => $team_id,
                        'member_id' => $coach['member_id'],
                        'member' => $coach['member'],
                        'name' => $coach['name'],
                        'status' => 1
                    ]);
                }
            }
        } else {
            // 提交"教练"数据为空 team_member_role所有教练(type=4)status=-1
            $model->where([
                'team_id' => $team_id,
                'type' => 4
            ])->update(['status' => -1]);
        }

        if ( !empty($data['committeeMemberList']) && $data['committeeMemberList'] != '[]' ) {
            // 先将球队的"队委"status=-1为无效. 根据提交的"队委"数据覆盖或新增数据
            $model->where([
                'team_id' => $team_id,
                'type' => 1
            ])->update(['status' => -1]);
            // 转化提交"队委"数据
            $committeesData = json_decode($data['committeeMemberList'], true);
            // 提交"队委"数据有无 team_member_role队委（type=1)数据
            foreach ($committeesData as $committee) {
                $hasRoleCommittee = $model->where(['team_id' => $team_id, 'member_id' => $committee['member_id'], 'member' => $committee['member'], 'name' => $committee['name'], 'type' => 1])->find();
                if ($hasRoleCommittee) {
                    $hasRoleCommittee = $hasRoleCommittee->toArray();
                    // 覆盖原"教练"team_member_role
                    array_push($saveAlldata, [
                        'id' => $hasRoleCommittee['id'],
                        'member_id' => $committee['member_id'],
                        'member' => $committee['member'],
                        'name' => $committee['name'],
                        'status' => 1
                    ]);
                } else {
                    // 插入新的教练team_member_role数据
                    array_push($saveAlldata, [
                        'type' => 1,
                        'team_id' => $team_id,
                        'member_id' => $committee['member_id'],
                        'member' => $committee['member'],
                        'name' => $committee['name'],
                        'status' => 1
                    ]);
                }
            }
        } else {
            // 提交"队委"数据为空 team_member_role所有教练(type=1)status=-1
            $model->where([
                'team_id' => $team_id,
                'type' => 1
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
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
            ->where('team_member.delete_time', null)
            ->where('team_member_role.delete_time', null)
            ->order($order)
            ->select();
        return $list;
    }

<<<<<<< HEAD
    // 获取会员在球队的身份角色
    public function checkMemberTeamRole($team_id, $member_id) {
        $model = new TeamMemberRole();
        $res = $model->where(['team_id' => $team_id, 'member_id' => $member_id])
            ->where(['status' => 1])->value('type');
=======
    // 获取会员在球队的最大身份角色
    public function checkMemberTeamRole($team_id, $member_id)
    {
        $model = new TeamMemberRole();
        $res = $model->where(['team_id' => $team_id, 'member_id' => $member_id])
            ->where(['status' => 1])
            ->order('type desc')
            ->value('type');
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        return $res ? $res : 0;
    }

    // 查看会员加入球队申请记录
<<<<<<< HEAD
    public function getApplyInfo($map) {
        $model = new Apply();
        $res = $model->with('member')->where($map)->find();
        if ($res) {
            return $res->toArray();
=======
    public function getApplyInfo($map)
    {
        $model = new Apply();
        $res = $model->with('member')->where($map)->find();
        if ($res) {
            $result = $res->toArray();
            $getData = $res->getData();
            $result['status_num'] = $getData['status'];
            return $result;
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        } else {
            return $res;
        }
    }

    // 保存加入球队申请数据
<<<<<<< HEAD
    public function saveApply($data) {
=======
    public function saveApply($data)
    {
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        $model = new Apply();
        // 如果有带更新条件记录id就更新数据
        if (isset($data['id'])) {
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
<<<<<<< HEAD
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
=======
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        } else {
            // 插入一条加入球队申请数据
            $res = $model->allowField(true)->save($data);
            if ($res) {
<<<<<<< HEAD
                return ['code' => 200, 'msg' => __lang('MSG_200'), 'insid' => $model->id];
            } else {
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
=======
                return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
    }

    // 创建球队活动
<<<<<<< HEAD
    public function createTeamEvent($data) {
=======
    public function createTeamEvent($data)
    {
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
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
<<<<<<< HEAD
            trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
=======
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 修改球队活动
<<<<<<< HEAD
    public function updateTeamEvent($data, $noval=0) {
=======
    public function updateTeamEvent($data, $noval = 0)
    {
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        $model = new TeamEvent();
        // 传入$noval=1 忽略验证器
        if ($noval === 0) {
            // 验证数据
            $validate = validate('TeamEventVal');
            if (!$validate->scene('edit')->check($data)) {
                return ['code' => 100, 'msg' => $validate->getError()];
            }
        }
<<<<<<< HEAD
        // 保存数据，成功返回自增id，失败记录错误信息
=======
        // 保存数据，成功返回，失败记录错误信息
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        $res = $model->allowField(true)->isUpdate(true)->save($data);
        if ($res || ($res === 0)) {
            return ['code' => 200, 'msg' => __lang('MSG_200')];
        } else {
<<<<<<< HEAD
            trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
=======
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 软删除球队活动
<<<<<<< HEAD
    public function deleteTeamEvent($id) {
=======
    public function deleteTeamEvent($id)
    {
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        $res = TeamEvent::destroy($id);
        return $res;
    }

    // 球队活动列表分页
<<<<<<< HEAD
    public function teamEventPaginator($map, $order='id desc', $paginate=10) {
=======
    public function teamEventPaginator($map, $order = 'id desc', $paginate = 10)
    {
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        $model = new TeamEvent();
        $res = $model->where($map)->order($order)->paginate($paginate);
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 球队活动列表
<<<<<<< HEAD
    public function teamEventList($map, $page=1, $order='id desc', $limit=10) {
=======
    public function teamEventList($map, $page = 1, $order = 'id desc', $limit = 10)
    {
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        $model = new TeamEvent();
        $res = $model->where($map)->order($order)->page($page, $limit)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }
<<<<<<< HEAD
    
    // 球队活动详情
    public function getTeamEventInfo($map) {
        $model = new TeamEvent();
        $res = $model->where($map)->find();
        if ($res) {
            $result = $res->toArray();
=======

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
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
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
<<<<<<< HEAD
    public function getMemberTeamEvent($map) {
=======
    public function getMemberTeamEvent($map)
    {
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        $model = new TeamEventMember();
        $res = $model->where($map)->find();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 保存球队活动-会员关联数据
<<<<<<< HEAD
    public function saveTeamEventMember($data, $map=[]) {
=======
    public function saveTeamEventMember($data, $map = [])
    {
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        $model = new TeamEventMember();
        if (!empty($map)) {
            // 更新数据
            $res = $model->allowField(true)->save($data, $map);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
<<<<<<< HEAD
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
=======
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
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
<<<<<<< HEAD
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
=======
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
    }

    // 更新球队活动-会员关联数据
<<<<<<< HEAD
    public function saveAllTeamEventMember($data=[]) {
=======
    public function saveAllTeamEventMember($data = [])
    {
        //dump($data);die;
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        $model = new TeamEventMember();
        $res = $model->saveAll($data);
        if ($res || ($res === 0)) {
            return ['code' => 200, 'msg' => __lang('MSG_200')];
        } else {
<<<<<<< HEAD
            trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
=======
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 球队活动-会员关联列表分页
<<<<<<< HEAD
    public function teamEventMemberPaginator($map, $order='id desc', $paginate=10) {
=======
    public function teamEventMemberPaginator($map, $order = 'id desc', $paginate = 10)
    {
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        $model = new TeamEventMember();
        $res = $model->where($map)->order($order)->paginate($paginate);
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 球队活动-会员关联列表
<<<<<<< HEAD
    public function teamEventMemberList($map, $page=1, $order='id desc', $limit=10) {
=======
    public function teamEventMemberList($map, $page = 1, $order = 'id desc', $limit = 10)
    {
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        $model = new TeamEventMember();
        $res = $model->where($map)->order($order)->page($page, $limit)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 球队活动-会员关联列表（无分页）
<<<<<<< HEAD
    public function teamEventMembers($map, $order='id desc') {
=======
    public function teamEventMembers($map, $order = 'id desc')
    {
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        $model = new TeamEventMember();
        $res = $model->where($map)->order($order)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 球队模块评论列表分页
<<<<<<< HEAD
    public function getCommentPaginator($map, $order='id desc', $paginate=10) {
=======
    public function getCommentPaginator($map, $order = 'id desc', $paginate = 10)
    {
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
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
<<<<<<< HEAD
    public function getCommentList($map, $page=1, $order='id desc', $limit=10) {
=======
    public function getCommentList($map, $page = 1, $order = 'id desc', $limit = 10)
    {
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
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
<<<<<<< HEAD
    public function getCommentThumbCount($map) {
=======
    public function getCommentThumbCount($map)
    {
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        $model = new TeamComment();
        $map['thumbsup'] = 1;
        $res = $model->where($map)->count();
        return $res;
    }

    // 保存球队模块评论、点赞数据
<<<<<<< HEAD
    public function saveComment($data) {
=======
    public function saveComment($data)
    {
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        $model = new TeamComment();
        // 根据传参 有id字段更新数据否则新增数据
        if (isset($data['id'])) {
            // 更新数据
            $res = $model->allowField(true)->save($data, ['id' => $data['id']]);
<<<<<<< HEAD
            if ($res || ($res === 0) ) {
=======
            if ($res || ($res === 0)) {
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
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
<<<<<<< HEAD
    public function getCommentInfo($map) {
=======
    public function getCommentInfo($map)
    {
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        $model = new TeamComment();
        $res = $model->where($map)->find();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }
<<<<<<< HEAD
=======

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
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
}