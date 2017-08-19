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
		$result = GradeMember::where($map)->select();
		if($result){
            $result = $result->toArray();
        }
        return $result;
    }

    //获取教练拥有的班级
    public function getGradeOfCoach($map){
    	$result = GradeMember::with('grade')->where($map)->select()->toArray();
        if($result){
                    $result = $result->toArray();
                }
        return $result;
    }
    // 统计用户数量
    public function countMembers($map){
    	$result = $this->gradememberModel->where($map)->count();
    	return $result?$result:0;
    }
    
    
}