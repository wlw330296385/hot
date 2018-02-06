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
    		return ['code'=>200,'msg'=>'ok','data'=>$result];
    	}else{
    		return ['code'=>100,'msg'=>'暂无数据'];
    	}
    }


    public function createCert($data){
        $validate = validate('CertVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }

        $result = $this->certModel->save($data);
        if($result){
            return ['code'=>200,'msg'=>'创建成功','data'=>$result];
        }else{
            return ['code'=>100,'msg'=>'创建失败','data'=>$result];
        }

    }


    public function updateCert($data,$id){
        $validate = validate('CertVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        $result = $this->certModel->save($data,['id'=>$id]);
        if($result){
            return ['code'=>200,'msg'=>'创建成功','data'=>$result];
        }else{
            return ['code'=>100,'msg'=>'创建失败','data'=>$result];
        }
    }

    // 保存证件
    public function saveCert($request) {
        $model = new Cert();
        $map['camp_id'] = $request['camp_id'];
        $map['member_id'] = $request['member_id'];
        $map['cert_type'] = $request['cert_type'];
        $find = $model->where($map)->find();
        if ($find) {
            $res = $model->save($request, $map);
        } else {
            $res = $model->save($request);
        }

        if ($res) {
            $response = ['code' => 200, 'msg' => __lang('MSG_200')];
        } else {
            $response = ['code' => 100, 'msg' => __lang('MSG_400')];
        }
        return $response;
    }
}