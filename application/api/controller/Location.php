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


    // 获取两个经纬度之间的距离
    public function getDistanceApi(){
        try{
            $lat1 = input('param.lat1');
            $lat2 = input('param.lat2');
            $lng1 = input('param.lng1');
            $lng2 = input('param.lng2');
            $earthRadius = 6367000; //approximate radius of earth in meters   
            $lat1 = ($lat1 * pi() ) / 180;   
            $lng1 = ($lng1 * pi() ) / 180;   
            $lat2 = ($lat2 * pi() ) / 180;   
            $lng2 = ($lng2 * pi() ) / 180;   
            $calcLongitude = $lng2 - $lng1;   
            $calcLatitude = $lat2 - $lat1;   
            $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);   
            $stepTwo = 2 * asin(min(1, sqrt($stepOne)));   
            $calculatedDistance = $earthRadius * $stepTwo;   
            return json(['code'=>200,'msg'=>'成功','data'=>round($calculatedDistance)]); 
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    
}