<?php
namespace app\frontend\controller;

// 微信端一些不用检测会员登录的操作
use app\service\MemberService;
use app\service\WechatService;
use think\Cache;
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

        cache('userinfo_'.$userinfo['openid'], $userinfo, 300);

        //dump($member);
        //dump($userinfo);
        $this->assign('newwx', $userinfo);
        $this->assign('member', $member);
        $this->assign('guid', $guid);
        return view('Member/wechatComfirm');
    }

    // 扫描更换二维码 server-sent监听
    public function bindwxsse() {
        header('Content-Type: text/event-stream; charset=utf-8');
        header('Cache-Control: no-cache');
        header("Expires: 0");
        $guid = input('guid');
//        $time = date('r');
//        echo "data: The server time is: {$time}\n\n";
        $info = Cache::get('memberchangewx_'.$guid) ? Cache::get('memberchangewx_'.$guid) : '0';
        if ($info != '0') {
            echo "event: message"."\n";
            echo "data: 绑定成功\n\n";
            Cache::rm('memberchangewx_'.$guid);
        }
        flush();
    }
}