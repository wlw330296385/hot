<?php
// banner service
namespace app\service;


use app\model\Banner;

class BannerService
{
    public $model;
    public function __construct()
    {
        $this->model = new Banner();
    }

    // 获取banner列表
    public function bannerList($map=[], $order=['ord' => 'desc', 'id' => 'desc'], $size=10) {
        $res = $this->model->where($map)->order($order)->limit($size)->select();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        return $result;
    }

    // 保存banner数据
    public function saveBanner($data=[], $condition=[]) {
        // 带更新条件更新数据
        if (!empty($condition)) {
            $res = $this->model->allowField(true)->save($data, $condition);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
        // 直接更新数据（需要传入id）
        if (isset($data['id'])) {
            $res = $this->model->allowField(true)->isUpdate(true)->save($data);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
        // 新增数据
        $res = $this->model->allowField(true)->save($data);
        if ($res) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $this->model->id];
        } else {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }
}