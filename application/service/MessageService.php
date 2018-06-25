<?php

namespace app\service;

use app\model\Message;
use app\model\MessageMember;
use app\common\validate\MessageVal;
use think\Db;

class MessageService
{
    private $MessageModel;
    private $MessageMemberModel;

    public function __construct()
    {
        $this->MessageModel = new Message;
        $this->MessageMemberModel = new MessageMember;
    }

    // 获取Message
    public function getMessageInfo($map)
    {
        $result = $this->MessageModel->where($map)->find();
        if ($result) {
            $res = $result->toArray();
            return $res;
        } else {
            return $result;
        }


    }

    //个人消息
    public function getMessageMemberInfo($map)
    {
        $result = $this->MessageMemberModel->where($map)->find();
        if ($result) {
            $res = $result->toArray();
            return $res;
        } else {
            return $result;
        }


    }


    //获取个人消息列表
    public function getMessageMemberList($map = [], $page = 1, $paginate = 10)
    {
        $result = $this->MessageMemberModel
            ->where($map)
            ->page($page, $paginate)
            ->select();
        if ($result) {
            $res = $result->toArray();
            return $res;
        } else {
            return $result;
        }
    }

    // 只发送个人消息
    public function saveMessageMemberInfo($data)
    {
        $validate = validate('MessageVal');
        if (!$validate->check($data)) {
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        $result = $this->MessageMemberModel->save($data);
        // 循环发送模板消息

        if ($result === false) {
            return ['msg' => $this->MessageModel->getError(), 'code' => 100];
        } else {
            return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }
    }


    // 发送个人消息和模板消息
    public function sendMessageMember($member_id, $messageData, $saveData)
    {   
        $res = $this->MessageMemberModel->save($saveData);
        if ($res) {
            $memberInfo = db('member')->where(['id'=>$member_id])->find();
            if($memberInfo['openid']){
                $messageData['touser'] = $memberInfo['openid'];
                $WechatService = new \app\service\WechatService();
                $result = $WechatService->sendTemplate($messageData);
                if ($result) {
                    $logData = ['wxopenid' => $messageData['touser'], 'member_id' => $saveData['member_id'], 'status' => 1, 'content' => serialize($messageData),'system_remarks'=>'给用户的通知','url'=>$messageData['url']];
                    $this->insertLog($logData);
                } else {
                    $logData = ['wxopenid' => $messageData['touser'], 'member_id' => $saveData['member_id'], 'status' => 0, 'content' => serialize($messageData),'system_remarks'=>'给用户的通知','url'=>$messageData['url']];
                    $this->insertLog($logData);
                }
                return true;
            }
            
        }
        return false;
    }

    // 给训练营的营主|管理员发送消息
    public function sendCampMessage($camp_id, $messageData, $saveData)
    {
        $saveallData = [];
        // 获取训练营的营主openid
        $memberIDs = db('camp_member')->where(['camp_id' => $camp_id, 'status' => 1])->where('type', 'egt', 3)->column('member_id');
        $memberList = db('member')->where('id', 'in', $memberIDs)->select();
        $WechatService = new \app\service\WechatService();
        // 发送模板消息
        foreach ($memberList as $key => $value) {
            if ($value['openid']) {
                $messageData['touser'] = $value['openid'];
                $messageData['url'] = $messageData['url'].'/openid/'.$value['openid'];
                
                $result = $WechatService->sendTemplate($messageData);
                if ($result) {
                    $logData = ['wxopenid' => $value['openid'], 'member_id' => $value['id'], 'status' => 1, 'content' => serialize($messageData), 'url' => $messageData['url'],'system_remarks'=>'给训练营营主和管理员的通知'];
                    $this->insertLog($logData);
                } else {
                    $logData = ['wxopenid' => $value['openid'], 'member_id' => $value['id'], 'status' => 0, 'content' => serialize($messageData), 'url' => $messageData['url'],'system_remarks'=>'给训练营营主和管理员的通知'];
                    $this->insertLog($logData);
                }
            }
            $saveallData[$key] = $saveData;
            $saveallData[$key]['member_id'] = $value['id'];
        }
        $res = $this->MessageMemberModel->saveAll($saveallData);
    }

    // 获取系统消息列表
    public function getMessageList($map = [], $paginate = 10)
    {
		$result = Message::where(['status' => 1])->order('id desc')->paginate($paginate);
		if ($result) {
		    $list= $result->toArray();
		    foreach ($list['data'] as $key => $val) {
		        $messageRead = db('message_read')->where(['message_id' => $val['id'], 'member_id' => $map['member_id'], 'isread' => 2])->find();
		        if ($messageRead) {
                    $list['data'][$key]['isread'] = 2;
                } else {
                    $list['data'][$key]['isread'] = 1;
                }
            }
		    return $list;
        } else {
		    return $result;
        }
    }

    // 获取个人消息列表
    public function getMessageMemberListByPage($map = [], $paginate = 10)
    {
        $result = $this->MessageMemberModel
            ->where($map)
            ->order('id desc')
            ->paginate($paginate);
            // echo $this->MessageMemberModel->getlastsql();die;
        if ($result) {
            $res = $result->toArray();
            return $res;
        } else {
            return $result;
        }
    }

    //修改系统Message资料
    public function updateMessageInfo($data, $id)
    {
        $result = $this->MessageModel->save($data, ['id' => $id]);

        if ($result === false) {
            return ['msg' => $this->MessageModel->getError(), 'code' => 100];
        } else {
            return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }
    }

    //新建系统Message
    public function saveMessageInfo($data, $templateData)
    {
        $validate = validate('MessageVal');
        if (!$validate->check($data)) {
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        $result = $this->MessageModel->data($data)->save();
        // 循环发送模板消息

        if ($result === false) {
            return ['msg' => $this->MessageModel->getError(), 'code' => 100];
        } else {
            return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }
    }


    // 删除消息
    public function removeMessageMember($map)
    {
        $result = $this->MessageMemberModel->delete($map);
        return $result;
    }

    // 消息记录封装
    private function insertLog($data)
    {
        $LogSendtemplatemsg = new \app\model\LogSendtemplatemsg;
        $LogSendtemplatemsg->save($data);
    }

    // 发送消息给管理员/营主-申请加入训练营审核
    public function campJoinAudit($data, $camp_id)
    {
        if (!$camp_id) {
            return ['code' => 100, 'msg' => __lang('MSG_402')];
        }
        $receivers = db('camp_member')->where(['camp_id' => $camp_id, 'status' => 1, 'type' => ['egt', 3]])->select();
        $wechatS = new WechatService();
        foreach ($receivers as $receiver) {
            $memberopenid = getMemberOpenid($receiver['member_id']);
            $sendTemplateData = [
                'touser' => $memberopenid,
                'template_id' => 'aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q',
                'url' => url($data['baseurl'], ['camp_id' => $camp_id, 'status' => 0, 'openid' => $memberopenid], '', true),
                'data' => [
                    'first' => ['value' => $data['content']],
                    'keyword1' => ['value' => $data['member']],
                    'keyword2' => ['value' => $data['jointime']],
                    'remark' => ['value' => '点击进入操作']
                ]
            ];
            $sendTemplateResult = $wechatS->sendTemplate($sendTemplateData);
            $log_sendTemplateData = [
                'wxopenid' => $sendTemplateData['touser'],
                'member_id' => $receiver['member_id'],
                'url' => $sendTemplateData['url'],
                'content' => serialize($sendTemplateData),
                'create_time' => time()
            ];
            if ($sendTemplateResult) {
                $log_sendTemplateData['status'] = 1;
            } else {
                $log_sendTemplateData['status'] = 0;
            }
            db('log_sendtemplatemsg')->insert($log_sendTemplateData);

            db('message_member')->insert([
                'title' => $data['title'],
                'content' => $data['content'],
                'url' => $sendTemplateData['url'],
                'member_id' => $receiver['member_id'],
                'create_time' => time(),
                'update_time' => time(),
                'status' => 1
            ]);
        }
    }

    // 发送消息给申请人-申请加入训练营审核结果
    public function campJoinAuditResult($data, $member_id)
    {
        if (!$member_id) {
            return ['code' => 100, 'msg' => __lang('MSG_402')];
        }
        $wechatS = new WechatService();
        $memberopenid = getMemberOpenid($member_id);
        $sendTemplateData = [
            'touser' => $memberopenid,
            'template_id' => 'xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88',
            'url' => $data['url'],
            'data' => [
                'first' => ['value' => $data['content']],
                'keyword1' => ['value' => $data['checkstr']],
                'keyword2' => ['value' => $data['audittime']],
                'remark' => ['value' => '点击进入操作']
            ]
        ];
        $sendTemplateResult = $wechatS->sendTemplate($sendTemplateData);
        $log_sendTemplateData = [
            'wxopenid' => $sendTemplateData['touser'],
            'member_id' => $member_id,
            'url' => $sendTemplateData['url'],
            'content' => serialize($sendTemplateData),
            'create_time' => time()
        ];
        if ($sendTemplateResult) {
            $log_sendTemplateData['status'] = 1;
        } else {
            $log_sendTemplateData['status'] = 0;
        }
        db('log_sendtemplatemsg')->insert($log_sendTemplateData);

        db('message_member')->insert([
            'title' => $data['title'],
            'content' => $data['content'],
            'url' => $sendTemplateData['url'],
            'member_id' => $member_id,
            'create_time' => time(),
            'update_time' => time(),
            'status' => 1
        ]);
    }

    /** 发送站内信息和模板消息给一个会员 2017-12-8
     * @param $member_id 接收信息的会员id
     * @param array $data 消息内容
     * $data = ['title' 'content', 'url', 'keyword1', 'keyword2', 'keyword3', 'remark']
     * @param $template_id 公众号模板消息id 应用config config('wxTemplateID.')
     * @param int $sendInterval 产生发送消息时间间隔(秒) 0:忽略时间间隔
     * @return array|bool
     */
    public function sendMessageToMember($member_id, $data=[], $template_id, $sendInterval=0) {
        if (!$member_id) {
            return ['code' => 100, 'msg' => __lang('MSG_402')];
        }
        $res = false;
        // 产生发送消息时间间隔
        if ($sendInterval) {
            // 查询消息数据中最近有无同样的消息内容
            $messageMember = db('message_member')
                ->where([
                'steward_type' => $data['steward_type'],
                'title' => $data['title'],
                'content' => $data['content'],
                'member_id' => $member_id,
                'url' => $data['url']
                ])
                ->whereNull('delete_time')
                ->order('id desc')
                ->find();
            // 查有数据记录，与当前时间比较是否大于产生发送消息时间间隔（$sendInterval），并且信息未读。不产生消息推送
            if ($messageMember
                && $messageMember['status'] == 1
                && (time()-$messageMember['create_time']) < $sendInterval
            ) {
                // 跳出
                return ;
            }
        }
        $wechatS = new WechatService();
        $memberopenid = getMemberOpenid($member_id);
        $sendTemplateData = [
            'touser' => $memberopenid,
            'template_id' => $template_id,
            'url' => $data['url'].'/openid/'.$memberopenid,
            'data' => [
                'first' => ['value' => $data['content']],
                'keyword1' => ['value' => $data['keyword1']],
                'keyword2' => ['value' => $data['keyword2']],
                'remark' => ['value' => $data['remark']]
            ]
        ];
        if (isset($data['keyword3'])) {
            $sendTemplateData['data']['keyword3'] = [ 'value' => $data['keyword3'] ];
        }
        $sendTemplateResult = $wechatS->sendTemplate($sendTemplateData);
        $log_sendTemplateData = [
            'wxopenid' => $sendTemplateData['touser'],
            'member_id' => $member_id,
            'url' => $sendTemplateData['url'],
            'content' => serialize($sendTemplateData),
            'create_time' => time(),
            'update_time' => time()
        ];
        if ($sendTemplateResult) {
            $log_sendTemplateData['status'] = 1;
        } else {
            $log_sendTemplateData['status'] = 0;
        }
        db('log_sendtemplatemsg')->insert($log_sendTemplateData);

        db('message_member')->insert([
            'title' => $data['title'],
            'content' => $data['content'],
            'url' => $data['url'],
            'member_id' => $member_id,
            'create_time' => time(),
            'update_time' => time(),
            'status' => 1,
            'steward_type' => isset($data['steward_type']) ? $data['steward_type'] : 1
        ]);
        $res = true;
        return $res;
    }

    /**
     * 发送站内信息和模板消息给多个会员 2018-1-31
     * @param $member_ids  接收信息的会员id集合
     * @param $data  消息内容
     * $data = ['title' 'content', 'url', 'keyword1', 'keyword2', 'keyword3', 'remark']
     * @param $template_id  公众号模板消息id 应用config config('wxTemplateID.')
     * @return
     */
    public function sendMessageToMembers($member_ids=[], $data=[], $template_id) {
        if (!is_array($member_ids)) {
            return ['code' => 100, 'msg' => __lang('MSG_402')];
        }
        $res = false;
        $wechatS = new WechatService();
        foreach ($member_ids as $k => $val) {
            $memberopenid = getMemberOpenid($val['id']);
            $sendTemplateData = [
                'touser' => $memberopenid,
                'template_id' => $template_id,
                'url' => $data['url'].'/openid/'.$memberopenid,
                'data' => [
                    'first' => ['value' => $data['content']],
                    'keyword1' => ['value' => $data['keyword1']],
                    'keyword2' => ['value' => $data['keyword2']],
                    'remark' => ['value' => $data['remark']]
                ]
            ];
            if (isset($data['keyword3'])) {
                $sendTemplateData['data']['keyword3'] = [ 'value' => $data['keyword3'] ];
            }
            $sendTemplateResult = $wechatS->sendTemplate($sendTemplateData);
            $log_sendTemplateData = [
                'wxopenid' => $sendTemplateData['touser'],
                'member_id' => $val['id'],
                'url' => $sendTemplateData['url'],
                'content' => serialize($sendTemplateData),
                'create_time' => time(),
                'update_time' => time()
            ];
            if ($sendTemplateResult) {
                $log_sendTemplateData['status'] = 1;
            } else {
                $log_sendTemplateData['status'] = 0;
            }
            db('log_sendtemplatemsg')->insert($log_sendTemplateData);

            db('message_member')->insert([
                'title' => $data['title'],
                'content' => $data['content'],
                'url' => $sendTemplateData['url'],
                'member_id' => $val['id'],
                'create_time' => time(),
                'update_time' => time(),
                'status' => 1,
                'steward_type' => isset($data['steward_type']) ? $data['steward_type'] : 1
            ]);
        }
        $res = true;
        return $res;
    }
}