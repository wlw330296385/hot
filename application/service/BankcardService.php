<?php

namespace app\service;

use app\model\Bankcard;
use think\Db;
use app\common\validate\BankcardVal;
class BankcardService {
    private $BankcardModel;
    private $BankcardMemberModel;
    public function __construct(){
        $this->BankcardModel = new Bankcard;
    }


    // 获取所有银行卡
    public function getBankcardList($map=[],$page = 1,$order='',$paginate = 10) {
        $result = Bankcard::where($map)->order($order)->page($page,$paginate)->select();

        if($result){
            $res = $result->toArray();
            return $res;
        }else{
            return $result;
        }
    }

    // 分页获取银行卡
    public function getBankcardListByPage($map=[], $order='',$paginate=10){
        $result = Bankcard::where($map)->order($order)->paginate($paginate);
        if($result){
            $res =  $result->toArray();
            return $res;
        }else{
            return $result;
        }
    }

    // 软删除
    public function SoftDeleteBankcard($id) {
        $result = Bankcard::destroy($id);
        if (!$result) {
            return [ 'msg' => __lang('MSG_400'), 'code' => 100 ];
        } else {
            return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }
    }

    // 获取一个银行卡
    public function getBankcardInfo($map) {
        $result = Bankcard::where($map)->find();
        if ($result){
            $res = $result->toArray();
            return $res;
        }else{
            return $result;
        }
    }




    // 编辑银行卡
    public function updateBankcard($data,$id){
        
        $validate = validate('BankcardVal');
        if(!$validate->scene('edit')->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        
        $result = $this->BankcardModel->allowField(true)->save($data,['id'=>$id]);
        if($result){
            return ['msg' => '操作成功', 'code' => 200, 'data' => $id];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }

    // 新增银行卡
    public function createBankcard($data){
        
        
        $validate = validate('BankcardVal');
        if(!$validate->scene('add')->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        $result = $this->BankcardModel->allowField(true)->save($data);
        if($result){
            db('camp')->where(['id'=>$data['organization_id']])->setInc('total_events');
            return ['msg' => '操作成功', 'code' => 200, 'data' => $this->BankcardModel->id];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }





}

