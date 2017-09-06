<?php
// 教练模块
namespace app\admin\controller;

use app\admin\controller\base\Backend;
use app\service\CoachService;
use app\service\AuthService;
use think\Db;
use think\Request;

class Coach extends Backend {
    public function index() {
        $Coach = new CoachService();
        $res = $Coach->coachListPage();
        if ($res['code'] != 200) {
            $list = $res['data'];
        }

        $breadcrumb = [ 'ptitle' => '训练营' , 'title' => '教练管理' ];
        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('list', $list);
        return $this->fetch();
    }

    public function detail() {
        $id = input('id');
        $Coach = new CoachService();
        $result = $Coach->getCoachInfo($id);
        if ($result['code'] == 100 ) {
            $coach = $result['data'];
            $coachcamp_res = $Coach->coachCamp($coach['id'], $coach['member_id']);
            if ($coachcamp_res['code'] != 200) {
                $coachcamp = $coachcamp_res['data'];
                foreach ($coachcamp as $k => $val) {
                    //dump($val['camp']);
                    $coach['_camp'] = $val['camp'] . ',';
                }
            }
            $coach['cert'] = getCert($coach['cert_id']);
            $coach['member']['cert'] = getCert($coach['member']['cert_id']);
        }

        $breadcrumb = [ 'ptitle' => '教练管理' , 'title' => '教练详细' ];
        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('coach', $coach);
        return view();
    }

    public function audit() {
        if ( request()->isAjax() ) {
            $id = input('coach');
            $status = input('code');
            $sys_remarks = input('sys_remarks');
            $data = [
                'id' => $id,
                'status' => $status,
                'remarks_admin' => $sys_remarks,
                'update_time' => time()
            ];

            $execute = Db::name('coach')->update($data);
            $Auth = new AuthService();
            if ( $execute ) {
                $no = '';
                if ($status == 2) {
                    $no = '不';
                }
                $doing = '审核教练id: '. $id .' 审核'. $no .'通过 成功';
                $Auth->record($doing);
                $response = [ 'status' => 1, 'msg' => __lang('MSG_100_SUCCESS'), 'goto' => url('coach/index') ];
            } else {
                $doing = '审核教练id: '. $id .' 审核操作 失败';
                $Auth->record($doing);
                $response = [ 'status' => 0, 'msg' => __lang('MSG_200_ERROR') ];
            }
            return $response;
        }
    }

    public function sdel() {
        $id = input('id');
        $Coach = new CoachService();
        $result = $Coach->SoftDeleteCamp($id);
        $Auth = new AuthService();
        if ( $result['code'] == 100 ) {
            $Auth->record('教练id:'. $id .' 软删除 成功');
            $this->success($result['msg'], 'coach/index');
        } else {
            $Auth->record('教练id:'. $id .' 软删除 失败');
            $this->error($result['msg']);
        }
    }

    public function edit() {
        if ( request()->isPost() ) {
            $request = Request::instance()->post();
            $id = $request['id'];
            $validate = $this->validate(
                [
                    'id' => $id,
                    '__token__' => $request['__token__']
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
                'remarks_admin' => $request['remarks_admin']
            ];
            $Coach = new CoachService();
            $res = $Coach->updateCoachStatus($data);

            $Auth = new AuthService();
            if ( $res['code'] == 100 ) {
                $Auth->record('教练id:'. $id .' 修改平台备注 成功');
                $this->success(__lang('MSG_100_SUCCESS'), 'coach/index');
            } else {
                $Auth->record('教练id:'. $id .' 修改平台备注 失败');
                $this->error(__lang('MSG_200_ERROR'));
            }
        }
    }
}