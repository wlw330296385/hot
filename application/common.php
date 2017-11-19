<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

// 获取页面域名地址
function getdomain() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    return $url;
}

// 用户密码加密
function passwd($str) {
    return sha1(config('salekey') . $str);
}

// 获取语言包
function __lang($name, $vars = [], $lang = '') {
    $Lang = new \think\Lang;
    $Lang::load(APP_PATH . '/lang/' . $Lang::detect() . '/msg.php');
    return $Lang::get($name, $vars, $lang);
}

// view层 获取证件
function getCert($cert_id) {
    $Cert = new \app\service\CertService();
    $res = $Cert->CertOneById($cert_id);
    if (!$res) return ;

    return $res;
}

/** 返回多级栏目
 * @param $data 数组
 * @param int $pid 一级pid值
 * @param string $fieldPri 键名，是数据表就表主键
 * @param string $fieldPid 父级id键名
 * @param int $level (执行调用)不传参数
 * @return array
 */
function channelLevel($data, $pid = 0, $fieldPri = 'cid', $fieldPid = 'pid', $level = 1)
{
    if (empty($data)) {
        return [];
    }
    $arr = [];
    foreach ($data as $v) {
        if ($v[$fieldPid] == $pid) {
            $arr[$v[$fieldPri]]           = $v;
            $arr[$v[$fieldPri]]['_level'] = $level;
            $arr[$v[$fieldPri]]["_data"]  = channelLevel($data, $v[$fieldPri], $fieldPri, $fieldPid, $level + 1);
        }
    }

    return $arr;
}

/**
 * 获取2个时间戳之间的月份个数
 */
function getMonthInterval($min,$max){
    $sum = 0;
    $minMonth = date('Ym',$min);
    $maxMonth = date('Ym',$max);
    $sum = $maxMonth-$minMonth;
    return $sum?$sum:1;
}


/**
 * 获取2个时间戳之间的年份个数
 */
function getYearInterval($min,$max){
    $sum = 0;
    $minMonth = date('Y',$min);
    $maxMonth = date('Y',$max);
    $sum = $maxMonth-$minMonth;
    return $sum?$sum:1;
}

// 格式化输出性别
function format_sex($sex_int) {
    $str = '未知';
    if ($sex_int) {
        $str = $sex_int == 2 ? '女' : '男';
    }
    return $str;
}

/**
 * 获取性别
 */

function getSex($value){
    if($value == 1){
        //1=男
        return "/static/frontend/images/male.png";
    }else{
        return "/static/frontend/images/female.png";
    }
}


/**
 * 返回checkbox的选中值;$value:传入的值|$val:标准值
 */
function getChecked($value,$val){
    if($value == $val){
        return 'checked';
    }
}


// 生成交易单号,int
function getTID($salt){
    $result = date('YmdHis').rand(0000,9999).$salt;
    return $result;
}

// 生成订单号
function getOrderID(){
    $result = date('YmdHis').rand(0000,9999).$salt;
    return $result;
}



function sendMessage($data){
    $MessageService = new \app\service\MessageService;
    $result = $MessageService->saveMessageInfo($data);
    return $result;
}


function sendMessageMember($data){
    $MessageMemberService = new \app\service\MessageMemberService;
    $result = $MessageMemberService->saveMessageInfo($data);
    return $result;
}

function buildqrcode($url, $size=4, $level='L')
{
//    dump($url);

    $savePath = ROOT_PATH . 'public/uploads/images/qrcode/' . date('Y') .'/'. date('m') .'/';
    $webPath = '/uploads/images/qrcode/' . date('Y') .'/'. date('m') . '/';

    if (!file_exists($savePath)) {
        mkdir($savePath, 0777, true);
    }
    //$qr=new \phpqrcode\QRcode();
    //\QRcode::png($url, $filename, $level,$size);
    $filename = $savePath . DS . date('His').md5($url) . '.png';
    \think\Loader::import('phpqrcode.phpqrcode');
    $qrcodeObj = new \phpqrcode\QRcode();
    if (isset($url)) {
        $qrcodeObj::png($url, $filename, $level,$size);
    }
    //dump( $savePath . basename($filename) );
    if ( file_exists($savePath . basename($filename) ) ) {
        return $webPath.basename($filename);
    } else {
        return false;
    }
}

