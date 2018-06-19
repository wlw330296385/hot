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
            $groupInfo = $this->GroupService->getGroupInfo(['id'=>$group_id]);
            if($groupInfo['member_id']<>$this->memberInfo['id']){
                return json(['code'=>100,'msg'=>'权限不足']);
            }

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
           $groupInfo = $this->GroupService->getGroupInfo(['id'=>$group_id]);
            if($groupInfo['member_id']<>$this->memberInfo['id']){
                return json(['code'=>100,'msg'=>'权限不足']);
            }
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


    // 获取带本期打卡总数的社群群员列表
    public function getGroupMemberWithTotalPunchListApi(){
        try{
            $group_id = input('param.group_id');
            $page = input('param.page',1);
            $group_member = db('group_member')->where(['group_id'=>$group_id])->page($page)->select();
            $poolInfo = db('pool')->where(['group_id'=>$group_id,'status'=>2])->find();
            foreach ($group_member as $key => $value) {
                    $group_member[$key]['c_p'] = 0;
                }
            if($poolInfo){
                $memberIDs = [];
                foreach ($group_member as $key => $value) {
                    $memberIDs[] = $value['member_id'];
                }
                $punchs = db('group_punch')->field('count(id) as c_id,member_id,member')->where(['member_id'=>['in',$memberIDs],'pool_id'=>$poolInfo['id']])->group('member_id')->select();
                foreach ($group_member as $key => $value) {
                    foreach ($punchs as $k => $val) {
                        if($val['member_id'] == $value['member_id']){
                            $group_member[$key]['c_p'] = $val['c_id'];
                        }
                    }
                }
            }

            
            return json(['code'=>200,'msg'=>'获取成功','data'=>$group_member]);   
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 获取带奖金池的groupList不分页
    public function getGroupListJoinPoolApi(){
        try {
            // 获取开启奖金池规则的社群
            $groupList = [];
            $punch_time = input('param.punch_time');
            if ($punch_time) {
                $punchTime_start = strtotime($punch_time);
                $punchTime_end = $punchTime_start+86399;
            }else{
                return jsoin(['code'=>100,'msg'=>'请选择时间']);
            }
            $groupList = db('group_member')
                ->field('group_member.*,pool.stake,pool.pool,pool.status as p_status,pool.id as p_id,pool.times')
                ->join('pool','pool.group_id = group_member.group_id','left')
                ->where(['group_member.member_id'=>$this->memberInfo['id'],'group_member.status'=>1])
                // ->where(['pool.status'=>2])
                ->order('group_member.id desc')
                ->select();
             
            //如果某人当天已在奖金池里打卡超过times(不允许打卡)
            $pool_ids = [];
            if(!empty($groupList)){
                foreach ($groupList as $key => $value) {
                    $pool_ids[] = $value['p_id'];
                    $groupList[$key]['punchs'] = 0;
                }
                $punchList = db('group_punch')->field('count(id) as c_id,pool_id')->where(['pool_id'=>['in',$pool_ids]])->where(['member_id'=>$this->memberInfo['id']])->where(['create_time'=>['between',[$punchTime_start,$punchTime_end]]])->group('pool_id')->select();
                foreach ($groupList as $key => $value) {
                    foreach ($punchList as $k => $val) {
                        if($val['pool_id'] == $value['p_id']){
                            // unset($groupList[$key]);
                            $groupList[$key]['punchs'] = $val['c_id'];
                        }
                    }
                }
            }
            return jsoin(['code'=>200,'msg'=>'获取成功','data'=>$groupList]);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}