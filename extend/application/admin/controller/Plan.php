<?php

namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\service\GradeService;
use app\service\ExerciseService;
use app\service\PlanService;
use think\Db;

class Plan extends Backend {
    // 管理
    public function index() {
        $PlanS = new PlanService();
        $condi['type'] = 0;
        $condi['camp_id'] = 0;
        $res = $PlanS->PlanListPage($condi);
        if ($res['code'] == 200) {
            $this->error($res['msg']);
        }

        $breadcrumb = ['title' => '教案管理', 'ptitle' => '训练营'];
        $this->assign('breadcrumb', $breadcrumb);
        $this->assign('list', $res['data']);
        return $this->fetch();
    }

    // 创建视图
    public function create() {
        $GradeS = new GradeService();
        $category_res = $GradeS->getGradeCategory(1);
        if ($category_res['code'] == 100) {
            $category = $category_res['data'];
        }

        $breadcrumb = ['title' => '添加教案', 'ptitle' => '教案管理'];
        $this->assign('breadcrumb', $breadcrumb);
        $this->assign('category', $category);
        return view();
    }

    //
    public function exerciselist() {
        $ExerciseS = new ExerciseService();
        $condi = ['camp_id' => 0];
        $exercise_res = $ExerciseS->getExerciseAll($condi);
        if ($exercise_res['code'] != 200) {
            $exercise = $exercise_res['data'];
            $exercise = channelLevel($exercise, 0, 'id', 'pid');
            //dump($exercise);

        }
        $this->assign('exercise', $exercise);
        return view();
    }

    // 处理组合所选训练项目
    public function handleselected() {
        if ( request()->isAjax() ) {
            $content = input('content');
            $data = explode('|', $content);
            $arr = [];
            foreach ($data as $k => $v) {
                $temp = explode(',', $v);
                $arr[$k]['id'] = $temp[0];
                $arr[$k]['name'] = $temp[1];
                $arr[$k]['pid'] = isset($temp[2]) ? $temp[2] : 0;
            }
            $arr = channelLevel($arr, 0, 'id', 'pid');
            //dump($arr);

            $string = serialize($arr);
            //dump($string);
            $html = "";
            foreach ($arr as $k => $v) {
                $html .= "<div class='col-sm-6 col-md-3 col-xs-12'>";
                $html .= "<ul class='list-group'><li class='list-group-item exer_p' data-id='". $v['id'] ."'>". $v['name'] ."</li>";
                if ($v['_data']) {
                    foreach ($v['_data'] as $v2) {
                        $html .= "<li class='list-group-item clearfix'><label>";
                        $html .= "<span data-id='". $v2['id'] ."'>". $v2['name'] ."</span></label></li>";
                    }
                }
                $html .= "</ul></div>";
            }
            //dump($html);

            if ($string && $html) {
                return [ 'status' => 1, 'string' => $string, 'html' => $html ];
            } else {
                return [ 'status' => 0, 'msg' => __lang('MSG_000_NULL')];
            }
        }
    }

    // 获取训练项目所选
    public function ajaxselected()
    {
        if (request()->isAjax()) {
            $content = input('content');
            $data = unserialize($content);
            $arr = [];
            foreach ($data as $v) {
                if ($v['_data']) {
                    foreach ($v['_data'] as $v2) {
                        array_push($arr, $v2['id']);
                    }
                }
            }
            if ($arr) {
                return ['status' => 1, 'data' => $arr];
            } else {
                return [ 'status' => 0, 'msg' => __lang('MSG_000_NULL')];
            }
        }
    }

    // 详情视图
    public function show() {

    }

    // 储存新数据
    public function store() {
        $request = request()->post();
        //dump($request);
        $data = [
            'camp_id' => 0,
            'camp' => '平台',
            'outline' => $request['outline'],
            'outline_detail' => $request['outline_detail'],
            'exercise' => $request['exercise'],
            'grade_category_id' => $request['grade_category_id'],
            'grade_category' => $request['grade_category'],
            'type' => 0,
            'is_open' => 1,
            'status' => 1,
            'create_time' => time(),
            'update_time' => time()
        ];
        $res = Db::name('plan')->insert($data);
        if ($res) {
            $this->success(__Lang('MSG_100_SUCCESS'), 'plan/index');
        } else {
            $this->error(__lang('MSG_200_ERROR'));
        }
    }

    // 更新数据
    public function update() {

    }

    // (软)删除数据
    public function del() {

    }
}