<?php 
namespace app\service;
use app\model\Coach;
use app\validate\CoachVal;

class CoachService{

	private $Coach;	
	public function __construct(){
		$this->Coach = new Coach;
	}

	/**
	 * 查询教练信息&&关联member表
	 */
	public function getCoachInfo($map){
		$CoachInfo = $this->Coach::with('member')->find();
		return $CoachInfo;
	}

	/**
	 * 申请成为教练
	 */
	public function createCoach($request){
		$result = $this->Coach->validate('CoachVal')->save($request);
		return $result;
	}


	/**
	 * 教练更改资料
	 */
	public function updateCoach($request,$id){
		$result = $this->Coach->save($request,['id'=>$id]);
		
		if($result ===false){
			return ['msg'=>$this->Coach->getError(),'code'=>200];
		}else{
			return ['msg'=>__lang('MSG_100_SUCCESS'),'code'=>100,'data'=>$result];
		}
	}
}