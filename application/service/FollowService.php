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
            } else {
                $data['status'] = 1;
                $msg = '关注成功';
            }
            $result = $model->allowField(true)->isUpdate(false)->save($data);
            if ($result) {
                $response = ['code' => 200, 'msg' => $msg];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
        return $response;
    }

    // 设置关注数据
    public function setFollow($data) {
        $model = new Follow();
        // 查询有无follow数据
        $follow = $model->where(['type' => $data['type'], 'follow_id' => $data['follow_id'], 'member_id' => $data['member_id']])->find();
        if ($follow) {
            $follow = $follow->toArray();
            // 更新原数据为正常
            if ($follow['status'] != 1) {
                $model->allowField(true)->isUpdate(true)->save(['id' => $follow['id'], 'status' => 1]);
            }
        } else {
            // 插入新数据
            $data['status'] = 1;
            $model->allowField(true)->save($data);
        }
    }

    // 关注列表
    public function getfollowlist($map, $order='id desc', $paginate=10) {
        $model = new Follow();
        $query = $model->where($map)->order($order)->paginate($paginate);
        if ($query) {
            return $query->toArray();
        } else {
            return $query;
        }
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

    // 实体获取粉丝数
    public function getfansnum($follow_id, $type=1) {
        $model = new Follow();
        $count = $model->where([
            'status' => 1,
            'follow_id' => $follow_id,
            'type' => $type
        ])->count();
        return ($count) ? $count : 0;
    }
}