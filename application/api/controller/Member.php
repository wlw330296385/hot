<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\MemberService;
use app\service\WechatService;
use think\Exception;

class Member extends Base{
	private $SalaryOut;
    private $MemberService;
	public function _initialize(){
		parent::_initialize();
        $this->MemberService = new MemberService;
		$this->SalaryOut = new SalaryOut;
	}

    public function index() {

      
    }

    

    // 提现申请
    // public function withdrawApi(){
    // 	try{
    // 		$data = input('post.');
    //         $data['member_id'] = $this->memberInfo['id'];
    //         $data['member'] = $this->memberInfo['member'];
    //         // 余额
    //         if($memberInfo['balance']<$data['money']){
    //             return json(['code'=>200,'msg'=>'余额不足']);die;
    //         }
	   //  	$result = $this->SalaryOut->saveSalaryOut($data);
	   //  	return json($result);
    // 	}catch (Exception $e){
    // 		return json(['code'=>200,'msg'=>$e->getMessage()]);
    // 	}
    	
    // }




    // 编辑个人资料
    public function updateMemberApi(){
        try{
            $member_id = $this->memberInfo['id'];
            $data = input('post.');
            $data['member_id'] = $member_id;
            $data['member'] = $this->memberInfo['member'];
            $result = $this->MemberService->updateMemberInfo($data,$member_id);
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }  
    }


    // 注销登录
    public function logout(){
        try{
                 
             $member = [
                    'id' => 0,
                    'openid' => '',
                    'member' => 'youke',
                    'nickname' => '游客',
                    'avatar' => '',
                    'hp' => 0,
                    'level' => 0,
                    'telephone' =>'',
                    'email' =>'',
                    'realname'  =>'',
                    'province'  =>'',
                    'city'  =>'',
                    'area'  =>'',
                    'location'  =>'',
                    'sex'   =>0,
                    'height'    =>0,
                    'weight'    =>0,
                    'charater'  =>'',
                    'shoe_code' =>0,
                    'birthday'  =>'0000-00-00',
                    'create_time'=>0,
                    'pid'   =>0,
                    'hp'    =>0,
                    'cert_id'   =>0,
                    'score' =>0,
                    'flow'  =>0,
                    'balance'   =>0,
                    'remarks'   =>0,
                    'hot_id'=>00000000,
                ];
            cookie('member',$member);  
            $result = session('memberInfo',$member,'think');
            return json(['code'=>200,'msg'=>'注销成功']);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 更换微信 绑定二维码
    public function changewxqrcode() {
        try {
            $member = $this->memberInfo;
            //dump($member);
            if (!$member) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            $wechatS = new WechatService();
            $guid = sha1(get_code(12));
            $url = $wechatS->oauthredirect( url('frontend/wechat/bindwx', ['memberid' => $member['id'], 'guid' => $guid], '', true) );
            //dump($url);
            $qrcode = buildqrcode($url);
            $sseurl = url('frontend/wechat/bindwxsse', ['guid' => $guid], '', true);
            $response = [
                'qrcode' => $qrcode,
                'sseurl' => $sseurl
            ];
            return json(['code' => 200, 'data' => $response]);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}