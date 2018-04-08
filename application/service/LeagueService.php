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
        if (!$validate->scene('add')->check($data)) {
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
}