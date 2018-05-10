<?php 
namespace app\service;
use app\model\EventMember;
use think\Db;
class EventMemberService{
	protected $EventMemberModel;
	public function __construct(){
		$this->EventMemberModel = new EventMember;
	}


	public function getEventMemberList($map,$page = 1,$paginate = 10){
		$result = $this->EventMemberModel->where($map)->page($page,$paginate)->select();
		 if($result){
            return $result->toArray();
        }
        return $result;
    }

    public function getEventMemberListByPage($map,$paginate = 10){
        $result = $this->EventMemberModel->with('eventInfo')->where($map)->paginate($paginate);
        if($result){
            return $result->toArray();
        }
        return $result;
    }

    public function getEventMemberListOfCampByPage($map,$paginate = 10){
        $result = $this->EventMemberModel->distinct('true')->field('member_id')->where($map)->paginate($paginate);
        if($result){
            return $result->toArray();
        }
        return $result;
    }

    // 统计用户数量
    public function countMembers($map){
    	$result = $this->EventMemberModel->where($map)->count();
    	return $result?$result:0;
    }
    
    
    
}