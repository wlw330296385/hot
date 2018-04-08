<?php
// 联赛api
namespace app\api\controller;
use app\service\CertService;
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
                    'match_org_id' => $id,
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
}