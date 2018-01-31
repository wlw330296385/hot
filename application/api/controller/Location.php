<?php 
namespace app\api\controller;
use app\api\controller\Base;
use think\Request;
class Location extends Base{
	public function _initialize(){
		parent::_initialize();
	}


    // 获取用户地址
    public function getLocation() {
        try{
            header("Access-Control-Allow-Origin: *");
            // header("Content-type: text/html; charset=utf-8"); 
            header('Content-type: text/html;charset=gbk');
            $ip = input('param.ip');
            // $ip = '183.13.99.208';
            if(!$ip){
                $ip = Request::instance()->ip();
            }
            // $s = file_get_contents("http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=".$ip);
            $s = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=".$ip);
            // $location = iconv("gbk", "utf-8//IGNORE",$s);
            // $ss = iconv("gb2312", "utf-8//IGNORE",$s);
            return json($s);
            // $ss = json_decode($s);
            // dump($ss); 
            // echo  $s;die;
            
           
            // preg_match('/{.+}/',$s,$r);
            // $p = array_map(function($s) {
            //      return iconv('utf-8', 'gbk', $s);
            //  }, json_decode($r[0], 1));
            
            // return json(['code'=>100,'msg'=>$ss,'data'=>$s]);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }

    }

    // 获取用户IP
    public function getIP(){
        try{
            $ip = Request::instance()->ip();
            return json(['code'=>200,'msg'=>$ip,'data'=>$ip]);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    
}