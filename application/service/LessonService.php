<?php

namespace app\service;

use app\model\Lesson;
use app\model\LessonAssignMember;
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
            return ['msg' => __lang('MSG_201_DBNOTFOUND'), 'code' => 100];

        return ['msg' => __lang('MSG_101_SUCCESS'), 'code' => 200, 'data' => $category];
    }
    
    // 获取所有课程
    public function getLessonList($map=[],$page = 1,$order='',$paginate = 10) {
        $result = Lesson::where($map)->order($order)->page($page,$paginate)->select();

        if($result){
            $res = $result->toArray();
            return $res;
        }else{
            return $result;
        }
    }

    // 分页获取课程
    public function getLessonListByPage($map=[], $order='',$paginate=10){
        $res = Lesson::where($map)->order($order)->paginate($paginate);
        if($res){
            return $res->toArray();
        }else{
            return $res;
        }
    }

    // 软删除
    public function SoftDeleteLesson($id) {
        $result = Lesson::destroy($id);
        if (!$result) {
            return [ 'msg' => __lang('MSG_400'), 'code' => 100 ];
        } else {
            return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }
    }

    // 获取一个课程
    public function getLessonInfo($map) {
        $result = Lesson::where($map)->find();
        if ($result){
            $res = $result->toArray();
            if($res['dom']){
                $res['doms'] = unserialize($res['dom']);
            }else{
                $res['doms'] = [];
            }
            if($res['assistant']){
                $pieces = unserialize($res['assistant']);
                $res['assistants'] = implode(',', $pieces);
            }else{
                $res['assistants'] = '';
            }

            if($res['assistant_id']){
                $pieces = unserialize($res['assistant_id']);
                $res['assistant_ids'] = implode(',', $pieces);
            }else{
                $res['assistant_ids'] = '';
            }
            $res['status_num'] = $result->getData('status');
            return $res;
        }else{
            return $result;
        }
    }




    // 编辑课程
    public function updateLesson($data,$id){
        $is_power = $this->isPower($data['camp_id'],$data['member_id']);
        if($is_power<2){
            return ['code'=>100,'msg'=> __lang('MSG_403')];
        }
        
        if($data['doms']){
                $doms = explode(',', $data['doms']);
                $seria = serialize($doms);
                $data['dom'] = $seria;
            }else{
                $data['dom'] = '';
            }
        if($data['assistants']){
            $doms = explode(',', $data['assistants']);
            $seria = serialize($doms);
            $data['assistant'] = $seria;
        }else{
            $data['assistant'] = '';
        }
        if($data['assistant_ids']){
            $doms = explode(',', $data['assistant_ids']);
            $seria = serialize($doms);
            $data['assistant_id'] = $seria;
        }else{
            $data['assistant_id'] = '';
        }
        $validate = validate('LessonVal');
        if(!$validate->scene('edit')->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        $result = $this->lessonModel->allowField(true)->save($data,['id'=>$id]);
        if($result){
            // return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $this->lessonModel->id];
            return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $id];
        }else{
            return ['msg'=>__lang('MSG_400'), 'code' => 100];
        }
    }

    // 新增课程
    public function createLesson($data){
        // 查询是否有权限
        $is_power = $this->isPower($data['camp_id'],$data['member_id']);
        if($is_power<2){
            return ['code'=>100,'msg'=>__lang('MSG_403')];
        }
        if($data['doms']){
                $doms = explode(',', $data['doms']);
                $seria = serialize($doms);
                $data['dom'] = $seria;
            }else{
                $data['dom'] = '';
            }
        if($data['assistants']){
            $doms = explode(',', $data['assistants']);
            $seria = serialize($doms);
            $data['assistant'] = $seria;
        }else{
            $data['assistant'] = '';
        }
        if($data['assistant_ids']){
            $doms = explode(',', $data['assistant_ids']);
            $seria = serialize($doms);
            $data['assistant_id'] = $seria;
        }else{
            $data['assistant_id'] = '';
        }
        $validate = validate('LessonVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
       
        $result = $this->lessonModel->allowField(true)->save($data);
        if($result){
            db('camp')->where(['id'=>$data['camp_id']])->setInc('total_lessons');
            return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $this->lessonModel->id];
        }else{
            return ['msg'=>__lang('MSG_400'), 'code' => 100];
        }
    }

    public function saveLessonAssign($data) {
        if (!$data['lesson_id']) {
            return ['code' => 100, 'msg' => '课程'.__lang('MSG_402')];
        }
        $model = new LessonAssignMember();
        // 查询课程有无指定数据
        $haslist = $model->where(['lesson_id' => $data['lesson_id']])->select();
        if (!$haslist->isEmpty()) {
            // 过滤选择指定会员被删除的数据
            $model->where(['lesson_id' => $data['lesson_id']])->setField('status', -1);
        }
        // 保存数据
        $members = json_decode($data['memberData'], true);
        $dataSave = [];
        foreach ($members as $k => $member) {
            $dataSave[$k]['lesson_id'] = $data['lesson_id'];
            $dataSave[$k]['lesson'] = $data['lesson'];
            $dataSave[$k]['member_id'] = $member['id'];
            $dataSave[$k]['member'] = $member['member'];
            $dataSave[$k]['status'] = 1;
        }
        $res = $model->saveAll($dataSave);
        return $res;
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

    // 修改课程上架/下架状态 2017/09/28
    public function updateLessonStatus($lessonid, $status) {
        $model = new Lesson();
        $res = $model->update(['id' => $lessonid, 'status' => $status]);
        if (!$res) {
            return [ 'code' => 100, 'msg' => __lang('MSG_400'), 'data' => $model->getError() ];
        } else {
            return [ 'code' => 200, 'msg' => __lang('MSG_200'), 'data' => $res ];
        }
    }

    // 课程是否被班级所用
    public function hasgradeused($lessonid) {
        $model = new \app\model\Grade();
        $res = $model->where(['lesson_id' => $lessonid])->select()->toArray();
        return $res;
    }
}

