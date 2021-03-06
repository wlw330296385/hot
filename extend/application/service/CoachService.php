<?php 
namespace app\service;
use app\model\Coach;
use app\common\validate\CoachVal;
use app\model\GradeMember;
use think\Db;
class CoachService{
	private $CoachModel;
	public function __construct(){
		$this->CoachModel = new Coach();
        $this->gradeMemberModel = new GradeMember;
	}

	/**
	 * 查询教练信息&&关联member表
	 */
	public function coachInfo($map){
        $res = Coach::with('member')->where($map)->find();
        if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return $res;
        }
	}

	/**
	 * 申请成为教练
	 */
	public function createCoach($request){
        $validate = validate('CoachVal');
        if(!$validate->check($request)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
		$result = $this->CoachModel->validate('CoachVal')->save($request);
        if($result){
            return ['code'=>100,'msg'=>'OK','data'=>$result];
        }else{
            return ['code'=>100,'msg'=>$this->CoachModel->getError()];
        }
	}


	/**
	 * 教练更改资料
	 */
	public function updateCoach($request,$id)
    {
        $validate = validate('CoachVal');
        if(!$validate->check($request)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        $result = $this->CoachModel->save($request,$id);

        if ($result === false) {
            return ['msg' => $this->Coach->getError(), 'code' => 200];
        } else {
            return ['msg' => __lang('MSG_100_SUCCESS'), 'code' => 100, 'data' => $result];
        }
    }
	
	// 教练列表
	public function coachList($map=[], $order='') {
	    $result = Coach::with('member')->where($map)->order($order)->select();
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
    public function coachListPage( $map=[], $paginate=0,$order='') {
        $result = Coach::with('member')->where($map)->order($order)->paginate($paginate);
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
        }else{
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


    // // 获取训练营下的教练
    // public function getCoahListOfCamp($map){
    //     $result = $this->gradeMemberModel->where($map)->paginate($paginate);
    //     return $result->toArray();
    // }

    public function getCoachListPage(){
        $result = Coach::with('member')->where($map)->order($order)->paginate($paginate);
        if (!$result) {
            return [ 'msg' => __lang('MSG_201_DBNOTFOUND'), 'code' => 200 ];
        }
        if ($result->isEmpty()) {
            return [ 'msg' => __lang('MSG_000_NULL'), 'code' => 000, 'data' => []];
        }
        return [ 'msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $result->toArray()];
    }   



    // 教练列表 分页
    public function getCoachList($map=[], $paginate = 10, $order='') {
        $result = $this->CoachModel->where($map)->order($order)->paginate($paginate);
        if($result){
            $result = $result->toArray();
            return $result['data'];
        }else{
            return $result;
        }
        
    }


    // 教练列表 分页
    public function getCoachListOfCamp($map=[], $paginate = 10, $order='') {
        $result = Db::view('grade_member','*')
                ->view('coach','portraits,star,sex,coach_year,coach_level','grade_member.coach_id=coach.id')
                ->where($map)
                ->order($order)
                ->paginate($paginate);
                // echo db('grade_member')->getlastsql();die;
        if($result){
            $result = $result->toArray();
            return $result['data'];
        }else{
            return $result;
        }
        
    }

    public function getCoachInfo($map){
        $res = $this->CoachModel->where($map)->find();
        if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return $res;
        }
    }
}