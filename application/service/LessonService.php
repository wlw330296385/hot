<?php

namespace app\service;

use app\model\Lesson;
use think\Db;
use app\model\GradeMember;
use app\common\validate\LessonVal;
class LessonService {
    private $gradeMemberModel;
    private $lessonModel;
    public function __construct(){
        $this->lessonModel = new Lesson;
        $this->gradeMemberModel = new GradeMember;
    }

    // 课程分类数据
    public function lessonCategory() {
        $category = Db::name('lesson_category')->where(['status' => 1])->field(['id', 'name', 'pid'])->select();
        if (!$category)
            return ['msg' => __lang('MSG_201_DBNOTFOUND'), 'code' => 200];

        return ['msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $category];
    }
    
    // 获取所有课程
    public function getLessonList($map=[], $order='',$paginate = 10) {
        $result = Lesson::where($map)->order($order)->paginate($paginate);
        if($result){
            $result = $result->toarray();
            return $result['data'];
        }else{
            return $result;
        }
    }

    // 分页获取课程
    public function getLessonPage($map=[],$paginate=10, $order=''){
        $res = Lesson::where($map)->order($order)->paginate($paginate);
        if (!$res) {
            return ['msg' => __lang('MSG_201_DBNOTFOUND'), 'code' => 200];
        }
        if ($res->isEmpty()) {
            return ['msg' => __lang('MSG_000_NULL'), 'code' => 000, 'data' => ''];
        }
        return ['msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $res];
    }

    // 软删除
    public function SoftDeleteLesson($id) {
        $result = Lesson::destroy($id);
        if (!$result) {
            return [ 'msg' => __lang('MSG_200_ERROR'), 'code' => 200 ];
        } else {
            return ['msg' => __lang('MSG_100_SUCCESS'), 'code' => 100, 'data' => $result];
        }
    }

    // 获取一个课程
    public function getLessonInfo($map) {
        $result = Lesson::where($map)->find();
        if ($result){
            $result = $result->toArray();
        }
            return $result;
    }


    // 发布课程
    public function pubLession($data){
        // 查询是否有权限
        $is_power = $this->isPower($data['camp_id'],$data['member_id']);
        if(!$is_power){
            return ['code'=>200,'msg'=>'权限不足'];
        }
        $result = $this->lessonModel->validate('LessonVal')->data($data)->save();
        if($result){
            return ['msg' => $this->lessonModel->getError(), 'code' => 100, 'data' => $result];
        }else{
            return ['msg'=>__lang('MSG_200_ERROR'), 'code' => 200];
        }
    }

    // 编辑课程
    public function updateLesson($data,$id){
        $is_power = $this->isPower($data['camp_id'],$data['member_id']);

        if(!$is_power){
            return ['code'=>200,'msg'=>'权限不足'];
        }

        $result = $this->lessonModel->validate('LessonVal')->save($data,['id'=>$id]);
        if($result){
            return ['msg' => $this->lessonModel->getError(), 'code' => 100, 'data' => $result];
        }else{
            return ['msg'=>__lang('MSG_200_ERROR'), 'code' => 200];
        }
    }


    // 课程权限
    public function isPower($camp_id,$member_id){
        $is_power = $this->gradeMemberModel
                    ->where([
                        'camp_id'   =>$camp_id,
                        'status'    =>1,
                        'member_id'  =>$member_id,
                        'type'      =>['in','2,3,4']
                        ])
                    ->find();
        if($is_power){
            return true;
        }else{
            return false;
        }
    }
}

