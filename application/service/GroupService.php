<?php

namespace app\service;

use app\model\Group;
use app\model\GroupMember;
use think\Db;
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
        $result = $this->GroupModel->where($map)->order($order)->paginate($paginate);
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
        if ($result){
            $res = $result->toArray();
            return $res;
        }else{
            return $result;
        }
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
    public function createGroupMember($member_id,$member,$group_id){
        $GroupInfo = $this->GroupModel->where(['id'=>$group_id])->find();
        $data = [
            'member_id'         =>$member_id,
            'member'            =>$member,
            'group_id'    =>$GroupInfo['id'],
            'group'       =>$GroupInfo['coupon'],
            'status'            =>1,
        ];

        $GroupMemberInfo = $this->GroupMemberModel->where(['group_id'=>$group_id,'member_id'=>$member_id,'status'=>1])->find();
        if($GroupMemberInfo){
            return ['code'=>100,'msg'=>'您加入过该社群'];
        }
        $result = $this->GroupMemberModel->save($data);

        if($result){
            $this->GroupModel->where(['id'=>$group_id])->setInc('members',1);
            return ['msg' => '加入成功', 'code' => 200];
        }else{
            return ['msg'=>'加入失败', 'code' => 100];
        }
    }

    



}

