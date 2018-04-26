<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\CampWithdrawService;
class CampWithdraw extends Base{
   protected $CampWithdrawService;
 
    public function _initialize(){
        parent::_initialize();
        $this->CampWithdrawService = new CampWithdrawService;

    }
    
    protected function isPower(){
        $isPower = $this->CampWithdrawService->isPower(input('param.camp_id'),$this->memberInfo['id']);
        return $isPower;
    }


    // 获取提现列表
    public function getCampWithdrawListApi(){
         try{
            $isPower = $this->isPower();
            if($isPower<3){
                return json(['code'=>100,'msg'=>'权限不足']);
            }   
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1; 
            $result = $this->CampWithdrawService->getCampWithdrawList($map,$page);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  
            
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }
    
    // 编辑提现
    public function updateCampWithdrawApi(){
         try{
            $isPower = $this->isPower();
            if($isPower<>4){
                return json(['code'=>100,'msg'=>'权限不足']);
            }   
            $data = input('post.');
            $camp_withdraw_id = input('param.camp_withdraw_id');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];

            $campInfo = db('camp')->where(['id'=>$data['camp_id']])->find();
            if($campInfo['balance']<$data['withdraw']){
                return json(['code'=>100,'msg'=>'余额不足']);
            }
            $data['s_balance'] = $data['e_balance'] = $campInfo['balance'];
            $data['camp_type'] = $campInfo['type'];

            $result = $this->CampWithdrawService->updateCampWithdraw($data,['id'=>$camp_withdraw_id]);
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
     }
    // 新建提现
    public function createCampWithdrawApi(){
         try{
            $isPower = $this->isPower();
            if($isPower<>4){
                return json(['code'=>100,'msg'=>'权限不足']);
            }   
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];

            $campInfo = db('camp')->where(['id'=>$data['camp_id']])->find();
            if($campInfo['balance']<$data['withdraw']){
                return json(['code'=>100,'msg'=>'余额不足']);
            }
            $data['s_balance'] = $data['e_balance'] = $campInfo['balance'];
            $data['camp_type'] = $campInfo['type'];
            $buffer = $data['withdraw'];
            if($campInfo['type'] == 2){
                $buffer += $buffer*$campInfo['schedule_rebate'];
            }
            $data['buffer'] = $buffer;
            $result = $this->CampWithdrawService->createCampWithdraw($data);
            if($result['code'] == 200){
                db('camp')->where(['id'=>$data['camp_id']])->dec('balance',$buffer)->update();
            }
            return json($result);   
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}