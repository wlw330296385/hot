<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\GroupService;
class Group extends Base{
   protected $GroupService;
 
    public function _initialize(){
        parent::_initialize();
       $this->GroupService = new GroupService;
    }
 
    // 获取社群列表
    public function getGroupListApi(){
         try{
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1; 
            $result = $this->GroupService->getGroupList($map,$page);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'查询有误']);
            }  
            
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }
     // 获取社群列表 无page
    public function getGroupListNoPageApi(){
         try{
            $map = input('post.');
            $result = $this->GroupService->getGroupListNoPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'查询有误']);
            }  
            
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }
    // 获取社群列表带page
     public function getGroupListByPageApi(){
        try{
            $map = input('post.');
            $result = $this->GroupService->getGroupListByPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'查询有误']);
            }  

        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 获取用户社群带page
    public function getGroupMemberListByPageApi(){
        try{
            $map = input('post.');
            $result = $this->GroupService->getGroupMemberListByPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'查询有误']);
            }  
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 编辑社群
    public function updateGroupApi(){
         try{
            $data = input('post.');
            $group_id = input('param.group_id');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $result = $this->GroupService->updateGroup($data,['id'=>$group_id]);
            return json($result);
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }

    // 操作社群
    public function editGroupApi(){
        try{
           $data = input('post.');
           $group_id = input('param.group_id');
           $data['member_id'] = $this->memberInfo['id'];
           $data['member'] = $this->memberInfo['member'];
           $result = db('group')->where(['id'=>$group_id])->update($data);
           if($result){
                return json(['code'=>200,'msg'=>'ok']);
            }
            return json(['code'=>100,'msg'=>'失败']);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    //创建社群
    public function createGroupApi(){
         try{
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];

            $result = $this->GroupService->createGroup($data);
             return json($result);   
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


 
    //加入社群
    public function createGroupMemberApi(){
         try{
            $group_id = input('param.group_id');
            $member_id = $this->memberInfo['id'];
            $member = $this->memberInfo['member'];
            $result = $this->GroupService->createGroupMember($member_id,$member,$group_id);
             return json($result);   
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }



    //退出社群
    public function dropGroup(){
        try{
            $member_id = $this->memberInfo['id'];
            $group_id = input('param.group_id');
            $result = $this->GroupService->useGroup($member_id,$group_id);
             return json($result);   
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}