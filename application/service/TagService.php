<?php
// 评论标签service
namespace app\service;


use app\model\Tag;
use app\model\TagComment;

class TagService {
    /** 标签列表（所有数据 无分页）
     * @param array $map 查询条件
     * @param string $order 排序
     * @return array|false|\PDOStatement|string|\think\Collection
     */
    public function getTags($map=[], $order='id desc') {
        $model = new Tag();
        $res = $model->where($map)->order($order)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    /** 标签列表（page分页）
     * @param array $map 查询条件
     * @param int $page 页数（第几页）
     * @param string $order 排序
     * @param int $limit 每页显示的数量
     * @return array|false|\PDOStatement|string|\think\Collection
     */
    public function getTagList($map=[], $page=1, $order='id desc', $limit=10) {
        $model = new Tag();
        $res = $model->where($map)->order($order)->page($page)->limit($limit)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    /** 标签列表（paginate分页）
     * @param $map
     * @param string $order
     * @param int $paginate
     * @return array|\think\Paginator
     */
    public function getTagPaginator($map, $order='id desc', $paginate=10) {
        $model = new Tag();
        $res = $model->where($map)->order($order)->paginate($paginate);
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    /** 添加标签评论记录
     * @param $data = [
     *  'comment_type', 'commented', 'commented_id', 'member_id', 'member', 'member_avatar', 'tag_id, 'tag'
     * ]
     * @return array|false
     */
    public function addTagComment($data) {
        // 拆分提交的tag_id集合、tag集合
        $tag_idArr = explode(',', $data['tag_ids']);
        $tagArr = explode(',', $data['tags']);
        $saveData = [];
        // 遍历拆分提交的tag_id
        // 会员只能对评论实体发布一次评论标签
        // 组合保存数据
        $commentModel = new TagComment();
        foreach ($tag_idArr as $k => $tag_id) {
            $hadComment = $commentModel->where([ 'comment_type' => $data['comment_type'], 'commented_id' => $data['commented_id'], 'member_id' => $data['member_id'] ])->find();
            if ($hadComment) {
                return ['code' => 100, 'msg' => '您已经发表"'.$tagArr[$k].'"印象，不能再次发表喔'];
            } else {
                array_push($saveData, [
                    'comment_type' => $data['comment_type'],
                    'commented' => $data['commented'],
                    'commented_id' => $data['commented_id'],
                    'member_id' => $data['member_id'],
                    'member' => $data['member'],
                    'member_avatar' => $data['member_avatar'],
                    'tag_id' => $tag_id,
                    'tag' => $tagArr[$k]
                ]);
            }
        }
        // 保存评论记录
        // 返回结果
        $res = $commentModel->saveAll($saveData);
        if ($res) {
            // 评论成功 更新所提交的tag被评论次数统计+1
            $tagModel = new Tag();
            $tagModel->where('id','in', $data['tag_ids'])->setInc('comment_num', 1);
            return ['code' => 200, 'msg' => __lang('MSG_200')];
        } else {
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    /** 获取标签评论记录（带统计评论次数）
     * @param $map
     * @return array|false|\PDOStatement|string|\think\Collection
     */
    public function getTagComment($map){
        $model = new TagComment();
        $field = '*, count(*) as count';
        $res = $model->field($field)->where($map)->group('tag_id')->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }
}