<?php
namespace app\frontend\controller;
// 聊天室
class Chat extends Base
{
    // 聊天窗口
    public function imchat() {
        return view('Chat/imchat');
    }
}