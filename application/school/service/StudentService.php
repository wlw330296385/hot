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
	    $model = new Student();
        $res = $model->with('member')->where($map)->find();
        if($res){
            $result = $res->toArray();
            $result['age'] = getAgeByBirthday($result['student_birthday']);
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
        if(isset($data['address'])){
            $res = explode(' ', $data['address']);
            $data['student_province'] = $res[0];
            $data['student_city'] = $res[1];
            $data['student_area'] = isset($res[2])?$res[2]:$res[1];
        }

		$result = $this->studentModel->allowField(true)->data($data)->save();
		if($result){
			return ['code'=>200,'msg'=>'添加成功','data'=>$result];
		}else{
			return ['code'=>100,'msg'=>$this->studentModel->getError()];
		}
	}

	public function updateStudent($data,$id){
		$validate = validate('StudentVal');
        if(!$validate->scene('edit')->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        if(isset($data['address'])){
            $res = explode(' ', $data['address']);
            $data['student_province'] = $res[0];
            $data['student_city'] = $res[1];
            $data['student_area'] = isset($res[2])?$res[2]:$res[1];
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

    // 学员参加的课程列表
    public function getInLessons($map=[]){
        $res = db('lesson_member')->where($map)->whereNull('delete_time')->select();
        if (!$res) {
            return $res;
        }
        // 遍历课程信息
        foreach ($res as $k => $val) {
            $res[$k]['lesson'] = db('lesson')->where('id', $val['lesson_id'])->whereNull('delete_time')->find();
        }
        return $res;
    }

    // 学员所在班级列表
    public function getInGrades($map=[]) {
        $res = db('grade_member')->where($map)->whereNull('delete_time')->select();
        if (!$res) {
            return $res;
        }
        // 遍历班级信息
        foreach ($res as $k => $val) {
            $res[$k]['grade'] = db('grade')->where('id', $val['grade_id'])->whereNull('delete_time')->find();
        }
        return $res;
    }

    // 学员所在训练营列表
    public function getCamps($map=[]) {
        $where['student.id'] = $map['student_id'];
        $where['camp_member.camp_id'] = $map['camp_id'];
        if (!isset($map['status'])) {
            $where['camp_member.status'] = 1;
        }
        $result = Db::view('camp_member')
            ->view('student', ['id' => 'student_id', 'member_id', 'student', 'student_sex', 'student_avatar'], 'student.member_id=camp_member.member_id')
            ->where($where)
            ->where('camp_member.delete_time', null)
            ->select();
        return $result;
    }
}