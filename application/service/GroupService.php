<?php

namespace app\service;

use app\model\Group;
use app\model\GroupMember;
use think\Db;
use app\model\Pool;
class GroupService {
    private $GroupModel;
    private $GroupMemberModel;
    public function __construct(){
        $this->GroupModel = new Group;
        $this->GroupMemberModel = new GroupMember;
    }


    public function getGroupListNoPage($map){
        $result = $this->GroupModel->where($map)->select();
        return $result;
    }

    // 获取所有社群
    public function getGroupList($map=[],$page = 1,$order='',$paginate = 10) {
        $result = $this->GroupModel->where($map)->order($order)->page($page,$paginate)->select();

        
        return $result;
    }

    // 分页获取社群
    public function getGroupListByPage($map=[], $order='',$paginate=10){
        $result = $this->GroupModel->with('pool')->where($map)->order($order)->paginate($paginate);
        return $result;
    }

    // 软删除
    public function SoftDeleteGroup($id) {
        $result = $this->GroupModel->destroy($id);
        if (!$result) {
            return [ 'msg' => __lang('MSG_400'), 'code' => 100 ];
        } else {
            return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }
    }

    // 获取一个社群
    public function getGroupInfo($map) {
        $result = $this->GroupModel->where($map)->find();
        return $result;
    }

    // 获取一个社群-用户
    public function getGroupMemberInfo($map) {
        $result = $this->GroupMemberModel->where($map)->find();
        if ($result){
            $res = $result->toArray();
            return $res;
        }else{
            return $result;
        }
    }

    // 创建社群
    public function createGroup($data){
        
        $validate = validate('GroupVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        
        $result = $this->GroupModel->save($data);
        if($result){
            return ['msg' => '操作成功', 'code' => 200, 'data' => $this->GroupModel->id];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }


    // 编辑社群
    public function updateGroup($data,$map){
        
        $validate = validate('GroupVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        
        $result = $this->GroupModel->save($data,$map);
        if($result){
            return ['msg' => '操作成功', 'code' => 200];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }

    



    /**
    * 加入社群
    * @param $member_id $member
    * @param $group_id 主表id
    **/ 
    public function createGroupMember($member_id,$member,$avatar,$group_id){
        $GroupInfo = $this->GroupModel->where(['id'=>$group_id])->find();
        if($GroupInfo['members']>=$GroupInfo['max']){
            return ['msg'=>'已满人,不允许加入', 'code' => 100];
        }
        $data = [
            'member_id'         =>$member_id,
            'member'            =>$member,
            'group_id'          =>$GroupInfo['id'],
            'group'             =>$GroupInfo['group'],
            'avatar'            =>$avatar,
            'status'            =>1,
        ];

        $GroupMemberInfo = $this->GroupMemberModel->where(['group_id'=>$group_id,'member_id'=>$member_id])->find();
        if($GroupMemberInfo){
            if($GroupMemberInfo['status'] == 2)
            return ['code'=>100,'msg'=>'你同意了该会员的申请'];
        }
        $result = $this->GroupMemberModel->save($data);

        if($result){
            $this->GroupModel->where(['id'=>$group_id])->setInc('members',1);
            return ['msg' => '加入成功', 'code' => 200];
        }else{
            return ['msg'=>'加入失败', 'code' => 100];
        }
    }

    /**
     * 踢出社群/退出社群
     * @param $id 被踢\要退出的人,即被操作对象
     * @param $member_id 操作对象
     */
     
    public function dropGroup($member_id,$group_id,$id){
        $GroupInfo = $this->GroupModel->where(['id'=>$group_id])->find();
        if($member_id == $GroupInfo['member_id']){
            return ['msg'=>'群主不可退出', 'code' => 100];
        }
        if($member_id<>session('memberInfo.id') && $member_id <> $GroupInfo['member_id']){
            return ['msg'=>'非群主不可将他人踢出社群', 'code' => 100];
        }

        if($member_id<>session('memberInfo.id')){
            $status = -1;//被踢
        }else{
            $status = -2;//自己退出
        }

        $result = $this->GroupMemberModel->save(['status'=>$status],['id'=>$id]);
        if($result){
            $res = $this->GroupModel->where(['id'=>$group_id])->setDec('members',1);
            if(!$res){
                return ['msg'=>'网络错误', 'code' => 100];
            }
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
        
        return ['msg'=>'操作成功', 'code' => 200];
        
    }



    // 踢出社群/退出社群
    public function dropGroups($member_id,$group_id,$ids){
        $GroupInfo = $this->GroupModel->where(['id'=>$group_id])->find();
        if($member_id <> $GroupInfo['member_id']){
            return ['msg'=>'只有群主可操作', 'code' => 100];
        }

        
        $result = $this->GroupMemberModel->where(['id'=>['in',$ids]])->update(['status'=>-1]);
        if($result){
            $res = $this->GroupModel->where(['id'=>$group_id])->setDec('members',count($ids));
            if(!$res){
                return ['msg'=>'网络错误', 'code' => 100];
            }
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
        
        return ['msg'=>'操作成功', 'code' => 200];
        
    }


    public function dissolveGroup($group_id){
        $result = $this->GroupModel->save(['status'=>-1],['id'=>$group_id]);
        if($result){
            $res = db('group_member')->where(['group_id'=>$group_id])->update(['status'=>-1]);
        }
        if($res){
            return $result;
        }
        return $res;
    }

    public function getGroupMemberListByPage($map,$paginate = 10){
        $result = $this->GroupMemberModel->with('group')->where($map)->paginate($paginate);
        return $result;
    }




    public function getPoolInfo($map){
        $Pool = new Pool;
        $result = $Pool->where($map)->find();
        return $result;
    }




}

