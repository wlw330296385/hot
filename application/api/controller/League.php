<?php
// 联赛api
namespace app\api\controller;
use app\service\LeagueService;
use think\Exception;

class League extends Base
{
    // 新建联赛组织
    public function creatematchorg() {
        // 检测会员登录
        if ($this->memberInfo['id'] === 0 ) {
            return json(['code' => 100, 'msg' => '请先登录或注册会员']);
        }
        // 提交参数
        $data = input('post.');
        $data['creater_member_id'] = $this->memberInfo['id'];
        $data['creater_member'] = $this->memberInfo['member'];
        $data['member_id'] = $this->memberInfo['id'];
        $data['member'] = $this->memberInfo['member'];
        // 联系电话默认会员电话
        if ( !array_key_exists('contact_tel', $data) || empty($data['contact_tel']) ) {
            $data['contact_tel'] = $this->memberInfo['telephone'];
        }
        // 保存数据
        $leagueService = new LeagueService();
        try {
            $res = $leagueService->createMatchOrg($data);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        return json($res);
    }
}