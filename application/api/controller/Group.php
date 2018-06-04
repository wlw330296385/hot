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
            $keyword = input('param.keyword');
            $page = input('param.page')?input('param.page'):1; 
            foreach ($map as $key => $value) {
                if($value == ''|| empty($value) || $value==' '){
                    unset($map[$key]);
                }
            }
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['group'] = ['LIKE','%'.$keyword.'%'];
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $result = $this->GroupService->getGroupList($map,$page);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
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
                return json(['code'=>100,'msg'=>'无数据']);
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
                return json(['code'=>100,'msg'=>'无数据']);
            }  

        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 获取社群详情
    public function getGroupInfoApi(){
        try{
            $map = input('post.');
            $result = $this->GroupService->getGroupInfo($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  

        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 获取member没参加的社群/其他社群list
    public function getOtherGroupListApi(){
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
                $map['group'] = ['LIKE','%'.$keyword.'%'];
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }

            $ids = db('group_member')->where(['member_id'=>$this->memberInfo['id']])->column('group_id');
            $map['id'] = ['not in',$ids];
            $result = $this->GroupService->getGroupList($map,$page);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  

        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 获取用户社群带page
    public function getGroupMemberListByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');

            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['group'] = ['LIKE','%'.$keyword.'%'];
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }

            $result = $this->GroupService->getGroupMemberListByPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
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
            if($result['code'] == 200){
                $res = $this->GroupService->createGroupMember($this->memberInfo['id'],$this->memberInfo['member'],$this->memberInfo['avatar'],$result['data']);
            }
            return json($result);   
        }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


 
    //加入社群
    public function createGroupMemberApi(){
        try{
            $group_id = input('param.group_id');
            $member_id = input('param.member_id',$this->memberInfo['id']);
            $avatar = input('param.avatar',$this->memberInfo['avatar']);
            $member = input('param.member',$this->memberInfo['member']);
            $result = $this->GroupService->createGroupMember($member_id,$member,$avatar,$group_id);
            return json($result);   
        }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }



    //退出社群/踢出社群
    public function dropGroup(){
        try{
            $id = input('param.id');
            $member_id = input('param.member_id',$this->memberInfo['id']);
            $group_id = input('param.group_id');
            $result = $this->GroupService->dropGroup($member_id,$group_id,$id);
            return json($result);   
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }




    //将多人批量踢出社群
    public function dropGroups(){
        try{
            $idList = input('param.idList');
            $ids = json_decode($idList);
            $member_id = input('param.member_id',$this->memberInfo['id']);
            $group_id = input('param.group_id');
            $result = $this->GroupService->dropGroups($member_id,$group_id,$ids);
            return json($result);   
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}