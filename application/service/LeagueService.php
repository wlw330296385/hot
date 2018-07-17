<?php
// 联赛service
namespace app\service;


use app\model\Article;
use app\model\Match;
use app\model\MatchGroup;
use app\model\MatchGroupTeam;
use app\model\MatchMember;
use app\model\MatchOrg;
use app\model\MatchOrgMember;
use app\model\MatchRank;
use app\model\MatchRecord;
use app\model\MatchSchedule;
use app\model\MatchStage;
use app\model\MatchTeam;
use app\model\MatchTeamMember;

class LeagueService
{
    // 创建联赛组织
    public function createMatchOrg($data)
    {
        $model = new MatchOrg();
        // 保存数据，成功返回自增id，失败记录错误信息
        $res = $model->data($data)->allowField(true)->save();
        if ($res) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
        } else {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 编辑联赛组织
    public function updateMatchOrg($data, $condition = [])
    {
        $model = new MatchOrg();
        // 带更新条件更新数据
        if (!empty($condition) && is_array($condition)) {
            $res = $model->allowField(true)->save($data, $condition);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
        // 更新数据
        if (array_key_exists('id', $data)) {
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
    }

    // 获取联赛组织信息
    public function getMatchOrg($map)
    {
        $model = new MatchOrg();
        $res = $model->where($map)->find();
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛组织证件图
    public function getOrgCert($org_id)
    {
        $certlist = db('cert')->where(['match_org_id' => $org_id])->select();
        $certArr = [
            'cert' => '',
            'fr' => ['cert_no' => '', 'photo_positive' => ''],
            'other' => ''
        ];
        if ($certlist) {
            foreach ($certlist as $val) {
                switch ($val['cert_type']) {
                    // 法人
                    case 1:
                        {
                            $certArr['fr']['cert_no'] = $val['cert_no'];
                            $certArr['fr']['photo_positive'] = $val['photo_positive'];
                            break;
                        }
                    // 营业执照
                    case 4:
                        {
                            $certArr['cert'] = $val['photo_positive'];
                            break;
                        }
                    // 其他证明
                    default:
                        {
                            $certArr['other'] = $val['photo_positive'];
                        }
                }
            }
        }
        return $certArr;
    }

    // 获取会员所在联赛组织列表
    public function getMemberInMatchOrgs($memberId)
    {
        $model = new MatchOrgMember();
        $res = $model->where([
            'member_id' => $memberId,
            'status' => 1
        ])->select();

        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 保存联赛组织-会员关系数据
    public function saveMatchOrgMember($data, $condition = [])
    {
        $model = new MatchOrgMember();
        // 带更新条件更新数据
        if (!empty($condition) && is_array($condition)) {
            $res = $model->allowField(true)->save($data, $condition);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
        // 直接更新数据
        if (array_key_exists('id', $data)) {
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
        // 插入数据
        $res = $model->allowField(true)->isUpdate(false)->save($data);
        if ($res) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
        } else {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 获取联赛信息带有联赛组织
    public function getLeaugeInfoWithOrg($map)
    {
        $model = new Match();
        $res = $model->with('matchOrg')->where($map)->find();
        if (!$res) {
            return $res;
        }
        // 原始数据
        $getData = $res->getData();
        $result = $res->toArray();
        // 组合原始数据
        $result['status_num'] = $getData['status'];
        $result['type_num'] = $getData['type'];
        $result['is_finished_num'] = $getData['is_finished'];
        $result['apply_status_num'] = $getData['apply_status'];
        // 粉丝数
        $result['fans_num'] = getfansnum($result['id'], 5);
        // 比赛场次数
        $result['records_count'] = $this->getMatchRecordCount(['match_id' => $result['id']]);
        return $result;
    }

    // 获取联赛组织人员列表
    public function getMatchOrgMemberList($map, $page = 1, $order = 'id desc', $limit = 10)
    {
        $model = new MatchOrgMember();
        $res = $model->where($map)->order($order)->page($page)->limit($limit)->select();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        foreach ($result as $k => $val) {
            $result[$k]['type_num'] = $res[$k]->getData('type');
        }
        return $result;
    }

    // 获取联赛组织人员列表
    public function getMatchOrgMemberPaginator($map, $order = 'id desc', $limit = 10)
    {
        $model = new MatchOrgMember();
        $res = $model->where($map)->order($order)->paginate($limit);
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        foreach ($result['data'] as $k => $val) {
            $result['data'][$k]['type_num'] = $res[$k]->getData('type');
        }
        return $result;
    }

    // 获取联赛组织人员列表
    public function getMatchOrgMembers($map)
    {
        $model = new MatchOrgMember();
        $res = $model->where($map)->select();
        $result = $res->toArray();
        foreach ($result as $k => $val) {
            $result[$k]['type_num'] = $res[$k]->getData('type');
        }
        return $result;
    }

    // 获取联赛组织人员详情
    public function getMatchOrgMember($map)
    {
        $model = new MatchOrgMember();
        $res = $model->where($map)->find();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        $result['type_num'] = $res->getData('type');
        return $result;
    }

    // 联赛使用获取apply数据
    public function getApplyByLeague($map)
    {
        $model = new \app\model\Apply();
        $res = $model->where($map)->find();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        $result['status_num'] = $res->getData('status');
        return $result;
    }

    // 联赛使用保存apply数据
    public function saveApplyByLeague($data)
    {
        $model = new \app\model\Apply();
        // 直接更新数据
        if (array_key_exists('id', $data)) {
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $data['id']];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
        // 插入数据
        $res = $model->allowField(true)->isUpdate(false)->save($data);
        if ($res) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
        } else {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 软删除联赛组织人员
    public function delMatchOrgMember($id)
    {
        $model = new MatchOrgMember();
        return $model::destroy($id);
    }

    // ***** 联赛工作人员 *****
    // 保存联赛-工作人员关系数据
    public function saveMatchMember($data, $condition = [])
    {
        $model = new MatchMember();
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
        // 直接更新数据
        if (array_key_exists('id', $data)) {
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
        // 插入数据
        $res = $model->allowField(true)->isUpdate(false)->save($data);
        if ($res) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
        } else {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 获取联赛-工作人员详情
    public function getMatchMember($map)
    {
        $model = new MatchMember();
        $res = $model->where($map)->find();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        $result['type_text'] = $res->type_text;
        return $result;
    }

    // 获取会员的联赛工作人员角色权限
    public function getMatchMemberType($map)
    {
        $model = new MatchMember();
        $res = $model->where($map)->value('type');
        return ($res) ? $res : 0;
    }

    // 获取联赛工作人员类型内容
    public function getMatchMemberTypes()
    {
        $model = new MatchMember();
        return $model->getTypes();
    }

    // 获取联赛-工作人员列表（无分页）
    public function getMatchMembers($map, $order = 'id desc')
    {
        $model = new MatchMember();
        $res = $model->where($map)->order($order)->select();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        foreach ($result as $k => $val) {
            $result[$k]['type_text'] = $res[$k]->type_text;
        }
        return $result;
    }

    //  获取联赛-工作人员列表
    public function getMatchMemberList($map, $page = 1, $order = 'id desc', $limit = 10)
    {
        $model = new MatchMember();
        $res = $model->where($map)->order($order)->page($page)->limit($limit)->select();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        foreach ($result as $k => $val) {
            $result[$k]['type_text'] = $res[$k]->type_text;
        }
        return $result;
    }

    //  获取联赛-工作人员列表（分页）
    public function getMatchMemberPaginator($map, $order = 'id desc', $limit = 10)
    {
        $model = new MatchMember();
        $res = $model->where($map)->order($order)->paginate($limit);
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        foreach ($result['data'] as $k => $val) {
            $result['data'][$k]['type_text'] = $res[$k]->type_text;
        }
        return $result;
    }

    // 删除联赛工作人员
    public function delMatchMember($id)
    {
        $model = new MatchMember();
        return $model::destroy($id);
    }

    // ***** 联赛工作人员 end *****

    // 获取联赛球队数
    public function getMatchTeamCount($map)
    {
        $model = new MatchTeam();
        $res = $model->where($map)->count();
        return ($res) ? $res : 0;
    }

    // 获取联赛球队详情（关联比赛、球队详细）
    public function getMatchTeamInfo($map)
    {
        $model = new MatchTeam();
        $res = $model->with('team,match')->where($map)->find();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        return $result;
    }

    public function getMatchTeamInfoSimple($map)
    {
        $model = new MatchTeam();
        $res = $model->where($map)->find();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        return $result;
    }

    // 获取联赛球队列表
    public function getMatchTeamList($map, $page = 1, $order = ['id' => 'desc'], $limit = 10)
    {
        $model = new MatchTeam();
        $res = $model->where($map)->order($order)->page($page)->limit($limit)->select();
        if ($res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛球队列表（页码）
    public function getMatchTeamPaginator($map, $order = ['id' => 'desc'], $limit = 10)
    {
        $model = new MatchTeam();
        $res = $model->where($map)->order($order)->paginate($limit);
        if ($res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛球队列表
    public function getMatchTeamWithTeamList($map, $page = 1, $order = ['id' => 'desc'], $limit = 10)
    {
        $model = new MatchTeam();
        $res = $model->with('team,match')->where($map)->order($order)->page($page)->limit($limit)->select();
        if ($res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛球队列表（页码）
    public function getMatchTeamWithTeamPaginator($map, $order = ['id' => 'desc'], $limit = 10)
    {
        $model = new MatchTeam();
        $res = $model->with('team,match')->where($map)->order($order)->paginate($limit);
        if ($res) {
            return $res;
        }
        return $res->toArray();
    }

    // 保存比赛球队数据
    public function saveMatchTeam($data)
    {
        $model = new MatchTeam();
        // 根据提交的参数有无id 识别执行更新/插入数据
        if (array_key_exists('id', $data)) {
            // 更新数据
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
        // 插入数据
        $res = $model->allowField(true)->save($data);
        if ($res) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
        } else {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 保存联赛分组球队数据
    public function saveMatchGroup($data)
    {
        $model = new MatchGroup();
        // 更新数据
        if (array_key_exists('id', $data)) {
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res == false) {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            }
            return $res;
        }
        // 插入数据
        $res = $model->allowField(true)->isUpdate(false)->save($data);
        if ($res == false) {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
        }
        return $model->id;
    }

    // 删除联赛分组数据
    public function deleteMatchGroup($id, $force = false)
    {
        return MatchGroup::destroy($id, $force);
    }

    // 获取联赛分组详情
    public function getMatchGroup($map)
    {
        $model = new MatchGroup();
        $res = $model->where($map)->find();
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛分组数
    public function getMatchGroupCount($map)
    {
        $model = new MatchGroup();
        $res = $model->where($map)->count();
        return ($res) ? $res : 0;
    }

    // 获取联赛分组列表（无分页）
    public function getMatchGroups($map, $order = 'id desc')
    {
        $model = new MatchGroup();
        $res = $model->where($map)->order($order)->select();
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛分组列表
    public function getMatchGroupList($map, $page = 1, $order = 'id desc', $limit = 10)
    {
        $model = new MatchGroup();
        $res = $model->where($map)->order($order)->page($page)->limit($limit)->select();
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛分组列表（页码）
    public function getMatchGroupPaginator($map, $order = 'id desc', $limit = 10)
    {
        $model = new MatchGroup();
        $res = $model->where($map)->order($order)->paginate($limit);
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 保存联赛-分组-球队数据
    public function saveMatchGroupTeam($data)
    {
        $model = new MatchGroupTeam();
        // 更新数据
        if (array_key_exists('id', $data)) {
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res == false) {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            }
            return $res;
        }
        // 插入数据
        $res = $model->allowField(true)->isUpdate(false)->save($data);
        if ($res == false) {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
        }
        return $model->id;
    }

    // 获取联赛分组球队列表（无分页）
    public function getMatchGroupTeams($map, $order = 'id desc')
    {
        $model = new MatchGroupTeam();
        $res = $model->where($map)->order($order)->select();
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 删除联赛分组球队数据
    public function deleteMatchGroupTeam($id, $force = false)
    {
        return MatchGroupTeam::destroy($id, $force);
    }

    // 获取联赛球队球员列表（无分页）
    public function getMatchTeamMembers($map, $order = 'id desc')
    {
        $model = new MatchTeamMember();
        $res = $model->where($map)->order($order)->select();
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛球队球员列表
    public function getMatchTeamMemberList($map, $page = 1, $order = 'id desc', $limit = 10)
    {
        $model = new MatchTeamMember();
        $res = $model->where($map)->order($order)->page($page)->limit($limit)->select();
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛球队球员列表（页码）
    public function getMatchTeamMemberPaginator($map, $order = 'id desc', $limit = 10)
    {
        $model = new MatchTeamMember();
        $res = $model->where($map)->order($order)->paginate($limit);
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛球队球员详情
    public function getMatchTeamMember($map)
    {
        $model = new MatchTeamMember();
        $res = $model->where($map)->find();
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 批量保存联赛参赛球队球员数据
    public function saveAllMatchTeamMember($data)
    {
        $model = new MatchTeamMember();
        $res = $model->allowField(true)->saveAll($data);
        return $res;
    }

    // 保存联赛参赛球队球员数据
    public function saveMatchTeamMember($data, $condi = [])
    {
        $model = new MatchTeamMember();
        if (!empty($condi) && is_array($condi)) {
            // 带更新条件更新数据
            $res = $model->allowField(true)->isUpdate(true)->save($data, $condi);
            if ($res === false) {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            }
            return $res;
        }
        // 更新数据
        if (array_key_exists('id', $data)) {
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res === false) {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            }
            return $res;
        }
        // 插入数据
        $res = $model->allowField(true)->isUpdate(false)->save($data);
        if ($res === false) {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
        }
        return $model->id;
    }

    // 删除联赛参赛球队球员数据 $force 是否强制删除
    public function delMatchTeamMember($data, $force = false)
    {
        return MatchTeamMember::destroy($data, $force);
    }

    // 保存联赛赛程
    public function saveMatchSchedule($data, $condi = [])
    {
        $model = new MatchSchedule();
        if (!empty($condi) && is_array($condi)) {
            // 带更新条件更新数据
            $res = $model->allowField(true)->isUpdate(true)->save($data, $condi);
            if ($res === false) {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            }
            return $res;
        }
        // 更新数据
        if (array_key_exists('id', $data)) {
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res === false) {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            }
            return $res;
        }
        // 插入数据
        $res = $model->allowField(true)->isUpdate(false)->save($data);
        if ($res === false) {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
        }
        return $model->id;
    }

    // 批量保存联赛赛程
    public function saveAllMatchSchedule($data)
    {
        $model = new MatchSchedule();
        $res = $model->saveAll($data);
        return $res;
    }

    // 获取赛程详情
    public function getMatchSchedule($map)
    {
        $model = new MatchSchedule();
        $res = $model->where($map)->find();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        $result['match_timestamp'] = $res->getData('match_time');
        // 字段json格式转换
        if ( !empty($result['scorers']) && !is_null( json_decode( $result['scorers'] ) ) ) {
            $result['scorers_list'] = json_decode($result['scorers'], true);
        } else {
            $result['scorers_list'] = [];
        }
        if ( !empty($result['custom_member']) && !is_null( json_decode( $result['custom_member'] ) ) ) {
            $result['custom_member_list'] = json_decode($result['custom_member'], true);
        } else {
            $result['custom_member_list'] = [];
        }
        return $result;
    }

    // 获取赛程列表
    public function getMatchSchedules($map, $order = 'id desc')
    {
        $model = new MatchSchedule();
        $res = $model->where($map)->order($order)->select();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        foreach ($result as $k => $val) {
            $result[$k]['match_timestamp'] = $res[$k]->getData('match_time');
        }
        return $result;
    }

    // 获取赛程列表
    public function getMatchScheduleList($map, $page = 1, $order = 'id desc', $limit = 10)
    {
        $model = new MatchSchedule();
        $res = $model->where($map)->order($order)->page($page)->limit($limit)->select();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        foreach ($result as $k => $val) {
            $result[$k]['match_timestamp'] = $res[$k]->getData('match_time');
        }
        return $result;
    }

    // 获取赛程列表（页码）
    public function getMatchSchedulePaginator($map, $order = 'id desc', $limit = 10)
    {
        $model = new MatchSchedule();
        $res = $model->where($map)->order($order)->paginate($limit);
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        foreach ($result['data'] as $k => $val) {
            $result['data'][$k]['match_timestamp'] = $res[$k]->getData('match_time');
        }
        return $result;
    }

    // 删除赛程
    public function delMatchSchedule($data, $force = false)
    {
        return MatchSchedule::destroy($data, $force);
    }

    // 获取根据阶段分组的赛程列表
    public function getMatchScheduleListByStageAndGroup($map, $page = 1, $order = 'id desc', $limit = 10)
    {
        $stageModel = new MatchStage();
        $groupModel = new MatchGroup();
        $scheduleModel = new MatchSchedule();
        $data = [];
        $stages = $stageModel->where($map)->field(['create_time', 'update_time', 'delete_time'], true)->select();
        if (!$stages) {
            return $stages;
        }
        $stages = $stages->toArray();
        foreach ($stages as $key => $value) {
            $data[] = $value;
            // 小组赛先查询分组数据
            if ($value['type'] == 1) {
                $groups = $groupModel->where([
                    'match_id' => $value['match_id'],
                    'status' => 1
                ])
                    ->field(['create_time', 'update_time', 'delete_time'], true)
                    ->select();
                if ($groups) {
                    $groups = $groups->toArray();
                    $data[$key]['groups'] = $groups;
                    foreach ($groups as $key2 => $group) {
                        $schedules = $scheduleModel->where([
                            'match_id' => $value['match_id'],
                            'match_group_id' => $group['id'],
                            'match_stage_id' => $value['id'],
                            'status' => 1
                        ])
                            ->field(['create_time', 'update_time', 'delete_time'], true)
                            ->select();
                        if ($schedules) {
                            $data[$key]['groups'][$key2]['schedules'] = $schedules->toArray();
                        }
                    }
                }
            } else {
                $schedules = $scheduleModel->where([
                    'match_id' => $value['match_id'],
                    'match_stage_id' => $value['id'],
                    'status' => 1
                ])
                    ->field(['create_time', 'update_time', 'delete_time'], true)
                    ->select();
                if ($schedules) {
                    $data[$key]['schedules'] = $schedules->toArray();
                }
            }
        }
        return $data;
    }

    // 保存比赛阶段数据
    public function saveMatchStage($data, $condi = [])
    {
        $model = new MatchStage();
        if (!empty($condi) && is_array($condi)) {
            // 带更新条件更新数据
            $res = $model->allowField(true)->isUpdate(true)->save($data, $condi);
            if ($res === false) {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            }
            return $res;
        }
        // 更新数据
        if (array_key_exists('id', $data)) {
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res === false) {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            }
            return $res;
        }
        // 插入数据
        $res = $model->allowField(true)->isUpdate(false)->save($data);
        if ($res === false) {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
        }
        return $model->id;
    }

    // 获取比赛阶段详情
    public function getMatchStage($map)
    {
        $model = new MatchStage();
        $res = $model->where($map)->find();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        $result['type_text'] = $res->type_text;
        return $result;
    }


    // 获取比赛阶段列表
    public function getMatchStageList($map, $page = 1, $order = 'id desc', $limit = 10)
    {
        $model = new MatchStage();
        $res = $model->where($map)->order($order)->page($page)->limit($limit)->select();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        foreach ($result as $k => $val) {
            $result[$k]['type_text'] = $res[$k]->type_text;
        }
        return $result;
    }

    public function getMatchStages($map) {
        $model = new MatchStage();
        $res = $model->where($map)->select();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        foreach ($result as $k => $val) {
            $result[$k]['type_text'] = $res[$k]->type_text;
        }
        return $result;
    }

    // 获取比赛阶段列表（页码）
    public function getMatchStagePaginator($map, $order = 'id desc', $limit = 10)
    {
        $model = new MatchStage();
        $res = $model->where($map)->order($order)->paginate($limit);
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        foreach ($result['data'] as $k => $val) {
            $result['data'][$k]['type_text'] = $res[$k]->type_text;
        }
        return $result;
    }

    // 比赛阶段类型文案列表
    public function getMatchStageTypes()
    {
        $type = [
            '1' => '小组赛',
            '2' => '热身赛',
            '3' => '全明星赛',
            '4' => '淘汰赛',
            '5' => '决赛',
            '0' => '其他'
        ];
        return $type;
    }

    // 删除比赛阶段
    public function delMatchStage($data, $force = false)
    {
        return MatchStage::destroy($data, $force);
    }

    // 获取联赛积分数据
    public function getMatchRanks($map) {
        $model = new MatchRank();
        $res = $model->where($map)->select();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        return $result;
    }

    // 批量保存联赛球队积分
    public function saveAllMatchRank($data) {
        $model = new MatchRank();
        $res = $model->allowField(true)->saveAll($data);
        if ($res === false) {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
        }
        return $res;
    }

    // 比赛结果列表
    public function getMatchRecords($map, $order='id desc') {
        $model = new MatchRecord();
        $res = $model->where($map)->order($order)->select();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        foreach ($result as $key => $value) {
            $result[$key]['match_timestamp'] = $value['match_time'];
            $result[$key]['match_time'] = date('Y-m-d H:i', $value['match_time']);
        }
        return $result;
    }

    // 获取比赛成绩记录条数
    public function getMatchRecordCount($map) {
        $model = new MatchRecord();
        $res = $model->where($map)->count();
        return ($res) ? $res : 0;
    }

    // 获取球队在联赛的比赛记录条数
    public function getMatchRecordCountByTeam($map, $team_id) {
        $model = new MatchRecord();
        $res = $model
            ->where($map)
            ->where('home_team_id|away_team_id', $team_id)
            ->count();
        return ($res) ? $res : 0;
    }

    // 保存联赛文章
    public function saveArticle($data) {
        $model = new Article();
        if (!empty($condi) && is_array($condi)) {
            // 带更新条件更新数据
            $res = $model->allowField(true)->isUpdate(true)->save($data, $condi);
            if ($res === false) {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            }
            return $res;
        }
        // 更新数据
        if (array_key_exists('id', $data)) {
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res === false) {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            }
            return $res;
        }
        // 插入数据
        $res = $model->allowField(true)->isUpdate(false)->save($data);
        if ($res === false) {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
        }
        return $model->id;
    }

}