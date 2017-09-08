<?php
namespace app\service;
use wechatsdk\TPwechat;

class WechatService
{
    public $options;

    public function __construct() {
        $this->options = array(
            'token' => config('token'),
            //'encodingaeskey'=> config('queue.encodingaeskey'),
            'appid' => config('appid'),
            'appsecret' => config('appsecret')
        );
    }

    //获取全局access_token
    public function authactoken() {
        $weObj = new TPwechat($this->options);
        $appid = $this->options['appid'];
        $appsecret = $this->options['appsecret'];

        $authname = 'wechat_access_token'.$appid;
        $auth_cache = cache($authname);
        if (!$auth_cache) {
            $result = $weObj->checkAuth($appid, $appsecret);
            return $result;
        } else {
            return $auth_cache;
        }

    }

    // 公众号绑定
    public function mpbind() {
        $weObj = new TPwechat($this->options);
        $weObj->valid();
        ob_clean();
    }

    // 获取公众号菜单
    public function getmenu() {
        $weObj = new TPwechat($this->options);
        $menu = $weObj->getMenu();
        return $menu;
    }

    /** 设置公众号菜单
     * @param $menu 菜单数据数组
     * @return bool
     */
    public function setmenu($menu) {
        $weObj = new TPwechat($this->options);
        return $weObj->createMenu($menu);
    }

    // 生成用户授权链接
    public function oauthredirect($callback) {
        $weObj = new TPwechat($this->options);
        return $weObj->getOauthRedirect($callback,config('state'));
    }

    // 获取授权用户信息
    public function oauthuserinfo() {
        $weObj = new TPwechat($this->options);
        $accesstoken = $weObj->getOauthAccessToken();
        //dump($accesstoken);
        if ($accesstoken) {
            $userinfo = $weObj->getOauthUserinfo($accesstoken['access_token'], $accesstoken['openid']);
            if ($userinfo) {
                return $userinfo;
            }
        }
    }

    /**
     * 发送模板消息
     * @param array $data 消息结构
     * ｛
            "touser":"OPENID",
            "template_id":"ngqIpbwh8bUfcSsECmogfXcV14J0tQlEpBO27izEYtY",
            "url":"http://weixin.qq.com/download",
            "topcolor":"#FF0000",
            "data":{
                "参数名1": {
                    "value":"参数",
                    "color":"#173177"	 //参数颜色
                },
                "Date":{
                    "value":"06月07日 19时24分",
                    "color":"#173177"
                },
                "CardNumber":{
                    "value":"0426",
                    "color":"#173177"
                },
                "Type":{
                    "value":"消费",
                    "color":"#173177"
                }
            }
        }
     */
    public function sendmessage($data) {
        $weObj = new TPwechat($this->options);
        return $weObj->sendTemplateMessage($data);
    }

    /** jssdk 签名验证 用于分享页面
     * @param $url 分享页面url 不带传参
     * @return array|bool
     */
    public function jsapi($url) {
        $appid = $this->options['appid'];
        $weObj = new TPwechat($this->options);
        return $weObj->getJsSign($url, 0, '', $appid);
    }
}