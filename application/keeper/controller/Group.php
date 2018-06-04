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
        // 是否已加入社群
        $id = db('group_member')->where(['group_id'=>$group_id,'status'=>1,'member_id'=>$this->memberInfo['id']])->value('id');
        $this->assign('lastPool',$lastPool);
        $this->assign('id',$id);
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




        $this->assign('groupInfo',$groupInfo);
        return view('Group/groupEdit');
    }

    
    // 创建奖金池
    public function createPool() {
        $group_id = input('param.group_id');
        $groupInfo = $this->GroupService->getGroupInfo(['id'=>$group_id]);




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

    // 社群成员申请列表
    public function groupApplyList() {
        $group_id = input('param.group_id');
        $groupInfo = $this->GroupService->getGroupInfo(['id'=>$group_id]);
        $this->assign('groupInfo',$groupInfo);
        return view('Group/groupApplyList');
    }
    // 社群成员操作回复列表
    public function groupApplyInfo() {
        $group_id = input('param.group_id');
        $groupInfo = $this->GroupService->getGroupInfo(['id'=>$group_id]);
        $this->assign('groupInfo',$groupInfo);
        return view('Group/groupApplyInfo');
    }

     // 社群宗旨
     public function groupTenet() {
        return view('Group/groupTenet');
    }

}