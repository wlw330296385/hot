<?php

namespace app\service;

use app\model\Lesson;
use think\Db;
use app\model\GradeMember;
use app\common\validate\LessonVal;
class LessonService {

    private $lessonModel;
    public function __construct(){
        $this->lessonModel = new Lesson();
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
    public function getLessonAll($map=[], $order='') {
        $res = Lesson::where($map)->order($order)->select();
        if (!$res)
            return [ 'msg' => __lang('MSG_201_DBNOTFOUND'), 'code' => 200 ];

        if ( $res->isEmpty() )
            return [ 'msg' => __lang('MSG_000_NULL'), 'code' => '000', 'data' => '' ];

        return [ 'msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $res->toArray() ];
    }

    // 分页获取课程
    public function getLessonPage($paginate=0, $map=[], $order=''){
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
    public function getLessonOne($map) {
        $res = Lesson::where($map)->find();
        if (!$res)
            return ['msg'=>__lang('MSG_201_DBNOTFOUND'), 'code' => 200];
        return ['msg' => __lang('MSG_101_SUCCESS'), 'code' => 100, 'data' => $res->toArray()];
    }


    // 发布课程
    public function pubLession($data){
        // 查询是否有权限
        $is_power = $this->gradeMemberModel
                    ->where([
                        'camp_id'   =>$data['camp_id'],
                        'status'    =>1,
                        'member_id'  =>$data['member_id'],
                        'type'      =>['in','3,4,5']
                        ])
                    ->find()
                    ->toArray();
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
}

