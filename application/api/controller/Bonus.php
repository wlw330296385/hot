<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\admin\service\BonusService;
class Bonus extends Base{
   protected $BonusService;
 
    public function _initialize(){
        parent::_initialize();
        $this->BonusService = new BonusService;
    }
 
    // 获取礼包列表带分页
    public function getBonusListApi(){
        try{
            $map = input('post.');
            // $map['item_coupon.target_type'] = -1;
            $page = input('param.page')?input('param.page'):1; 
            $result = $this->BonusService->getBonusList($map,$page);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  
            
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
 
    // 获取礼包无分页page
    public function getBonusListNoPageApi(){
        try{
            $map = input('post.');
            $result = $this->BonusService->getBonusListNoPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'查询有误']);
            }  
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 领取一个礼包
    public function grantBounusApi(){
        try{
            $bonus_id = input('param.bonus_id');
            $member_id = $this->memberInfo['id'];
            if(!$member_id){
                return json(['code'=>100,'msg'=>'请先登录']);
            }
            // 找到礼包
            $bonusInfo = $this->BonusService->getbonusInfo(['id'=>$bonus_id,'status'=>1]);
            if(!$bonusInfo){
                return json(['code'=>100,'msg'=>'礼包无效']);
            }
            $isBonus = $this->BonusService->getBonusMember(['bonus_id'=>$bonus_id,'member_id'=>$member_id,'status'=>1]);
            if($isBonus){
                return json(['code'=>101,'msg'=>'你已经领过该礼包']);
            }
            // 领取礼包
            $member = $this->memberInfo['member'];
            $data = ['bonus_id'=>$bonus_id,'member_id'=>$member_id,'member'=>$member,'bonus'=>$bonusInfo['bonus'],'status'=>1];
            $result = $this->BonusService->createBonusMember($data);
            return json($result);
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}