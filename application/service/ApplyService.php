<?php 
namespace app\service;
use app\model\Apply;
use think\Db;
use app\common\validate\ApplyVal;
class ApplyService{
	protected $ApplyModel;
	public function __construct(){
		$this->ApplyModel = new Apply;
	}


	public function getApplyList($map,$page = 1,$paginate = 10){
		$result = Apply::where($map)->page($page,$paginate)->select();
        return $result;
    }

    public function getApplyListByPage($map,$paginate = 10){
        $result = Apply::where($map)->paginate($paginate);
        
        return $result;
    }

    public function getApplyListWithMtachByPage($map,$paginate = 10){
        $result = Apply::with('match')->where($map)->paginate($paginate);
        
        return $result;
    }

    // 统计用户数量
    public function countMembers($map){
    	$result = $this->ApplyModel->where($map)->count();
    	return $result?$result:0;
    }
    
    // 插入一条数据
    public function createApply($data){
        $validate = validate('ApplyVal');
        if(!$validate->check($data)){

             return ['msg' => $validate->getError(), 'code' => 100];
        }
        $result = $this->ApplyModel->save($data);
        if($result){
            if ($data['type'] == 1 && $data['organization_type'] == 1) {
                $MessageService = new \app\service\MessageService;
                $MessageService->saveMessageMemberInfo(['tital'=>'申请加入成功','content'=>"您申请加入{$data['organization']}成功",'member_id'=>$data['member_id'],'member'=>$data['member'],'url'=>url('frontend/camp/campInfo',['camp_id'=>$data['organization_id']])]);
            }elseif($data['type'] == 2 && $data['organization_type'] == 1){
                $MessageService = new \app\service\MessageService;
                $MessageService->saveMessageMemberInfo(['tital'=>'邀请加入成功','content'=>"您邀请{$data['member']}加入{$data['organization']}成功",'member_id'=>$data['invater_id'],'member'=>$data['invater'],'url'=>url('frontend/camp/campInfo',['camp_id'=>$data['organization_id']])]);
            }
           
            return ['code'=>200,'msg'=>'操作成功','data'=>$this->ApplyModel->id];
        }else{
            return ['code'=>100,'msg'=>'操作失败'];
        }
    }


    //更新一条数据
    public function updateApply($data,$apply_id){
        $validate = validate('ApplyVal');
        if(!$validate->scene('edit')->check($data)){
             return ['msg' => $validate->getError(), 'code' => 100];
        }
        $result = $this->ApplyModel->save($data,['id'=>$apply_id]);
        if($result){
            return ['code'=>200,'msg'=>'操作成功'];
        }else{
            return ['code'=>100,'msg'=>'操作失败'];
        }
    }
    
}