<?php 
namespace app\api\controller;
use SmsApi;
class Login extends Base{
	
    public function _initialize(){
        parent::_initialize();
    }

    public function index() {

       
    }

    public function registerApi(){
        try{
        	$data = input('post.');
            $pid = input('param.pid');
            if($pid){
                $data['pid'] = $pid;
            }

            $memberInfo = session('memberInfo', '', 'think');
            // 如果有微信授权信息
            if (isset($memberInfo['openid'])) {
                $data['openid'] = $memberInfo['openid'];
                $data['nickname'] = $memberInfo['nickname'];
                $data['avatar'] = $memberInfo['avatar'];
            }
            
        	$memberService = new \app\service\MemberService;
        	return $memberService->saveMemberInfo($data);
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
            return json(['code'=>200,'msg'=>$result]);
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
            	$res = $this->setSession($result);
            	if($res===true){
                    session(null,'token');
            		return json(['code'=>200,'msg'=>'登陆成功']);
            	}else{
            		return json(['code'=>100,'msg'=>'系统错误']);
            	}
            }
            return json(['code'=>100,'msg'=>'账号密码错误']);
        }catch (Exception $e){
        	return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    protected function setSession($id){
		$member =new \app\service\MemberService;
    	$member = $member->getMemberInfo(['id'=>$id]);
    	unset($member['password']);
        cookie('mid', $member['id']);
    	cookie('member',md5($member['id'].$member['member'].config('salekey')));
        session('memberInfo',$member,'think');
        if ( session('memberInfo', '', 'think') ) {
           return true;
        } else {
            return false;
        }
	}



    public function autoLogin(){
        $id = input('param.id')?input('param.id'):1;
        $member =new \app\service\MemberService;
        $memberInfo = $member->getMemberInfo(['id'=>$id]);
        dump($memberInfo);
        unset($memberInfo['password']);
        $this->memberInfo = $memberInfo;
<<<<<<< HEAD
        $cookie = md5($memberInfo['id'].$memberInfo['member'].'hot');
        cookie('member',md5($this->memberInfo['id'].$this->memberInfo['member'].'hot'));
        session('memberInfo',$memberInfo,'think');
=======
//        $cookie = md5($memberInfo['id'].$memberInfo['member'].'hot');
        cookie('member',md5($this->memberInfo['id'].$this->memberInfo['member'].config('salekey')));
        session('memberInfo',$memberInfo);
>>>>>>> e82354d8d45cab0cd2497fb83e583003f5053a56
        if ( session('?memberInfo') ) {
            return json( session('memberInfo', '','think') );
        }
    }
}