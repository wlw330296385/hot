<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\CertService;
class Cert extends Base{
	protected $CertService;

	public function _initialize(){
		parent::_initialize();
		$this->CertService = new CertService;
	}

    // 分页获取数据
    public function CertListApi(){
        try{
            $map = input();
            $result = $this->CertService->getCertList($map);    
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function updateCertApi(){
        try{
            $data = input('post.');
            $cert_id = input('param.cert_id');
            $result = $this->CertService->updateCert($data,$cert_id);
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function createCertApi(){
        try{
            $data = input('post.');
            $result = $this->CertService->createCert($data);
            return json($result);   
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    
}