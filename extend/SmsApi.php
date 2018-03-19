<?php
//namespace extend;
class SmsApi {
    public $api_appid;
    public $api_secret;
    public $paramArr;

    public function __construct() {
        $this->api_appid = config('SMS_APPID');
        $this->api_secret = config('SMS_SECRET');
    }

    // 创建参数并签名处理
    public function createParam($paramArr, $api_secret) {
        $paraStr = "";
        $signStr = "";
        ksort($paramArr);
        foreach ( $paramArr as $key => $val ) {
            if ( $key != '' && $val != '' ) {
                $signStr .= $key.$val;
                $paraStr .= $key.'='.urlencode($val).'&';
            }
        }
        $signStr .= $api_secret;
        $sign = strtolower( md5($signStr) );
        $paraStr .= 'showapi_sign='. $sign;
        //dump($paraStr);
        return $paraStr;
    }

    /** 添加短信模板
     * $smsapi = new SmsApi();
     * $smsapi->paramArr = [
     *     'content' => '您好,您的验证码是[code]，本验证有效时间[minute]分钟',
     *     'title' => '【showapi sms】'
     * ];
     * $smsapi->addTemplate();
     */
    public function addTemplate() {
        $this->paramArr = array_merge( $this->paramArr, ['showapi_appid' => $this->api_appid] );
        $param = $this->createParam($this->paramArr, $this->api_secret);
        //dump($param);
        $url = 'http://route.showapi.com/28-2?'.$param;
        $result = file_get_contents($url);
        $result = json_decode($result);
        $code = $result->showapi_res_code;
        if ($code == 0) {
            return $result->showapi_res_body;
        } else {
            return false;
        }
    }

    /** 查询短信模板
     * $smsApi = new SmsApi();
     * $smsApi->allTemplate();
     */
    public function allTemplate() {
        $this->paramArr = ['showapi_appid' => $this->api_appid] ;
        $param = $this->createParam($this->paramArr, $this->api_secret);
        $url = 'http://route.showapi.com/28-3?'.$param;
        $result = file_get_contents($url);
        $result = json_decode($result);
        $code = $result->showapi_res_code;
        if ( $code == 0 ) {
            return $result->showapi_res_body;
        } else {
            return false;
        }
    }

    /** 发送短信
     * mobile 手机号码 content 短信内容json格式(utf-8编码) tNum 短信模板ID
     * $smsApi = new SmsApi();
     * $smsApi->paramArr = [
     *     'mobile' => '',
     *     'content' => '',
     *     'tNum' => ''
     * ];
     * $smsApi->sendsms();
     * @return bool
     */
    public function sendsms() {
        $this->paramArr = array_merge( $this->paramArr, ['showapi_appid' => $this->api_appid] );
        $param = $this->createParam($this->paramArr, $this->api_secret);
        $url = 'http://route.showapi.com/28-1?'.$param;
        $result = file_get_contents($url);
        $result = json_decode($result);
        $code = $result->showapi_res_code;
        if ( $code == 0 ) {
            return $result->showapi_res_code;
        } else {
            return $result->showapi_res_body->msg;
        }
    }
}