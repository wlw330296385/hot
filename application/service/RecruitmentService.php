<?php
namespace app\service;
use app\model\Recruitment;
use think\Db;
use app\common\RecruitmentVal;
use app\model\RecruitmentMember;
class RecruitmentService{

    private $RecruitmentModel;

    public function __construct(){
        $this->RecruitmentModel = new Recruitment;

    }


    // 招募列表
    public function getRecruitmentList($map=[],$page = 1, $order='',$p=10) {
        $res = Recruitment::where($map)->order($order)->page($page,$p)->select();
        // echo Recruitment::getlastsql();
        if($res){   
            $result = $res->toArray();
        }
        return $res;
    }

    // 招募分页
    public function getRecruitmentListByPage($map , $order='', $paginate=10) {
        $result =  $this->RecruitmentModel
                // ->with('gradeMember')
                ->where($map)
                ->order($order)
                ->paginate($paginate);
                // echo $this->RecruitmentModel->getlastsql();die;

        if($result){
            $res = $result->toArray();
            return $res;
        }else{
            return $result;
        }
        
    }

    // 一个招募
    public function getRecruitmentInfo($map=[]) {
        $res = $this->RecruitmentModel->where($map)->find();
        if($res){           
            $result = $res->toArray();
            return $result;
        }
        return $res;
    }

    // 获取招募分类 $tree传1 返回树状列表，不传就返回查询结果集数组
    public function getRecruitmentCategory($tree=0) {
        $res = Db::name('grade_category')->field(['id', 'name', 'pid'])->select();
        if($res){
            $result = channelLevel($res,0,'id','pid');
            return $result;
        }else{
            return $res;
        }
    }


    // 返回招募数量统计
    public function countRecruitments($map){
        $result = $this->RecruitmentModel->where($map)->count();
        return $result?$result:0;
    }

    // 新增招募
    public function createRecruitment($data){
        $validate = validate('RecruitmentVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        $result = $this->RecruitmentModel->allowField(true)->save($data);
         if (!$result) {
            return [ 'msg' => __lang('MSG_400'), 'code' => 100 ];
        }else{
            db('camp')->where(['id'=>$data['camp_id']])->setInc('total_grade');
            return [ 'msg' => __lang('MSG_200'), 'code' => 200, 'data' => $this->RecruitmentModel->id];
        }
    }

    // 编辑招募
    public function updateRecruitment($data,$id){
        $validate = validate('RecruitmentVal');
        if(!$validate->scene('edit')->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        $result = $this->RecruitmentModel->save($data,['id'=>$id]);
         if (!$result) {
            return [ 'msg' => __lang('MSG_400'), 'code' =>100 ];
        }else{
             return [ 'msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }
    }
   


     // 获取学生列表
     public function getRecruitmentMemberList($recruitment_id,$page = 1,$paginate = 10){
        $result = RecruitmentMember::where(['recruitment_id'=>$recruitment_id,'status'=>1])
                // ->page($page,$paginate)
                ->select();
        if($result){
            $res = $result->toArray();
            return $res;
        }else{
            return $result;
        }
    }


    // 招募权限
    public function isPower($camp_id,$member_id){
        $is_power = db('camp_member')
                    ->where([
                        'camp_id'   =>$camp_id,
                        'status'    =>1,
                        'member_id'  =>$member_id,
                        ])
                    ->value('type');

        return $is_power?$is_power:0;
    
    }


}