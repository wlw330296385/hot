<?php
// banner管理
namespace app\admin\controller;


use app\admin\controller\base\Backend;
use app\service\BannerService;

class Banner extends Backend
{
    public $model;
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->model = new \app\model\Banner();
    }

    // banner列表
    public function index() {
        $bannerList = $this->model->order(['ord' => 'desc', 'id' => 'desc'])->paginate();

        return view('banner/index', [
            'bannerList' => $bannerList
        ]);
    }

    // 添加新banner
    public function add() {
        if ($this->request->isPost()) {
            $data = input('post.');
            if (empty($data['url'])) {
                $this->error('请上传图片');
            }
            if (empty($data['steward_type'])) {
                $this->error('请选择管家类型');
            }
            $bannerS = new BannerService();
            $result = $bannerS->saveBanner($data);
            if ($result['code'] == 200) {
                $this->record('添加banner 成功');
                $this->success(__lang('MSG_200'), 'banner/index');
            } else {
                $this->record('添加banner 失败');
                $this->error(__lang('MSG_400'));
            }
        } else {
            return view('banner/add');
        }
    }

    // banner编辑详情页
    public function edit() {
        if ($this->request->isPost()) {
            $data = input('post.');
            if (empty($data['url'])) {
                $this->error('请上传图片');
            }
            if (empty($data['steward_type'])) {
                $this->error('请选择管家类型');
            }
            $bannerS = new BannerService();
            $result = $bannerS->saveBanner($data);
            if ($result['code'] == 200) {
                $this->record('修改banner 成功');
                $this->success(__lang('MSG_200'), 'banner/index');
            } else {
                $this->record('修改banner 失败');
                $this->error(__lang('MSG_400'));
            }
        } else {
            $id = input('param.id');
            $bannerInfo = $this->model->where('id', $id)->find();
            return view('banner/edit', [
                'bannerInfo' => $bannerInfo
            ]);
        }
    }

    // 软删除banner
    public function delete() {
        $id = input('id');
        if (!$id) {
            $this->error(__lang('MSG_402'));
        }
        $bannerInfo = $this->model->where('id', $id)->find();
        if (!$bannerInfo) {
            $this->error(__lang('MSG_404'));
        }
        if ($bannerInfo['status'] == 1) {
            $this->error('请先下架此banner');
        }
        $res = \app\model\Banner::destroy($bannerInfo['id']);
        if ($res) {
            $this->record('软删除banner 成功');
            $this->success(__lang('MSG_200'), 'banner/index');
        } else {
            $this->record('软删除banner 失败');
            $this->error(__lang('MSG_400'));
        }
    }
}