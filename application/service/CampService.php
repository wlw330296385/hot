<?php
namespace app\service;
use app\model\Camp;
use app\validate\CampVal;
class CampService {

    public $Camp;
    public function __construct()
    {
        $this->Camp = new Camp();
    }

    public function CampList($map=[], $order='') {
        $res = $this->Camp->where($map)->order($order)->select()->toArray();
        return $res;
    }

    public function campListPage($paginate=0, $map=[], $order=''){
        $res = $this->Camp->where($map)->order($order)->paginate($paginate);
        return $res;
    }

    /**
     * 读取资源
     */
    public function CampOneById($id) {
        $res = $this->Camp->get($id)->toArray();
        if (!$res) return false;
        
        return $res;
    }

    /**
     * 更新资源
     */
    public function UpdateCamp($data) {
        $res = $this->Camp->validate('CampVal')->update($data);
        if($res === false){
            return ['msg'=>$this->Camp->getError(),'code'=>'200'];
        }else{
            return ['data'=>$res,'msg'=>__lang('MSG_100_SUCCESS'),'code'=>'100'];
        }
    }

    public function SoftDeleteCamp($id) {
        $res = $this->Camp->destroy($id);
        return $res;
    }

    /**
     * 创建资源
     */
    public function createCamp($request){
        // 一个人只能创建一个训练营
        $res = $this->Camp->validate('CampVal')->save($request);
        if($res === false){
            return ['msg'=>$this->Camp->getError(),'code'=>'200'];
        }else{
            return ['data'=>$res,'msg'=>__lang('MSG_100_SUCCESS'),'code'=>'100'];
        }
    }
}