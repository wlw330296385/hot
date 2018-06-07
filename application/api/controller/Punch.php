<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\PunchService;
use think\Db;
class Punch extends Base{
   protected $PunchService;
 
    public function _initialize(){
        parent::_initialize();
       $this->PunchService = new PunchService;
    }
 
    // 获取打卡列表
    public function getPunchListApi(){
         try{
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1; 
            $result = $this->PunchService->getPunchList($map,$page);  
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
    public function getPunchListNoPageApi(){
         try{
            $map = input('post.');
            $result = $this->PunchService->getPunchListNoPage($map);  
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
     public function getPunchListByPageApi(){
        try{
            $map = input('post.');
            $result = $this->PunchService->getPunchListByPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'查询有误']);
            }  

        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 获取社群打卡带page
    public function getGroupPunchListByPageApi(){
        try{
            $map = input('post.');
            $result = $this->PunchService->getGroupPunchListByPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'查询有误']);
            }  
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }



    // 操作打卡
    public function editPunchApi(){
        try{
           $data = input('post.');
           $punch_id = input('param.punch_id');
           $data['member_id'] = $this->memberInfo['id'];
           $data['member'] = $this->memberInfo['member'];
           $result = db('punch')->where(['id'=>$punch_id])->update($data);
           if($result){
                return json(['code'=>200,'msg'=>'ok']);
            }
            return json(['code'=>100,'msg'=>'失败']);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    //创建打卡
    public function createPunchApi(){
        Db::startTrans();
         try{
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['avatar'] = $this->memberInfo['avatar'];
            $data['province'] = $this->memberInfo['province'];
            $data['city'] = $this->memberInfo['city'];
            $data['area'] = $this->memberInfo['area'];

            $data['month_str'] = date('Ym',time());
            $data['date_str'] = date('Ym',time());
            $result = $this->PunchService->createPunch($data);

            if(isset($data['groupList']) && $data['groupList'] != '[]' && $result['code']== 200){
                
                $groupList = json_decode($data['groupList'],true);
                foreach ($groupList as $key => &$value) {
                    $value['punch'] = $data['punch'];
                    $value['member'] = $data['member'];
                    $value['punch_id'] = $result['data'];
                    $value['month_str'] = date('Ym',time());
                    $value['date_str'] = date('Ymd',time());
                    db('pool')->where(['id'=>$value['pool_id']])->inc('members',1)->inc('bonus',$value['stake'])->update();
                }
                
                $GroupPunch = new \app\model\GroupPunch;
                $GroupPunch->saveAll($groupList);
            }
            Db::commit();   
            return json($result);   
         }catch (Exception $e){
            Db::rollback();
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


 



    // 打卡评论
    public function commentApi(){
        try{
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['avatar'] = $this->memberInfo['avatar'];
            $comment_id = input('param.comment_id');
            if($comment_id){
                $result = $this->PunchService->updateComment($data,['id'=>$comment_id,'member_id'=>$this->memberInfo['id']]);
            }else{
                $result = $this->PunchService->createComment($data);
            }
            return json($result);   
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }   
    }

    // 获取评论列表
    public function getCommentListApi(){
        try{
            $map = input('post.');
            $page = input('param.page',1);
            $result = $this->PunchService->getCommentList($map,$page);
            if($result){
                return json(['msg' => '获取成功', 'code' => 200, 'data' => $result]);
            }else{
                return json(['msg'=>'获取失败', 'code' => 100]);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        } 
    }
    // 获取评论列表byPage
    public function getCommentListByPageApi(){
        try{
            $map = input('post.');

            $result = $this->PunchService->getCommentListByPage($map);
            if($result){
                return json(['msg' => '获取成功', 'code' => 200, 'data' => $result]);
            }else{
                return json(['msg'=>'获取失败', 'code' => 100]);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        } 
    }

    // 点赞评论
    public function likesApi(){
        try{
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            
            $likesInfo = $this->PunchService->getLikesInfo(['punch_id'=>$data['punch_id'],'member_id'=>$data['member_id']]);
            if($likesInfo){
                if($likesInfo['status'] == 1){
                    $result = $this->PunchService->updateLikes(['status'=>-1,'punch_id'=>$data['punch_id']],['id'=>$likesInfo['id']]);
                }else{
                    $result = $this->PunchService->updateLikes(['status'=>1,'punch_id'=>$data['punch_id']],['id'=>$likesInfo['id']]);
                }
            }else{
                $result = $this->PunchService->createLikes($data);
            }
            return json($result);   
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 打赏
    public function rewardApi(){
        try{
            $member_id = $this->memberInfo['id'];
            $member = $this->memberInfo['member'];
            $avatar = $this->memberInfo['avatar'];
            $reward = input('param.reward');
            $punch_id = input('param.punch_id');
            if($reward>$this->memberInfo['hot_coin']){
                return json(['code'=>100,'msg'=>'热币不足']);
            }
            $result = db('member')->where(['id'=>$member_id])->dec('hot_coin',$reward)->update();
            if($result){
                db('punch')->where(['id'=>$punch_id])->inc('rewards',1)->inc('rewards_money',$reward)->update();
                db('hotcoin_finance')->insert(
                    [
                        'member_id' =>$member_id,
                        'member'    =>$member,
                        'avatar'    =>$avatar,
                        'hot_coin'  =>-$reward,
                        'type'      =>-3,
                        'status'    =>1,
                        'f_id'      =>$punch_id,
                        'create_time'=>time(),
                    ]
                );
                session('memberInfo.hot_coin',($this->memberInfo['hot_coin']-$reward));
                return json(['code'=>200,'msg'=>'打赏成功']);
            }else{
                return json(['code'=>100,'msg'=>'热币扣除失败,请重新登录']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}