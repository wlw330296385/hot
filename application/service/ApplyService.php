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
<<<<<<< HEAD
		 if($result){
            return $result->toArray();
        }
=======
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        return $result;
    }

    public function getApplyListByPage($map,$paginate = 10){
        $result = Apply::where($map)->paginate($paginate);
<<<<<<< HEAD
        if($result){
            return $result->toArray();
        }
        return $result;
    }

=======
        
        return $result;
    }

    public function getApplyListWithMtachByPage($map,$paginate = 10){
        $result = Apply::with('match')->where($map)->paginate($paginate);
        
        return $result;
    }
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4

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