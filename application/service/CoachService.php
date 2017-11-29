<?php 
namespace app\service;
use app\model\Coach;
use app\common\validate\CoachVal;
use app\model\Grade;
use think\Db;
class CoachService{
	private $CoachModel;
	public function __construct(){
		$this->CoachModel = new Coach();
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
        $model = new Coach();
        $result = $model->validate('CoachVal')->save($request);
        if ($result === false) {
            return ['code' => 100, 'msg' => $model->getError()];
        }else{
            return ['code'=>200,'msg'=>__lang('MSG_200'),'data'=> $model->getLastInsID() ];
        }
    }


	/**
	 * 教练更改资料
	 */
	public function updateCoach($request,$id)
    {
        $model = new Coach();
        $result = $model->validate('CoachVal')->save($request, ['id' => $id]);
        if ($result === false) {
            return ['code' => 100, 'msg' => $model->getError()];
        } else {
            return ['code' => 200, 'msg' => __lang('MSG_200')];
        }
    }
	


    // 教练列表 分页
    public function getCoachListByPage( $map=[],$order='',$paginate = 10) {
        $res = Coach::with('member')->where($map)->order($order)->paginate($paginate);
        if($res){
            $result = $res->toArray();
        }else{
            $res;
        }
    }
    
    public function updateCoachStatus($request) {
	    $result = Coach::update($request);
	    if (!$result) {
	        return [ 'msg' => __lang('MSG_400'), 'code' => 100 ];
        }else{
            return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }
    }

    public function SoftDeleteCamp($id) {
        $result = Coach::destroy($id);
        if (!$result) {
	        return [ 'msg' => __lang('MSG_400'), 'code' => 100 ];
        } else {
            return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }
    }



    // 教练列表 分页
    public function getCoachList($map=[],$page=1, $paginate = 10, $order='') {
        $result = $this->CoachModel->where($map)->order($order)->page($page,$paginate)->select();
        if($result){
            $res = $result->toArray();
            foreach ($res as $k => $val) {
                if ($val['star'] >0) {
                    $res[$k]['star'] = ceil($val['star']/$val['star_num']);
                }
            }
            return $res;
        }else{
            return $result;
        }
        
    }


    // 教练列表 分页
    public function getCoachListOfCamp($map=[],$page = 1, $paginate = 10, $order='') {
        $result = Db::view('camp_member','member_id,type')
                ->view('coach','*','camp_member.member_id=coach.member_id')
                ->where($map)
                ->order($order)
                ->page($page,$paginate)
                ->select();
        return $result;
    }



     // 教练列表 分页
    public function getCoachListOfCampByPage($map=[], $order='', $paginate = 10) {
        $result = Db::view('camp_member','member_id,type')
                ->view('coach','*','camp_member.member_id=coach.member_id')
                ->where($map)
                ->order($order)
                ->paginate($paginate);
        return $result;
    }

    public function getCoachInfo($map){
        $res = $this->CoachModel->with('member')->where($map)->find();
        if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return $res;
        }
    }

    // 教练在训练营的班级列表
    public function ingradelist($coach_id, $camp_id=0) {
        $model = new Grade();
        $map = [];
        if ($camp_id) {
            $map['camp_id'] = $camp_id;
        }
        $coach = $this->coachInfo(['id' => $coach_id]);
        $res = $model->where($map)
            ->where('coach_id = :coach_id or assistant like :coach', ['coach_id' => $coach_id, 'coach' => "%".$coach['coach']."%"])
            ->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 教练在训练营的班级列表(有分页)
    public function ingradelistPage($coach_id, $camp_id=0, $order='id desc', $paginate=10) {
        $model = new Grade();
        $map = [];
        if ($camp_id) {
            $map['camp_id'] = $camp_id;
        }
        $coach = $this->coachInfo(['id' => $coach_id]);
        $res = $model->where($map)
            ->where('coach_id = :coach_id or assistant like :coach', ['coach_id' => $coach_id, 'coach' => "%".$coach['coach']."%"])
            ->order($order)
            ->paginate($paginate);
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 教练在训练营的课程列表
    public function inlessonlist($coach_id, $camp_id) {
        $model = new \app\model\Lesson();
        $iscoachlist = $model->where(['camp_id' => $camp_id, 'coach_id' => $coach_id])->select();
        if (!$iscoachlist) {
            return $iscoachlist;
        }
        $isassistantlist = [];
        $assistants = $model->where(['camp_id' => $camp_id])->select();
        if (!$assistants) {
            return $assistants;
        }
        $assistants = $assistants->toArray();

        foreach ($assistants as $assistant) {
            if ($assistant) {
                $assistantId = unserialize($assistant['assistant_id']);
                if ($assistantId) {
                    foreach ($assistantId as $val) {
                        if ($val && $val == $coach_id) {
                            array_push($isassistantlist, $assistant);
                        }
                    }
                }
            }
        }
        $result = array_merge($iscoachlist->toArray(), $isassistantlist);
        return $result;
    }

    // 教练执教学员统计
    public function teachstudents($coach_id) {
        $grades = $this->ingradelist($coach_id);
        if ($grades) {
            //return $grades;
            $gradeIds = [];
            foreach ($grades as $grade) {
                array_push($gradeIds, $grade['id']);
            }
            //dump($gradeIds);
            $students = db('grade_member')->distinct(true)->field('member_id')->where(['grade_id'=>['in',$gradeIds],'type'=>1,'status'=>1])->where('delete_time', null)->count();
            return $students;
        } else {
            return 0;
        }
    }


    // 创建教练评论
    public function createCoachComment($data){
        $CoachComemnt = new \app\model\CoachComment;
        $result = $CoachComemnt->save($data);
        if($result){
            return ['code' => 200, 'msg' => '评论成功'];
        }else{
            return ['code' => 100, 'msg' => $CoachComemnt->getError()];
        }
    }
}