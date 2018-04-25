<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\CampBankcardService;
class CampBankcard extends Base{
   protected $CampBankcardService;
 
    public function _initialize(){
        parent::_initialize();
        $this->CampBankcardService = new CampBankcardService;

    }
    
    protected function isPower(){
        $isPower = $this->CampBankcardService->isPower(input('param.camp_id'),$this->memberInfo['id']);
        return $isPower;
    }

    // 获取账户记录
    public function getCampBankcardInfoApi(){
         try{
            $isPower = $this->isPower();
            if($isPower<3){
                return json(['code'=>100,'msg'=>'权限不足']);
            }   
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1; 
            $result = $this->CampBankcardService->getCampBankcardList($map,$page);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  
            
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }
 
    // 更新账户
    public function updateCampBankcardApi(){
         try{
            $isPower = $this->isPower();
            if($isPower<>4){
                return json(['code'=>100,'msg'=>'权限不足']);
            }   
            $data = input('post.');
            $camp_bankcard_id = input('param.camp_bankcard_id');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $result = $this->CampBankcardService->updateCampBankcard($data,['id'=>$camp_bankcard_id]);
            return json($result);
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }
 

    // 创建账户
    public function createCampBankcardApi(){
         try{
            $isPower = $this->isPower();
            if($isPower<>4){
                return json(['code'=>100,'msg'=>'权限不足']);
            }   
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $result = $this->CampBankcardService->createCampBankcard($data);
            return json($result);   
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}