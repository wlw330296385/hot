<?php 
namespace app\api\Controller;
use app\service\WechatService;

use think\Controller;
use Think\Log;
class Wx extends Controller{
    private $WechatService; 
    public function _initialize(){
        parent::_initialize();
        $this->WechatService = new WechatService;
    }
    
	public function index(){

    }




	/**
	 * 获取微信用户分组统计
	 * @return void
	 */
	public function getGroups()
	{      

        $access_token = $this->WechatService->authactoken();
        $WxUrl = "https://api.weixin.qq.com/cgi-bin/groups/get?access_token={$access_token}";
        $result = file_get_contents($WxUrl);
        return json($result);
	}
}