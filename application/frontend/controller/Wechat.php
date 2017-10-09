<?php
namespace app\frontend\controller;

// 微信端一些不用检测会员登录的操作
use app\service\MemberService;
use app\service\WechatService;
use think\Controller;

class Wechat extends Controller {
    // 扫描更换二维码 信息确认页
    public function bindwx() {
        $guid = input('param.guid');
        $memberid = input('param.memberid');
        $memberS = new MemberService();
        $member = $memberS->getMemberInfo(['id' => $memberid]);

        $wechatS = new WechatService();
        $userinfo = $wechatS->oauthUserinfo();
        
        dump($member);
        dump($userinfo);
        $this->assign('newwx', $userinfo);
        $this->assign('member', $member);
        return view();
    }

    // 扫描更换二维码 server-sent监听
    public function bindwxsse() {
        $request = input('param.');
        dump($request);
    }
}