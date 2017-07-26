<?php 
namespace app\service;
use app\model\Student;
use app\model\GradeMember;
use think\Db;
use app\common\validate\StudentVal;
class StudentService{

	private $studentModel;

	public function __construct(){
		$this->studentModel = new Student;
		$this->gradeMemberModel = new GradeMember;
	}


	public function getStudentInfo($map){
			$result = $this->studentModel->where($map)->select()->toArray();
			if ($result === false) {
	        	return ['msg' => $this->studentModel->getError(), 'code' => 200];
		    } else {
		        return ['msg' => __lang('MSG_100_SUCCESS'), 'code' => 100, 'data' => $result];
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



	public function createStudent($request){
		$result = $this->studentModel->validate('StudentVal')->save($request);
		if ($result === false) {
	        return ['msg' => $this->studentModel->getError(), 'code' => 200];
	    } else {
	        return ['msg' => __lang('MSG_100_SUCCESS'), 'code' => 100, 'data' => $result];
		}
	}


	// 获取一个教练下的所有学生
	public function getStudentListOfCoach($map){
		$result = $this->gradeMemberModel->where($map)->select()->toArray();
		return $result;
    }
}