<?php 
namespace app\service;
use app\model\LessonMember;
use think\Db;
class LessonMemberService{
	protected $LessonMemberModel;
	public function __construct(){
		$this->LessonMemberModel = new LessonMember;
	}


	public function getLessonMemberList($map,$page = 1,$paginate = 10){
		$result = $this->LessonMemberModel->where($map)->page($page,$paginate)->select();
		 if($result){
            return $result->toArray();
        }
        return $result;
    }

    public function getLessonMemberListByPage($map,$paginate = 10){
        $result = $this->LessonMemberModel->with('student')->where($map)->paginate($paginate);
        if($result){
            return $result->toArray();
        }
        return $result;
    }


    //获取教练拥有的班级
    public function getGradeOfCoach($map){
    	$res = $this->LessonMemberModel->with('grade')->where($map)->select();
        if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return $res;
        }
        
    }
    // 统计用户数量
    public function countMembers($map){
    	$result = $this->LessonMemberModel->where($map)->count();
    	return $result?$result:0;
    }
    
    
    
}