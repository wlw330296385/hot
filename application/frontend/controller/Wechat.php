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

    // 扫描更换二维码 监听
    public function bindwxsse() {
//        header('Content-Type: text/event-stream; charset=utf-8');
//        header('Cache-Control: no-cache');
//        header("Expires: 0");
        $guid = input('guid');
//        $time = date('r');
//        echo "data: The server time is: {$time}\n\n";
        $info = Cache::get('memberchangewx_'.$guid) ? Cache::get('memberchangewx_'.$guid) : '0';
        if ($info != '0') {
            $member = [
                'id' => 0,
                'openid' => '',
                'member' => 'youke',
                'nickname' => '游客',
                'avatar' => '',
                'hp' => 0,
                'level' => 0,
                'telephone' => '',
                'email' => '',
                'realname' => '',
                'province' => '',
                'city' => '',
                'area' => '',
                'location' => '',
                'sex' => 0,
                'height' => 0,
                'weight' => 0,
                'charater' => '',
                'shoe_code' => 0,
                'birthday' => '0000-00-00',
                'create_time' => 0,
                'pid' => 0,
                'hp' => 0,
                'cert_id' => 0,
                'score' => 0,
                'flow' => 0,
                'balance' => 0,
                'remarks' => 0,
                'hot_id' => 00000000,
            ];
            cookie('mid', 0);
            cookie('member',md5($member['id'].$member['member'].config('salekey')));
            session('memberInfo',$member,'think');
            Cache::rm('memberchangewx_'.$guid);
            return json(['code'=> 200, 'msg' => __lang('MSG_200')]);
        }
//        flush();
    }
}