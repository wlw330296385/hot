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
    $powertype = db('camp_member')->where(['camp_id' => $camp_id, 'member_id' => $member_id, 'status' => 1])->value('type');
    return $powertype ? $powertype : 0;
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

// 根据会员生日计算年龄
function getMemberAgeByBirthday($member_id) {
    $iage = 0;
    $memberS = new \app\service\MemberService();
    $member = $memberS->getMemberInfo(['id' => $member_id]);
    if (!$member) {
        return false;
    }
    // 取出会员生日字段信息
    $birthday = $member['birthday'];
    $birthday_timestamp = strtotime($birthday);
    if ($birthday_timestamp == false ) {
        return 0;
    }
    //格式化出生时间年月日
    $birth_y = date('Y', $birthday_timestamp);
    $birth_m = date('Y', $birthday_timestamp);
    $birth_d = date('Y', $birthday_timestamp);
    //格式化当前时间年月日
    $now_y = date('Y');
    $now_m = date('m');
    $now_d = date('d');
    //开始计算年龄
    $iage = $now_y-$birth_y;
    if ($birth_m > $now_m || $birth_m == $now_m && $birth_d > $now_d) {
        $iage--;
    }
    return $iage;
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

// 检查日期格式是否正确
function checkDatetimeIsValid($date) {
    //strtotime转换不对，代表日期格式不对。
    $unixTime = strtotime($date);
    if (!$unixTime) {
        return false;
    }
    // 检查日期格式是否有效
    if (date('Y-m-d', $unixTime) == $date) {
        return true;
    } else {
        return false;
    }
}