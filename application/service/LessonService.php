<?php

namespace app\service;

use app\model\Lesson;
use think\Db;

use app\common\validate\LessonVal;
class LessonService {
    private $lessonModel;
    public function __construct(){
        $this->lessonModel = new Lesson;
    }

    // 课程分类数据
    public function lessonCategory() {
        $category = Db::name('lesson_category')->where(['status' => 1])->field(['id', 'name', 'pid'])->select();
        if (!$category)
            return ['msg' => __lang('MSG_201_DBNOTFOUND'), 'code' => 200];

        return ['msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $category];
    }
    
    // 获取所有课程
    public function getLessonList($map=[],$page = 1,$order='',$paginate = 10) {
        $result = Lesson::where($map)->order($order)->where(['status'=>1])->page($page,$paginate)->select();
        if($result){
            $result = $result->toarray();
            return $result;
        }else{
            return $result;
        }
    }

    // 分页获取课程
    public function getLessonPage($map=[],$page = 1 ,$paginate=10, $order=''){
        $res = Lesson::where($map)->where(['status'=>1])->order($order)->page($page,$paginate)->select();
        if($res){
            $result = $res->toArray();
            return $result;
        }else{
            return $res;
        }
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
            $res = $result->toArray();
            // dump($res);die;
            $res['doms'] = unserialize($res['dom']);
            return $res;
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
        $validate = validate('LessonVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        $result = $this->lessonModel->data($data)->save();
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
        $validate = validate('LessonVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        $result = $this->lessonModel->save($data,['id'=>$id]);
        if($result){
            return ['msg' => $this->lessonModel->getError(), 'code' => 100, 'data' => $result];
        }else{
            return ['msg'=>__lang('MSG_200_ERROR'), 'code' => 200];
        }
    }

    // 新增课程
    public function createLesson($data){
        $is_power = $this->isPower($data['camp_id'],$data['member_id']);

        if(!$is_power){
            return ['code'=>200,'msg'=>'权限不足'];
        }
        $validate = validate('LessonVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        $result = $this->lessonModel->save($data);
        if($result){
            return ['msg' => $this->lessonModel->getError(), 'code' => 100, 'data' => $result];
        }else{
            return ['msg'=>__lang('MSG_200_ERROR'), 'code' => 200];
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
}

