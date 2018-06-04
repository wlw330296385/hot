<?php

namespace app\service;

use app\model\Pool;
use app\common\validate\PoolVal;
use think\Db;
class PoolService {
    private $PoolModel;
    public function __construct(){
        $this->PoolModel = new Pool;
    }


    public function getPoolListNoPage($map){
        $result = $this->PoolModel->where($map)->select();
        return $result;
    }

    // 获取所有奖金池\擂台
    public function getPoolList($map=[],$page = 1,$order='',$paginate = 10) {
        $result = $this->PoolModel->where($map)->order($order)->page($page,$paginate)->select();

        return $result;
        
    }

    // 分页获取奖金池\擂台
    public function getPoolListByPage($map=[], $order='',$paginate=10){
        $result = $this->PoolModel->where($map)->order($order)->paginate($paginate);
        return $result;
    }

    // 软删除
    public function SoftDeletePool($id) {
        $result = $this->PoolModel->destroy($id);
        if (!$result) {
            return [ 'msg' => __lang('MSG_400'), 'code' => 100 ];
        } else {
            return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }
    }

    // 获取一个奖金池\擂台
    public function getPoolInfo($map) {
        $result = $this->PoolModel->where($map)->find();
        return $result;
    }

    
    // 生成奖金池\擂台
    public function createPool($data){
        
        $validate = validate('PoolVal');

        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        
        $result = $this->PoolModel->save($data);
        if($result){
            return ['msg' => '操作成功', 'code' => 200, 'data' => $this->PoolModel->id];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }


    // 编辑奖金池\擂台
    public function updatePool($data,$map){
        
        $validate = validate('PoolVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        
        $result = $this->PoolModel->save($data,$map);
        if($result){
            return ['msg' => '操作成功', 'code' => 200];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }

    
    
    


}

