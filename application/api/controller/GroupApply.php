<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\GroupApplyService;
use think\Db;

class GroupApply extends Base{
    protected $GroupApplyService;
	public function _initialize(){
		parent::_initialize();
        $this->GroupApplyService = new GroupApplyService;
	}


    // 获取申请列表page
    public function getGroupApplyListByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['member'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $result = $this->GroupApplyService->getGroupApplyListByPage($map);    
            if($result){
                return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'检查你的参数','data'=>0]);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

   
    // 不带page
    public function getGroupApplyListNoPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['member'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $GroupApply = new \app\model\GroupApply;
            $result = $GroupApply->where($map)->select();
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
    public function createGroupApplyApi(){
        try{
            $data = input('post.');
            $group_apply_id = input('param.group_apply_id');
            //同意操作
            if($group_apply_id){
                $result = $this->GroupApplyService->updateGroupApply($data,$group_apply_id);
            }else{
                $result = $this->GroupApplyService->createGroupApply($data);
            }
            
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}
