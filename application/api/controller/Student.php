<?php 
namespace app\api\controller;
use app\service\StudentService;
use app\api\controller\Base;

/**
* 学生控制器
*/
class Student extends Base
{
	protected $studentService;
	function __construct()
	{
		$this->studentService = new StudentService;
	}

	public function index(){
	}


	public function createStudentApi(){
		try{
			$data = input('post.');
			$data['member'] = $this->memberInfo['member'];
			$data['member_id'] = $this->memberInfo['id'];
			$result = $this->studentService->createStudent($data);
			return json($result);
		}catch (Exception $e){
			return json(['code'=>100,'msg'=>$e->getMessage()]);
		}
		
	}


	
	public function updateStudentApi(){
		try{
			$data = input('post.');
			$student_id = input('student_id');
			$result = $this->studentService->updateStudent($data,$student_id);
			return json($result);
		}catch (Exception $e){
			return json(['code'=>100,'msg'=>$e->getMessage()]);
		}
		
	}

	public function getStudentListApi(){
		try{
			dump(session('memberInfo','','think'));
			dump($this->memberInfo);
			$member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
			$result = $this->studentService->getStudentList(['member_id'=>$member_id]);
			dump($result);
			if($result){
				return json(['data'=>$result,'code'=>100,'msg'=>'ok']);
			}else{
				return json(['code'=>100,'msg'=>'没数据了']);
			}
		}catch(Exception $e){
			return json(['code'=>100,'msg'=>$e->getMessage()]);
		}
		
	}	
}