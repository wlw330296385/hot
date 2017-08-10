<?php
namespace app\service;
use app\model\Court;
use app\common\validate\CourtVal;
class CourtService {
    private $courtModel;
    public function __construct(){
        $this->courtModel = new Court;
    }
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

        return ['msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $res->toArray()];
    }

    // 场地详情
    public function getCourtOne($map=[]) {
        $res = Court::get($map);
        if (!$res)
            return [ 'msg' => __lang('MSG_201_DBNOTFOUND'), 'code' => 200 ];
        return [ 'msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $res->toArray()];
    }


    // 编辑场地
    public function updateCourt($data,$id){
        $result = $this->courtModel->validate('CourtVal')->save($data,$id);
        if($result){
            return ['code'=>100,'data'=>$result,'msg'=>__lang('MSG_101_SUCCESS')];
        }else{
            return ['code'=>200,'msg'=>$this->courtModel->getError()];
        }
    }

    // 新增场地
    public function createCourt($data){
        $result = $this->courtModel->validate('CourtVal')->save($data);
        if($result){
            return ['code'=>100,'data'=>$result,'msg'=>__lang('MSG_101_SUCCESS')];
        }else{
            return ['code'=>200,'msg'=>$this->courtModel->getError()];
        }
    }
}