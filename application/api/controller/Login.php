<?php 
namespace app\api\controller;

class Login{
	
    public function index() {

       
    }

    public function registerApi(){
        try{
        	$data = input('post.');
        	$memberService = new \app\service\MemberService;
        	$result = $memberService->saveMemberInfo($data);
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

    }


    // 获取手机验证码
    public function getMobileCode(){
        try{
            
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }
}