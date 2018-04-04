<?php
namespace app\service;
use app\model\Feedback;

class FeedbackService
{
    /** 添加建议反馈
     * @param $data
     * @return array
     */
    public function addFeedback($data) {
        $model = new Feedback();
        $res = $model->allowField(true)->save($data);
        if (!$res) {
            trace('error:' . $model->getError() . ', \n sql:' . $model->getLastSql(), 'error');
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        } else {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
        }
    }
}