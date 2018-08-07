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
 
    // 获取擂台列表
    public function getPoolListApi(){
         try{
            $map = input('post.');
            $keyword = input('param.keyword');
            $page = input('param.page')?input('param.page'):1; 
            foreach ($map as $key => $value) {
                if($value == ''|| empty($value) || $value==' '){
                    unset($map[$key]);
                }
            }
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['camp'] = ['LIKE','%'.$keyword.'%'];
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $result = $this->PoolService->getPoolList($map,$page);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  
            
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }
     // 获取擂台列表 无page
    public function getPoolListNoPageApi(){
         try{
            $map = input('post.');
            $result = $this->PoolService->getPoolListNoPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  
            
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }
    // 获取擂台列表带page
     public function getPoolListByPageApi(){
        try{
            $map = input('post.');
            $result = $this->PoolService->getPoolListByPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  

        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 获取擂台用户带page
    public function getPoolMemberListByPageApi(){
        try{
            $map = input('post.');
            $result = $this->PoolService->getPoolMemberListByPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  

        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 编辑擂台
    public function updatePoolApi(){
         try{
            $data = input('post.');
            $pool_id = input('param.pool_id');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
       
            if(isset($data['starts'])){
                $data['start'] = strtotime($data['starts'])+86399;
            }
            if(isset($data['ends'])){
                $data['end'] = strtotime($data['ends']);
                $data['end_str'] = date('Ymd',$data['end']);
            }
            $poolInfo = db('pool')->where(['id'=>$pool_id])->find();
            if(!$poolInfo){
                return json(['code'=>100,'msg'=>'参数错误']);
            }
            $groupInfo = db('group')->where(['id'=>$poolInfo['group_id']])->find();
            if($groupInfo['member_id']<>$this->memberInfo['id']){
                return json(['code'=>100,'msg'=>'权限不足']);
            }
            $is_punch = db('group_punch')->where(['pool_id'=>$pool_id])->find();
            if($is_punch){
                return json(['code'=>100,'msg'=>'已有打卡不允许编辑']);
            }
            $result = $this->PoolService->updatePool($data,['id'=>$pool_id]);
            return json($result);
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }

    // 操作擂台
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

    //创建擂台
    public function createPoolApi(){
        try{
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            if(isset($data['starts'])){
                $data['start'] = strtotime($data['starts']);
                $start_str = date('Ymd',$data['start']);
                if($start_str <= date('Ymd',time())){
                    $data['status'] = 2;
                }else{
                    $data['status'] = 1;
                };
            }
            if(isset($data['ends'])){
                $data['end'] = strtotime($data['ends']);
                $data['end_str'] = date('Ymd',$data['end']);
            }
            $data['winner_list'] = '[]';
            $result = $this->PoolService->createPool($data);
            return json($result);   
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }



    //获取奖金池下的打卡数据
    public function getPoolPunchsApi(){
        try {   
            $pool_id = input('param.pool_id');
            $result = db('group_punch')
                ->field('count(group_punch.id) as c_id,group_punch.member,group_punch.avatar')
                ->where(['group_punch.pool_id'=>$pool_id])
                ->group('group_punch.member_id')
                ->order('group_punch.id desc')
                ->select();
            return json(['code'=>200,'data'=>$result,'msg'=>'收到']);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 获取擂台擂主列表
    public function getPoolWinnerListApi(){
        try{
            $map = input('post.');
            $page = input('param.page',1);
            $PoolWinner = new \app\model\PoolWinner;
            $result = $PoolWinner->where($map)->page($page)->select();
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'获取失败,请检查参数','data'=>$result]);
            } 
        }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
   

   // 获取擂台擂主列表
    public function getPoolWinnerListsApi(){
        try{
            $map = input('post.');
            $page = input('param.page',1);
            $PoolWinners = new \app\model\PoolWinners;
            $result = $PoolWinners->where($map)->page($page)->select();
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'获取失败,请检查参数','data'=>$result]);
            } 
        }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 获取擂台擂主列表带page
    public function getPoolWinnerListByPageApi(){
        try{
            $map = input('post.');
            $PoolWinner = new \app\model\PoolWinner;
            $result = $PoolWinner->where($map)->paginate(10);
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'获取失败,请检查参数','data'=>$result]);
            } 
        }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    
}