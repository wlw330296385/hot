<?php
namespace app\service;


use app\model\Court;

class CourtService {
    // 场地列表
    public function getCourtAll($map=[], $order='', $field='*'){
        $res = Court::where($map)->field($field)->order($order)->select();
        if (!$res)
            return ['msg' => __lang('MSG_201_DBNOTFOUND'), 'code' => 200];

        if ($res->isEmpty())
            return ['msg' => __lang('MSG_000_NULL'), 'code' => '000', 'data' => ''];

        return ['msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $res->toArray()];
    }

    // 场地分页
    public function getCourtPage($map=[], $order='', $field='*', $paginate=0){
        $res = Court::where($map)->field($field)->order($order)->paginate($paginate);
        if (!$res)
            return ['msg' => __lang('MSG_201_DBNOTFOUND'), 'code' => 200];

        if ($res->isEmpty())
            return ['msg' => __lang('MSG_000_NULL'), 'code' => '000', 'data' => ''];

        return ['msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $res];
    }

    // 场地详情
    public function getCourtOne($map=[]) {
        $res = Court::get($map);
        if (!$res)
            return [ 'msg' => __lang('MSG_201_DBNOTFOUND'), 'code' => 200 ];
        return [ 'msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $res->toArray()];
    }
}