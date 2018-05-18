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
    $Lang::setAllowLangList(['zh-cn']);
    $Lang::load(APP_PATH . 'lang/' . $Lang::detect() . '/msg.php');
    return $Lang::get($name, $vars, $lang);
}

function getTree($arr = [],$pid = 0){
    $list = [];
     foreach ($arr as $key => &$value) {
        if($value['pid'] == $pid){
            $value['daughter'] = getTree($arr,$value['id']);
            $list[] = $value;
        }
    }
    return $list;
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
    $str = '';
    $str = $sex_int == 2 ? '女' : '男';
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
function getOrderID($salt){
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

// 生成二维码图片
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

/** 获取会员在训练营的身份角色
 * @param $camp_id 训练营id
 * @param $member_id 会员id
 * @return int|mixed -1:粉丝 1:学生 2:教练 3:管理员 4:创建人
 */
function getCampPower($camp_id, $member_id) {
    $powertype = db('camp_member')->where(['camp_id' => $camp_id, 'member_id' => $member_id, 'status' => 1])->whereNull('delete_time')->value('type');
    return $powertype ? $powertype : 0;
}

/** 获取会员在训练营的身份角色权限
 * @param $camp_id
 * @param $member_id
 * @return int
 */
function getCampMemberLevel($camp_id, $member_id) {
    // type=2教练，区分level兼职教练1，全职教练2
    $campMember = db('camp_member')->where(['camp_id' => $camp_id, 'member_id' => $member_id, 'status' => 1])->whereNull('delete_time')->find();
    if ($campMember['type'] == 2) {
        return $campMember['level'] ?  $campMember['level'] : 0;
    }
    return 0;
}

// 获取会员表的openid字段
function getMemberOpenid($memberid) {
    $memberS = new \app\service\MemberService();
    $member = $memberS->getMemberInfo(['id' => $memberid]);
    if (!$member) {
        return false;
    }
    if ( !$member['openid'] ) {
        return false;
    } else {
        return $member['openid'];
    }
}

// 生日日期计算年龄
function getAgeByBirthday($birthday) {
    $iage = 0;
    if ( checkDatetimeIsValid($birthday) ) {
        list($by, $bm, $bd) = explode('-', $birthday);
        $cm=date('n');
        $cd=date('j');
        $iage=date('Y')-$by-1;
        if ($cm>$bm || $cm==$bm && $cd>$bd) {
            $iage++;
        }
        return $iage;
    } else {
        return 0;
    }
}

// 检查日期格式是否正确
function checkDatetimeIsValid($date)
{
    $arr = explode('-', $date);
    return checkdate($arr[1],$arr[2],$arr[0]) ? true : false;
}

// 数字验证码 用于server-sent事件 生成guid
function get_code($length=6) {
    $min = pow(10 , ($length - 1));
    $max = pow(10, $length) - 1;
    return rand($min, $max);
}

// 初始化日期
function initDateTime() {
    $dateTime = [];
    // 当前年、月
    $dateTime['date'] = input('date', date('Y-m'));
    $dateTime['year'] = input('year', date('Y'));
    $dateTime['month'] = input('month', date('m'));
    // 本月第一天、最后一天
    //$monthfirstday = input('firstday', date('Y-m-01'));
    $monthday = getthemonth();
    $dateTime['fistday'] = input('firstday', $monthday[0]);
    $dateTime['lastday'] = input('lastday', $monthday[1]);
    // 上月（年）
    $lastmonthTimestr = strtotime("last month");
    $dateTime['lastmonth'] = input('lastmonth', date('m', $lastmonthTimestr));
    $dateTime['lastmonth_year'] = input('lastmonth', date('Y', $lastmonthTimestr));
    // 上月第一天、最后一天
    $lastmonthday = getthemonth($lastmonthTimestr);
    $dateTime['lastmonth_firstday'] = $lastmonthday[0];
    $dateTime['lastmonth_lastday'] = $lastmonthday[1];
    return $dateTime;
}

// 当前unix时间戳获取当月第一天及最后一天
function getthemonth($timestamp=0)
{
    if (!$timestamp) {$timestamp = time();}
    $firstday = date('Y-m-01', $timestamp);
    $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
    return array($firstday,$lastday);
}

/**
 * 获取指定年月日的开始时间戳和结束时间戳(本地时间戳非GMT时间戳)
 * [1] 指定年：获取指定年份第一天第一秒的时间戳和下一年第一天第一秒的时间戳
 * [2] 指定年月：获取指定年月第一天第一秒的时间戳和下一月第一天第一秒时间戳
 * [3] 指定年月日：获取指定年月日第一天第一秒的时间戳
 * @param  integer $year     [年份]
 * @param  integer $month    [月份]
 * @param  integer $day      [日期]
 * @return array('start' => '', 'end' => '')
 */
function getStartAndEndUnixTimestamp($year = 0, $month = 0, $day = 0)
{
    if(empty($year))
    {
        $year = date("Y");
    }

    $start_year = $year;
    $start_year_formated = str_pad(intval($start_year), 4, "0", STR_PAD_RIGHT);
    $end_year = $start_year + 1;
    $end_year_formated = str_pad(intval($end_year), 4, "0", STR_PAD_RIGHT);

    if(empty($month))
    {
        //只设置了年份
        $start_month_formated = '01';
        $end_month_formated = '01';
        $start_day_formated = '01';
        $end_day_formated = '01';
    }
    else
    {

        $month > 12 || $month < 1 ? $month = 1 : $month = $month;
        $start_month = $month;
        $start_month_formated = sprintf("%02d", intval($start_month));

        if(empty($day))
        {
            //只设置了年份和月份
            $end_month = $start_month + 1;

            if($end_month > 12)
            {
                $end_month = 1;
            }
            else
            {
                $end_year_formated = $start_year_formated;
            }
            $end_month_formated = sprintf("%02d", intval($end_month));
            $start_day_formated = '01';
            $end_day_formated = '01';
        }
        else
        {
            //设置了年份月份和日期
            $startTimestamp = strtotime($start_year_formated.'-'.$start_month_formated.'-'.sprintf("%02d", intval($day))." 00:00:00");
            $endTimestamp = $startTimestamp + 24 * 3600 - 1;
            return array('start' => $startTimestamp, 'end' => $endTimestamp);
        }
    }

    $startTimestamp = strtotime($start_year_formated.'-'.$start_month_formated.'-'.$start_day_formated." 00:00:00");
    $endTimestamp = strtotime($end_year_formated.'-'.$end_month_formated.'-'.$end_day_formated." 00:00:00") - 1;
    return array('start' => $startTimestamp, 'end' => $endTimestamp);
}


// 下载远程图片保存到本地
function download($url, $path = 'images/')
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    $file = curl_exec($ch);
    curl_close($ch);
    $filename = pathinfo($url, PATHINFO_DIRNAME);
    $filename = sha1($filename);
    $resource = fopen($path . $filename, 'a');
    fwrite($resource, $file);
    fclose($resource);
    // 返回保存的文件名
    return $filename;
}

// 获取粉丝数
function getfansnum($follow_id, $type=1) {
    $model = new \app\model\Follow();
    $count = $model->where([
        'status' => 1,
        'follow_id' => $follow_id,
        'type' => $type
    ])->count();
    return ($count) ? $count : 0;
}

//二维数组验证一个值是否存在
function deep_in_array($value, $array) {
    foreach($array as $item) {
        if(!is_array($item)) {
            if ($item == $value) {
                return true;
            } else {
                continue;
            }
        }

        if(in_array($value, $item)) {
            return true;
        } else if(deep_in_array($value, $item)) {
            return true;
        }
    }
    return false;
}

/**
 * [将Base64图片转换为本地图片并保存]
 * @param  [Base64] $base64_image_content [要保存的Base64]
 * @param  [目录] $path [要保存的路径]
 * @return bool|string
 */
function base64_image_content($image_content,$path){
    if (empty($image_content) || is_null($image_content)) {
        return $image_content;
    } else {
        //匹配出图片的格式
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $image_content, $result)){
            // 文件后缀
            $type = $result[2];
            // 文件名
            $fileName = sha1(time().rand(1111, 9999)).".{$type}";
            // 文件路径
            $dirName = "uploads/images/". $path . "/" . date('Y') . "/" . date('m') . "/";
            $saveDir =  ROOT_PATH  . "public" . "/" . $dirName;
            if ( !is_dir($saveDir) ) { // 目录不存在 创建目录
                mkdir($saveDir, 0700, true);
            }
            $fileSrc = $saveDir . $fileName;
            // 转存文件数据
            $fileContent = base64_decode( str_replace($result[1], '', $image_content) );
            $res = file_put_contents($fileSrc, $fileContent);
            if ($res) {
                return '/'.$dirName . $fileName;
            } else {
                return false;
            }
        } else {
            return $image_content;
        }
    }
}