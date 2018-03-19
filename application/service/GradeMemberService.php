<?php 
namespace app\service;
use app\model\GradeMember;
use think\Db;
class GradeMemberService{
	protected $gradememberModel;
	public function __construct(){
		$this->gradememberModel = new GradeMember;
	}


	public function getGradeMemberList($map,$page = 1,$paginate = 10){
		$result = GradeMember::where($map)->page($page,$paginate)->select();
		 if($result){
            return $result->toArray();
        }
        return $result;
    }

    public function getGradeMemberListByPage($map,$paginate = 10){
        $result = GradeMember::with('student')->where($map)->paginate($paginate);
        if($result){
            return $result->toArray();
        }
        return $result;
    }

    public function getGradeMemberListOfCampByPage($map,$paginate = 10){
        $result = GradeMember::with('student')->distinct('true')->field('student_id')->where($map)->paginate($paginate);
        if($result){
            return $result->toArray();
        }
        return $result;
    }

    //获取教练拥有的班级
    public function getGradeOfCoach($map){
    	$res = GradeMember::with('grade')->where($map)->select();
        if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return $res;
        }
        
    }
    // 统计用户数量
    public function countMembers($map){
    	$result = $this->gradememberModel->where($map)->count();
    	return $result?$result:0;
    }
    
    
    
}