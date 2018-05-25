<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\PoolService;
class Pool extends Base{
   protected $PoolService;
 
    public function _initialize(){
        parent::_initialize();
       $this->PoolService = new PoolService;
    }
 
    // 获取打卡列表
    public function getPoolListApi(){
         try{
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1; 
            $result = $this->PoolService->getPoolList($map,$page);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'查询有误']);
            }  
            
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }
     // 获取打卡列表 无page
    public function getPoolListNoPageApi(){
         try{
            $map = input('post.');
            $result = $this->PoolService->getPoolListNoPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'查询有误']);
            }  
            
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }
    // 获取打卡列表带page
     public function getPoolListByPageApi(){
        try{
            $map = input('post.');
            $result = $this->PoolService->getPoolListByPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'查询有误']);
            }  

        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 获取用户打卡带page
    public function getPoolMemberListByPageApi(){
        try{
            $map = input('post.');
            $result = $this->PoolService->getPoolMemberListByPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'查询有误']);
            }  
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 编辑打卡
    public function updatePoolApi(){
         try{
            $data = input('post.');
            $pool_id = input('param.pool_id');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $result = $this->PoolService->updatePool($data,['id'=>$pool_id]);
            return json($result);
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }

    // 操作打卡
    public function editPoolApi(){
        try{
           $data = input('post.');
           $pool_id = input('param.pool_id');
           $data['member_id'] = $this->memberInfo['id'];
           $data['member'] = $this->memberInfo['member'];
           $result = db('pool')->where(['id'=>$pool_id])->update($data);
           if($result){
                return json(['code'=>200,'msg'=>'ok']);
            }
            return json(['code'=>100,'msg'=>'失败']);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    //创建打卡
    public function createPoolApi(){
         try{
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];

            $result = $this->PoolService->createPool($data);
             return json($result);   
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


 
    //加入打卡
    public function createPoolMemberApi(){
         try{
            $pool_id = input('param.pool_id');
            $member_id = $this->memberInfo['id'];
            $member = $this->memberInfo['member'];
            $result = $this->PoolService->createPoolMember($member_id,$member,$pool_id);
             return json($result);   
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }



    //退出打卡
    public function dropPool(){
        try{
            $member_id = $this->memberInfo['id'];
            $pool_id = input('param.pool_id');
            $result = $this->PoolService->usePool($member_id,$pool_id);
             return json($result);   
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}