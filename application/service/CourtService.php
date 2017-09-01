<?php
namespace app\service;
use app\model\Court;
use app\common\validate\CourtVal;
use think\Db;
class CourtService {
    private $courtModel;
    public function __construct(){
        $this->courtModel = new Court;
    }
    // 场地列表
    public function getCourtList($map=[], $order='', $field='*'){
        $result = Court::where($map)->field($field)->limit(10)->order($order)->select();
        if($result){           
            $result = $result->toArray();
        }
        return $result;
    }

    // 场地分页
    public function getCourtPage($map=[], $order='', $field='*', $paginate=10){
        $result = Court::where($map)->field($field)->order($order)->paginate($paginate)->toArray();
        if($result){           
            $result = $result['data'];
        }
        return $result;
    }

    // 场地详情
    public function getCourtInfo($map=[]) {
        $result = Court::get($map);
        if($result){           
            $result = $result->toArray();
        }
        return $result;
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