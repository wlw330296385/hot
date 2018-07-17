<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    // 安全key
    'salekey' => 'hotpaas',

    // 公众号
    'appid' => 'wx19f60be0f2f24c31',
    'appsecret' => 'cd9e6671b9d382ebd079929e70b86f99',
    'token' => 'hotbasketball',
    'encodingaeskey' => 'hWJMgOj45Q5wNRFmY0BRHzNz6jLsDBNKFqd11YK492s',
    'state' => 'hb',
    'mchid' =>'1488926612',
    'key'   =>'93a793a3b611f19008432d0032251f34',//注：key为商户平台设置的密钥key
    'sslcert_path'=>'',
    'sslkey_path'=>'',

    // 模板消息
    'wxTemplateID' => [
        'successBill' => 'oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU',//支付成功
        'successJoin' => 'aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q',//申请加入
        'memberQuit' => 'b2DC63QQokA8WwfoaUb-FgUuyMOaiPBdzxH7Gm0-1hs',//成员退出
        'successRefund' => 'MHLQONFLdMBSEGQS2AW06V3sFV5zEXQYq_iqbPJpAgQ',//申请退款成功
        'successCheck' => 'xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88',//审核通过
        'sendSchedule' => '_ld4qtOLJA1vl-oh0FxCliMK1tbGD0nOTq7Z4OmeFCE', //发送课时通知
        'checkPend' => 'eq30-P4InOr-gndRqTdK8xAgpsMWdh3BWO1AArdxoeI', // 待审批事项通知
        'eventJoin' =>'rgF4hfyPKVxeP9HSOSbmzf7iqITPB_Bo5UgGyc9j36s',//付费活动报名成功
        'eventBook' =>'RvMcKdoOyu5RRlT7ucXtAgF5-dOA-n3Gd61eho4k4lw',//免费活动报名成功通知
        'lessonBook'=>'G1EeDZ-4CS7MUTND_sEPKAzbZElqRygKzbftYfvGYF8',//预约体验成功,
        'applyResult' => 'fIaJMxa6cpenLyViHq10WiFkz2Wd_ANs3H1SV0PXDMk', //申请结果通知
        'statusChange' => '_MXeO37KI0lygDDJ82GEFciIQYW0GXzTcLl0Y8HgWPY', //业务状态变更通知
        'scheduleExpend'=>'squ4uaAVXJ52Dhfjtlol08cpo49FonbFwN-wUFObAV4', //课时消耗通知
        'refereeTask' => '9XyZ3Mb70gR8HmE0N6y_9TESECJYyi3r4kA_c45d_EU', // 裁判任务通知
        'receviceInvitaion' => '68DeWPCsdhaPuLJfPCPwPhrjhxo3m2ZUqa7b9j8XIfg', // 邀请已接受通知
        'refuseInvitaion' => 'oajS06HPl02rKIH-Xsvqm5_ogdPQv9cxl-Gs782Ifrg', // 拒绝邀请提醒,
        'matchResult' => 'R5jFmx4b5mTSXyRXyls3AAGO0vGgy7tbTMJ6GcEdotI', // 比赛结果通知
        'informationChange' => 'b_aj8CaXc3P4d03RpCtQbLCUBLeowrj-z1SVo2uXr5M', //信息变更提醒
        'cancelRefund'=>'gXXoLU9ccggzyEgKrvDZoNYNnX71k7-A6gXHRAPU1qs',//撤销退款通知
    ],

    // 七牛云
    //accessKey
    'qn_accesskey' => 'OOzGcbsIECVSx8uNY7d6iy8z8j60LruYL88dCGj8',
    //secretKey
    'qn_secretkey' => 'jBcQ0f2v4z-bV35i-mbW46goE70LPKDS2FsY2MHl',
    //上传的空间
    'qn_bucket' => 'w8723qmxxhwmcpgcgoymbbv1kwlpvayo',
    //空间绑定的域名
    'qn_domain'=>'http://ou1z1q8b2.bkt.clouddn.com/',
	
	// 短信通道showapi
	'sms_appid' => '45842',
    'sms_secret' => '9b3c9e8899a7484890ab1c100a8fca82',

    // 固定默认图片
    'default_image' => [
        'member_avatar' =>'/static/default/avatar.png', // 默认会员头像
        'upload_default' => '/static/frontent/images/uploadDefault.jpg', // 上传默认图片
        'team_logo' => '/static/frontend/images/basketball.jpg', //球队logo
    ],

    // +----------------------------------------------------------------------
    // | 应用设置
    // +----------------------------------------------------------------------

    // 应用命名空间
    'app_namespace'          => 'app',
    // 应用调试模式
    'app_debug'              => false,
    // 应用Trace
    'app_trace'              => false,
    // 应用模式状态
    'app_status'             => '',
    // 是否支持多模块
    'app_multi_module'       => true,
    // 入口自动绑定模块
    'auto_bind_module'       => false,
    // 注册的根命名空间
    'root_namespace'         => [],
    // 扩展函数文件
    'extra_file_list'        => [THINK_PATH . 'helper' . EXT],
    // 默认输出类型
    'default_return_type'    => 'html',
    // 默认AJAX 数据返回格式,可选json xml ...
    'default_ajax_return'    => 'json',
    // 默认JSONP格式返回的处理方法
    'default_jsonp_handler'  => 'jsonpReturn',
    // 默认JSONP处理方法
    'var_jsonp_handler'      => 'callback',
    // 默认时区
    'default_timezone'       => 'PRC',
    // 是否开启多语言
    'lang_switch_on'         => false,
    // 默认全局过滤方法 用逗号分隔多个
    'default_filter'         => '',
    // 默认语言
    'default_lang'           => 'zh-cn',
    // 应用类库后缀
    'class_suffix'           => false,
    // 控制器类后缀
    'controller_suffix'      => false,

    // +----------------------------------------------------------------------
    // | 模块设置
    // +----------------------------------------------------------------------

    // 默认模块名
    'default_module'         => 'index',
    // 禁止访问模块
    'deny_module_list'       => ['common'],
    // 默认控制器名
    'default_controller'     => 'Index',
    // 默认操作名
    'default_action'         => 'index',
    // 默认验证器
    'default_validate'       => '',
    // 默认的空控制器名
    'empty_controller'       => 'Error',
    // 操作方法后缀
    'action_suffix'          => '',
    // 自动搜索控制器
    'controller_auto_search' => false,

    // +----------------------------------------------------------------------
    // | URL设置
    // +----------------------------------------------------------------------

    // PATHINFO变量名 用于兼容模式
    'var_pathinfo'           => 's',
    // 兼容PATH_INFO获取
    'pathinfo_fetch'         => ['ORIG_PATH_INFO', 'REDIRECT_PATH_INFO', 'REDIRECT_URL'],
    // pathinfo分隔符
    'pathinfo_depr'          => '/',
    // URL伪静态后缀
    'url_html_suffix'        => '',
    // URL普通方式参数 用于自动生成
    'url_common_param'       => false,
    // URL参数方式 0 按名称成对解析 1 按顺序解析
    'url_param_type'         => 0,
    // 是否开启路由
    'url_route_on'           => true,
    // 路由使用完整匹配
    'route_complete_match'   => false,
    // 路由配置文件（支持配置多个）
    'route_config_file'      => ['route'],
    // 是否强制使用路由
    'url_route_must'         => false,
    // 域名部署
    'url_domain_deploy'      => false,
    // 域名根，如thinkphp.cn
    'url_domain_root'        => '',
    // 是否自动转换URL中的控制器和操作名
    'url_convert'            => true,
    // 默认的访问控制器层
    'url_controller_layer'   => 'controller',
    // 表单请求类型伪装变量
    'var_method'             => '_method',
    // 表单ajax伪装变量
    'var_ajax'               => '_ajax',
    // 表单pjax伪装变量
    'var_pjax'               => '_pjax',
    // 是否开启请求缓存 true自动缓存 支持设置请求缓存规则
    'request_cache'          => false,
    // 请求缓存有效期
    'request_cache_expire'   => null,
    // 全局请求缓存排除规则
    'request_cache_except'   => [],

    // +----------------------------------------------------------------------
    // | 模板设置
    // +----------------------------------------------------------------------

    'template'               => [
        // 模板引擎类型 支持 php think 支持扩展
        'type'         => 'Think',
        // 模板路径
        'view_path'    => '',
        // 模板后缀
        'view_suffix'  => 'html',
        // 模板文件名分隔符
        'view_depr'    => DS,
        // 模板引擎普通标签开始标记
        'tpl_begin'    => '{',
        // 模板引擎普通标签结束标记
        'tpl_end'      => '}',
        // 标签库标签开始标记
        'taglib_begin' => '{',
        // 标签库标签结束标记
        'taglib_end'   => '}',
    ],

    // 视图输出字符串内容替换
    'view_replace_str'       => [],
    // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl'  => THINK_PATH . 'tpl' . DS . 'dispatch_jump.tpl',
    'dispatch_error_tmpl'    => THINK_PATH . 'tpl' . DS . 'dispatch_jump.tpl',

    // +----------------------------------------------------------------------
    // | 异常及错误设置
    // +----------------------------------------------------------------------

    // 异常页面的模板文件
    'exception_tmpl'         => THINK_PATH . 'tpl' . DS . 'think_exception.tpl',

    // 错误显示信息,非调试模式有效
    'error_message'          => '此页面正在上新功能...',
    // 显示错误信息
    'show_error_msg'         => true,
    // 异常处理handle类 留空使用 \think\exception\Handle
    'exception_handle'       => '',

    // +----------------------------------------------------------------------
    // | 日志设置
    // +----------------------------------------------------------------------

    'log'                    => [
        // 日志记录方式，内置 file socket 支持扩展
        'type'  => 'File',
        // 日志保存目录
        'path'  => LOG_PATH,
        // 日志记录级别
        'level' => ['error','sql','log','info'],
        'apart_level' => ['error', 'sql','log','info'],
    ],

    // +----------------------------------------------------------------------
    // | Trace设置 开启 app_trace 后 有效
    // +----------------------------------------------------------------------
    'trace'                  => [
        // 内置Html Console 支持扩展
        'type' => 'Html',
    ],

    // +----------------------------------------------------------------------
    // | 缓存设置
    // +----------------------------------------------------------------------

    'cache'                  => [
        // 驱动方式
        'type'   => 'File',
        // 缓存保存目录
        'path'   => CACHE_PATH,
        // 缓存前缀
        'prefix' => '',
        // 缓存有效期 0表示永久缓存
        'expire' => 0,
    ],

    // +----------------------------------------------------------------------
    // | 会话设置
    // +----------------------------------------------------------------------

    'session'                => [
        'id'             => '',
        // SESSION_ID的提交变量,解决flash上传跨域
        'var_session_id' => '',
        // SESSION 前缀
        'prefix'         => 'think',
        // 驱动方式 支持redis memcache memcached
        'type'           => '',
        // 是否自动开启 SESSION
        'auto_start'     => true,
    ],

    // +----------------------------------------------------------------------
    // | Cookie设置
    // +----------------------------------------------------------------------
    'cookie'                 => [
        // cookie 名称前缀
        'prefix'    => '',
        // cookie 保存时间
        'expire'    => 7200,
        // cookie 保存路径
        'path'      => '/',
        // cookie 有效域名
        'domain'    => '',
        //  cookie 启用安全传输
        'secure'    => false,
        // httponly设置
        'httponly'  => '',
        // 是否使用 setcookie
        'setcookie' => true,
    ],

    //分页配置
    'paginate'               => [
        'type'      => 'bootstrap',
        'var_page'  => 'page',
        'list_rows' => 15,
    ],
];
