<?php
namespace app\service;
use app\model\Follow;

class FollowService {
    // 保存follow数据
    public function saveFollow($data) {
        $model = new Follow();
        $hadFollow = $model->where(['type' => $data['type'], 'follow_id' => $data['follow_id'], 'member_id' => $data['member_id']])->find();
        if (!$hadFollow) {
            $data['status'] = 1;
            $result = $model->allowField(true)->save($data);
            if ($result) {
                
                $response = ['code' => 200, 'msg' => '关注成功', 'data' => $model->id];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        } else {
            $hadFollow = $hadFollow->toArray();
            $data['id'] = $hadFollow['id'];
            $msg = '';
            if ($hadFollow['status']==1) {
                $data['status'] = -1;
                $msg = '取消关注成功';
                // 若是球队，球队粉丝数-1
                if ($data['type'] == 4) {
                    db('team')->where('id', $data['follow_id'])->setDec('fans_num', 1);
                }
            } else {
                $data['status'] = 1;
                $msg = '关注成功';
                
                // 若是球队，球队粉丝数+1
                if ($data['type'] == 4) {
                    db('team')->where('id', $data['follow_id'])->setInc('fans_num', 1);
                }
            }
            $result = $model->allowField(true)->isUpdate()->save($data);
            if ($result) {
                $response = ['code' => 200, 'msg' => $msg];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
        return $response;
    }

    // 关注列表
    public function getfollowlist($map, $order='id desc', $paginate=10) {
        $model = new Follow();
        $list = $model->where($map)->order($order)->paginate($paginate);
        return $list;
    }

    // 获取关注数据
    public function getfollow($map) {
        $model = new Follow();
        $result = $model->where($map)->find();
        if ($result) {
            return $result->toArray();
        } else {
            return $result;
        }
    }

    // 保存canmp_mebmer数据
    protected function saveCampMember($data) {
        $campmemberDb = db('camp_member');
        $campmember = $campmemberDb->where(['camp_id' => $data['follow_id'], 'member_id' => $data['member_id']])->find();
        if ($campmember) {
            if ($campmember['status'] != 1) {
                $campmemberDb->where(['id' => $campmember['id']])->update(['status' => 1, 'type' => -1]);
            }
        } else {
            $campmemberDb->insert([
                'camp_id' => $data['follow_id'],
                'camp' => $data['follow_name'],
                'member_id' => $data['member_id'],
                'member' => $data['member'],
                'type' => -1, 'status' => 1,
                'create_time' => time(), 'update_time' => time()
            ]);
        }
    }


}