<?php
// 证件 service
namespace app\service;
use app\common\validate\CertVal;

use app\model\Cert;

class CertService {
    protected $certModel;
    public function __construct(){
        $this->certModel = new Cert;
    }

    public static function CertOneById($cert_id) {
        $cert = Cert::get($cert_id);
        if (!$cert) return false;
        if ( empty($cert)  ) return ;
        return $cert->toArray();
    }

    public function getCertList($map,$page = 1,$p= 10){
    	$res = Cert::where($map)->page($page,$p)->select();
    	if($res){
    		$result = $res->toArray();
    		return ['code'=>100,'msg'=>'ok','data'=>$result];
    	}else{
    		return ['code'=>200,'msg'=>'暂无数据'];
    	}
    }


    public function createCert($data){
        $validate = validate('CertVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }

        $result = $this->certModel->save($data);
        if($result){
            return ['code'=>100,'msg'=>'创建成功','data'=>$result];
        }else{
            return ['code'=>100,'msg'=>'创建失败','data'=>$result];
        }

    }


    public function updateCert($data,$id){
        $validate = validate('CertVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        $result = $this->certModel->save($data,$id);
        if($result){
            return ['code'=>100,'msg'=>'创建成功','data'=>$result];
        }else{
            return ['code'=>100,'msg'=>'创建失败','data'=>$result];
        }
    }
}