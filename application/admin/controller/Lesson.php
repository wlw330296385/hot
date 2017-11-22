<?php
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\service\LessonService;
use app\service\AuthService;
use think\Db;
use app\model\Lesson as LessonModel;

class Lesson extends Backend {
    // 列表
    public function index() {
        $map = [];
        if ($cur_camp = $this->cur_camp) {
            $map['camp_id'] = $cur_camp['camp_id'];
        }
        $camp = input('camp');
        if ($camp) {
            $map['camp'] = ['like', '%'. $camp .'%'];
        }
        $lesson = input('lesson');
        if ($lesson) {
            $map['lesson'] = ['like', '%'. $lesson .'%'];
        }
        $coach = input('coach');
        if ($coach) {
            $map['coach'] = ['like', '%'. $coach .'%'];
        }

        $list = LessonModel::where($map)->paginate(15);
        
        $breadcrumb = ['title' => '课程管理', 'ptitle' => '训练营'];
        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('list', $list);
        return $this->fetch();
    }

    // 详情
    public function detail() {
        $id = input('id');

        $lesson = LessonModel::where([ 'id' => $id ])->find()->toArray();

        $breadcrumb = [ 'ptitle' => '课程管理' , 'title' => '课程详细' ];
        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('lesson', $lesson);
        return view();
    }

    // 审核
    public function audit() {
        if ( request()->isAjax() ) {
            $id = input('lesson');
            $status = input('code');
            $data = [
                'id' => $id,
                'status' => $status
            ];
            $execute = Db::name('lesson')->update($data);
            $Auth = new AuthService();
            if ($execute) {
                $no = '';
                if ($status == 2) {
                    $no = '不';
                }
                $doing = '审核课程id: '. $id .' 审核'. $no .'通过 成功';
                $Auth->record($doing);
                $response = [ 'status' => 1, 'msg' => __lang('MSG_100_SUCCESS'), 'goto' => url('lesson/index') ];
            } else {
                $doing = '审核课程id: '. $id .' 审核操作 失败';
                $Auth->record($doing);
                $response = [ 'status' => 0, 'msg' => __lang('MSG_200_ERROR') ];
            }
            return $response;
        }
    }

    // 软删除
    public function sdel() {
        $id = input('id');
        $LessonS = new LessonService();
        $result = $LessonS->SoftDeleteLesson($id);
        $Auth = new AuthService();
        if ( $result['code'] == 100 ) {
            $Auth->record('课程id:'. $id .' 软删除 成功');
            $this->success($result['msg'], 'lesson/index');
        } else {
            $Auth->record('课程id:'. $id .' 软删除 失败');
            $this->error($result['msg']);
        }
    }



    // 购买课程
    public function buyLesson(){
        $LessonService = new LessonService;
        $lessonList = $LessonService->getLessonList();
        $breadcrumb = ['ptitle' => '课程管理', 'title' => '帮购买课程'];
        $this->assign('breadcrumb',$breadcrumb);
        $member_id = input('param.member_id');
        // 学生列表
        $studentList = db('student')->where(['member_id'=>$member_id])->select();



        return view('lesson/buyLesson');
    }

}