<?php
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\service\ExerciseService;
use think\Db;
use think\Request;

class Exercise extends Backend {
    public function _initialize() {
        parent::_initialize();
        $ExerciseS = new ExerciseService();
        $exerciseType_res = $ExerciseS->getExerciseType();
        if ($exerciseType_res['code'] != 200) {
            $exerciseType = $exerciseType_res['data'];
        }
        $this->assign('type', $exerciseType);
    }

    // 管理 平台发布 训练项目
    public function index() {
        $ExerciseS = new ExerciseService();
        $condi = ['camp_id' => 0];
        $exercise_res = $ExerciseS->getExerciseAll($condi);
        if ($exercise_res['code'] != 200) {
            $exercise = $exercise_res['data'];
            $exercise = channelLevel($exercise, 0, 'id', 'pid');

        }

        $breadcrumb = ['ptitle' => '训练营', 'title' => '训练项目管理'];
        $this->assign('breadcrumb', $breadcrumb);
        $this->assign('exercise', $exercise);
        return view();
    }

    // 管理 训练营/教练发布 训练项目
    public function lists() {
        $ExerciseS = new ExerciseService();
        $condi['camp_id'] = ['<>', 0];
        $exercise_res = $ExerciseS->getExerciseAll($condi);
        if ($exercise_res['code'] != 200) {
            $exercise = $exercise_res['data'];
            foreach ( $exercise as $k => $val ) {
                $pid = $val['pid'];
                $parent_exercise = $ExerciseS->getExerciseOne(['id' => $pid, 'pid' => 0], 'exercise');
                if ($parent_exercise['code'] == 100) {
                    $exercise[$k]['parent_exercise'] = $parent_exercise['data']['exercise'];
                }
            }
        }

        $breadcrumb = ['ptitle' => '训练营', 'title' => '训练项目管理'];
        $this->assign('breadcrumb', $breadcrumb);
        $this->assign('exercise', $exercise);
        return $this->fetch();
    }

    // 创建视图
    public function create() {
        return view();
    }

    // 详情视图
    public function show() {
        $id = input('id/d', 0);
        if (!$id) {
            abort(404, __lang('MSG_202_MISSPARAM'));
        }

        $ExerciseS = new ExerciseService();
        $exercise_res = $ExerciseS->getExerciseOne(['id' => $id]);
        if ($exercise_res['code'] == 200) {
            $this->error($exercise_res['msg']);
        }
        $exercise = $exercise_res['data'];
        $view = ($exercise['camp_id'] > 0 && $exercise['member_id'] > 0) ? 'audit' : 'show';
        
        $this->assign('exercise', $exercise);
        return view($view);
    }

    // 储存新数据
    public function store() {
        if (request()->isPost()) {
            $request = Request::instance()->post();
            $data = [
                'camp_id' => 0,
                'camp' => '平台',
                'exercise' => $request['exercise'],
                'pid' => $request['pid'],
                'exercise_detail' => $request['exercise_detail'],
                'is_open' => 1,
                'status' => 1,
                'media' => $request['media']
            ];
            $validate = $this->validate($data, 'ExerciseVal');
            if ( true !== $validate ) {
                $this->error($validate);
            }

            //dump($data);
            $ExerciseS = new ExerciseService();
            $res = $ExerciseS->addExercise($data);
            if ($res['code'] == 100) {
                $this->success($res['msg']);
            } else {
                $this->error($res['msg']);
            }
        }
    }

    // 更新数据
    public function update() {
        if (request()->isPost()) {
            $request = Request::instance()->post();
            $id = $request['id'];
            $data = [
                'exercise' => $request['exercise'],
                'pid' => $request['pid'],
                'exercise_detail' => $request['exercise_detail'],
                'media' => $request['media']
            ];
            $validate = $this->validate($data, 'ExerciseVal');
            if ( true !== $validate ) {
                $this->error($validate);
            }

            //dump($data);
            $ExerciseS = new ExerciseService();
            $res = $ExerciseS->updateExercise($data, ['id' => $id]);
            if ($res['code'] == 100) {
                $this->success($res['msg']);
            } else {
                $this->error($res['msg']);
            }
        }
    }

    // (软)删除数据
    public function del() {
        if ( request()->isAjax() ) {
            $id = input('id');
            $ExerciseS = new ExerciseService();
            $res = $ExerciseS->softDeleteExercise($id);
            return $res;
        }
    }

    // 审核
    public function audit() {
        if ( request()->isAjax() ) {
            $eid = input('eid/d', 0);
            $db = Db::name('exercise');
            $exercise = $db->where('id', $eid)->find();
            $result = $db->where('id', $exercise['id'])->setField('status', $exercise['camp_id']);

            if ($result) {
                $response = ['status' => 1, 'msg' => __lang('MSG_100_SUCCESS')];
            } else {
                $response = ['status' => 0, 'msg' => __lang('MSG_200_ERROR')];
            }
            return $response;
        }
    }
}