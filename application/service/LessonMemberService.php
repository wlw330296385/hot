<?php 
namespace app\service;
use app\model\LessonMember;
use think\Db;
class LessonMemberService{
	protected $LessonMemberModel;
	public function __construct(){
		$this->LessonMemberModel = new LessonMember;
	}


	public function getLessonMemberList($map = [],$page = 1,$paginate = 10){
		$result = $this->LessonMemberModel->where($map)->page($page,$paginate)->select();
		 if($result){
            return $result->toArray();
        }
        return $result;
    }

    public function getLessonMemberListByPage($map = [],$paginate = 10){
        $result = $this->LessonMemberModel->where($map)->paginate($paginate);

        if($result){
            return $result->toArray();
        }
        return $result;
    }


    public function getLessonMemberListOfCampWithStudentByPage($map = [],$paginate = 10){
        $result = $this->LessonMemberModel->distinct(true)->field('student_id,student,lesson')->with('student')->where($map)->paginate($paginate);
        // echo $this->LessonMemberModel->getlastsql();
        if($result){
            return $result->toArray();
        }
        return $result;
    }

    public function getLessonMemberListWithStudentByPage($map=[],$paginate = 10){
        $result = $this->LessonMemberModel->with('student')->where($map)->paginate($paginate);
        if($result){
            return $result->toArray();
        }
        return $result;
    }

    //获取教练拥有的班级
    public function getGradeOfCoach($map = []){
    	$res = $this->LessonMemberModel->with('grade')->where($map)->select();
        if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return $res;
        }
        
    }
    // 统计用户数量
    public function countMembers($map = []){
    	$result = $this->LessonMemberModel->where($map)->count();
    	return $result?$result:0;
    }
    
    // 修改lesson_member
    public function updateLessonMember($data,$map){
        $result = $this->LessonMemberModel->save($data,$map);
        if($result){
            return ['code'=>200,'msg'=>'操作成功'];
        }else{
            return ['code'=>100,'msg'=>$this->LessonMemberModel->getError()];
        }    
    }

    // 添加lesson_member
    public function createLessonMember($data){
        $result = $this->LessonMemberModel->save($data);
        if($result){
            return ['code'=>200,'msg'=>'操作成功'];
        }else{
            return ['code'=>100,'msg'=>$this->LessonMemberModel->getError()];
        }    
    }

    // 添加lesson_member
    public function getLessonMemberInfo($map){
        $result = $this->LessonMemberModel->where($map)->find();
        return $result;
    }

    // 课程转移
    public function transferLesson(){
            
    }
}