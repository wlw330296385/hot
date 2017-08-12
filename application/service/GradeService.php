<?php
namespace app\service;
use app\model\Grade;
use think\Db;
class GradeService {

    protected $GradeModel;

    public function __construct(){
        $this->GradeModel = new Grade;
    }


    // 班级列表
    public function getGradeAll($map=[], $order='') {
        $result = Grade::where($map)->order($order)->select();
        //return $result;
        if (!$result) {
            return [ 'msg' => __lang('MSG_201_DBNOTFOUND'), 'code' => 200 ];
        }
        if ($result->isEmpty()) {
            return [ 'msg' => __lang('MSG_000_NULL'), 'code' => '000', 'data' => ''];
        }
        return [ 'msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $result];
    }

    // 班级分页
    public function getGradePage($map=[], $order='', $paginate=0) {
        $result =  Grade::where($map)->order($order)->paginate($paginate);
        //return $result;
        if (!$result) {
            return [ 'msg' => __lang('MSG_201_DBNOTFOUND'), 'code' => 200 ];
        }
        if ($result->isEmpty()) {
            return [ 'msg' => __lang('MSG_000_NULL'), 'code' => '000', 'data' => ''];
        }
        return [ 'msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $result];
    }

    // 一个班级
    public function getGradeOne($map=[]) {
        $res = Grade::with('student')->where($map)->find();
        //dump($res);die;
        if (!$res)
            return [ 'msg' => __lang('MSG_201_DBNOTFOUND'), 'code' => 200 ];

        return [ 'msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $res->toArray() ];
    }

    // 获取班级分类 $tree传1 返回树状列表，不传就返回查询结果集数组
    public function getGradeCategory($tree=0) {
        $res = Db::name('grade_category')->field(['id', 'name', 'pid'])->select();
        if (!$res)
            return [ 'msg' => __lang('MSG_201_DBNOTFOUND'), 'code' => 200 ];

        if ($tree) {
            $list = channelLevel($res, 0, 'id', 'pid');
            return [ 'msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $list ];
        } else {
            return [ 'msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $res ];
        }
    }


    // 返回班级数量统计
    public function countGrades($map){
        $result = $this->GradeModel->where($map)->count();
        return $result?$result:0;
    }
}