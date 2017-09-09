<?php 
namespace app\api\controller;
use think\Exception;

class Sms {
    public function sendcode() {
        try {
            $telephone = input('telephone');
            $smsapi = new \SmsApi();
            $code = rand(100000, 999999);

            $smsapi->paramArr = [
                'mobile' => $telephone,
                'content' => json_encode(['code' => $code, 'minute' => '5', 'comName' => 'HOT大热篮球']),
                'tNum' => 'T150606060601'
            ];
            $sendsmsRes = $smsapi->sendsms();
            if ($sendsmsRes == 0) {
                $data = ['smsCode' => $code, 'telephone' => $telephone, 'time' => time()];
                session('smsCode', $data, 'think');
                return [ 'code' => 100, 'msg' => '验证码已发送' ];
            } else {
                return ['code' => 200, 'msg' => $sendsmsRes];
            }

        } catch (Exception $e) {
            return ['code' => 200, 'msg' => $e->getMessage()];
        }
    }

    public function checkcode($telephone, $smscode) {
        try {
            $data = session('smsCode', '', 'think');
            if (time()-$data['time'] > 300) {
                return [ 'code' => 200, 'msg' => '验证码已过期失效,请重新获取' ];
            }
            if ($telephone == $data['telephone'] && $smscode == $data['smsCode']) {
                return [ 'code' => 100, 'msg' => '验证成功' ];
            } else {
                return [ 'code' => 200, 'msg' => '验证码不符,请重试' ];
            }
        } catch( Exception $e) {
            return ['code' => 200, 'msg' => $e->getMessage()];
        }
    }
}