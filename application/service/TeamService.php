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

    // 我的球队列表（带输出在队职位角色）
    public function myTeamWithRole($member_id) {
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
            $result = $res->getData();
            $result['status_text'] = $res->status;
            $result['type_text'] = $res->type;
            // 计算球队胜率
            if ($result['match_num'] > 0) {
                $result['match_lose'] = $result['match_num']-$result['match_win'];
                $result['win_rate'] = ($result['match_win']/$result['match_num'])*100 . '%';
            } else {
                $result['win_rate'] = 0;
            }
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
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        } else {
            // 新增球队成员
            $res = $model->allowField(true)->save($data);
            if ($res) {
                // 查询有无关注数据保存关注数据
                $followDb = db('follow');
                $follow = $followDb->where(['type' => 4, 'follow_id' => $data['team_id'], 'member_id' => $data['member_id']])->find();
                if ($follow) {
                    if ($follow['status'] != 1 ) {
                        $followDb->where('id', $follow['id'])->update(['status' => 1, 'update_time' => time()]);
                    }
                } else {
                    $followDb->insert([
                        'type' => 4, 'follow_id' => $data['team_id'], 'follow_name' => $data['team'],
                        'member_id' => $data['member_id'], 'member' => $data['member'], 'member_avatar' => $data['avatar'],
                        'status' => 1, 'create_time' => time()
                    ]);
                }

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
            $result['position_num'] = $res->getData('position');
            // 获取成员在球队的角色身份
            $roleModel = new TeamMemberRole();
            $result['role_text'] = '';
            $memberRole = $roleModel->where(['member_id' => $result['member_id'], 'team_id' => $result['team_id'], 'status' => 1])->select()->toArray();
            foreach ($memberRole as $val) {
                $result['role_text'] .= $val['type'].',';
            }
            return $result;
        } else {
            return $res;
        }
    }

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
            ->where('team_member.delete_time', null)
            ->where('team_member_role.delete_time', null)
            ->order($order)
            ->select();
        return $list;
    }

    // 获取会员在球队的最大身份角色
    public function checkMemberTeamRole($team_id, $member_id) {
        $model = new TeamMemberRole();
        $res = $model->where(['team_id' => $team_id, 'member_id' => $member_id])
            ->where(['status' => 1])
            ->order('type desc')
            ->value('type');
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
            $res = $model->allowField(true)->isUpdate(true)->save($data);
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

    // 创建球队活动
    public function createTeamEvent($data) {
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
            trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 修改球队活动
    public function updateTeamEvent($data, $noval=0) {
        $model = new TeamEvent();
        // 传入$noval=1 忽略验证器
        if ($noval === 0) {
            // 验证数据
            $validate = validate('TeamEventVal');
            if (!$validate->scene('edit')->check($data)) {
                return ['code' => 100, 'msg' => $validate->getError()];
            }
        }
        // 保存数据，成功返回自增id，失败记录错误信息
        $res = $model->allowField(true)->isUpdate(true)->save($data);
        if ($res || ($res === 0)) {
            return ['code' => 200, 'msg' => __lang('MSG_200')];
        } else {
            trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 软删除球队活动
    public function deleteTeamEvent($id) {
        $res = TeamEvent::destroy($id);
        return $res;
    }

    // 球队活动列表分页
    public function teamEventPaginator($map, $order='id desc', $paginate=10) {
        $model = new TeamEvent();
        $res = $model->where($map)->order($order)->paginate($paginate);
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 球队活动列表
    public function teamEventList($map, $page=1, $order='id desc', $limit=10) {
        $model = new TeamEvent();
        $res = $model->where($map)->order($order)->page($page, $limit)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 球队活动列表（无分页)
    public function teamEventListAll($map, $order='id desc') {
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
    public function getTeamEventInfo($map, $order='') {
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
    public function getMemberTeamEvent($map) {
        $model = new TeamEventMember();
        $res = $model->where($map)->find();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 保存球队活动-会员关联数据
    public function saveTeamEventMember($data, $map=[]) {
        $model = new TeamEventMember();
        if (!empty($map)) {
            // 更新数据
            $res = $model->allowField(true)->save($data, $map);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
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
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
    }

    // 更新球队活动-会员关联数据
    public function saveAllTeamEventMember($data=[]) {
        //dump($data);die;
        $model = new TeamEventMember();
        $res = $model->saveAll($data);
        if ($res || ($res === 0)) {
            return ['code' => 200, 'msg' => __lang('MSG_200')];
        } else {
            trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 球队活动-会员关联列表分页
    public function teamEventMemberPaginator($map, $order='id desc', $paginate=10) {
        $model = new TeamEventMember();
        $res = $model->where($map)->order($order)->paginate($paginate);
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 球队活动-会员关联列表
    public function teamEventMemberList($map, $page=1, $order='id desc', $limit=10) {
        $model = new TeamEventMember();
        $res = $model->where($map)->order($order)->page($page, $limit)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 球队活动-会员关联列表（无分页）
    public function teamEventMembers($map, $order='id desc') {
        $model = new TeamEventMember();
        $res = $model->where($map)->order($order)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 球队模块评论列表分页
    public function getCommentPaginator($map, $order='id desc', $paginate=10) {
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
    public function getCommentList($map, $page=1, $order='id desc', $limit=10) {
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
    public function getCommentThumbCount($map) {
        $model = new TeamComment();
        $map['thumbsup'] = 1;
        $res = $model->where($map)->count();
        return $res;
    }

    // 保存球队模块评论、点赞数据
    public function saveComment($data) {
        $model = new TeamComment();
        // 根据传参 有id字段更新数据否则新增数据
        if (isset($data['id'])) {
            // 更新数据
            $res = $model->allowField(true)->save($data, ['id' => $data['id']]);
            if ($res || ($res === 0) ) {
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
    public function getCommentInfo($map) {
        $model = new TeamComment();
        $res = $model->where($map)->find();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 保存球队公告信息
    public function saveTeamMessage($data) {
        $model = new TeamMessage();
        $res = $model->allowField(true)->save($data);
        if ($res) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->getLastInsID()];
        } else {
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 球队公告信息列表分页
    public function getTeamMessagePaginator($map, $order='id desc', $paginate=10) {
        $model = new TeamMessage();
        $res = $model->where($map)->order($order)->paginate($paginate);
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 球队公告信息列表
    public function getTeamMessageList($map, $page=1, $order='id desc', $limit=10) {
        $model = new TeamMessage();
        $res = $model->where($map)->order($order)->page($page, $limit)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }
}