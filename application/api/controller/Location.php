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
            header("Access-Control-Allow-Origin: http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=php");
            header("Content-type: text/html; charset=utf-8"); 
            $ip = Request::instance()->param('ip');
            if(!$ip){
                $ip = Request::instance()->ip();
            }
            
            $location = file_get_contents("http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=".$ip);
            $location = iconv("gb2312", "utf-8//IGNORE",$location);
            return json(['code'=>100,'msg'=>$location,'data'=>$location]);
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }

    }

    // 获取用户IP
    public function getIP(){
        try{
            $ip = Request::instance()->ip();
            return json(['code'=>100,'msg'=>$ip,'data'=>$ip]);
        }catch (Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }
    }

    
}