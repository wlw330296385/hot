<?php 
namespace app\keeper\controller;
use app\keeper\controller\Base;
use app\service\GroupService;
class Group extends Base{
	   private $GroupService;
	public function _initialize(){
		parent::_initialize();
        $this->GroupService = new GroupService;
	}

    // 群组列表
    public function index() {
        
        return view('Group/index');
    }

    // 群组详情
    public function groupInfo() {

        $group_id = input('param.group_id');
        $groupInfo = $this->GroupService->getGroupInfo(['id'=>$group_id]);

        $lastPool = db('pool')->where(['group_id'=>$group_id,'status'=>2])->find();//上一期
        $nowPool = db('pool')->where(['group_id'=>$group_id,'status'=>1])->find();//本期
        $winnerList = [];
        if($lastPool){
            $winnerList = db('pool_winner')->where(['pool_id'=>$lastPool['id']])->select();
        }
        // 是否已加入社群
        $id = db('group_member')->where(['group_id'=>$group_id,'status'=>1,'member_id'=>$this->memberInfo['id']])->value('id');
        // 本期个人打卡次数
        
        $this->assign('lastPool',$lastPool);
        $this->assign('id',$id);
        $this->assign('winnerList',$winnerList);
        $this->assign('nowPool',$nowPool);
        $this->assign('groupInfo',$groupInfo);
        return view('Group/groupInfo');
    }

    // 创建群组
    public function createGroup() {

        return view('Group/createGroup');
    }

    // 编辑群组
    public function groupEdit() {
        $group_id = input('param.group_id');
        $groupInfo = $this->GroupService->getGroupInfo(['id'=>$group_id]);

        if($groupInfo['member_id']<>$this->memberInfo['id']){
            $this->error('权限不足');
        }


        $this->assign('groupInfo',$groupInfo);
        return view('Group/groupEdit');
    }

    
    // 创建奖金池
    public function createPool() {
        $group_id = input('param.group_id');
        $groupInfo = $this->GroupService->getGroupInfo(['id'=>$group_id]);

        if($groupInfo['member_id']<>$this->memberInfo['id']){
            $this->error('权限不足');
        }


        $this->assign('groupInfo',$groupInfo);
        return view('Group/createPool');
    }

    // 奖金池详情
    public function poolInfo() {

        $pool_id = input('param.pool_id');
        $poolInfo = $this->GroupService->getPoolInfo(['id'=>$pool_id]);




        $this->assign('poolInfo',$poolInfo);
        

        return view('Group/poolInfo');
    }

    // 编辑奖金池
    public function poolEdit() {
        $pool_id = input('param.pool_id');
        $poolInfo = $this->GroupService->getPoolInfo(['id'=>$pool_id]);
        $groupInfo = $this->GroupService->getGroupInfo(['id'=>$poolInfo['group_id']]);
        if($groupInfo['member_id']<>$this->memberInfo['id']){
            $this->error('权限不足');
        }


        
        $this->assign('poolInfo',$poolInfo);
        
        return view('Group/poolEdit');
    }

    // 奖金池列表
    public function poolList() {
        $group_id = input('param.group_id');
        $groupInfo = $this->GroupService->getGroupInfo(['id'=>$group_id]);




        $this->assign('groupInfo',$groupInfo);
        return view('Group/poolList');
    }

       // 奖金池擂主列表
       public function poolWinnerList() {
        $group_id = input('param.group_id');
        $groupInfo = $this->GroupService->getGroupInfo(['id'=>$group_id]);
        $this->assign('groupInfo',$groupInfo);
        return view('Group/poolWinnerList');
    }

    // 社群成员申请列表
    public function groupApplyList() {
        $group_id = input('param.group_id');
        $groupInfo = $this->GroupService->getGroupInfo(['id'=>$group_id]);
        if($groupInfo['member_id']<>$this->memberInfo['id']){
            $this->error('权限不足');
        }
        $this->assign('groupInfo',$groupInfo);
        return view('Group/groupApplyList');
    }
    // 社群成员操作回复列表
    public function groupApplyInfo() {
        $group_id = input('param.group_id');
        $groupInfo = $this->GroupService->getGroupInfo(['id'=>$group_id]);
        if($groupInfo['member_id']<>$this->memberInfo['id']){
            $this->error('权限不足');
        }
        $this->assign('groupInfo',$groupInfo);
        return view('Group/groupApplyInfo');
    }

     // 社群宗旨
     public function groupTenet() {
        $group_id = input('param.group_id');
        $groupInfo = $this->GroupService->getGroupInfo(['id'=>$group_id]);
        $poolInfo = db('pool')->where(['group_id'=>$group_id])->find();//本期
         // 是否已加入社群
         $id = db('group_member')->where(['group_id'=>$group_id,'status'=>1,'member_id'=>$this->memberInfo['id']])->value('id');
        $this->assign('poolInfo',$poolInfo);
        $this->assign('id',$id);
        $this->assign('groupInfo',$groupInfo);
        return view('Group/groupTenet');
    }

    // 我的社群邀请
    public function myGroupApply() {
        $group_id = input('param.group_id');
        $groupInfo = $this->GroupService->getGroupInfo(['id'=>$group_id]);
        if($groupInfo['member_id']<>$this->memberInfo['id']){
            $this->error('权限不足');
        }
        $lastPool = db('pool')->where(['group_id'=>$group_id,'status'=>2])->find();//上一期
        $nowPool = db('pool')->where(['group_id'=>$group_id,'status'=>1])->find();//本期
        $winnerList = [];
        if($lastPool){
            $winnerList = db('pool_winner')->where(['pool_id'=>$lastPool['id']])->select();
        }
        // 是否已加入社群
        $id = db('group_member')->where(['group_id'=>$group_id,'status'=>1,'member_id'=>$this->memberInfo['id']])->value('id');
        $this->assign('lastPool',$lastPool);
        $this->assign('id',$id);
        $this->assign('winnerList',$winnerList);
        $this->assign('nowPool',$nowPool);
        $this->assign('groupInfo',$groupInfo);
        return view('Group/myGroupApply');
    }

    // 社群个人打卡列表
    public function groupMemberPunch() {
        $group_id = input('param.group_id');
        $groupInfo = $this->GroupService->getGroupInfo(['id'=>$group_id]);
        $this->assign('groupInfo',$groupInfo);
        return view('Group/groupMemberPunch');
    }

    // 社群成员列表
    public function groupMemberList() {
        $group_id = input('param.group_id');
        $groupInfo = $this->GroupService->getGroupInfo(['id'=>$group_id]);
        $this->assign('groupInfo',$groupInfo);
        return view('Group/groupMemberList');
    }

}