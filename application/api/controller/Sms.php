<?php 
namespace app\api\controller;
use SmsApi;

class Sms {
    // 获取手机验证码
    public function getMobileCodeApi(){
        try{
            $telephone = input('telephone');
            $use = input('use','会员注册');
            $randstr = str_shuffle('1234567890');
            $smscode = substr($randstr, 0, 6);
            $content = json_encode([ 'code' => $smscode, 'minute' => 5, 'comName' => 'HOT大热篮球' ]);
            $smsApi = new SmsApi();
            $smsApi->paramArr = [
                'mobile' => $telephone,
                'content' => $content,
                'tNum' => 'T150606060601'
            ];
            $sendsmsRes = $smsApi->sendsms();
            if ($sendsmsRes == 0) {
                $data = ['smscode' => $smscode, 'phone' => $telephone, 'content' => $content,'create_time' => time(), 'use' => $use];
                $savesms = db('smsverify')->insert($data);
                if (!$savesms) {
                    return [ 'code' => 200, 'msg' => '短信验证码记录异常' ];
                }

                return [ 'code' => 100, 'msg' => '验证码已发送,请注意查收' ];
            } else {
                return [ 'code' => 200, 'msg' => '获取验证码失败,请重试' ];
            }

        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }

    // 验证手机验证码
    public function validateSmsCodeApi(){
        try{
            $telephone = input('telephone');
            $smscode = input('smsCode');
            $smsverify = db('smsverify')->where([ 'phone' => $telephone, 'smscode' => $smscode, 'status' => 0 ])->find();
            if (!$smsverify) {
                return [ 'code' => 200, 'msg' => '验证码无效,请重试' ];
            }

            if (time()-$smsverify['create_time'] > 300) {
                return [ 'code' => 200, 'msg' => '验证码已过期,请重新获取' ];
            }

            db('smsverify')->where(['id' => $smsverify['id']])->setField('status', 1);
            return [ 'code' => 100, 'msg' => '验证通过'];

        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }
}