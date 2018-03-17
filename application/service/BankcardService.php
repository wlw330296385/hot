<?php
// 证件 service
namespace app\service;
use app\common\validate\BankcardVal;

use app\model\Bankcard;

class BankcardService {
    protected $BankcardModel;
    public function __construct(){
        $this->BankcardModel = new Bankcard;
    }

    public static function getBankcardInfo($map) {
        $result = $this->BankcardModel->where($map)->find();
        if($result){
            return $result->toArray();
        }else{
            return $result;
        }
    }

    public function getBankcardList($map,$page = 1,$p= 10){
       $res = Bankcard::where($map)->page($page,$p)->select();
       if($res){
           $result = $res->toArray();
           return ['code'=>200,'msg'=>'ok','data'=>$result];
       }else{
           return ['code'=>100,'msg'=>'暂无数据'];
       }
    }


    public function createBankcard($data){
        $validate = validate('BankcardVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }

        $result = $this->BankcardModel->save($data);
        if($result){
            return ['code'=>200,'msg'=>'创建成功','data'=>$result];
        }else{
            return ['code'=>100,'msg'=>'创建失败','data'=>$result];
        }

    }


    public function updateBankcard($data,$id){
        $validate = validate('BankcardVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        $result = $this->BankcardModel->save($data,['id'=>$id]);
        if($result){
            return ['code'=>200,'msg'=>'创建成功','data'=>$result];
        }else{
            return ['code'=>100,'msg'=>'创建失败','data'=>$result];
        }
    }

    
}