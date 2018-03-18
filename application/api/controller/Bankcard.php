<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\BankcardService;
class Bankcard extends Base{
   protected $BankcardService;
 
    public function _initialize(){
        parent::_initialize();
       $this->BankcardService = new BankcardService;
    }
 
    public function getBankcardListApi(){
         try{
            $map = input('post.');
<<<<<<< HEAD
             $page = input('param.page')?input('param.page'):1; 
            $result = $this->BankcardService->getBankcardList($map,$page);    
             return json($result);
=======
            $page = input('param.page')?input('param.page'):1; 
            $result = $this->BankcardService->getBankcardList($map,$page);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  
            
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }
 
    public function updateBankcardApi(){
         try{
             $data = input('post.');
            $bankcard_id = input('param.bankcard_id');
             $data['member_id'] = $this->memberInfo['id'];
             $data['member'] = $this->memberInfo['member'];
            $result = $this->BankcardService->updateBankcard($data,$bankcard_id);
             return json($result);
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }
 
    public function createBankcardApi(){
         try{
             $data = input('post.');
<<<<<<< HEAD
=======
             $data['member_id'] = $this->memberInfo['id'];
             $data['member'] = $this->memberInfo['member'];
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
            $result = $this->BankcardService->createBankcard($data);
             return json($result);   
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}