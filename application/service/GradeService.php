<?php
namespace app\service;
use app\model\Grade;
use think\Db;
use app\common\GradeVal;
class GradeService{

    private $GradeModel;

    public function __construct(){
        $this->GradeModel = new Grade;
    }


    // 班级列表
    public function getGradeList($map=[],$page = 1, $order='',$p=10) {
        $result = [];
        $res = Grade::where($map)->order($order)->page($page,$p)->select();
        if($res){           
            $res = $res->toArray();
            $result = $res;
        }
        return $result;
    }

    // 班级分页
    public function getGradePage($map=[],$page = 1, $order='', $paginate=10) {
        $result =  Grade::where($map)->order($order)->page($page,$paginate)->select();
        if($result){           
            $result = $result->toArray();
        }
        return $result;
    }

    // 一个班级
    public function getGradeInfo($map=[]) {
        $res = $this->GradeModel->where($map)->find();
        if($res){           
            $result = $res->toArray();
            if($result['assistant']){
                $assis = unserialize($result['assistant']);
                $result['assistants'] = implode(',', $assis);
            }else{
                 $result['assistants'] = '';
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
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        $result = $this->GradeModel->save($data);
         if (!$result) {
            return [ 'msg' => __lang('MSG_201_DBNOTFOUND'), 'code' => 200 ];
        }else{
             return [ 'msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $this->GradeModel->id];
        }
    }

    // 编辑班级
    public function updateGrade($data,$id){
        $validate = validate('GradeVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        $result = $this->GradeModel->save($data,['id'=>$id]);
         if (!$result) {
            return [ 'msg' => __lang('MSG_201_DBNOTFOUND'), 'code' => 200 ];
        }else{
             return [ 'msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $result];
        }
    }
   


    // 获取学生列表
     public function getStudentList($grade_id,$page = 1,$paginate = 10){
        $result = db('grade_member')->where(['grade_id'=>$grade_id,'type'=>1,'status'=>1])->page($page,$paginate)->select();
        return $result;
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

}