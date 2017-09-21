1. 注册教练、训练营审核结果
模板id：xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88

格式内容：
{{first.DATA}}
审核状态：{{keyword1.DATA}}
审核时间：{{keyword2.DATA}}
{{remarkDATA}}

内容示例：
你好，你提交的资料已通过审核。
审核状态：通过审核
审核时间：2017年10月2日 18:00:20
你的维泽无线已经可以正常使用了。

2. 购买课程支付订单完成通知课程发布人
模板id：oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU

格式内容：
{{first.DATA}}
用户名：{{keyword1.DATA}}
订单号：{{keyword2.DATA}}
订单金额：{{keyword3.DATA}}
商品信息：{{keyword4.DATA}}
{{remark.DATA}}

内容示例：
您的订单已支付成功。 &gt;&gt;查看订单详情
用户名：123456789@qingpinji.com
订单号：2015698571200
订单金额：￥98.80
商品信息：星冰乐（焦糖味）  家乐氏香甜玉米片*2  乐天七彩爱情糖*3
如有问题请致电xxx客服热线400-8070028或直接在微信留言，客服在线时间为工作日10:00——18:00.客服人员将第一时间为您服务。

3. 申请加入训练营
模板id：aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q

格式内容：
{{first.DATA}}
真实姓名：{{keyword1.DATA}}
申请时间：{{keyword2.DATA}}
{{remark.DATA}}

内容示例：
您好，有新老师申请加入你创建的摩屋啦！
真实姓名：王小明
申请时间：2014年7月21日 18:36
请登录平台同意或拒绝。

4. 退款提醒
模板id：MHLQONFLdMBSEGQS2AW06V3sFV5zEXQYq_iqbPJpAgQ

格式内容：
{{first.DATA}}
订单号：{{keyword1.DATA}}
退款金额：{{keyword2.DATA}}
退款原因：{{keyword3.DATA}}
{{remark.DATA}}

内容示例：
您好，您申请的订单已退款到余额,请至个人中心查看
订单号：XM1611090416059
退款金额：10.5 元
退款原因：整个订单取消
点击此处，查看订单退款详情

5. 成员退出
模板id：ZeiTfOWQG2lPbLqZ6zj0Y8_UePEqB4htq9r1PEfTCUQ

格式内容：
{{first.DATA}}
姓名：{{keyword1.DATA}}
原因：{{keyword2.DATA}}
当前人数：{{keyword3.DATA}}
{{remark.DATA}}

内容示例：
李四退出了&#39;周四晚上踢足球活动&#39;
姓名：李四
原因：明晚出差，来不了呢
当前人数：10
点击查看成员详情

***
wechatService调用
$data = [
	"touser" => OPENID,
	"template_id" => "ngqIpbwh8bUfcSsECmogfXcV14J0tQlEpBO27izEYtY",
	"url" => "http://weixin.qq.com/download",
	"topcolor":"#FF0000",
	"data" => [
		'first' => ['value' => 'ddddd'],
		'keyword1' => ['value' => 'ccccc'],
		'remark' => ['value' => 'xxxxx']
	]
]
$w = new WechatService();
$res = $w->sendmessage($data)			
$res 成功返回json|失败返回false