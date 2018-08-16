<?php
// 联赛service
namespace app\service;

use app\model\MatchOrg;
use app\model\MatchOrgMember;
use Think\Db;

class OrganizationService
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

    // 获取会员所在组织列表
    public function getOrganizationByMemberId($member_id)
    {
        $res = Db::query("SELECT `mo`.name, mom.* FROM 
            `match_org_member` AS mom, `match_organization` AS mo
            WHERE `mom`.match_org_id = `mo`.id AND `mom`.`member_id` = :member_id
        ", ['member_id' => $member_id]);

        if (!$res) {
            return $res;
        } else {
            return $res;
        }
    }
}