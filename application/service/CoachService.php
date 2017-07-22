<?php 
namespace app\service;
use app\model\Coach;
use app\common\validate\CoachVal;

class CoachService{
	private $Coach;
	public function __construct(){
		$this->Coach = new Coach();
	}

	/**
	 * 查询教练信息&&关联member表
	 */
	public function getCoachInfo($id){
        $coach = Coach::with('MemberInfo')->where('id', $id)->find();
        if (!$coach)
            return [ 'msg' => __lang('MSG_201_DBNOTFOUND'), 'code' => 200 ];

        return [ 'msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $coach->toArray()];
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
	public function updateCoach($request)
    {
        $result = $this->Coach->validate('CoachVal')->save($request);

        if ($result === false) {
            return ['msg' => $this->Coach->getError(), 'code' => 200];
        } else {
            return ['msg' => __lang('MSG_100_SUCCESS'), 'code' => 100, 'data' => $result];
        }
    }
	
	// 教练列表
	public function coachList($map=[], $order='') {
	    $result = Coach::with('MemberInfo')->where($map)->order($order)->select();
	    //return $result;
        if (!$result) {
            return [ 'msg' => __lang('MSG_201_DBNOTFOUND'), 'code' => 200 ];
        }
        if ($result->isEmpty()) {
            return [ 'msg' => __lang('MSG_000_NULL'), 'code' => 000, 'data' => ''];
        }
        return [ 'msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $result->toArray()];
    }

    // 教练列表 分页
    public function coachListPage($paginate=0, $map=[], $order='') {
        $result = Coach::with('MemberInfo')->where($map)->order($order)->paginate($paginate);
        //return $result;
        if (!$result) {
            return [ 'msg' => __lang('MSG_201_DBNOTFOUND'), 'code' => 200 ];
        }
        if ($result->isEmpty()) {
            return [ 'msg' => __lang('MSG_000_NULL'), 'code' => 000, 'data' => ''];
        }
        return [ 'msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $result];
    }
    
    public function updateCoachStatus($request) {
	    $result = Coach::update($request);
	    if (!$result) {
	        return [ 'msg' => __lang('MSG_200_ERROR'), 'code' => 200 ];
        } else {
            return ['msg' => __lang('MSG_100_SUCCESS'), 'code' => 100, 'data' => $result];
        }
    }

    public function SoftDeleteCamp($id) {
        $result = Coach::destroy($id);
        if (!$result) {
	        return [ 'msg' => __lang('MSG_200_ERROR'), 'code' => 200 ];
        } else {
            return ['msg' => __lang('MSG_100_SUCCESS'), 'code' => 100, 'data' => $result];
        }
    }
}