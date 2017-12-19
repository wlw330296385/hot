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

            /*$$data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['member_avatar'] = $this->memberInfo['avatar'];
            $tags_id = $data['tag_ids'];
            dump($tags_id);*/
            $tag_ids = input('tag_ids');
            $tag_idArr = explode(',', $tag_ids);
            $saveData = [];
            //dump($tag_idArr);
            foreach ($tag_idArr as $k => $tag_id) {
                $saveData[$k] = [
                    'comment_type' => input('post.comment_type'),
                    'commented' => input('post.commented'),
                    'commented_id' => input('post.commented_id'),
                    'member_id' => $this->memberInfo['id'],
                    'member' => $this->memberInfo['member'],
                    'member_avatar' => $this->memberInfo['avatar'],
                    'tag_id' => $tag_id
                ];
            }
            //dump($data);

        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }
}