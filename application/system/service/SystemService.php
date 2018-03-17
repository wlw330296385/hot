<?php
// 系统service
namespace app\service;


use think\Lang;

class SystemService {
    // 2017/7/18 获取站点数据
    public static function getSite() {
        return db('setting')->where('id', 1)->find();
    }

    // 2017/7/18 设置站点数据
    public static function setSite($posts) {
        $id = $posts['id'];
        $data = [
            'sitename' => $posts['sitename'],
            'title' => $posts['title'],
            'keywords' => $posts['keywords'],
            'description' => $posts['description'],
            'footer' => $posts['footer'],
            'wxappid' => $posts['wxappid'],
            'wxsecret' => $posts['wxsecret'],
            'level1' => $posts['level1'],
            'level2' => $posts['level2'],
            'vip1' => $posts['vip1'],
            'vip2' => $posts['vip2'],
            'vip3' => $posts['vip3'],
            'vip4' => $posts['vip4'],
            'vip5' => $posts['vip5'],
            'lrss' => $posts['lrss'],
            'lrcs' => $posts['lrcs']
        ];
        $result = db('setting')->where('id', $id)->update($data);
        return $result;
    }

    // 获取公众号信息
    public static function getWxApp() {
        $res = db('setting')->where('id', 1)->field(['wxappid', 'wxsecret'])->find();
        if (!$res)
            return false;

        return $res;
    }
}