<?php 
namespace app\service;
use app\model\Student;
use app\model\GradeMember;
use app\model\ScheduleMember;
use think\Db;
use app\common\validate\StudentVal;
class StudentService{

	private $studentModel;
	private $gradeMemberModel;
	private $scheduleMemberModel;
	public function __construct(){
		$this->studentModel = new Student;
		$this->gradeMemberModel = new GradeMember;
		$this->scheduleMemberModel = new ScheduleMember;
	}


	public function getStudentInfo($map){
			$res = $this->studentModel->where($map)->find();
			if($res){
				$result = $res->toArray();
				return $result;
			}else{
				return $res;
			}
			
	}	

	public function createStudent($data){
		$validate = validate('StudentVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
		$reuslt = $this->studentModel->data($data)->save();
		if($result){
			return ['code'=>100,'msg'=>'ok','data'=>$result];
		}else{
			return ['code'=>200,'msg'=>$this->studentModel->getError()];
		}
	}

	public function updateStudent($data,$id){
		$validate = validate('CampVal');
        if(!$validate->check($StudentVal)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
		$result = $this->studentModel->save($data,$id);
		if($result){
			return ['code'=>100,'msg'=>'ok','data'=>$result];
		}else{
			return ['code'=>200,'msg'=>$this->studentModel->getError()];
		}
	}
	/**
	 * 	购买课程
	 */
	public function buyLesson($request,$id = false){
		//是否完善资料
		$is_student = $this->studentModel->where(['member_id'=>$this->memberInfo['id']])->find();
		if(!$is_student){
			return false;
		}
		if($id){
			$result = $this->gradeMemberModel->save($request,$id);
		}else{
			$result = $this->gradeMemberModel->save($request);
		}
		if($result){
			return true;
		}else{
			return false;
		}
	}


	// 获取一个教练下的所有学生
	public function getStudentListOfCoach($map){
		$result = $this->gradeMemberModel->where($map)->paginate(10);
		if($result){
			$res = $result->toArray();return $res['data'];
		}
		return $result;
    }

    // 获取学生班级?
    public function getStudentGradeList($map){
    	$result = $this->gradeMemberModel->where($map)->paginate(10);
    	if($result){
			$res = $result->toArray();return $res['data'];
		}
		return $result;
    }

    // 获取课时学生列表
    public function getStudentScheduleList($map){
    	$result = db('schedule_member')->where($map)->paginate(10);
    	if($result){
			$res = $result->toArray();return $res['data'];
		}
    	return $result;
    }

    // 获取学生?
    public function getStudentListOfCamp($map){
    	$result = $this->gradeMemberModel->where($map)->paginate(10);
    	if($result){
			$res = $result->toArray();return $res['data'];
		}
    	return $result;
    }

     // 获取用户学生列表
    public function getStudentList($map){
        $result = $this->studentModel->where($map)->select();
        echo $this->studentModel->getlastsql();
        if($result){
			$res = $result->toArray();
			return $res;
		}
    	return $result;
    }
}