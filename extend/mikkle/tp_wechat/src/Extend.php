<?php
/**
 * Created by PhpStorm.
 * Power By Mikkle
 * Email：776329498@qq.com
 * Date: 2017/9/11
 * Time: 15:44
 */

namespace mikkle\tp_wechat\src;


use mikkle\tp_wechat\base\WechatBase;

class Extend extends WechatBase
{

    const QR_LIMIT_SCENE = 1;

    /** 语义理解 */
    const SEMANTIC_API_URL = '/semantic/semproxy/search?';
    const QRCODE_IMG_URL = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=';
    const QRCODE_CREATE_URL = '/qrcode/create?';
    const SHORT_URL = '/shorturl?';
    const QR_SCENE = 0;

    /** 数据分析接口 */
    static $DATACUBE_URL_ARR = array(//用户分析
        'user'        => array(
            'summary'  => '/datacube/getusersummary?', //获取用户增减数据（getusersummary）
            'cumulate' => '/datacube/getusercumulate?', //获取累计用户数据（getusercumulate）
        ),
        'article'     => array(//图文分析
            'summary'   => '/datacube/getarticlesummary?', //获取图文群发每日数据（getarticlesummary）
            'total'     => '/datacube/getarticletotal?', //获取图文群发总数据（getarticletotal）
            'read'      => '/datacube/getuserread?', //获取图文统计数据（getuserread）
            'readhour'  => '/datacube/getuserreadhour?', //获取图文统计分时数据（getuserreadhour）
            'share'     => '/datacube/getusershare?', //获取图文分享转发数据（getusershare）
            'sharehour' => '/datacube/getusersharehour?', //获取图文分享转发分时数据（getusersharehour）
        ),
        'upstreammsg' => array(//消息分析
            'summary'   => '/datacube/getupstreammsg?', //获取消息发送概况数据（getupstreammsg）
            'hour'      => '/datacube/getupstreammsghour?', //获取消息分送分时数据（getupstreammsghour）
            'week'      => '/datacube/getupstreammsgweek?', //获取消息发送周数据（getupstreammsgweek）
            'month'     => '/datacube/getupstreammsgmonth?', //获取消息发送月数据（getupstreammsgmonth）
            'dist'      => '/datacube/getupstreammsgdist?', //获取消息发送分布数据（getupstreammsgdist）
            'distweek'  => '/datacube/getupstreammsgdistweek?', //获取消息发送分布周数据（getupstreammsgdistweek）
            'distmonth' => '/datacube/getupstreammsgdistmonth?', //获取消息发送分布月数据（getupstreammsgdistmonth）
        ),
        'interface'   => array(//接口分析
            'summary'     => '/datacube/getinterfacesummary?', //获取接口分析数据（getinterfacesummary）
            'summaryhour' => '/datacube/getinterfacesummaryhour?', //获取接口分析分时数据（getinterfacesummaryhour）
        )
    );

    public function  __construct(array $option)
    {
        parent::__construct($option);
        $this->getToken();
    }


    /**
     * 获取二维码图片
     * @param string $ticket 传入由getQRCode方法生成的ticket参数
     * @return string url 返回http地址
     */
    public function getQRUrl($ticket)
    {
        return self::QRCODE_IMG_URL . urlencode($ticket);
    }

    /**
     * 长链接转短链接接口
     * @param string $long_url 传入要转换的长url
     * @return bool|string url 成功则返回转换后的短url
     */
    public function getShortUrl($long_url)
    {
        if (!$this->access_token  || empty($long_url)) {
            return false;
        }
        $data = ['action' => 'long2short', 'long_url' => $long_url];

        $curl_url = self::API_URL_PREFIX . self::SHORT_URL ."access_token={$this->access_token}";
        return $this->returnPostResult($curl_url,$data,__FUNCTION__, func_get_args());

    }

