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
     * @param array $tag_idArr 提交的评论标签tag表id集合数组
     * @return array|false
     */
    public function addTagComment($data, $tag_idArr=[]) {
        $commentModel = new TagComment();
        //$comment = $commentModel->data($data)->save();
        $comment = $commentModel->saveAll($data);
        if ($comment) {
            $tagModel = new Tag();
            foreach ($tag_idArr as $tag_id) {
                $tagModel->where('id', $tag_id)->setInc('comment_num', 1);
            }
        }
        return $comment;
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