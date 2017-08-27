<?php
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\service\LessonService;
use app\service\AuthService;
use think\Db;

class Lesson extends Backend {
    // 列表
    public function index() {
        $LessonS = new LessonService();
        $lesson = $LessonS->getLessonPage();

        //dump($lesson);
        if ($lesson['code'] != 200) {
            $list = $lesson['data'];
            $this->assign('list', $list);
        }
        
        $breadcrumb = ['title' => '课程管理', 'ptitle' => '训练营'];
        $this->assign( 'breadcrumb', $breadcrumb );
        return $this->fetch();
    }

    // 详情
    public function detail() {
        $id = input('id');
        $LessonS = new LessonService();
        $lesson = $LessonS->getLessonOne([ 'id' => $id ]);

        if ($lesson['code'] == 200) {
            $this->error($lesson['msg']);
        } else {
            $this->assign('lesson', $lesson['data']);
        }

        $breadcrumb = [ 'ptitle' => '课程管理' , 'title' => '课程详细' ];
        $this->assign( 'breadcrumb', $breadcrumb );
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

}