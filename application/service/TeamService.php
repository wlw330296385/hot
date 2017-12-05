<?php
// 球队service
namespace app\service;
use app\model\Team;
use app\model\TeamMember;
use app\model\TeamMemberRole;

class TeamService {
    // 创建球队
    public function createTeam($data) {
        $model = new Team();
        // 验证数据
        $validate = validate('TeamVal');
        if (!$validate->check($data)) {
           return ['code' => 100, 'msg' => $validate->getError()];
        }
        // 保存数据，成功返回自增id，失败记录错误信息
        $res = $model->data($data)->allowField(true)->save();
        if ($res) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'insid' => $model->id];
        } else {
            trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400').$model->getError()];
        }
    }

    // 获取球队详情
    public function getTeam($map) {
        $model = new Team();
        $res = $model->where($map)->find();
        if ($res) {
            $result = $res->toArray();
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
    public function updateTeam($data) {
        $model = new Team();
        // 验证数据
        $validate = validate('TeamVal');
        if (!$validate->check($data)) {
            return ['code' => 100, 'msg' => $validate->getError()];
        }
        // 保存数据，区分是否修改数据。成功返回true，失败记录错误信息
        $res = $model->update($data);
        if ($res || ($res === 0)) {
            return ['code' => 200, 'msg' => __lang('MSG_200')];
        } else {
            trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400').$model->getError()];
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
                return ['code' => 100, 'msg' => __lang('MSG_400').$model->getError()];
            }
        } else {
            $res = $model->allowField(true)->save($data);
            if ($res) {
                return ['code' => 200, 'msg' => __lang('MSG_200'), 'insid' => $model->id];
            } else {
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400').$model->getError()];
            }
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
                return ['code' => 100, 'msg' => __lang('MSG_400').$model->getError()];
            }
        } else {
            $res = $model->allowField(true)->save($data);
            if ($res) {
                return ['code' => 200, 'msg' => __lang('MSG_200'), 'insid' => $model->id];
            } else {
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400').$model->getError()];
            }
        }
    }
    
    // 我的球队列表（与会员有关联的球队）
    public function myTeamList($map=[], $page=1, $order='id desc', $limit=10) {
        $model = new TeamMember();
        $res = $model->with('team')->order($order)->page($page)->limit($limit)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }
}