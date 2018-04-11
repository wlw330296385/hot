<?php
// 联赛
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\model\Match;
use app\model\MatchOrg;
use app\service\LeagueService;
use app\service\MessageService;
use think\Exception;

class League extends Backend
{
    public $model;
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->model = new Match();
    }

    // 联赛列表
    public function index() {
        $map['match_org_id'] = ['<>', 0];
        $list = $this->model->where($map)->order(['status' => 'asc', 'id' => 'desc'])->paginate();

        return view('', [
            'list' => $list
        ]);
    }

    // 联赛详情
    public function detail() {
        $id = input('id', 0, 'intval');
        $leagueS = new LeagueService();
        // 联赛详情
        $matchInfo = $leagueS->getMatchWithOrg(['id' => $id]);
        // 联赛组织证件信息
        $orgCert = $leagueS->getOrgCert($matchInfo['match_org_id']);
        // 创建人身份证
        $idCard = db('cert')->where([
            'cert_type' => 1,
            'member_id' => $matchInfo['match_org']['creater_member_id'],
            'camp_id' => 0,
            'match_org_id' => 0
        ])->find();

        return view('', [
            'matchInfo' => $matchInfo,
            'orgCert' => $orgCert,
            'idCard' => $idCard
        ]);
    }

    // 审核联赛
    public function audit() {
        if (!$this->request->isPost()) {
            $this->error('请求错误');
        }
        $leagueS = new LeagueService();
        $id = input('id', 0, 'intval');
        // 审核状态
        $status = input('status', 0, 'intval');
        // 联赛详情
        $matchInfo = $leagueS->getMatchWithOrg(['id' => $id]);
        $checkstr = '审核未通过';
        if ($status == 1) {
            // 审核通过 更新数据status=1
            $checkstr = '审核已通过';
            $datetime = date('Y-m-d H:i', time());
            try {
                // 联赛
                db('match')->where('id', $matchInfo['id'])->update([
                    'status' => $status,
                    'system_remarks' => $datetime.$checkstr
                ]);
                // 联赛组织未审核 更新状态
                if ($matchInfo['match_org']['status'] == 0) {
                    // 联赛组织
                    db('match_organization')->where('id', $matchInfo['match_org_id'])->update([
                        'status' => $status
                    ]);
                    // 联赛组织证件
                    db('cert')->where(['match_org_id' => $matchInfo['match_org_id']])->update([
                        'status' => $status
                    ]);
                }
            } catch (Exception $e) {
                return json(['status' => 0, 'code' => 100, 'msg' => __lang('MSG_400') ]);
                trace('error:' . $e->getMessage() . ', \n' , 'error');
            }
            // 发送消息
            $messageS = new MessageService();
            $message = [
                'title' => '您注册的联赛'. $matchInfo['name']. $checkstr,
                'content' => '您注册的联赛'. $matchInfo['name']. $checkstr,
                'keyword1' => $checkstr,
                'keyword2' => $datetime,
                'url' => url('keeper/match/leagueManage', ['league_id' => $matchInfo['id']], '', true),
                'remark' => '点击进入',
                'steward_type' => 2,
            ];
            $messageS->sendMessageToMember($matchInfo['member_id'], $message, config('wxTemplateID.successCheck'));
        } else {
            // 审核不通过
            db('match')->where('id', $matchInfo['id'])->update([
                'system_remarks' => date('Y-m-d H:i', time()).$checkstr
            ]);
        }

        // 记录控制台日志
        $doing = '审核联赛id: '. $matchInfo['id'] .'审核操作:'. $checkstr .'成功';
        $this->AuthService->record($doing);
        // 返回结果
        $response = [ 'status' => 1, 'code' => 200, 'msg' => __lang('MSG_200') ];
        return json($response);
    }
}