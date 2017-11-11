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
            return ['msg' => $validate->getError(), 'code' => 100];
        }
		$result = $this->studentModel->data($data)->save();
		if($result){
			return ['code'=>200,'msg'=>'ok','data'=>$result];
		}else{
			return ['code'=>100,'msg'=>$this->studentModel->getError()];
		}
	}

	public function updateStudent($data,$id){
		$validate = validate('CampVal');
        if(!$validate->scene('edit')->check($StudentVal)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
		$result = $this->studentModel->save($data,['id'=>$id]);
		if($result){
			return ['code'=>200,'msg'=>'ok','data'=>$result];
		}else{
			return ['code'=>100,'msg'=>$this->studentModel->getError()];
		}
	}


	// 获取一个教练下的所有学生
	public function getStudentListOfCoach($map,$page = 1,$paginate = 10){
		$result = $this->gradeMemberModel->where($map)->page($page,$paginate)->select();
		if($result){
			$res = $result->toArray();return $res;
		}
		return $result;
    }

    // 获取学生班级?
    public function getStudentGradeList($map,$page = 1,$paginate = 10){
    	$result = $this->gradeMemberModel->where($map)->page($page,$paginate)->select();
    	if($result){
			$res = $result->toArray();return $res;
		}
		return $result;
    }

    // 获取课时学生列表
    public function getStudentScheduleList($map,$page = 1,$paginate = 10){
    	$result = db('schedule_member')->where($map)->page($page,$paginate)->select();
    	if($result){
			$res = $result->toArray();return $res;
		}
    	return $result;
    }

    // 获取学生?
    public function getStudentListOfCamp($map,$page = 1,$paginate = 10){
    	$result = $this->gradeMemberModel->where($map)->page($page,$paginate)->select();
    	if($result){
			$res = $result->toArray();
			return $res;
		}
    	return $result;
    }

     // 获取用户学生列表
    public function getStudentList($map,$page = 1,$order = 'id desc',$paginate = 10){
        $result = $this->studentModel->where($map)->order($order)->page($page,$paginate)->select();

        if($result){
			$res = $result->toArray();
			return $res;
		}
    	return $result;
    }




    // 批量更新学生数据
    public function saveAllStudent($data){
    	//重组上课学员
        // foreach ($students as $key => $value) {
        //     $students[$key]['grade_id'] = $grade_id;
        //     $students[$key]['grade'] = $grade;
        // }
        // dump($students);die;
    	$result = $this->gradeMemberModel->saveAll($data);
    	//echo $this->gradeMemberModel->getlastsql();
    	if($result){
			return ['code'=>200,'msg'=>__lang('MSG_200'),'data'=>$result];
		}else{
			return ['code'=>100,'msg'=>$this->gradeMemberModel->getError()];
		}
    }


    // 班级学生变动
    public function updateGradeMember($data,$id){
        $result = $this->gradeMemberModel->save($data,['id'=>$id]);
        if($result){
			return ['code'=>200,'msg'=>'ok','data'=>$result];
		}else{
			return ['code'=>100,'msg'=>$this->gradeMemberModel->getError()];
		}
    }


    // 已上课程+1
    public function setIncFinishedTotal($num = 1,$student_id){
    	$this->studentModel->where(['id'=>$student_id])->setInc('finished_total',$num);
    }


    // 准哥要的

	public function getStudentListByPage($map=[], $order='', $paginate=10) {
	    $result =  $this->studentModel->where($map)->order($order)->paginate($paginate);
	    if($res){           
	        $res = $result->toArray();
	        return $res;
	    }else{
	        return $result;
	    }
        
    }

    // 学员参加的课程
    public function getLessons($map=[]){
        $where['lesson_member.camp_id'] = $map['camp_id'];
        if (isset($map['student_id'])) {
            $where['lesson_member.student_id'] = $map['student_id'];
        }
        $where['lesson_member.member_id'] = $map['member_id'];
        if (isset($map['status'])) {
            $where['lesson_member.status'] = $map['status'];
        }
        $result = Db::view('lesson')
            ->view('lesson_member', ['student_id','student','member_id','member','status' => 'lesson_member_status','rest_schedule'], 'lesson_member.lesson_id=lesson.id')
            ->where($where)
            ->where('lesson.delete_time', null)
            ->select();
        return $result;
    }

    // 学员所在班级
    public function getGrades($map=[]) {
        $where['grade_member.camp_id'] = $map['camp_id'];
        $where['grade_member.student_id'] = $map['student_id'];
        $where['grade_member.member_id'] = $map['member_id'];
        if (isset($map['status'])) {
            $where['grade_member.status'] = $map['status'];
        }
        $result = Db::view('grade')
            ->view('grade_member', ['student_id', 'student', 'member', 'member_id', 'status' => 'grade_member_status'], 'grade_member.grade_id=grade.id')
            ->where($where)
            ->where('grade.delete_time', null)
            ->select();
        return $result;
    }
}