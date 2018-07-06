<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\model\MemberFinance as MemberFinanceModel;
class MemberFinance extends Base{
protected $MemberFinanceModel;

public function _initialize(){
    parent::_initialize();
    $this->MemberFinanceModel = new MemberFinanceModel;
}

// 获取热币流水列表带分页
public function getMemberFinanceListApi(){
    try{
        $map = input('post.');
        // $map['item_coupon.target_type'] = -1;
        $page = input('param.page')?input('param.page'):1; 
        $result = $this->MemberFinanceModel->where($map)->page($page,10)->select();  
        if($result){
            return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
        }else{
            return json(['code'=>100,'msg'=>'无数据']);
        }  
        
    }catch (Exception $e){
        return json(['code'=>100,'msg'=>$e->getMessage()]);
    }
}


// 获取热币流水无分页page
public function getMemberFinanceListNoPageApi(){
    try{
        $map = input('post.');
        $result = $this->MemberFinanceModel->where($map)->select();  
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