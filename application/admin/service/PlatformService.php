<?php

namespace app\admin\service;

use app\admin\model\Platform;
use think\Db;
class PlatformService {
    private $PlatformModel;
    public function __construct(){
        $this->PlatformModel = new Platform;
    }


    // 获取所有模板
    public function getPlatformList($map=[],$page = 1,$order='',$paginate = 10) {
        $result = $this->PlatformModel->where($map)->order($order)->page($page,$paginate)->select();

        return $result;
    }

    // 分页获取模板
    public function getPlatformListByPage($map=[], $order='',$paginate=10){

        $result = $this->PlatformModel->where($map)->order($order)->paginate($paginate);
        return $result;
    }

    // 软删除
    public function SoftDeletePlatform($id) {
        $result = $this->PlatformModel->destroy($id);
        if (!$result) {
            return [ 'msg' => __lang('MSG_400'), 'code' => 100 ];
        } else {
            return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }
    }

    // 获取一个模板
    public function getPlatformInfo($map) {
        $result = $this->PlatformModel->where($map)->find();
        return $result;
    }




    // 编辑模板
    public function updatePlatform($data,$map){
        
        
        $result = $this->PlatformModel->save($data,$map);
        if($result){
            return ['msg' => '操作成功', 'code' => 200, 'data' => $map];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }

    // 新增模板
    public function createPlatform($data){
        $result = $this->PlatformModel->save($data);
        if($result){
            return ['msg' => '操作成功', 'code' => 200, 'data' => $this->PlatformModel->id];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }
   
}

