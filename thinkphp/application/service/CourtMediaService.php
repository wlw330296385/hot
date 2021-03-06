<?php
namespace app\service;
use app\model\CourtMedia;
class CourtMediaService {
    private $CourtMediaModel;
    public function __construct(){
        $this->CourtMediaModel = new CourtMedia;
    }
    // 场地列表
    // public function getCourtMediaList($map=[], $order='', $field='*'){
    //     $result = CourtMedia::where($map)->whereOr(['status'=>1])->field($field)->order($order)->select();
    //     if($result){           
    //         $result = $result->toArray();
    //     }
    //     return $result;
    // }

    // 场地分页
    public function getCourtMediaList($map=[], $order='', $field='*', $paginate=10){
        $result = CourtMedia::where($map)->field($field)->order($order)->paginate($paginate)->toArray();
        if($result){           
            $result = $result['data'];
        }
        return $result;
    }

    // 场地详情
    public function getCourtMediaInfo($map=[]) {
        $result = CourtMedia::get($map);
        if($result){           
            $result = $result->toArray();
        }
        return $result;
    }


    // 编辑场地
    public function updateCourtMedia($data,$id){
        $result = $this->CourtMediaModel->validate('CourtMediaVal')->save($data,$id);
        if($result){
            return ['code'=>100,'data'=>$result,'msg'=>__lang('MSG_101_SUCCESS')];
        }else{
            return ['code'=>200,'msg'=>$this->CourtMediaModel->getError()];
        }
    }

    // 新增场地
    public function createCourtMedia($data){
        $result = $this->CourtMediaModel->validate('CourtMediaVal')->save($data);
        if($result){
            return ['code'=>100,'data'=>$result,'msg'=>__lang('MSG_101_SUCCESS')];
        }else{
            return ['code'=>200,'msg'=>$this->CourtMediaModel->getError()];
        }
    }
}