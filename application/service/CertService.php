<?php
// 证件 service
namespace app\service;


use app\model\Cert;

class CertService {
    public static function CertOneById($cert_id) {
        $cert = Cert::get($cert_id);
        if (!$cert) return false;
        if ( empty($cert)  ) return ;
        return $cert->toArray();
    }

    public function getCertList($map){
    	$res = Cert::all($map);
    	if($res){
    		$result = $res->toArray();
    		return ['code'=>100,'msg'=>'ok','data'=>$result];
    	}else{
    		return ['code'=>200,'msg'=>'暂无数据'];
    	}
    }
}