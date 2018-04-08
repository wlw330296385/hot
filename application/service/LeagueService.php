<?php
// 联赛service
namespace app\service;


use app\model\MatchOrg;

class LeagueService
{
    // 创建联赛组织
    public function createMatchOrg($data) {
        $model = new MatchOrg();
        // 验证数据
        $validate = validate('MatchOrgVal');
        if (!$validate->scene('message')->check($data)) {
            return ['code' => 100, 'msg' => $validate->getError()];
        }
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
}