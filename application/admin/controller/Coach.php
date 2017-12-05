<?php
// 教练
namespace app\admin\controller;

use app\admin\controller\base\Backend;
use app\service\CoachService;
use app\service\AuthService;
use app\service\WechatService;
use think\Db;
use app\model\Coach as CoachModel;

class Coach extends Backend {
    public function _initialize(){
        parent::_initialize();
    }
    // 教练列表
    public function index() {
        $list = CoachModel::order('id desc')->paginate(15);

        $breadcrumb = [ 'ptitle' => '训练营' , 'title' => '教练管理' ];
        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('list', $list);
        return $this->fetch();
    }

    // 教练详情
    public function show() {
        $id = input('id');

        $coach = CoachModel::with('member')->where(['id' => $id])->find()->toArray();
        $coach['status_num'] = CoachModel::get(['id' => $id])->getData('status');
        // 教练所在训练营集合
        $coachInCamp = Db::name('camp_member')->where([ 'member_id' => $coach['member_id'], 'type' => ['in', '2,4'] ])->select();
        $coach['_incamp'] = '';
        foreach ($coachInCamp as $k => $val) {
            $coach['_incamp'] .= $val['camp'] . ',';
        }
        // 教练相关证书
        $certs = db('cert')->where(['member_id'=>$coach['member_id'],'camp_id'=>0])->select();
        foreach ($certs as $key => $value) {
            switch ( $value['cert_type'] ) {
                case '1':
                    $coach['cert']['idcert'] = $value;
                    break;
                case '3':
                    $coach['cert']['coachcert'] = $value;
            }
        }

        $breadcrumb = [ 'ptitle' => '教练管理' , 'title' => '教练详细' ];
        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('coach', $coach);
        return view();
    }

    // 教练审核
    public function audit() {
        if ( request()->isAjax() ) {
            $id = input('coach');
            $status = input('code');
            $memberid = input('member_id');
            $sys_remarks = input('sys_remarks');
            $data = [
                'id' => $id,
                'status' => $status,
                'update_time' => time(),
                'sys_remarks' => $sys_remarks
            ];
//            dump($data);die;

            $execute = Db::name('coach')->update($data);
            $Auth = new AuthService();
            if ( $execute ) {
                $memberopenid = getMemberOpenid($memberid);
                if ($status == 2) {
                    $checkstr = '审核未通过';
                    $remark = '点击进入修改完善资料';
                    $url = url('frontend/coach/updatecoach', ['openid' => $memberopenid], '', true);
                } else {
                    $checkstr = '审核已通过';
                    $remark = '点击进入平台进行操作吧';
                    $url = url('frontend/index/index', ['openid' => $memberopenid], '', true);
                }

                $sendTemplateData = [
                    'touser' => $memberopenid,
                    'template_id' => 'xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88',
                    'url' => $url,
                    'data' => [
                        'first' => ['value' => '您好,您所提交的教练员注册申请 '.$checkstr],
                        'keyword1' => ['value' => $checkstr],
                        'keyword2' => ['value' => date('Y年m月d日 H时i分')],
                        'remark' => ['value' => $remark]
                    ]
                ];
                $wechatS = new WechatService();
                $sendTemplateResult = $wechatS->sendTemplate($sendTemplateData);
                $log_sendTemplateData = [
                    'wxopenid' => $memberopenid,
                    'member_id' => $memberid,
                    'url' => $sendTemplateData['url'],
                    'content' => serialize($sendTemplateData),
                    'create_time' => time()
                ];
                if ($sendTemplateResult) {
                    $log_sendTemplateData['status'] = 1;
                } else {
                    $log_sendTemplateData['status'] = 0;
                }
                db('log_sendtemplatemsg')->insert($log_sendTemplateData);


                $doing = '审核教练id: '. $id .'审核操作:'. $checkstr .'成功';
                $Auth->record($doing);
                $response = [ 'status' => 1, 'msg' => __lang('MSG_200'), 'goto' => url('coach/index') ];
            } else {
                $doing = '审核教练id: '. $id .' 审核操作 失败';
                $Auth->record($doing);
                $response = [ 'status' => 0, 'msg' => __lang('MSG_400') ];
            }
            return $response;
        }
    }

    // 软删除教练
    public function sdel() {
        $id = input('id');
        $Coach = new CoachService();
        $result = $Coach->SoftDeleteCamp($id);

        $Auth = new AuthService();
        if ( $result['code'] == 200 ) {
            $Auth->record('教练id:'. $id .' 软删除 成功');
            $this->success($result['msg'], 'coach/index');
        } else {
            $Auth->record('教练id:'. $id .' 软删除 失败');
            $this->error($result['msg']);
        }
    }

    // 修改教练信息
    public function edit() {
        if ( request()->isPost() ) {
            $id = input('id');
            $validate = $this->validate(
                [
                    'id' => $id,
                    '__token__' => input('__token__')
                ],
                [
                    'id' => 'require',
                    '__token__' => 'token',
                ]
            );
            if ( true !== $validate ) {
                $this->error($validate);
            }
            $data = [
                'id' => $id,
                'coach_rank' => input('coach_rank'),
                'coach_year' => input('coach_year'),
                'coach_level' => input('coach_level'),
                'student_flow' => input('student_flow'),
                'lesson_flow' => input('lesson_flow'),
                'sys_remarks' => input('sys_remarks'),
                'update_time' => time()
            ];
            $execute = Db::name('coach')->update($data);


            $Auth = new AuthService();
            if ( $execute ) {
                $Auth->record('教练id:'. $id .' 修改 成功');
                $this->success(__lang('MSG_200'), 'coach/index');
            } else {
                $Auth->record('教练id:'. $id .' 修改 失败');
                $this->error(__lang('MSG_400'));
            }
        }
    }
}