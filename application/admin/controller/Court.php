<?php
// 场地
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\service\AuthService;
use think\Db;
use app\service\WechatService;
use app\model\Court as CourtModel;

class Court extends Backend {
    public function _initialize(){
        parent::_initialize();
    }
    // 场地管理
    public function index() {
        $court = CourtModel::order('id desc')->paginate(15);
        //dump($court);
        $breadcrumb = [ 'ptitle' => '训练营' , 'title' => '场地管理' ];
        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('list', $court);
        return $this->fetch();
    }

    // 新增场地
    public function add() {
        return view();
    }

    // 编辑场地
    public function edit() {
        $id = input('id');
        $court = CourtModel::get($id);
        //$court
        $res = $court->toArray();
        $res['status_num'] = $court->getData('status');
        if (!empty($res['cover'])) {
            $cover = unserialize($res['cover']);
            if (!empty($cover)) {
                $res['cover'] = $cover;
            }
        }
        $breadcrumb = [ 'ptitle' => '教练管理' , 'title' => '教练详细' ];
        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('court', $res);
        return view();
    }

    // 场地详情
    public function detail() {
        $id = input('id');
        $court = CourtModel::get($id);
        //$court
        $res = $court->toArray();
        $res['status_num'] = $court->getData('status');

        $breadcrumb = [ 'ptitle' => '教练管理' , 'title' => '教练详细' ];
        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('data', $res);
        return view();
    }

    // 场地审核
    public function audit() {
        if ( request()->isAjax() ) {
            $id = input('court');
            $status = input('code');

            $court = Db('court')->find($id);
            $execute = Db('court')->update([
                'id' => $court['id'],
                'status' => $status,
                'update_time' => time()
            ]);
            $Auth = new AuthService();
            if ( $execute ) {
                //if ($status) {
                    $checkstr = '场地资源被选为平台公开场地';
                    $remark = '点击进入查看详情';
                    $url = url('frontend/camp/courtlistofcamp',['camp_id' => $court['camp_id']], '', true);
                //}
                $camp = db('camp')->where(['id' => $court['camp_id']])->find();
                $memberopenid = getMemberOpenid($camp['member_id']);
                // 发送模板消息
                $sendTemplateData = [
                    'touser' => $memberopenid,
                    'template_id' => 'xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88',
                    'url' => $url,
                    'data' => [
                        'first' => ['value' => '您好,您所发布的'.$court['court'].$checkstr],
                        'keyword1' => ['value' => $checkstr],
                        'keyword2' => ['value' => date('Y年m月d日 H时i分')],
                        'remark' => ['value' => $remark]
                    ]
                ];
                $wechatS = new WechatService();
                $sendTemplateResult = $wechatS->sendTemplate($sendTemplateData);
                $log_sendTemplateData = [
                    'wxopenid' => $memberopenid,
                    'member_id' => $camp['member_id'],
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

                db('message_member')->insert([
                    'title' => $sendTemplateData['data']['first']['value'],
                    'content' => $sendTemplateData['data']['first']['value'],
                    'url' => $url,
                    'member_id' => $camp['member_id'],
                    'create_time' => time(),
                    'status' => 1
                ]);

                $doing = '场地id: '. $id .' 设为平台场地:'. $checkstr .'成功';
                $Auth->record($doing);
                $response = [ 'status' => 1, 'msg' => __lang('MSG_200'), 'goto' => url('court/index') ];
            } else {
                $doing = '场地id: '. $id .' 设为平台场地 失败';
                $Auth->record($doing);
                $response = [ 'status' => 0, 'msg' => __lang('MSG_400') ];
            }
            return json($response);
        }
    }
}