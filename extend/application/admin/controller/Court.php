<?php
namespace app\admin\controller;


use app\admin\controller\base\Backend;
use app\service\CourtService;
use app\service\AuthService;
use think\Db;

class Court extends Backend {
    // 场地管理
    public function index() {
        $CourtS = new CourtService();
        $court_res = $CourtS->getCourtPage();
        if ($court_res['code'] == 200) {
            $this->error($court_res['msg']);
        }
        //dump($court_res);

        $breadcrumb = [ 'ptitle' => '训练营' , 'title' => '场地管理' ];
        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('list', $court_res['data']);
        return $this->fetch();
    }

    // 场地详情
    public function detail() {
        $id = input('id');

        $CourtS = new CourtService();
        $court_res = $CourtS->getCourtOne([ 'id' => $id ]);
        if ($court_res['code'] == 200) {
            $this->error($court_res['msg']);
        }

        $breadcrumb = [ 'ptitle' => '教练管理' , 'title' => '教练详细' ];
        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('data', $court_res['data']);
        return view();
    }

    // 场地审核
    public function audit() {
        if ( request()->isAjax() ) {
            $id = input('court');
            $status = input('code');
            $data = [
                'id' => $id,
                'status' => $status
            ];

            $execute = Db::name('court')->update($data);
            $Auth = new AuthService();
            if ( $execute ) {
                $no = '';
                if ($status == 2) {
                    $no = '不';
                }
                $doing = '审核场地id: '. $id .' 审核'. $no .'通过 成功';
                $Auth->record($doing);
                $response = [ 'status' => 1, 'msg' => __lang('MSG_100_SUCCESS'), 'goto' => url('court/index') ];
            } else {
                $doing = '审核场地id: '. $id .' 审核操作 失败';
                $Auth->record($doing);
                $response = [ 'status' => 0, 'msg' => __lang('MSG_200_ERROR') ];
            }
            return $response;
        }
    }
}