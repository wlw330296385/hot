<?php 
namespace app\service;
use app\model\LessonMember;
use think\Db;
class LessonMemberService{
	protected $LessonMemberModel;
	public function __construct(){
		$this->LessonMemberModel = new LessonMember;
	}


<<<<<<< HEAD
	public function getLessonMemberList($map,$page = 1,$paginate = 10){
=======
	public function getLessonMemberList($map = [],$page = 1,$paginate = 10){
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
		$result = $this->LessonMemberModel->where($map)->page($page,$paginate)->select();
		 if($result){
            return $result->toArray();
        }
        return $result;
    }

<<<<<<< HEAD
    public function getLessonMemberListByPage($map,$paginate = 10){
=======
    public function getLessonMemberListByPage($map = [],$paginate = 10){
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        $result = $this->LessonMemberModel->where($map)->paginate($paginate);

        if($result){
            return $result->toArray();
        }
        return $result;
    }


<<<<<<< HEAD
    public function getLessonMemberListOfCampWithStudentByPage($map,$paginate = 10){
        $result = $this->LessonMemberModel->with('student')->where($map)->distinct(true)->paginate($paginate);
=======
    public function getLessonMemberListOfCampWithStudentByPage($map = [],$paginate = 10){
        $result = $this->LessonMemberModel->distinct(true)->field('student_id,student,lesson')->with('student')->where($map)->paginate($paginate);
        // echo $this->LessonMemberModel->getlastsql();
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
        if($result){
            return $result->toArray();
        }
        return $result;
    }

<<<<<<< HEAD

    //获取教练拥有的班级
    public function getGradeOfCoach($map){
=======
    public function getLessonMemberListWithStudentByPage($map=[],$paginate = 10){
        $result = $this->LessonMemberModel->with('student')->where($map)->paginate($paginate);
        if($result){
            return $result->toArray();
        }
        return $result;
    }

    //获取教练拥有的班级
    public function getGradeOfCoach($map = []){
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
    	$res = $this->LessonMemberModel->with('grade')->where($map)->select();
        if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return $res;
        }
        
    }
    // 统计用户数量
<<<<<<< HEAD
    public function countMembers($map){
=======
    public function countMembers($map = []){
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
    	$result = $this->LessonMemberModel->where($map)->count();
    	return $result?$result:0;
    }
    
<<<<<<< HEAD
    // 预约课程
    public function bookLesson($data){
        
    }
    
=======
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
>>>>>>> 12f73e9f54aec3c924def7292bf18f1602adfef4
}