<?php
// 会员推荐分成
namespace app\api\Controller;

use app\api\controller\Base;
use app\service\RebateService;
use think\Exception;

class Rebate extends Base
{
    // 会员推荐分成列表
    public function getrebatelistpage() {
        try {
            $map = input('param.');
            $page = input('param.page', 1);
            // 默认查询当前登录会员
            if (!isset($map['member_id'])) {
                $map['member_id'] = $this->memberInfo['id'];
            }
            if (isset($map['page'])) {
                unset($map['page']);;
            }
            $rebateS = new RebateService();
            // 推荐分成列表
            $result = $rebateS->getRebatePaginator($map);
            // 推荐分成层级收入统计
            // 一级下线
            $tier1 = $rebateS->sumRebateByTier($map, 1);
            // 二级下线
            $tier2 = $rebateS->sumRebateByTier($map, 2);
            // 返回结果
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result, 'tier1' => $tier1, 'tier2' => $tier2];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_000'), 'tier1' => $tier1, 'tier2' => $tier2];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }
}