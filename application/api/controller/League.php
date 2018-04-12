<?php
// 联赛api
namespace app\api\controller;
use app\service\CertService;
use app\service\LeagueService;
use app\service\MatchService;
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
            // 创建联赛组织成功
            if ($res['code'] == 200) {
                $matchOrgId = $res['data'];
                // 保存联赛组织-会员关系数据
                $leagueService->saveMatchOrgMember([
                    'match_org_id' => $matchOrgId,
                    'match_org' => $data['name'],
                    'match_org_logo' => $data['logo'],
                    'member_id' => $this->memberInfo['id'],
                    'member' => $this->memberInfo['member'],
                    'member_avatar' => $this->memberInfo['avatar'],
                    'status' => 1
                ]);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        return json($res);
    }

    // 修改联系组织
    public function editmatchorg() {
        // 提交参数
        $data = input('post.');
        // 获取联赛组织信息
        $id = input('post.id', 0, 'intval');
        if (!$id) {
            return json(['code' => 100, 'msg' => __lang('MSG_402')]);
        }
        $leagueService = new LeagueService();
        $matchOrgInfo = $leagueService->getMatchOrg(['id' => $id]);
        if (!$matchOrgInfo) {
            return json(['code' => 100, 'msg' => __lang('MSG_404')]);
        }
        // 检测会员登录
        if ($this->memberInfo['id'] === 0 ) {
            return json(['code' => 100, 'msg' => '请先登录或注册会员']);
        }
        // 操作会员发生更新
        if ($this->memberInfo['id'] != $matchOrgInfo['member_id']) {
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
        }

        try {
            // 保存证件信息
            $certS = new CertService();
            // 营业执照
            if ( input('?post.cert') ) {
                $cert1 = $certS->saveCert([
                    'photo_positive' => $data['cert'],
                    'member_id' => 0,
                    'match_org_id' => $id,
                    'cert_type' => 4
                ]);
                if ($cert1['code'] != 200) {
                    return ['code' => 100, 'msg' => '营业执照保存失败,请重试'];
                }
            }
            // 法人
            if ( input('?post.fr_idno') || input('?post.fr_idcard') ) {
                $cert2 = $certS->saveCert([
                    'match_org_id' => $id,
                    'member_id' => 0,
                    'cert_type' => 1,
                    'cert_no' => input('post.fr_idno'),
                    'photo_positive' => input('post.fr_idcard')
                ]);
                if ($cert2['code'] != 200) {
                    return ['code' => 100, 'msg' => '法人信息保存失败,请重试'];
                }
            }
            // 创建人
            if ( input('?post.cjz_idno') || input('?post.cjz_idcard') ) {
                $cert3 = $certS->saveCert([
                    'member_id' => $this->memberInfo['id'],
                    'cert_type' => 1,
                    'cert_no' => input('post.cjz_idno'),
                    'photo_positive' => input('post.cjz_idcard')
                ]);
                if ($cert3['code'] != 200) {
                    return ['code' => 100, 'msg' => '创建人信息保存失败'];
                }
            }
            // 其他证明
            if ( input('?post.other_cert') ) {
                $cert4 = $certS->saveCert([
                    'match_org_id' => $id,
                    'member_id' => 0,
                    'cert_type' => 0,
                    'photo_positive' => input('post.other_cert')
                ]);
                if ($cert4['code'] != 200) {
                    return ['code' => 100, 'msg' => '其他证明保存失败'];
                }
            }

            // 更新联赛组织数据
            $resUpdateMatchOrg = $leagueService->updateMatchOrg($data);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        return json($resUpdateMatchOrg);
    }

    // 创建联赛信息
    public function creatematch() {
        // 接收输入变量
        $data = input('post.');
        $data['member_id'] = $this->memberInfo['id'];
        $data['member'] = $this->memberInfo['member'];
        $data['member_avatar'] = $this->memberInfo['avatar'];
        // 时间字段格式转化
        $newTime = time();
        if ( array_key_exists('start_time', $data) ) {
            $data['start_time'] = empty($data['start_time']) ? 0 : strtotime($data['start_time']);
            if ( $data['start_time'] != 0 && $newTime > $data['start_time'] ) {
                return json(['code' => 100, 'msg' => '开始时间必须大于当前时间']);
            }
        }
        if ( array_key_exists('end_time', $data) ) {
            $data['end_time'] = empty($data['end_time']) ? 0 : strtotime($data['end_time']);
            if ( $data['end_time'] != 0 && $newTime > $data['end_time'] ) {
                return json(['code' => 100, 'msg' => '结束时间必须大于当前时间']);
            }
        }
        if ( isset($data['start_time']) && isset($data['end_time']) ) {
            if ($data['end_time'] <= $data['start_time']) {
                return json(['code' => 100, 'msg' => '结束时间必须大于开始时间']);
            }
        }

        // 创建联赛 status=0 待审核
        $data['status'] = 0;
        $matchS = new MatchService();
        $leagueS = new LeagueService();
        try {
            // 保存联赛信息
            $res = $matchS->saveMatch($data, 'league_add');
            if ($res['code'] == 200) {
                $matchId = $res['data'];
                // 保存联赛-工作人员关系数据
                $leagueS->saveMatchMember([
                    'match_id' => $matchId,
                    'match' => $data['name'],
                    'match_logo' => $data['logo'],
                    'member_id' => $this->memberInfo['id'],
                    'member' => $this->memberInfo['member'],
                    'member_avatar' => $this->memberInfo['avatar'],
                    'type' => 10,
                    'status' => 1
                ]);
            }
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        return json($res);
    }

    // 编辑联赛信息
    public function updatematch() {
        // 检测会员登录
        if ($this->memberInfo['id'] === 0 ) {
            return json(['code' => 100, 'msg' => '请先登录或注册会员']);
        }
        // 接收输入变量
        $data = input('post.');
        $newTime = time();
        if ( array_key_exists('start_time', $data) ) {
            $data['start_time'] = empty($data['start_time']) ? 0 : strtotime($data['start_time']);
            if ( $data['start_time'] != 0 && $newTime > $data['start_time'] ) {
                return json(['code' => 100, 'msg' => '开始时间必须大于当前时间']);
            }
        }
        if ( array_key_exists('end_time', $data) ) {
            $data['end_time'] = empty($data['end_time']) ? 0 : strtotime($data['end_time']);
            if ( $data['end_time'] != 0 && $newTime > $data['end_time'] ) {
                return json(['code' => 100, 'msg' => '结束时间必须大于当前时间']);
            }
        }
        if ( isset($data['start_time']) && isset($data['end_time']) ) {
            if ($data['end_time'] <= $data['start_time']) {
                return json(['code' => 100, 'msg' => '结束时间必须大于开始时间']);
            }
        }

        $matchS = new MatchService();
        try {
            // 保存联赛信息
            $res = $matchS->saveMatch($data, 'league_edit');
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
        return json($res);
    }
}