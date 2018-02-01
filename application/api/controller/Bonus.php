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

}