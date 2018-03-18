<?php
<<<<<<< HEAD
// 证件 service
namespace app\service;
use app\common\validate\BankcardVal;

use app\model\Bankcard;

class BankcardService {
    protected $BankcardModel;
=======

namespace app\service;

use app\model\Bankcard;
use think\Db;
use app\common\validate\BankcardVal;
class BankcardService {
    private $BankcardModel;
    private $BankcardMemberModel;
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
    public function __construct(){
        $this->BankcardModel = new Bankcard;
    }

<<<<<<< HEAD
    public static function getBankcardInfo($map) {
        $result = $this->BankcardModel->where($map)->find();
        if($result){
            return $result->toArray();
=======

    // 获取所有银行卡
    public function getBankcardList($map=[],$page = 1,$order='',$paginate = 10) {
        $result = Bankcard::where($map)->order($order)->page($page,$paginate)->select();

        if($result){
            $res = $result->toArray();
            return $res;
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        }else{
            return $result;
        }
    }

<<<<<<< HEAD
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
=======
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
            return ['msg' => '操作成功', 'code' => 200, 'data' => $this->BankcardModel->id];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }





}

>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
