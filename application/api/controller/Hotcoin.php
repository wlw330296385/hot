<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\model\Hotcoin as HotcoinModel;
class Hotcoin extends Base{
   protected $HotcoinModel;
 
    public function _initialize(){
        parent::_initialize();
        $this->HotcoinModel = new HotcoinModel;
    }
 
    // 获取礼包列表带分页
    public function getHotcoinFinanceListApi(){
        try{
            $map = input('post.');
            // $map['item_coupon.target_type'] = -1;
            $page = input('param.page')?input('param.page'):1; 
            $result = $this->HotcoinModel->where($map)->page($page,10)->select();  
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
    public function getHotcoinFinanceListNoPageApi(){
        try{
            $map = input('post.');
            $result = $this->HotcoinModel->where($map)->select();  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'查询有误']);
            }  
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

}