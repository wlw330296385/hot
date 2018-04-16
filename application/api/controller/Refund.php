<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\RefundService;
use think\Db;

class Refund extends Base{
    protected $RefundService;
	public function _initialize(){
		parent::_initialize();
        $this->RefundService = new RefundService;
	}



    public function getRefundListByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['member'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $result = $this->RefundService->getRefundListByPage($map);    
            if($result){
                return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'检查你的参数']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

   
    // 不带page
    public function getRefundListNoPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['member'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $Refund = new \app\model\Refund;
            $result = $Refund->where($map)->select();
            if($result){
                return json(['code'=>200,'msg'=>'ok','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'检查你的参数']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 邀请退款|申请退款,写入一条
    public function updateRefundApi(){
        try{
            $data = input('post.');
            $refund_id = input('param.refund_id');
            if($refund_id){
                $result = $this->RefundService->updateRefund($data,$refund_id);
            }else{
                $result = $this->RefundService->createRefund($data);
            }
            
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}
