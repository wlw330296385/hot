<?php 
namespace app\service;
use app\model\ScheduleMember;
use think\Db;
class ScheduleMemberService{
	protected $scheduleMemberModel;
	public function __construct(){
		$this->scheduleMemberModel = new ScheduleMember;
	}

	public function getScheduleMemberList($map){
		$result = $this->scheduleMemberModel->where($map)->select();
		if($result){
			$res = $result->toArray();
			return $res;
		}
		return $result;		

    }

    public function getScheduleMemberListWithSchedule($map){
        $result = $this->scheduleMemberModel->with('schedule')->where($map)->select();
        if($result){
            $res = $result->toArray();
            return $res;
        }
        return $result;     

    }

 	public function getScheduleMemberListByPage($map,$paginate = 10){
        $result = $this->scheduleMemberModel->where($map)->paginate($paginate);
        if($result){
            return $result->toArray();
        }
        return $result;
    }

    public function getScheduleMemberListWithScheduleByPage($map,$paginate = 10){
        $result = $this->scheduleMemberModel->with('schedule')->where($map)->paginate($paginate);
        if($result){
            return $result->toArray();
        }
        return $result;
    }

    public function getScheduleMemberListOfCampByPage($map,$paginate = 10){
        $result = $this->scheduleMemberModel->distinct('true')->field('schedule_id')->where($map)->paginate($paginate);
        if($result){
            return $result->toArray();
        }
        return $result;
    }

    //获取教练拥有的班级
    public function getGradeOfCoach($map){
    	$res = $this->scheduleMemberModel->with('grade')->where($map)->select();
        if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return $res;
        }
        
    }
    // 统计用户数量
    public function countMembers($map){
    	$result = $this->ScheduleMemberModel->where($map)->count();
    	return $result?$result:0;
    }

}