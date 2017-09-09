<?php 
namespace app\api\controller;
use SmsApi;
class Login extends Base{
	
    public function index() {

       
    }

    public function registerApi(){
        try{
        	$data = input('post.');
        	$memberService = new \app\service\MemberService;
        	$result = $memberService->saveMemberInfo($data);
            if($result['code']==100){
                if($this->param['pid'] && !$memberInfo['pid']){
                    $MemberSerivce = new \app\service\MemberSerivce;
                    $MemberSerivce->setPid($this->param['pid'],$memberInfo['id']);
                }
            }
            return json($result);
        }catch (Exception $e){
        	return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function isFieldRegisterApi(){
    	try{
        	$field = input('post.field');
        	$value = input('post.value');
        	$memberService = new \app\service\MemberService;
        	$result = $memberService->isFieldRegister($field,$value);
            return json(['code'=>100,'msg'=>$result]);
        }catch (Exception $e){
        	return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    public function loginApi(){
    	try{
        	$username = input('post.username');
        	$password = input('post.password');
        	$memberService = new \app\service\MemberService;
        	$result = $memberService->login($username,$password);
            if($result){
            	$res = $this->wxlogin($result);
            	if($res===true){
                    session(null,'token');
            		return json(['code'=>100,'msg'=>'登陆成功']);
            	}else{
            		return json(['code'=>200,'msg'=>'系统错误']);
            	}            	
            }
            return json(['code'=>200,'msg'=>'账号密码错误']);
        }catch (Exception $e){
        	return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }


    protected function wxlogin($id){
		$member =new \app\service\MemberService;
    	$memberInfo = $member->getMemberInfo(['id'=>$id]);
    	unset($memberInfo['password']);
    	$cookie = md5($memberInfo['id'].$memberInfo['create_time'].'hot');
    	cookie('member',md5($memberInfo['id'].$memberInfo['create_time'].'hot'));    	
        $result = session('memberInfo',$memberInfo,'think');
        if($cookie){
        	return true;
        }else{
        	return false;
        }
	}



    public function autoLogin(){
        $id = 1;
        $member =new \app\service\MemberService;
        $memberInfo = $member->getMemberInfo(['id'=>$id]);
        unset($memberInfo['password']);
        $this->memberInfo = $memberInfo;
        $cookie = md5($memberInfo['id'].$memberInfo['create_time'].'hot');
        cookie('member',md5($this->memberInfo['id'].$this->memberInfo['create_time'].'hot'));   
        $result = session('memberInfo',$memberInfo,'think');
        return json($result);
    }


    
    // 获取手机验证码
    public function getMobileCodeApi(){
        try{
            $telephone = input('param.telephone');
            $SmsApi = new SmsApi;
            $smsCode = rand(10000,99999);
            $data = ['smsCode'=>$smsCode,'telephone'=>$telephone,'time' => time()];
            $result = session('smsCode',$data,'think');
            if($result){
                $SmsApi->paramArr = [
                  'mobile' => $telephone,
                  'content' => json_encode(['code'=>$smsCode,'minute'=>'5','comName'=>'HOT大热篮球']),
                  'tNum' => 'T150606060601'
                ];
                $res = $SmsApi->sendsms();
                if($res == 0){
                    return json(['code'=>100,'msg'=>'验证码已发送']);
                }else{
                    return json(['code'=>200,'msg'=>$res]);
                }
            }else{
                return json(['code'=>200,'msg'=>'系统错误']);
            }
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }

    // 验证手机验证码
    public function validateSmsCodeApi(){
        try{
            $telephone = input('param.telephone');
            $smsCode = input('param.smsCode');
            $data = session('smsCode','','think');
            if(time()-$data['time']>300){
                return json(['code'=>200,'msg'=>'验证码过期失效']);
            }
            if($telephone == $data['telephone'] && $smsCode = $data['smsCode']){
                return json(['code'=>100,'msg'=>'验证码正确']);
            }else{
                return json(['code'=>200,'msg'=>'验证码不正确']);
            }
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }
}