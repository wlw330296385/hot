<?php 
namespace app\service;
use app\model\GroupApply;
use think\Db;
class GroupApplyService{
	protected $GroupApplyModel;
	public function __construct(){
		$this->GroupApplyModel = new GroupApply;
	}


	public function getGroupApplyList($map,$page = 1,$paginate = 10){
		$result = GroupApply::where($map)->page($page,$paginate)->select();
        return $result;
    }

    public function getGroupApplyListByPage($map,$paginate = 10){
        $result = GroupApply::where($map)->paginate($paginate);
        
        return $result;
    }

    // 统计用户数量
    public function countMembers($map){
    	$result = $this->GroupApplyModel->where($map)->count();
    	return $result?$result:0;
    }
    
    // 插入一条数据
    public function createGroupApply($data){
        $res = $this->GroupApplyModel->where(['member_id'=>$data['member_id'],'group_id'=>$data['group_id'],'status'=>1])->find();

        if($res){
            return ['code'=>100,'msg'=>'请不要重复申请'];
        }
        $result = $this->GroupApplyModel->save($data);
        if($result){
            return ['code'=>200,'msg'=>'操作成功','data'=>$this->GroupApplyModel->id];
        }else{
            return ['code'=>100,'msg'=>'操作失败'];
        }
    }


    //更新一条数据
    public function updateGroupApply($data,$apply_id){

        $result = $this->GroupApplyModel->save($data,['id'=>$apply_id]);
        if($result){
            return ['code'=>200,'msg'=>'操作成功'];
        }else{
            return ['code'=>100,'msg'=>'操作失败'];
        }
    }
    
}