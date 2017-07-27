<?php 
namespace app\service;
use app\model\GradeMember;
use think\Db;
class GradeMemberService{
	protected $gradememberModel;
	public function __construct(){
		$this->gradememberModel = new GradeMember;
	}

	public function getList($map){
		$result = GradeMember::where($map)->select()->toArray();
		return $result;
    }

    //获取教练拥有的班级
    public function getGradeOfCoach($map){
    	$result = GradeMember::with('grade')->where($map)->select()->toArray();
    	// dump(GradeMember::getlastsql());die;
		return $result;
    }


}