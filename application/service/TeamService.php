<?php
// 球队service
namespace app\service;
use app\model\Apply;
use app\model\Team;
use app\model\TeamEvent;
use app\model\TeamMember;
use app\model\TeamMemberRole;
use think\Db;

class TeamService {
    // 我的球队列表（与会员有关联的球队）
    public function myTeamList($map=[], $page=1, $order='id desc', $limit=10) {
        $model = new TeamMember();
        $res = $model->with('team')->where($map)->order($order)->page($page)->limit($limit)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 创建球队
    public function createTeam($data) {
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
            trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 获取球队详情
    public function getTeam($map) {
        $model = new Team();
        $res = $model->where($map)->find();
        if ($res) {
            // 详情数据数组组合需要的元素
            $result = $res->toArray();
            $result['status_num'] = $res->getData('status');
            $result['type_num'] = $res->getData('type');
            return $result;
        } else {
            return $res;
        }
    }

    // 球队列表
    public function getTeamList($map=[], $page=1, $order='id desc', $limit=10) {
        $model = new Team();
        $res = $model->where($map)->order($order)->page($page)->limit($limit)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 球队列表带分页页码
    public function getTeamListPaginator($map=[], $order='id desc', $paginate=10) {
        $model = new Team();
        $res = $model->where($map)->order($order)->paginate($paginate);
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 修改球队信息
    public function updateTeam($data, $id) {
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
            trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }


    // 保存team_member球队-会员关系信息
    public function saveTeamMember($data, $teamMember_id=0) {
        $model = new TeamMember();
        // 有传入team_member表id 更新关系数据，否则新增关系数据
        if ($teamMember_id) {
            $res = $model->where('id', $teamMember_id)->update($data);
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
        $model = new TeamMember();
        $res = $model->with('team')->where($map)->order($order)->page($page)->limit($limit)->select();
        if ($res) {
            // 遍历获取成员在球队的角色身份
            $teammembers = $res->toArray();
            $roleModel = new TeamMemberRole();
            foreach ($teammembers as $k => $teammember) {
                $teammembers[$k]['role_text'] = '';
                $memberRole = $roleModel->where(['member_id' => $teammember['member_id'], 'team_id' => $teammember['team_id'], 'status' => 1])->select()->toArray();
                foreach ($memberRole as $val) {
                    $teammembers[$k]['role_text'] .= $val['type'].',';
                }
            }
            return $teammembers;
        } else {
            return $res;
        }
    }

    // 获取球队-队员详细
    public function getTeamMemberInfo($map) {
        $model = new TeamMember();
        $res = $model->where($map)->find();
        if ($res) {
            $result = $res->toArray();
            $result['status_num'] = $res->getData('status');
            return $result;
        } else {
            return $res;
        }
    }

    // 保存team_member_role 会员-球队角色关联信息
    public function saveTeamMemberRole($data, $teamMemberRole_id=0) {
        $model = new TeamMemberRole();
        // 有传入team_member_role表id 更新关系数据，否则新增关系数据
        if ($teamMemberRole_id) {
            $res = $model->where('id', $teamMemberRole_id)->update($data);
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

    // 获取球队有角色身份的会员列表
    public function getTeamRoleMembers($team_id)
    {
        $list = Db::view('team_member_role', '*, status as role_status')
            ->view('team_member', '*', 'team_member.member_id=team_member_role.member_id', 'left')
            ->where(['team_member_role.team_id' => $team_id, 'team_member_role.status' => 1, 'team_member.status' => 1])
            ->where('team_member.delete_time', null)
            ->where('team_member_role.delete_time', null)
            ->order('type desc')
            ->select();
        return $list;
    }

    // 获取会员在球队的身份角色
    public function checkMemberTeamRole($team_id, $member_id) {
        $model = new TeamMemberRole();
        $res = $model->where(['team_id' => $team_id, 'member_id' => $member_id])
            ->where(['status' => 1])->value('type');
        return $res ? $res : 0;
    }

    // 查看会员加入球队申请记录
    public function getApplyInfo($map) {
        $model = new Apply();
        $res = $model->with('member')->where($map)->find();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 保存加入球队申请数据
    public function saveApply($data) {
        $model = new Apply();
        // 如果有带更新条件记录id就更新数据
        if (isset($data['id'])) {
            $res = $model->allowField(true)->save($data, ['id' => $data['id']]);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        } else {
            // 插入一条加入球队申请数据
            $res = $model->allowField(true)->save($data);
            if ($res) {
                return ['code' => 200, 'msg' => __lang('MSG_200'), 'insid' => $model->id];
            } else {
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
    }

    // 球队活动分页
    public function teamEventPaginator($map, $order='id desc', $paginate=10) {
        $model = new TeamEvent();
        $res = $model->where($map)->order($order)->paginate();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }
}