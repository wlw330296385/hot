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
    public function getCourtMediaList($map=[], $order='', $field='*',$page=1, $paginate=10){
        $result = CourtMedia::where($map)->field($field)->order($order)->page($page,$paginate)->select();
        if($result){           
            $result = $result;
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


    // 编辑场地图片
    public function updateCourtMedia($data,$id){

        $result = $this->CourtMediaModel->save($data,['id'=>$id]);
        if($result){
            return ['code'=>200,'data'=>$result,'msg'=>__lang('MSG_200')];
        }else{
            return ['code'=>100,'msg'=>$this->CourtMediaModel->getError()];
        }
    }

    // 新增场地
    public function createCourtMedia($data){
        $result = $this->CourtMediaModel->save($data);
        if($result){
            return ['code'=>200,'data'=>$result,'msg'=>__lang('MSG_200')];
        }else{
            return ['code'=>100,'msg'=>$this->CourtMediaModel->getError()];
        }
    }
}