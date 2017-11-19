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
    public function getCourtList($map=[],$page = 1,$paginate = 10, $order='', $field='*'){
        $result = Court::where($map)->field($field)->order($order)->page($page,$paginate)->select();
        if($result){           
            $result = $result->toArray();
        }
        return $result;
    }

    // 场地分页
    public function getCourtListbyPage($map=[], $order='', $field='*', $paginate=10){
        $result = Court::where($map)->field($field)->order($order)->paginate($paginate);
        if($result){           
            $result = $result->toArray();
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
        $validate = validate('CourtVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        $result = $this->courtModel->save($data,['id'=>$id]);
        if($result){
            return ['code'=>100,'data'=>$result,'msg'=>__lang('MSG_101_SUCCESS')];
        }else{
            return ['code'=>200,'msg'=>$this->courtModel->getError()];
        }
    }

    // 新增场地
    public function createCourt($data){
        $validate = validate('CourtVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        $result = $this->courtModel->save($data);
        if($result){
            return ['code'=>100,'data'=>$result,'msg'=>__lang('MSG_101_SUCCESS')];
        }else{
            return ['code'=>200,'msg'=>$this->courtModel->getError()];
        }
    }
}