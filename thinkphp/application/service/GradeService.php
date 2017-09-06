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
    public function getGradeList($map=[], $order='',$p=10) {
        $result = [];
        $res = Grade::where($map)->order($order)->paginate($p);
        if($res){           
            $res = $res->toArray();
            $result = $res['data'];
        }
        return $result;
    }

    // 班级分页
    public function getGradePage($map=[], $order='', $paginate=0) {
        $result =  Grade::where($map)->order($order)->paginate($paginate);
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
            $result['assistant_list'] = unserialize($result['assistant']);
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

    public function createGrade($data){
        $result = $this->GradeModel->validate('GradeVal')->data($map)->save();
         if (!$result) {
            return [ 'msg' => __lang('MSG_201_DBNOTFOUND'), 'code' => 200 ];
        }else{
             return [ 'msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $result];
        }
    }


    // 获取班级学生
    public function getStudentList($id){
        $result = db('grade_member')->where(['grade_id'=>$id,'type'=>1,'status'=>1])->select();
        // if($result){           
        //     $result = $result->toArray();
        // }
        return $result;
    }


}