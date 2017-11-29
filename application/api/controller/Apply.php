<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\ApplyService;
use think\Db;

class Apply extends Base{
    protected $ApplyService;
	public function _initialize(){
		parent::_initialize();
        $this->ApplyService = new ApplyService;
	}



    public function getApplyListByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['member'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $result = $this->ApplyService->getApplyListByPage($map);    
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
    public function getApplyListNoPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['member'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $Apply = new \app\model\Apply;
            $result = $Apply->where($map)->select();
            if($result){
                return json(['code'=>200,'msg'=>'ok','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'检查你的参数']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 邀请加入|申请加入,写入一条
    public function createApplyApi(){
        try{
            $data = input('post.');
            $apply_id = input('param.apply_id');
            if($apply_id){
                $result = $this->ApplyService->updateApply($data,$apply_id);
            }else{
                $result = $this->ApplyService->createApply($data);
            }
            
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}
