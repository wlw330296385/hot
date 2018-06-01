<?php 
namespace app\api\controller;
use app\api\controller\Base;
use think\Db;
use app\model\AppsApply as AppsApplyModel;
class AppsApply extends Base{
    private $AppsApply;
    public function _initialize(){
        parent::_initialize();
        $this->AppsApply = new AppsApplyModel;
    }



    public function getAppsApplyListByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['member'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $result = $this->AppsApply->where($map)->paginate(10);    
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
    public function getAppsApplyListNoPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['member'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            
            $result = $this->AppsApply->where($map)->select();
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
    public function createAppsApplyApi(){
        try{
            $data = input('post.');
            $apps_apply_id = input('param.apps_apply_id');
            if($apps_apply_id){
                $result = $this->AppsApply->save($data,$apps_apply_id);
            }else{
                $result = $this->AppsApply->save($data);
            }
            
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


}