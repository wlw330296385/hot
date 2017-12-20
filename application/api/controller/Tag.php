<?php
// tag标签评论api
namespace app\api\controller;


use app\service\TagService;
use think\Exception;

class Tag extends Base {
    // 获取上架所有标签
    public function tagall() {
        try {
            $tagS = new TagService();
            $res = $tagS->getTags(['status' => 1]);
            if ($res) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $res];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 添加标签评论
    public function addtagcomment() {
        try {
            if (!input('?tag_ids')) {
                return json(['code' => 100, 'msg' => '请选择印象标签']);
            }
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['member_avatar'] = $this->memberInfo['avatar'];
            $tagS = new TagService();
            $result = $tagS->addTagComment($data);
            return json($result);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 获取实体的评论记录列表
    public function commentlist() {
        try {
            // 判断必传参数
            $comment_type = input('post.comment_type');
            $commented_id = input('post.commented_id');
            if (!$comment_type || !$commented_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            // 组合接收参数作为查询提交
            $map = input('post.');
            $tagS = new TagService();
            $result = $tagS->getTagComment($map);
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_401')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }
}