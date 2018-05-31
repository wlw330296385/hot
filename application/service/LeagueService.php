<?php
// 联赛service
namespace app\service;


use app\model\Match;
use app\model\MatchGroup;
use app\model\MatchGroupTeam;
use app\model\MatchMember;
use app\model\MatchOrg;
use app\model\MatchOrgMember;
use app\model\MatchTeam;
use app\model\MatchTeamMember;

class LeagueService
{
    // 创建联赛组织
    public function createMatchOrg($data) {
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
    public function updateMatchOrg($data, $condition=[]) {
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
    public function getMatchOrg($map) {
        $model = new MatchOrg();
        $res = $model->where($map)->find();
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛组织证件图
    public function getOrgCert($org_id) {
        $certlist = db('cert')->where(['match_org_id' => $org_id])->select();
        $certArr = [
            'cert' => '',
            'fr' => ['cert_no' => '', 'photo_positive' => ''],
            'other' => ''
        ];
        if ($certlist) {
            foreach ($certlist as $val) {
                switch ( $val['cert_type'] ) {
                    // 法人
                    case 1: {
                        $certArr['fr']['cert_no'] = $val['cert_no'];
                        $certArr['fr']['photo_positive'] = $val['photo_positive'];
                        break;
                    }
                    // 营业执照
                    case 4: {
                        $certArr['cert'] = $val['photo_positive'];
                        break;
                    }
                    // 其他证明
                    default: {
                        $certArr['other'] = $val['photo_positive'];
                    }
                }
            }
        }
        return $certArr;
    }

    // 获取会员所在联赛组织列表
    public function getMemberInMatchOrgs($memberId) {
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
    public function saveMatchOrgMember($data, $condition=[]) {
        $model = new MatchOrgMember();
        // 带更新条件更新数据
        if ( !empty($condition) && is_array($condition) ) {
            $res = $model->allowField(true)->save($data, $condition);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
        // 直接更新数据
        if ( array_key_exists('id', $data) ) {
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
        if ($res ) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
        } else {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 获取联赛信息带有联赛组织
    public function getMatchWithOrg($map) {
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
        // 粉丝数
        $result['fans_num'] = getfansnum($result['id'], 5);
        return $result;
    }

    // 获取联赛组织人员列表
    public function getMatchOrgMemberList($map, $page=1, $order='id desc', $limit=10) {
        $model = new MatchOrgMember();
        $res = $model->where($map)->order($order)->page($page)->limit($limit)->select();
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛组织人员列表
    public function getMatchOrgMemberPaginator($map, $order='id desc', $limit=10) {
        $model = new MatchOrgMember();
        $res = $model->where($map)->order($order)->paginate($limit);
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛组织人员列表
    public function getMatchOrgMembers($map) {
        $model = new MatchOrgMember();
        $res = $model->where($map)->select();
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛组织人员详情
    public function getMatchOrgMember($map) {
        $model = new MatchOrgMember();
        $res = $model->where($map)->find();
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 保存联赛-工作人员关系数据
    public function saveMatchMember($data, $condition=[]) {
        $model = new MatchMember();
        // 带更新条件更新数据
        if ( !empty($condition) ) {
            $res = $model->allowField(true)->save($data, $condition);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
        // 直接更新数据
        if ( array_key_exists('id', $data) ) {
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
        if ($res ) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
        } else {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 获取联赛-工作人员详情
    public function getMatchMember($map) {
        $model = new MatchMember();
        $res = $model->where($map)->find();
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取会员的联赛工作人员角色权限
    public function getMatchMemberType($map) {
        $model = new MatchMember();
        $res = $model->where($map)->value('type');
        return ($res) ? $res : 0;
    }

    // 获取联赛球队数
    public function getMatchTeamCount($map) {
        $model = new MatchTeam();
        $res = $model->where($map)->count();
        return ($res) ? $res : 0;
    }

    // 获取联赛球队详情（关联比赛、球队详细）
    public function getMatchTeamInfo($map) {
        $model = new MatchTeam();
        $res = $model->with('team,match')->where($map)->find();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        return $result;
    }

    public function getMatchTeamInfoSimple($map) {
        $model = new MatchTeam();
        $res = $model->where($map)->find();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        return $result;
    }

    // 获取联赛球队列表
    public function getMatchTeamList($map, $page=1, $order=['id' => 'desc'], $limit = 10) {
        $model = new MatchTeam();
        $res = $model->where($map)->order($order)->page($page)->limit($limit)->select();
        if ($res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛球队列表（页码）
    public function getMatchTeamPaginator($map,  $order=['id' => 'desc'], $limit = 10) {
        $model = new MatchTeam();
        $res = $model->where($map)->order($order)->paginate($limit);
        if ($res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛球队列表
    public function getMatchTeamWithTeamList($map, $page=1, $order=['id' => 'desc'], $limit = 10) {
        $model = new MatchTeam();
        $res = $model->with('team,match')->where($map)->order($order)->page($page)->limit($limit)->select();
        if ($res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛球队列表（页码）
    public function getMatchTeamWithTeamPaginator($map,  $order=['id' => 'desc'], $limit = 10) {
        $model = new MatchTeam();
        $res = $model->with('team,match')->where($map)->order($order)->paginate($limit);
        if ($res) {
            return $res;
        }
        return $res->toArray();
    }

    // 保存比赛球队数据
    public function saveMatchTeam($data) {
        $model = new MatchTeam();
        // 根据提交的参数有无id 识别执行更新/插入数据
        if ( array_key_exists('id', $data) ) {
            // 更新数据
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
        // 插入数据
        $res = $model->allowField(true)->save($data);
        if ($res) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
        } else {
            trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 保存联赛分组球队数据
    public function saveMatchGroup($data) {
        $model = new MatchGroup();
        // 更新数据
        if (array_key_exists('id', $data)) {
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res == false) {
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
            }
            return $res;
        }
        // 插入数据
        $res = $model->allowField(true)->isUpdate(false)->save($data);
        if ($res == false) {
            trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
        }
        return $model->id;
    }

    // 获取联赛分组详情
    public function getMatchGroup($map) {
        $model = new MatchGroup();
        $res = $model->where($map)->find();
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛分组数
    public function getMatchGroupCount($map) {
        $model = new MatchGroup();
        $res = $model->where($map)->count();
        return ($res) ? $res : 0;
    }

    // 获取联赛分组列表（无分页）
    public function getMatchGroups($map, $order='id desc') {
        $model = new MatchGroup();
        $res = $model->where($map)->order($order)->select();
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛分组列表
    public function getMatchGroupList($map, $page=1, $order='id desc', $limit=10) {
        $model = new MatchGroup();
        $res = $model->where($map)->order($order)->page($page)->limit($limit)->select();
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛分组列表（页码）
    public function getMatchGroupPaginator($map, $order='id desc', $limit=10) {
        $model = new MatchGroup();
        $res = $model->where($map)->order($order)->paginate($limit);
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 保存联赛-分组-球队数据
    public function saveMatchGroupTeam($data) {
        $model = new MatchGroupTeam();
        // 更新数据
        if (array_key_exists('id', $data)) {
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res == false) {
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
            }
            return $res;
        }
        // 插入数据
        $res = $model->allowField(true)->isUpdate(false)->save($data);
        if ($res == false) {
            trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
        }
        return $model->id;
    }

    // 获取联赛分组球队列表（无分页）
    public function getMatchGroupTeams($map, $order='id desc') {
        $model = new MatchGroupTeam();
        $res = $model->where($map)->order($order)->select();
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛球队球员列表（无分页）
    public function getMatchTeamMembers($map, $order='id desc') {
        $model = new MatchTeamMember();
        $res = $model->where($map)->order($order)->select();
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛球队球员列表
    public function getMatchTeamMemberList($map, $page=1, $order='id desc', $limit=10) {
        $model = new MatchTeamMember();
        $res = $model->where($map)->order($order)->page($page)->limit($limit)->select();
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛球队球员列表（页码）
    public function getMatchTeamMemberPaginator($map, $order='id desc', $limit=10) {
        $model = new MatchTeamMember();
        $res = $model->where($map)->order($order)->paginate($limit);
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 获取联赛球队球员详情
    public function getMatchTeamMember($map) {
        $model = new MatchTeamMember();
        $res = $model->where($map)->find();
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 批量保存联赛参赛球队球员数据
    public function saveAllMatchTeamMember($data) {
        $model = new MatchTeamMember();
        $res = $model->allowField(true)->saveAll($data);
        return $res;
    }

    // 保存联赛参赛球队球员数据
    public function saveMatchTeamMember($data, $condi=[]) {
        $model = new MatchTeamMember();
        if ( !empty($condi) && is_array($condi) ) {
            // 带更新条件更新数据
            $res = $model->allowField(true)->isUpdate(true)->save($data, $condi);
            if ($res === false) {
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
            }
            return $res;
        }
        // 更新数据
        if ( array_key_exists('id', $data) ) {
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res === false) {
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
            }
            return $res;
        }
        // 插入数据
        $res = $model->allowField(true)->isUpdate(false)->save($data);
        if ($res === false) {
            trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
        }
        return $model->id;
    }

    // 删除联赛参赛球队球员数据 $force 是否强制删除
    public function delMatchTeamMember($data, $force=false) {
        return MatchTeamMember::destroy($data, $force);
    }
}