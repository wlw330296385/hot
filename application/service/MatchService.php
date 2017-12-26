<?php
// 比赛service
namespace app\service;
use app\model\Match;
use app\model\MatchTeam;

class MatchService {
    // 保存比赛数据
    public function saveMatch($data) {
        $model = new Match();
        // 验证数据
        $validate = validate('MatchVal');
        if (!$validate->check($data)) {
            return ['code' => 100, 'msg' => $validate->getError()];
        }
        // 根据提交的参数有无id 识别执行更新/插入数据
        if (isset($data['id'])) {
            // 更新数据
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        } else {
            // 插入数据
            $res = $model->allowField(true)->save($data);
            if ($res) {
                return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->getLastInsID()];
            } else {
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
    }

    // 获取比赛数据
    public function getMatch($map) {
        $model = new Match();
        $res = $model->where($map)->find();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 比赛列表Pagigator
    public function matchListPaginator($map, $order='id desc', $paginate=10) {
        $model = new Match();
        $res = $model->where($map)->order($order)->paginate($paginate);
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 比赛列表
    public function matchList($map, $page=1, $order='id desc', $limit=10) {
        $model = new Match();
        $res = $model->where($map)->order($order)->page($page)->limit($limit)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 比赛列表（所有数据）
    public function matchListAll($map, $order='id desc') {
        $model = new Match();
        $res = $model->where($map)->order($order)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 保存比赛球队数据
    public function saveMatchTeam($data) {
        $model = new MatchTeam();
        // 根据提交的参数有无id 识别执行更新/插入数据
        if (isset($data['id'])) {
            // 更新数据
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        } else {
            // 插入数据
            $res = $model->allowField(true)->save($data);
            if ($res) {
                return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->getLastInsID()];
            } else {
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
    }

    // 获取比赛球队数据

    // 比赛球队列表Pagigator
    public function matchTeamListPaginator($map, $order='id desc', $paginate=10) {
        $model = new MatchTeam();
        $res = $model->where($map)->order($order)->paginate($paginate);
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 比赛球队列表
    public function matchTeamList($map, $page=1, $order='id desc', $limit=10) {
        $model = new MatchTeam();
        $res = $model->where($map)->order($order)->page($page)->limit($limit)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 比赛球队列表（所有数据）
    public function matchTeamListAll($map, $order='id desc') {
        $model = new Match();
        $res = $model->where($map)->order($order)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }
}