    /**
     * 创建二维码ticket
     * @param int|string $scene_id 自定义追踪id,临时二维码只能用数值型
     * @param int $type 0:临时二维码；1:永久二维码(此时expire参数无效)；2:永久二维码(此时expire参数无效)
     * @param int $expire 临时二维码有效期，最大为2592000秒(30天)
     * @return bool|array ('ticket'=>'qrcode字串','expire_seconds'=>2592000,'url'=>'二维码图片解析后的地址')
     */
    public function getQRCode($scene_id, $type = 0, $expire = 2592000)
    {
        if (!$this->access_token|| empty($scene_id)) {
            return false;
        }
        $type = ($type && is_string($scene_id)) ? 2 : $type;
        $data = [
            'action_name'    => $type ? ($type == 2 ? "QR_LIMIT_STR_SCENE" : "QR_LIMIT_SCENE") : "QR_SCENE",
            'expire_seconds' => $expire,
            'action_info'    => ['scene' => ($type == 2 ?['scene_str' => $scene_id] : ['scene_id' => $scene_id])]
        ];
        if ($type == 1) {
            unset($data['expire_seconds']);
        }

        $curl_url = self::API_URL_PREFIX . self::QRCODE_CREATE_URL ."access_token={$this->access_token}";
        return $this->returnPostResult($curl_url,$data,__FUNCTION__, func_get_args());

    }

    /**
     * 语义理解接口
     * @param string $uid 用户唯一id（非开发者id），用户区分公众号下的不同用户（建议填入用户openid）
     * @param string $query 输入文本串
     * @param string $category 需要使用的服务类型，多个用“，”隔开，不能为空
     * @param float $latitude 纬度坐标，与经度同时传入；与城市二选一传入
     * @param float $longitude 经度坐标，与纬度同时传入；与城市二选一传入
     * @param string $city 城市名称，与经纬度二选一传入
     * @param string $region 区域名称，在城市存在的情况下可省略；与经纬度二选一传入
     * @return bool|array
     */
    public function querySemantic($uid, $query, $category, $latitude = 0.00, $longitude = 0.00, $city = "", $region = "")
    {
        if (!$this->access_token || empty($uid)|| empty($query)|| empty($category)) {
            return false;
        }
        $data = [
            'query'    => $query,
            'category' => $category,
            'appid'    => $this->appId,
            'uid'      => ''
        ];
        //地理坐标或城市名称二选一
        if ($latitude) {
            $data['latitude'] = $latitude;
            $data['longitude'] = $longitude;
        } elseif ($city) {
            $data['city'] = $city;
        } elseif ($region) {
            $data['region'] = $region;
        }

        $curl_url = self::API_BASE_URL_PREFIX . self::SEMANTIC_API_URL ."access_token={$this->access_token}";
        return $this->returnPostResult($curl_url,$data,__FUNCTION__, func_get_args());

    }

    /**
     * 获取统计数据
     * @param string $type 数据分类(user|article|upstreammsg|interface)分别为(用户分析|图文分析|消息分析|接口分析)
     * @param string $subtype 数据子分类，参考 DATACUBE_URL_ARR 常量定义部分 或者README.md说明文档
     * @param string $begin_date 开始时间
     * @param string $end_date 结束时间
     * @return bool|array 成功返回查询结果数组，其定义请看官方文档
     */
    public function getDatacube($type, $subtype, $begin_date, $end_date = '')
    {
        if (!$this->access_token|| empty($type)|| empty($subtype)|| empty($begin_date)) {
            return false;
        }
        if (!isset(self::$DATACUBE_URL_ARR[$type]) || !isset(self::$DATACUBE_URL_ARR[$type][$subtype])) {
            return false;
        }
        $data = ['begin_date' => $begin_date, 'end_date' => $end_date ? $end_date : $begin_date];


        $curl_url = self::API_BASE_URL_PREFIX . self::$DATACUBE_URL_ARR[$type][$subtype] ."access_token={$this->access_token}";
        return $this->returnPostResult($curl_url,$data,__FUNCTION__, func_get_args());

    }


}