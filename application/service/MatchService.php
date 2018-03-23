<?php
// 比赛service
namespace app\service;
use app\model\Match;
use app\model\MatchApply;
use app\model\MatchRecord;
use app\model\MatchRecordMember;
use app\model\MatchReferee;
use app\model\MatchRefereeApply;
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
                return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
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
            $result['apply_status_num'] = $res->getData('apply_status');
            $result['match_timestamp'] = $res->getData('match_time');
            return $result;
        } else {
            return $res;
        }
    }

    // 比赛列表Pagigator
    public function matchListPaginator($map, $order='id desc', $paginate=10) {
        $model = new Match();
        $query = $model->where($map)->order($order)->paginate($paginate);
        if ($query) {
            //return $res->toArray();
            $res = $query->toArray();
            // 获取器原始数据
            foreach ($res['data'] as $k => $val) {
                $getData = $model->where('id', $val['id'])->find()->getData();
                $res['data'][$k]['type_num'] = $getData['type'];
                $res['data'][$k]['is_finished_num'] = $getData['is_finished'];
                $res['data'][$k]['status_num'] = $getData['status'];
                $res['data'][$k]['apply_status_num'] = $getData['apply_status'];
            }
            return $res;
        } else {
            return $query;
        }
    }

    // 比赛列表
    public function matchList($map, $page=1, $order='id desc', $limit=10) {
        $model = new Match();
        $query = $model->where($map)->order($order)->page($page)->limit($limit)->select();
        if ($query) {
            //return $res->toArray();
            $res = $query->toArray();
            // 获取器原始数据
            foreach ($res as $k => $val) {
                $getData = $model->where('id', $val['id'])->find()->getData();
                $res[$k]['type_num'] = $getData['type'];
                $res[$k]['is_finished_num'] = $getData['is_finished'];
                $res[$k]['status_num'] = $getData['status'];
                $res[$k]['apply_status_num'] = $getData['apply_status'];
            }
            return $res;
        } else {
            return $query;
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
        // match表记录软删除
        $res = Match::destroy($id);
        // match_record表 match_id相关数据 软删除
        db('match_record')->where('match_id', $id)->update(['delete_time' => time()]);
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
                return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
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
    public function saveMatchRecord($data, $condition=[]) {
        $model = new MatchRecord();
        // 带更新条件更新数据
        if (!empty($condition)) {
            $res = $model->allowField(true)->save($data, $condition);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
        // 更新数据
        if (isset($data['id'])) {
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
        // 插入数据
        $res = $model->allowField(true)->save($data);
        if ($res) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
        } else {
            trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
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
            // match字段内容输出转换
            $modelMatch = new Match();
            foreach ($res['data'] as $k => $val) {
                $res['data'][$k]['match_timestamp'] = $val['match_time'];
                $res['data'][$k]['match_time'] = date('Y-m-d H:i',  $val['match_time']);
                $res['data'][$k]['create_time'] = date('Y-m-d H:i', $val['create_time']);
                $res['data'][$k]['update_time'] = date('Y-m-d H:i', $val['update_time']);
                $matchInfo =$modelMatch->where(['id' => $val['match_id']])->find();
                if($matchInfo){
                    $matchInfo = $matchInfo->toArray();
                    $res['data'][$k]['type_num'] = $val['type'];
                    $res['data'][$k]['type'] = $matchInfo['type'];
                    $res['data'][$k]['is_finished_num']  = $val['is_finished'];
                    $res['data'][$k]['is_finished']  = $matchInfo['is_finished'];
                    $res['data'][$k]['status_num'] = $val['status'];
                    $res['data'][$k]['status'] = $matchInfo['status'];
                }
            }
            return $res;
        } else {
            return $query;
        }
    }

    // 比赛球队战绩列表
    public function matchRecordList($map, $page=1, $order='match_record.id desc', $limit=10) {
        $matchField = ['type', 'start_time', 'end_time', 'reg_start_time', 'reg_end_time', 'province', 'city', 'area',
            'court_id', 'court', 'court_lng', 'court_lat', 'status', 'logo', 'cover',
            'finished_time', 'is_finished' ,'islive'];

        $res = Db::view('match_record', '*')
            ->view('match', $matchField, 'match.id=match_record.match_id', 'left')
            ->where($map)
            ->order($order)
            ->page($page)->limit($limit)->select();


        if ($res) {
            // match字段内容输出转换
            $modelMatch = new Match();
            foreach ($res as $k => $val) {
                $res[$k]['match_timestamp'] = $val['match_time'];
                $res[$k]['match_time'] = date('Y-m-d H:i',  $val['match_time']);
                $res[$k]['create_time'] = date('Y-m-d H:i', $val['create_time']);
                $res[$k]['update_time'] = date('Y-m-d H:i', $val['update_time']);
                $matchInfo =$modelMatch->where(['id' => $val['match_id']])->find();
                if($matchInfo){
                    $matchInfo = $matchInfo->toArray();
                    $res[$k]['type_num'] = $val['type'];
                    $res[$k]['type'] = $matchInfo['type'];
                    $res[$k]['is_finished_num']  = $val['is_finished'];
                    $res[$k]['is_finished']  = $matchInfo['is_finished'];
                    $res[$k]['status_num'] = $val['status'];
                    $res[$k]['status'] = $matchInfo['status'];
                }
            }
            return $res;
        } else {
            return $res;
        }
    }

    // 比赛球队战绩列表（所有数据）
    public function matchRecordListAll($map, $order='match_record.id desc') {
        $matchField = ['type', 'start_time', 'end_time', 'reg_start_time', 'reg_end_time', 'province', 'city', 'area',
            'court_id', 'court', 'court_lng', 'court_lat', 'status', 'logo', 'cover',
            'finished_time', 'is_finished' ,'islive'];

        $res = Db::view('match_record', '*')
            ->view('match', $matchField, 'match.id=match_record.match_id', 'left')
            ->where($map)
            ->order($order)->select();


        if ($res) {
            // match字段内容输出转换
            $modelMatch = new Match();
            foreach ($res as $k => $val) {
                $res[$k]['match_timestamp'] = $val['match_time'];
                $res[$k]['match_time'] = date('Y-m-d H:i',  $val['match_time']);
                $res[$k]['create_time'] = date('Y-m-d H:i', $val['create_time']);
                $res[$k]['update_time'] = date('Y-m-d H:i', $val['update_time']);
                $matchInfo =$modelMatch->where(['id' => $val['match_id']])->find();
                if($matchInfo){
                    $matchInfo = $matchInfo->toArray();
                    $res[$k]['type_num'] = $val['type'];
                    $res[$k]['type'] = $matchInfo['type'];
                    $res[$k]['is_finished_num']  = $val['is_finished'];
                    $res[$k]['is_finished']  = $matchInfo['is_finished'];
                    $res[$k]['status_num'] = $val['status'];
                    $res[$k]['status'] = $matchInfo['status'];
                }
            }
            return $res;
        } else {
            return $res;
        }
    }


    // 更新球队的比赛场数与胜场数
    public function countTeamMatchNum($teamId) {
        $dbTeam = db('team');
        $teamInfo = $dbTeam->where('id', $teamId)->whereNull('delete_time')->find();
        if ($teamInfo) {
            $teamMatchNum =  Db::view('match_record', '*')
                ->view('match', '*', 'match.id=match_record.match_id', 'left')
                ->where('match.is_finished', 1)
                ->where('match_record.home_team_id|away_team_id', $teamInfo['id'])
                ->order('match_record.id desc')
                ->count();
            $teamWinNum =  Db::view('match_record', '*')
                ->view('match', '*', 'match.id=match_record.match_id', 'left')
                ->where('match.is_finished', 1)
                ->where(['match_record.win_team_id' => $teamInfo['id']])
                ->order('match_record.id desc')
                ->count();
            $dbTeam->where('id', $teamInfo['id'])->update(['match_num' => $teamMatchNum, 'match_win' => $teamWinNum]);
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
                return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
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
                return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
            } else {
                trace('error:'.$model->getError().', \n sql:'.$model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
    }

    // 获取球队参加比赛申请
    public function getMatchApply($map) {
        $model = new MatchApply();
        $query = $model->where($map)->find();
        if ($query) {
            return $query->toArray();
        } else {
            return $query;
        }
    }

    // 球队参加比赛申请列表（页码）
    public function getMatchApplyPaginator($map, $order='id desc', $paginate=10) {
        $model = new MatchApply();
        $query = $model->where($map)->order($order)->paginate($paginate);
        if ($query) {
            return $query->toArray();
        } else {
            return $query;
        }
    }

    // 球队参加比赛申请列表
    public function getMatchApplyList($map, $page=1, $order='id desc', $limit=10) {
        $model = new MatchApply();
        $query = $model->where($map)->order($order)->page($page)->limit($limit)->select();
        if ($query) {
            return $query->toArray();
        } else {
            return $query;
        }
    }

    // 保存比赛裁判关系记录
    public function saveMatchReferee($data=[], $condition=[]) {
        $model = new MatchReferee();
        // 带更新条件更新数据
        if (!empty($condition)) {
            $res = $model->allowField(true)->save($data, $condition);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
        // 显式更新数据
        if (isset($data['id'])) {
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
        // 插入数据
        $res = $model->allowField(true)->save($data);
        if ($res) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'insid' => $model->id];
        } else {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 批量保存比赛裁判关系记录
    public function saveAllMatchReferee($data) {
        $model = new MatchReferee();
        // 带更新条件更新数据
        $res = $model->allowField(true)->saveAll($data);
        if ($res || ($res === 0)) {
            return ['code' => 200, 'msg' => __lang('MSG_200')];
        } else {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    /** 裁判员信息插入到比赛referee_str字段
     * @param $referee 裁判员信息数组
     */
    public function setMatchRefereeStr($matchId=0, $recordId=0) {
        $model = new MatchRefereeApply();
        $res = $model->where(['match_id' => $matchId, 'match_record_id' => $recordId, 'status' => 2])->select();
        $refereeCost= 0;
        $refereeStr=[];
        if (!$res) {
            return ['referee_str' => $refereeStr, 'referee_cost' => $refereeCost];
        }
        $result = $res->toArray();
        $matchRefereeStr=[];
        foreach ($result as $val) {
            array_push($matchRefereeStr, [
                'referee' => $val['referee'],
                'referee_id' => $val['id'],
                'referee_cost' => $val['referee_cost']
            ]);
            foreach ($matchRefereeStr as $matchReferee) {
                $refereeCost += $matchReferee['referee_cost'];
            }
            $refereeStr = json_encode($matchRefereeStr, JSON_UNESCAPED_UNICODE); //json不转码中文
        }
        return ['referee_str' => $refereeStr, 'referee_cost' => $refereeCost];
    }

    // 获取比赛-裁判关系详细
    public function getMatchReferee($map) {
        $model = new MatchReferee();
        $res = $model->with('match')->where($map)->find();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        return $result;
    }

    // 获取比赛-裁判关系记录数
    public function getMatchRefereeCount($map) {
        $model = new MatchReferee();
        $res = $model->where($map)->count();
        return $res ? $res : 0;
    }

    // 获取比赛-裁判关系列表（分页）
    public function getMatchRefereePaginator($map=[], $order='id desc', $size=10) {
        $model = new MatchReferee();
        $res = $model->with('match')->where($map)->order($order)->paginate($size);
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        foreach ($result['data'] as $k => $val) {
            // 裁判信息转格式
            if (!empty($val['match']['referee_str'])) {
                $result['data'][$k]['match']['referee_str'] = json_decode($val['match']['referee_str'], true);
            }
            // 比赛时间戳
            if ($val['match']['match_time']) {
                $result['data'][$k]['match']['match_timestamp'] = strtotime($val['match']['match_time']);
            }
            // 比赛战绩数据
            $result['data'][$k]['record'] = $this->getMatchRecord(['id' => $val['match_record_id'], 'match_id' => $val['match_id']]);
        }
        return $result;
    }

    // 获取比赛-裁判关系列表
    public function getMatchRefereeList($map=[], $page=1, $order='id desc', $size=10) {
        $model = new MatchReferee();
        $res = $model->with('match')->where($map)->order($order)->page($page)->limit($size)->select();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        foreach ($result as $k => $val) {
            // 裁判信息转格式
            if (!empty($val['match']['referee_str'])) {
                $result[$k]['match']['referee_str'] = json_decode($val['match']['referee_str'], true);
            }
            // 比赛时间戳
            if ($val['match']['match_time']) {
                $result[$k]['match']['match_timestamp'] = strtotime($val['match']['match_time']);
            }
            // 比赛战绩数据
            $result[$k]['record'] = $this->getMatchRecord(['id' => $val['match_record_id'], 'match_id' => $val['match_id']]);
        }
        return $result;
    }

    // 获取比赛申请|邀请裁判列表（分页）
    public function getMatchRefereeApplyPaginator($map=[], $order='id desc', $size=10) {
        $model = new MatchRefereeApply();
        $res = $model->where($map)->order($order)->paginate($size);
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        foreach ($result['data'] as $k => $val) {
            // 比赛信息
            $result['data'][$k]['match'] = $this->getMatch(['id' => $val['match_id']]);
            // 比赛战绩信息
            $result['data'][$k]['record'] = $this->getMatchRecord(['id' => $val['match_record_id'], 'match_id' => $val['match_id']]);
        }
        return $result;
    }

    // 获取比赛申请|邀请裁判列表
    public function getMatchRefereeApplyList($map=[], $page=1, $order='id desc', $size=10) {
        $model = new MatchRefereeApply();
        $res = $model->where($map)->order($order)->page($page)->limit($size)->select();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        foreach ($result as $k => $val) {
            // 比赛信息
            $result[$k]['match'] = $this->getMatch(['id' => $val['match_id']]);
            // 比赛战绩信息
            $result[$k]['record'] = $this->getMatchRecord(['id' => $val['match_record_id'], 'match_id' => $val['match_id']]);
        }
        return $result;
    }

    // 保存比赛申请|邀请裁判数据
    public function saveMatchRerfereeApply($data=[], $condition=[]) {
        $model = new MatchRefereeApply();
        if (!empty($condition)) {
            // 带更新条件更新数据
            $res = $model->allowField(true)->save($data, $condition);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
        if (isset($data['id'])) {
            // 更新数据
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
        // 插入数据
        $res = $model->allowField(true)->save($data);
        if ($res) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
        } else {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 批量保存比赛申请|邀请裁判数据
    public function saveAllMatchRerfereeApply($data) {
        $model = new MatchRefereeApply();
        $res = $model->saveAll($data);
        if ($res) {
            return ['code' => 200, 'msg' => __lang('MSG_200')];
        } else {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 获取比赛申请|邀请裁判数据
    public function getMatchRerfereeApply($map=[]) {
        $model = new MatchRefereeApply();
        $res = $model->where($map)->find();
        if (!$res) {
            return $res;
        }
        $result = $res->toArray();
        // 比赛信息
        $result['match'] = $this->getMatch(['id' => $result['match_id']]);
        // 比赛战绩信息
        $result['record'] = $this->getMatchRecord(['id' => $result['match_record_id'], 'match_id' => $result['match_id']]);
        return $result;
    }

    // 获取比赛申请|邀请裁判记录数
    public function getMatchRerfereeApplyCount($map=[]) {
        $model = new MatchRefereeApply();
        $res = $model->where($map)->count();
        return $res ? $res : 0;
    }

}