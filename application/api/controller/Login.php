<?php 
namespace app\api\controller;
use SmsApi;
class Login extends Base{
	
    public function _initialize(){
        parent::_initialize();
    }

    public function index() {

       
    }

    // 注册会员
    public function registerApi(){
        try{
        	$data = input('post.');
            $pid = input('param.pid');
            if($pid){
                $data['pid'] = $pid;
            }

            $memberInfo = session('memberInfo', '', 'think');
            $memberS = new \app\service\MemberService;
            // 如果有微信授权信息
            if (isset($memberInfo['openid'])) {
                $isMember = $memberS->getMemberInfo(['openid' => $memberInfo['openid']]);
                if ($isMember) {
                    return ['code' => 100, 'msg' => '您的微信号已注册成为会员'];
                } else {
                    $data['openid'] = $memberInfo['openid'];
                    $data['nickname'] = $memberInfo['nickname'];
                    $data['avatar'] = $memberInfo['avatar'];
                }
            }

        	$response = $memberS->saveMemberInfo($data);
        	if ($response['code'] ==200) {
        	    $lasturl = cookie('url');
        	    if ($lasturl && $lasturl != '/frontend') { // 记录最后访问地址, 注册成功返回该页面
                    $response['goto'] = $lasturl;
                    cookie('url', null);
                } else {
                    $response['goto'] = url('frontend/member/registerSuccess');
                }
            }
            return $response;
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
        $id = input('param.id',1);
        $member =new \app\service\MemberService;
        $memberInfo = $member->getMemberInfo(['id'=>$id]);
        unset($memberInfo['password']);
        $this->memberInfo = $memberInfo;
        cookie('mid', $memberInfo['id']);
        cookie('member',md5($memberInfo['id'].$memberInfo['member'].config('salekey')));
        session('memberInfo',$memberInfo,'think');

        if ( session('?memberInfo') ) {
            return json( session('memberInfo', '','think') );
        }
    }
}