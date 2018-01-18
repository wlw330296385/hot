<?php
// 比赛service
namespace app\service;
use app\model\Match;
use app\model\MatchApply;
use app\model\MatchRecord;
use app\model\MatchRecordMember;
use app\model\MatchTeam;
use app\model\MatchHistoryTeam;
use think\Db;

class MatchService {
    // 保存比赛数据
    public function saveMatch($data) {
        $model = new Match();
        $validate = validate('MatchVal');
        // 根据提交的参数有无id 识别执行更新/插入数据
        if (isset($data['id'])) {
            // 验证数据
            if (!$validate->scene('edit')->check($data)) {
                return ['code' => 100, 'msg' => $validate->getError()];
            }
            // 更新数据
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        } else {
            // 验证数据
            if (!$validate->scene('add')->check($data)) {
                return ['code' => 100, 'msg' => $validate->getError()];
            }
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
            $result['status_num'] = $res->getData('status');
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
    
    // 软删除比赛记录
    public function deleteMatch($id) {
        $res = Match::destroy($id);
        return $res;
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

    // 获取一条比赛战绩数据
    public function getMatchRecord($map) {
        $model = new MatchRecord();
        $res = $model->where($map)->find();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 比赛球队战绩列表Pagigator
    public function matchRecordListPaginator($map, $order='match_record.id desc', $paginate=10) {
        /*$model = new MatchRecord();
        $res = $model->with('match')->where($map)->order($order)->paginate($paginate);
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }*/
        $matchField = ['type', 'start_time', 'end_time', 'reg_start_time', 'reg_end_time', 'province', 'city', 'area',
            'court_id', 'court', 'court_lng', 'court_lat', 'status', 'logo', 'cover',
            'finished_time', 'is_finished' ,'islive'];

        $query = Db::view('match_record', '*')
            ->view('match', $matchField, 'match.id=match_record.match_id', 'left')
            ->where($map)
            ->order($order)
            ->paginate($paginate);


        if ($query) {
            //return $query->toArray();
            $res = $query->toArray();
            // 字段内容显示转换（参考model/match）
            foreach ($res['data'] as $k => $val) {
                $res['data'][$k]['type_num'] = $val['type'];
                switch($val['type']) {
                    case 1 :
                        $res['data'][$k]['type'] = '友谊赛';
                        break;
                    case 2 :
                        $res['data'][$k]['type'] = '联赛';
                        break;

                }

                $res['data'][$k]['is_finished_num']  = $val['is_finished'];
                switch($val['is_finished']) {
                    case 1 :
                        $res['data'][$k]['is_finished'] = '已完成';
                        break;

                    default:
                        $res['data'][$k]['is_finished'] = '未完成';
                }

                $res['data'][$k]['status_num'] = $val['status'];
                switch ($val['status']) {
                    case 1 :
                        $res['data'][$k]['status'] = '公开';
                        break;
                    case -1:
                        $res['data'][$k]['status'] = '不公开';
                }
                $res['data'][$k]['create_time'] = date('Y-m-d H:i', $val['create_time']);
                $res['data'][$k]['update_time'] = date('Y-m-d H:i', $val['update_time']);
            }
            return $res;
        } else {
            return $query;
        }
    }

    // 比赛球队战绩列表
    public function matchRecordList($map, $page=1, $order='match_record.id desc', $limit=10) {
       /* $model = new MatchRecord();
        $res = $model->with('match')->where($map)->order($order)->page($page)->limit($limit)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }*/
        $matchField = ['type', 'start_time', 'end_time', 'reg_start_time', 'reg_end_time', 'province', 'city', 'area',
            'court_id', 'court', 'court_lng', 'court_lat', 'status', 'logo', 'cover',
            'finished_time', 'is_finished' ,'islive'];

        $res = Db::view('match_record', '*')
            ->view('match', $matchField, 'match.id=match_record.match_id', 'left')
            ->where($map)
            ->order($order)
            ->page($page)->limit($limit)->select();


        if ($res) {
            // 字段内容显示转换（参考model/match）
            foreach ($res as $k => $val) {
                $res[$k]['type_num'] = $val['type'];
                switch($val['type']) {
                    case 1 :
                        $res[$k]['type'] = '友谊赛';
                        break;
                    case 2 :
                        $res[$k]['type'] = '联赛';
                        break;

                }

                $res[$k]['is_finished_num']  = $val['is_finished'];
                switch($val['is_finished']) {
                    case 1 :
                        $res[$k]['is_finished'] = '已完成';
                        break;

                    default:
                        $res[$k]['is_finished'] = '未完成';
                }

                $res[$k]['status_num'] = $val['status'];
                switch ($val['status']) {
                    case 1 :
                        $res[$k]['status'] = '公开';
                        break;
                    case -1:
                        $res[$k]['status'] = '不公开';
                }
                $res[$k]['create_time'] = date('Y-m-d H:i', $val['create_time']);
                $res[$k]['update_time'] = date('Y-m-d H:i', $val['update_time']);
            }
            return $res;
        } else {
            return $res;
        }
    }

    // 比赛球队战绩列表（所有数据）
    public function matchRecordListAll($map, $order='match_record.id desc') {
        /*$model = new MatchRecord();
        $res = $model->with('match')->where($map)->order($order)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }*/
        $matchField = ['type', 'start_time', 'end_time', 'reg_start_time', 'reg_end_time', 'province', 'city', 'area',
            'court_id', 'court', 'court_lng', 'court_lat', 'status', 'logo', 'cover',
            'finished_time', 'is_finished' ,'islive'];

        $res = Db::view('match_record', '*')
            ->view('match', $matchField, 'match.id=match_record.match_id', 'left')
            ->where($map)
            ->order($order)->select();


        if ($res) {
            // 字段内容显示转换（参考model/match）
            foreach ($res as $k => $val) {
                $res[$k]['type_num'] = $val['type'];
                switch($val['type']) {
                    case 1 :
                        $res[$k]['type'] = '友谊赛';
                        break;
                    case 2 :
                        $res[$k]['type'] = '联赛';
                        break;

                }

                $res[$k]['is_finished_num']  = $val['is_finished'];
                switch($val['is_finished']) {
                    case 1 :
                        $res[$k]['is_finished'] = '已完成';
                        break;

                    default:
                        $res[$k]['is_finished'] = '未完成';
                }

                $res[$k]['status_num'] = $val['status'];
                switch ($val['status']) {
                    case 1 :
                        $res[$k]['status'] = '公开';
                        break;
                    case -1:
                        $res[$k]['status'] = '不公开';
                }
                $res[$k]['create_time'] = date('Y-m-d H:i', $val['create_time']);
                $res[$k]['update_time'] = date('Y-m-d H:i', $val['update_time']);
            }
            return $res;
        } else {
            return $res;
        }
    }

    // 查询比赛战绩-会员关系
    public function getMatchRecordMember($map) {
        $model = new MatchRecordMember();
        $res = $model->where($map)->find();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 保存比赛战绩-会员关系
    public function saveMatchRecordMember($data) {
        $model = new MatchRecordMember();
        $res = $model->allowField(true)->save($data);
        if ($res) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $res];
        } else {
            trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 批量保存比赛战绩-会员关系
    public function saveAllMatchRecordMember($data) {
        $model = new MatchRecordMember();
        $res = $model->allowField(true)->saveAll($data);
        if ($res) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $res];
        } else {
            trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 比赛战绩-会员关联列表（页码）
    public function getMatchRecordMemberListPaginator($map, $order='id desc', $paginate=10) {
        $model = new MatchRecordMember();
        $query = $model->where($map)->order($order)->paginate($paginate);
        if ($query) {
            return $query->toArray();
        } else {
            return $query;
        }
    }

    // 比赛战绩-会员关联列表
    public function getMatchRecordMemberList($map, $page=1, $order='id desc', $limit=10) {
        $model = new MatchRecordMember();
        $query = $model->where($map)->order($order)->page($page)->limit($limit)->select();
        if ($query) {
            return $query->toArray();
        } else {
            return $query;
        }
    }

    // 比赛战绩-会员关联列表（所有数据）
    public function getMatchRecordMemberListAll($map, $order='id desc') {
        $model = new MatchRecordMember();
        $query = $model->where($map)->order($order)->select();
        if ($query) {
            return $query->toArray();
        } else {
            return $query;
        }
    }

    // 保存历史对手球队
    public function saveHistoryTeam($data) {
        $model = new MatchHistoryTeam();
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

    // 获取历史对手球队
    public function getHistoryTeam($map) {
        $model = new MatchHistoryTeam();
        $query = $model->where($map)->find();
        if ($query) {
            return $query->toArray();
        } else {
            return $query;
        }
    }

    // 历史对手球队列表（页码）
    public function getHistoryTeamPaginator($map, $order='id desc', $paginate=10) {
        $model = new MatchHistoryTeam();
        $query = $model->with('opponentTeam')->where($map)->order($order)->paginate($paginate);
        if ($query) {
            return $query->toArray();
        } else {
            return $query;
        }
    }

    // 历史对手球队列表
    public function getHistoryTeamList($map, $page=1, $order='id desc', $limit=10) {
        $model = new MatchHistoryTeam();
        $query = $model->with('opponentTeam')->where($map)->order($order)->page($page)->limit($limit)->select();
        if ($query) {
            return $query->toArray();
        } else {
            return $query;
        }
    }

    // 历史对手球队列表（所有数据）
    public function getHistoryTeamAll($map, $order='id desc') {
        $model = new MatchHistoryTeam();
        $query = $model->with('opponentTeam')->where($map)->order($order)->select();
        if ($query) {
            return $query->toArray();
        } else {
            return $query;
        }
    }

    // 保存球队参加比赛申请
    public function saveMatchApply($data) {
        $model = new MatchApply();
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
}