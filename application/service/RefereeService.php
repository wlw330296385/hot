<?php 
namespace app\service;
use app\model\Referee;
use app\common\validate\RefereeVal;
use app\model\Grade;
use think\Db;
class RefereeService{
	private $RefereeModel;
	public function __construct(){
		$this->RefereeModel = new Referee();
	}

	/**
	 * 查询裁判信息&&关联member表
	 */
	public function refereeInfo($map){
        $res = Referee::with('member')->where($map)->find();
        if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return $res;
        }
	}

	/**
	 * 申请成为裁判
	 */
	public function createReferee($request){
        $model = new Referee();
        $result = $model->validate('RefereeVal')->save($request);
        if ($result === false) {
            return ['code' => 100, 'msg' => $model->getError()];
        }else{
            return ['code'=>200,'msg'=>__lang('MSG_200'),'data'=> $model->getLastInsID() ];
        }
    }


	/**
	 * 裁判更改资料
	 */
	public function updateReferee($request,$id)
    {
        $model = new Referee();
        $result = $model->validate('RefereeVal')->save($request, ['id' => $id]);
        if ($result === false) {
            return ['code' => 100, 'msg' => $model->getError()];
        } else {
            return ['code' => 200, 'msg' => __lang('MSG_200')];
        }
    }
	


    // 裁判列表 分页
    public function getRefereeListByPage( $map=[],$order='id desc',$paginate = 10) {
        $res = Referee::with('member')->where($map)->order($order)->paginate($paginate);
        if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return $res;
        }
    }
    
    public function updateRefereeStatus($request) {
	    $result = Referee::update($request);
	    if (!$result) {
	        return [ 'msg' => __lang('MSG_400'), 'code' => 100 ];
        }else{
            return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }
    }

    public function SoftDeleteCamp($id) {
        $result = Referee::destroy($id);
        if (!$result) {
	        return [ 'msg' => __lang('MSG_400'), 'code' => 100 ];
        } else {
            return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }
    }



    // 裁判列表 分页
    public function getRefereeList($map=[], $page=1, $order='id desc', $paginate = 10 ) {
        $result = $this->RefereeModel->where($map)->order($order)->page($page,$paginate)->select();
        
        return $result;
        
    }


    // 裁判列表 分页
    public function getRefereeListOfCamp($map=[],$page = 1, $paginate = 10, $order='') {
        $result = Db::view('camp_member','member_id,type')
                ->view('referee','*','camp_member.member_id=referee.member_id')
                ->where($map)
                ->order($order)
                ->page($page,$paginate)
                ->select();
        return $result;
    }



     // 裁判列表 分页
    public function getRefereeListOfCampByPage($map=[], $order='', $paginate = 10) {
        $result = Db::view('camp_member','member_id,type')
                ->view('referee','*','camp_member.member_id=referee.member_id')
                ->where($map)
                ->order($order)
                ->paginate($paginate);
        return $result;
    }

    public function getRefereeInfo($map){
        $res = $this->RefereeModel->with('member')->where($map)->find();
        if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return $res;
        }
    }

    // 裁判在训练营的班级列表
    public function ingradelist($referee_id, $camp_id=0) {
        $model = new Grade();
        $map = [];
        if ($camp_id) {
            $map['camp_id'] = $camp_id;
        }
        $referee = $this->refereeInfo(['id' => $referee_id]);
        $res = $model->where($map)
            ->where('referee_id = :referee_id or assistant like :referee', ['referee_id' => $referee_id, 'referee' => "%".$referee['referee']."%"])
            ->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 裁判在训练营的班级列表(有分页)
    public function ingradelistPage($referee_id, $camp_id=0, $order='id desc', $paginate=10) {
        $model = new Grade();
        $map = [];
        if ($camp_id) {
            $map['camp_id'] = $camp_id;
        }
        $referee = $this->refereeInfo(['id' => $referee_id]);
        $res = $model->where($map)
            ->where('referee_id = :referee_id or assistant like :referee', ['referee_id' => $referee_id, 'referee' => "%".$referee['referee']."%"])
            ->order($order)
            ->paginate($paginate);
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 裁判在训练营的课程列表
    public function inlessonlist($referee_id, $camp_id) {
        $model = new \app\model\Lesson();
        $isrefereelist = $model->where(['camp_id' => $camp_id, 'referee_id' => $referee_id])->select();
        if (!$isrefereelist) {
            return $isrefereelist;
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
                        if ($val && $val == $referee_id) {
                            array_push($isassistantlist, $assistant);
                        }
                    }
                }
            }
        }
        $result = array_merge($isrefereelist->toArray(), $isassistantlist);
        return $result;
    }

    // 裁判执教学员统计
    public function teachstudents($referee_id) {
        $grades = $this->ingradelist($referee_id);
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


    // 创建裁判评论
    public function createRefereeComment($data){
        $RefereeComemnt = new \app\model\RefereeComment;
        $result = $RefereeComemnt->save($data);
        if($result){
            return ['code' => 200, 'msg' => '评论成功'];
        }else{
            return ['code' => 100, 'msg' => $RefereeComemnt->getError()];
        }
    }
}