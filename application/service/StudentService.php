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
		$reuslt = $this->studentModel->validate('StudentVal')->data($data)->save();
		if($result){
			return ['code'=>100,'msg'=>'ok','data'=>$result];
		}else{
			return ['code'=>200,'msg'=>$this->studentModel->getError()];
		}
	}

	public function updateStudent($data,$id){
		$result = $this->studentModel->validate('StudentVal')->save($data,$id);
		if($result){
			return ['code'=>100,'msg'=>'ok','data'=>$result];
		}else{
			return ['code'=>200,'msg'=>$this->studentModel->getError()];
		}
	}
	/**
	 * 	
	 */
	public function buyLesson($request,$id = false){
		//是否完善资料
		$is_student = $this->studentModel->where(['member_id'=>$this->memberInfo['id']])->find()->toArray();
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

    public function getStudentGradeList($map){
    	$result = $this->gradeMemberModel->where($map)->paginate(10);
    	if($result){
			$res = $result->toArray();return $res['data'];
		}
		return $result;
    }

    public function getStudentScheduleList($map){
    	$result = $this->scheduleMemberModel->where($map)->paginate(10);
    	if($result){
			$res = $result->toArray();return $res['data'];
		}
    	return $result;
    }

    public function getStudentList($map){
    	$result = $this->gradeMemberModel->where($map)->paginate(10);
    	if($result){
			$res = $result->toArray();return $res['data'];
		}
    	return $result;
    }
}