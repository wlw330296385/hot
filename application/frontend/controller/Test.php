<?php 
namespace app\frontend\controller;
use app\service\TestService;
class Test {

    public function index(){

        // $this->redirect('/frontend/index/index/pid/1');
        dump($url = $_SERVER["REQUEST_URI"]);
        session(null);
        cookie(null);
        session(null,'think');echo '清空了cookie和session';die;
        // $param = input('param.');
        // cache('param',$param);
        // cookie('param', $param);
        // dump($param);
        // dump($this->memberInfo);
        // session('memberInfo',['id'=>'0','openid'=>'o83291CzkRqonKdTVSJLGhYoU98Q','member'=>'woo'],'think');
        dump(session('memberInfo','','think'));
        // dump(cache('param'));
        // dump(cookie('param'));

        // $WechatService = new WechatService;
        // $callback1 = url('login/wxlogin','','', true);
        // $callback2 = url('login/wxlogin');
        // dump( $WechatService -> oauthredirect($callback1) );
        // dump( $WechatService -> oauthredirect($callback2) );

    }

     public function test(){
        $a = ['a'=>1,'b'=>3];
        $b = $a['b'];
        $b++;
        $a['b'] = $b;
        dump($a);
     }


     public function getSession(){
        dump(session('memberInfo','','think'));
     }



     public function getArr(){

        $erwei =  [
            [
                'name'=>'首页',
                'icon'=>'icon iconfont icon-hotnav-home',
                'action'=>'index',
                'controller'=>'Index'
            ],
            [
                'name'=>'消息',
                'icon'=>'icon iconfont icon-hotnav-news',
                'action'=>'index',
                'controller'=>'Message'
            ],          
            [
                'name'=>'发现',
                'icon'=>'icon iconfont icon-hotnav-find',
                'action'=>'index',
                'controller'=>'Mall'
            ],
            [
                'name'=>'训练营',
                'icon'=>'icon iconfont icon-hotnav-training',
                'action'=>'index',
                'controller'=>'Camp'
            ],
            [
                'name'=>'我的',
                'icon'=>'icon iconfont icon-hotnav-mine',
                'action'=>'index',
                'controller'=>'Member'
            ],
        ];

        $sanwei=[
                ['a'=>[
                'name'=>'我的',
                'icon'=>'icon iconfont icon-hotnav-mine',
                'action'=>'index',
                'controller'=>[
                'name'=>'消息',
                'icon'=>'icon iconfont icon-hotnav-news',
                'action'=>'index',
                'controller'=>'Message'
            ],
                    ],
                'b'=>[
                        'name'=>'训练营',
                        'icon'=>'icon iconfont icon-hotnav-training',
                        'action'=>'index',
                        'controller'=>[
                'name'=>'消息',
                'icon'=>'icon iconfont icon-hotnav-news',
                'action'=>'index',
                'controller'=>'Message'
            ],
                    ]
                ],
                ['b'=>[
                'name'=>'我的',
                'icon'=>'icon iconfont icon-hotnav-mine',
                'action'=>'index',
                'controller'=>[
                'name'=>'消息',
                'icon'=>'icon iconfont icon-hotnav-news',
                'action'=>'index',
                'controller'=>'Message'
            ],
                    ],
                    'b'=>[
                        'name'=>'训练营',
                        'icon'=>'icon iconfont icon-hotnav-training',
                        'action'=>'index',
                        'controller'=>[
                'name'=>'消息',
                'icon'=>'icon iconfont icon-hotnav-news',
                'action'=>'index',
                'controller'=>'Message'
            ],
                    ]
                ],
        ];
        
        echo "二维<br>";
        echo json_encode($erwei);
        dump($erwei);

        echo "三维<br>";
        echo json_encode($sanwei);
        dump($sanwei);
    }



    public function service2(){
        $data = [
            'title'=>rand(00000,99999),
            'content'=>rand(00000,99999),
        ];
        $TestService = new TestService;
        $result = $TestService->insertMessage($data);
        // $result = testSerivce($data);
        dump($result);
    }



    public function seri(){
        $data = serialize(['/static/frontend/images/uploadDefault.jpg','/static/frontend/images/uploadDefault.jpg','/static/frontend/images/uploadDefault.jpg']);

        dump($data);
    }
}