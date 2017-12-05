<?php
// 系统设置
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\service\SystemService;
use app\service\AuthService;

class System extends Backend {
    public function _initialize(){
        parent::_initialize();
    }
    public function index(){
        $o_id = input('param.o_id',0);
        $o_type = input('param.o_type',0);
        $banner = db('banner')->where(['organization_id'=>$o_id,'organization_type'=>$o_type])->order('ord asc')->limit(3)->select();

        $this->assign('banner', $banner);
        return view('System/index');
    }

    // 设置平台信息
    public function editinfo() {
        if ( request()->isPost() ) {
            $id = input('id');
            $data = [
                'sitename' => input('sitename'),
                'title' => input('title'),
                'keywords' => input('keywords'),
                'description' => input('description'),
                'footer' => input('footer')
            ];
            $result = db('setting')->where('id', $id)->update($data);

            $AuthS = new AuthService();
            if ($result) {
                $AuthS->record('修改平台信息 成功');
                $this->success(__lang('MSG_200'));
            } else {
                $AuthS->record('修改平台信息 失败');
                $this->error(__lang('MSG_400'));
            }
        }
    }

    // 平台banner
    public function editbanner() {
        if ( request()->isPost() ) {
            $data = input('post.');
            $bannerModel = new \app\model\Banner;
            if($data['id']){
                $id = $data['id'];
                unset($data['id']);
                $result = $bannerModel->save($data,['id'=>$id]);
            }else{
                $result = $bannerModel->save($data);
            }
            
            $AuthS = new AuthService();
            if ($result) {
                $AuthS->record('修改平台banner 成功');
                $this->success(__lang('MSG_200'));
            } else {
                $AuthS->record('修改平台banner 失败');
                $this->error(__lang('MSG_400'));
            }
        }
    }

    // 会员积分设置
    public function editscore() {
        if ( request()->isPost() ) {
            $id = input('id');
            $data = [
                'memberlevel1' => input('memberlevel1'),
                'memberlevel2' => input('memberlevel2'),
                'memberlevel3' => input('memberlevel3'),
                'coachlevel1' => input('coachlevel1'),
                'coachlevel2' => input('coachlevel2'),
                'coachlevel3' => input('coachlevel3'),
                'coachlevel1award' => input('coachlevel1award'),
                'coachlevel2award' => input('coachlevel2award'),
                'lrss' => input('lrss'),
                'lrcs' => input('lrcs'),
                'rebate' => input('rebate/f')/100,
                'sysrebate' => input('sysrebate/f')/100,
                'starrebate' => input('starrebate/f')/100
            ];
            //dump($data);
            $result = db('setting')->where('id', $id)->update($data);

            $AuthS = new AuthService();
            if ($result) {
                $AuthS->record('修改会员积分设置 成功');
                $this->success(__lang('MSG_200'));
            } else {
                $AuthS->record('修改会员积分设置 失败');
                $this->error(__lang('MSG_400'));
            }
        }
    }
}