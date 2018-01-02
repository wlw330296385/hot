<?php
// 比赛service
namespace app\service;
use app\model\Match;
use app\model\MatchRecord;
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

    // 获取比赛详情
    public function getMatch($map) {
        $model = new Match();
        $res = $model->where($map)->find();
        if ($res) {
            $result = $res->toArray();
            $result['type_num'] = $res->getData('type');
            $result['is_finished_num'] = $res->getData('is_finished');
            return $result;
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

    // 保存球队比赛战绩
    public function saveMatchRecord($data) {
        $model = new MatchRecord();
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

    // 比赛球队战绩列表Pagigator
    public function matchRecordListPaginator($map, $order='id desc', $paginate=10) {
        $model = new MatchRecord();
        // 传入球队id 组合复合查询 查询作为主队或客队
        if (isset($map['team_id'])) {
            $team_id = $map['team_id'];
            unset($map['team_id']);
            $res = $model
                ->with('match')
                ->where($map)
                ->where('home_team_id|away_team_id', $team_id)
                ->order($order)->paginate($paginate);
        } else {
            $res = $model->with('match')->where($map)->order($order)->paginate($paginate);
        }

        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 比赛球队战绩列表
    public function matchRecordList($map, $page=1, $order='id desc', $limit=10) {
        $model = new MatchRecord();
        // 传入球队id 组合复合查询 查询作为主队或客队
        if (isset($map['team_id'])) {
            $team_id = $map['team_id'];
            unset($map['team_id']);
            $res = $model
                ->with('match')
                ->where($map)
                ->where('home_team_id|away_team_id', $team_id)
                ->order($order)->page($page)->limit($limit)->select();
        } else {
            $res = $model->with('match')->where($map)->order($order)->page($page)->limit($limit)->select();
        }
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 比赛球队战绩列表（所有数据）
    public function matchRecordListAll($map, $order='id desc') {
        $model = new MatchRecord();
        // 传入球队id 组合复合查询 查询作为主队或客队
        if (isset($map['team_id'])) {
            $team_id = $map['team_id'];
            unset($map['team_id']);
            $res = $model
                ->with('match')
                ->where($map)
                ->where('home_team_id|away_team_id', $team_id)
                ->order($order)->order($order)->select();
        } else {
            $res = $model->with('match')->where($map)->order($order)->select();
        }

        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 比赛战绩详情（关联比赛主表信息）
    public function getMatchRecordWith($map) {
        $model = new MatchRecord();
        $res = $model->with('match')->where($map)->find();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 比赛战绩详情
    public function getMatchRecord($map) {
        $model = new MatchRecord();
        $res = $model->where($map)->find();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }
}