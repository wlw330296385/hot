<?php
/**
* 	配置账号信息
*/

class WxPayConf_pub
{

    //=======【基本信息设置】=====================================
    //微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
    // const APPID = 'wx9f2cfaede45f8cb8';
    // //受理商ID，身份标识
    // const MCHID = '1447398502';//测试
    // //商户支付密钥Key。审核通过后，在微信发送的邮件中查看
    // const KEY = 'sjw12161111111111111111111111111';
    // //JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
    // const APPSECRET = '5bf85c2496fabe77ebaf0a75434a2fcc';

         //=======【基本信息设置】=====================================
    //微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
    const APPID = 'wxb22cfb38b4b95439';
    //受理商ID，身份标识
    const MCHID = '1483498322';//测试
    //商户支付密钥Key。审核通过后，在微信发送的邮件中查看
    const KEY = '749471f959d5f218a55164ab0b631bdb';
    //JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
    const APPSECRET = 'd21eae1cc6d146026b6bf39d6e201796';



    
    //=======【JSAPI路径设置】===================================
    //获取access_token过程中的跳转uri，通过跳转将code传入jsapi支付页面
    const JS_API_CALL_URL = 'https://m.hot-basketball.com/frontend/login/wxlogin';
    
    //=======【证书路径设置】=====================================
    //证书路径,注意应该填写绝对路径
    const SSLCERT_PATH = '/ThinkPHP/Library/Vendor/WxPayPubHelper/cacert/apiclient_cert.pem';
    const SSLKEY_PATH = '/ThinkPHP/Library/Vendor/WxPayPubHelper/cacert/apiclient_key.pem';
    const SSLCA_PATH = '/index.php/Home/WxJsAPI/notify';
    
    //=======【异步通知url设置】===================================
    //异步通知url，商户根据实际开发过程设定
   const NOTIFY_URL = 'https://m.hot-basketball.com/frontend/login/notifyUrl';

    //=======【curl超时设置】===================================
    //本例程通过curl使用HTTP POST方法，此处可修改其超时时间，默认为30秒
    const CURL_TIMEOUT = 30;
    
}
	
?>

