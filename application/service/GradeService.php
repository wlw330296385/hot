<?php
namespace app\service;
use app\model\Grade;
use think\Db;
use app\common\GradeVal;
use app\model\GradeMember;
class GradeService{

    private $GradeModel;

    public function __construct(){
        $this->GradeModel = new Grade;

    }


    // 班级列表
    public function getGradeList($map=[],$page = 1, $order='',$p=10) {
        $res = Grade::where($map)->order($order)->page($page,$p)->select();
        // echo Grade::getlastsql();
        if($res){   
            $result = $res->toArray();
        }
        return $res;
    }

    // 班级分页
    public function getGradeListByPage($map , $order='', $paginate=10) {
        $result =  $this->GradeModel
                ->with('gradeMember')
                ->where($map)
                ->order($order)
                ->paginate($paginate);
                // echo $this->GradeModel->getlastsql();die;
                
        if($result){
            $res = $result->toArray();
            return $res;
        }else{
            return $result;
        }
        
    }

    // 一个班级
    public function getGradeInfo($map=[]) {
        $res = $this->GradeModel->where($map)->find();
        if($res){           
            $result = $res->toArray();
            $result['status_num'] = $res->getData('status');
            if($result['assistant']){
                $assis = unserialize($result['assistant']);
                $result['assistants'] = implode(',', $assis);
            }else{
                 $result['assistants'] = '';
            }

            if($result['assistant_id']){
                $assis = unserialize($result['assistant_id']);
                $result['assistant_ids'] = implode(',', $assis);
            }else{
                 $result['assistant_ids'] = '';
            }
            return $result;
        }
        return $res;
    }

    // 获取班级分类 $tree传1 返回树状列表，不传就返回查询结果集数组
    public function getGradeCategory($tree=0) {
        $res = Db::name('grade_category')->field(['id', 'name', 'pid'])->select();
        if($res){
            $result = channelLevel($res,0,'id','pid');
            return $result;
        }else{
            return $res;
        }
    }


    // 返回班级数量统计
    public function countGrades($map){
        $result = $this->GradeModel->where($map)->count();
        return $result?$result:0;
    }

    // 新增班级
    public function createGrade($data){
        $validate = validate('GradeVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }

        if($data['assistants']){
                $assistan_list = explode(',', $data['assistants']);
                $seria = serialize($assistan_list);
                $data['assistant'] = $seria;
            }
        if($data['assistant_ids']){
            $assistan_list = explode(',', $data['assistant_ids']);
            $seria = serialize($assistan_list);
            $data['assistant_id'] = $seria;
        }
        $result = $this->GradeModel->allowField(true)->save($data);
         if (!$result) {
            return [ 'msg' => __lang('MSG_400'), 'code' => 100 ];
        }else{
            db('camp')->where(['id'=>$data['camp_id']])->setInc('total_grade');
            return [ 'msg' => __lang('MSG_200'), 'code' => 200, 'data' => $this->GradeModel->id];
        }
    }

    // 编辑班级
    public function updateGrade($data,$id){
        $validate = validate('GradeVal');
        if(!$validate->scene('edit')->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        if($data['assistants']){
                $assistan_list = explode(',', $data['assistants']);
                $seria = serialize($assistan_list);
                $data['assistant'] = $seria;
            }
        if($data['assistant_ids']){
            $assistan_list = explode(',', $data['assistant_ids']);
            $seria = serialize($assistan_list);
            $data['assistant_id'] = $seria;
        }
        $result = $this->GradeModel->save($data,['id'=>$id]);
         if (!$result) {
            return [ 'msg' => __lang('MSG_400'), 'code' =>100 ];
        }else{
             return [ 'msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }
    }
   


     // 获取学生列表
     public function getStudentList($grade_id,$page = 1,$paginate = 10){
        $result = GradeMember::where(['grade_id'=>$grade_id,'status'=>1])
                // ->page($page,$paginate)
                ->select();
        if($result){
            $res = $result->toArray();
            return $res;
        }else{
            return $result;
        }
    }


    // 课程权限
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

    // 修改班级status字段 2017/10/2
    public function updateGradeStatus($gradeid, $status=0) {
        $model = new Grade();
        $result = $model->update(['id' => $gradeid, 'status' => $status]);
//        dump($result);
        return $result->toArray();
    }

    // (软)删除班级 2017/10/2
    public function delGrade($id) {
        $result = Grade::destroy($id);
        return $result;
    }

    public function getGradeListOfCoachByPage(){

    }

}