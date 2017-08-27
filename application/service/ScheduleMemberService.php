<?php 
namespace app\service;
use app\model\ScheduleMember;
use think\Db;
class ScheduleMemberService{
	protected $scheduleMemberModel;
	public function __construct(){
		$this->scheduleMemberModel = new ScheduleMember;
	}

	public function getScheduleList($map){
		$result = ScheduleMember::where($map)->select()->toArray();
		return $result;
    }

 	

}