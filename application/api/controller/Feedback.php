<?php
namespace app\api\controller;


use app\service\FeedbackService;
use think\Exception;

class Feedback extends Base
{
    public function addfeedback() {
        // 检测会员登录
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => '请先登录平台或注册会员']);
        }
        $data = input('post.');
        if (!array_key_exists('content', $data) || empty($data['content'])) {
            return json(['code' => 100, 'msg' => '请填写问题意见']);
        }
        $data['member_id'] = $this->memberInfo['id'];
        $data['member'] = $this->memberInfo['member'];
        $data['member_avatar'] = $this->memberInfo['avatar'];
        $feedbackService = new FeedbackService();
        try {
            $res = $feedbackService->addFeedback($data);
            return json($res);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }
}