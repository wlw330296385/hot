<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\MemberService;
use app\service\StudentService;
use app\service\WechatService;
use think\Db;
class Member extends Base{
    private $MemberService;
	public function _initialize(){

		parent::_initialize();
        $this->MemberService = new MemberService;
	}

    public function index() {
        $member_id = input('param.member_id');
        if($member_id){
            $memberInfo = $this->MemberService->getMemberInfo(['id'=>$member_id]);
            $this->assign('memberInfo',$memberInfo);
        }

        $hasCoach = $this->MemberService->hasCoach($this->memberInfo['id']);
        $hasCamp  = $this->MemberService->hasCamp($this->memberInfo['id']);
        $this->assign('coach', $hasCoach);
        $this->assign('camp', $hasCamp);
        return view('Member/index');
    }

    public function followlist() {
	    return view('Member/followlist');
    }

    // 我的班级列表
    public function myGrade() {
        $member_id = $this->memberInfo['id'];
        return view('Member/myGrade');
    }

    // 教练邀请列表
    public function invitation() {
        $member_id = $this->memberInfo['id'];
        return view('Member/invitation');
    }

    // 会员设置页面
    public function memberSetup(){


        return view('Member/memberSetup');
    }

    // 登陆成功跳转的页面
    public function registerSuccess(){

        return view('Member/registerSuccess');
    }
    
    //个人信息-会员看
    public function memberInfo(){
        $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
        $memberInfo = $this->MemberService->getMemberInfo(['id'=>$member_id]);
        $this->assign('memberInfo',$memberInfo);
    	return view('Member/memberInfo');
    }

    //个人信息-他人看
    public function memberInfoOther(){
        $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
        $memberInfo = $this->MemberService->getMemberInfo(['id'=>$member_id]);
        $this->assign('memberInfo',$memberInfo);
    	return view('Member/memberInfoOther');
    }

    // 完善会员资料
    public function updateMember(){
        $html_name = input('param.html_name')?input('param.html_name'):'updateMember';
        $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
        $memberInfo = $this->MemberService->getMemberInfo(['id'=>$member_id]);  
        $this->assign('memberInfo',$memberInfo);
        return view('Member/'.$html_name);
    }
    public function photoAlbum(){
        $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
        // 相册类型
        $type = input('param.type')?input('param.type'):'schedule';
        // 获取用户的coach_id
        $coach_id = db('coach')->where(['member_id'=>$member_id])->value('id');

        // 获取用户学生身份的student_id
        $student_id = db('student')->where(['member_id'=>$member_id])->column('id');
        switch ($type) {
            case 'schedule':
                $studentAlbumList = [];
                $coachAlbumList =[];
                   
                $coachAlbumList = Db::view('schedule_member','schedule_id,schedule')
                                ->view('schedule_media','url,create_time','schedule_member.schedule_id = schedule_media.schedule_id')
                                ->where(['schedule_member.type'=>1,'schedule_member.user_id'=>$coach_id])
                                ->order('schedule_member.id desc')
                                ->select();
                 $studentAlbumList = Db::view('schedule_member','schedule_id,schedule')    
                                   ->view('schedule_media','url,create_time','schedule_member.schedule_id = schedule_media.schedule_id')
                                    ->where(['schedule_member.type'=>0])
                                    ->where('schedule_member.user_id','IN',$student_id)
                                    ->order('schedule_member.id desc')
                                    ->select();                  
                //合并数组
                $albumList = array_merge($studentAlbumList,$coachAlbumList);
                break;
            case 'match':

                break;
            case 'activity':
            
                break;
            default:
                # code...
                break;
        }

        // dump($albumList);die;
        $this->assign('albumList',$albumList);
    	return view('Member/photoAlbum');
    }

    //学员个人档案
    public function studentPersonArchives(){
        $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
        $memberInfo = $this->MemberService->getMemberInfo(['id'=>$member_id]);
        $this->assign('memberInfo',$memberInfo);
    	return view('Member/studentPersonArchives');
    }


    // 我的组织
    public function myGroup(){
        $hot_id = input('param.hot_id')?input('param.hot_id'):$this->memberInfo['hot_id'];
        $myGroupList = $this->MemberService->getMyGroup(['hot_id'=>$hot_id]);
        $this->assign('myGroupList',$myGroupList);
        return view('Member/myGroup');
    }


    // 个人钱包充值
    public function charge(){

        return view('Member/charge');
    }



    // 提现申请
    public function withdraw(){
        // 获取身份证号码
        $ident = db('cert')->where(['member_id'=>$this->memberInfo['id'],'cert_type'=>1])->value('cert_no');
        // 交易单号
        $tid = getTID($this->memberInfo['hot_id']);
        //银行卡列表
        $bankcardList = db('bankcard')->where(['member_id'=>$this->memberInfo['id']])->select();

        $this->assign('bankcardList',$bankcardList);
        $this->assign('tid',$tid);
        $this->assign('ident',$ident);
        return view('Member/withdraw');
    }

    // 我的钱包
    public function myWallet(){
        $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
        if($member_id){
            $memberInfo = db('member')->where(['id'=>$member_id])->find();
            $this->assign('memberInfo',$memberInfo);
        }else{
            $memberInfo = $this->memberInfo;
        }

        //被冻结金额
        $buffer = db('salary_out')->where(['member_id'=>$memberInfo['id']])->sum('buffer');
        $buffer = number_format($buffer, 2);
        $this->assign('buffer',$buffer);
        return view('Member/myWallet');
    }

    // 收支明细
    public function salaryDetail(){
        $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
        $SalaryInService = new \app\service\SalaryInService($member_id);
        $salaryinList = $SalaryInService->getSalaryInList(['member_id'=>$member_id]);
        $SalaryOutService = new \app\service\SalaryOutService($member_id);
        $salaryoutList = $SalaryOutService->getSalaryOutList(['member_id'=>$this->memberInfo['id']]);
        // dump($salaryoutList);die;
        $this->assign('salaryoutList',$salaryoutList);
        $this->assign('salaryinList',$salaryinList);
        return view('Member/salaryDetail');
    }

    // 我的积分
    // public function myScore(){
    //     $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
    //     if($member_id){

    //     }
    //     // 积分明细
    //     $ScoreService = new \app\service\ScoreService;
    //     $scoreList = $ScoreService->getScoreList(['member_id'=>$member_id]);
    //     $this->assign('rebateList',$rebateList);
    //     return view();
    // }
    // 添加银行卡
    public function createBankCard(){

        return view('Member/createBankCard');
    }


    // 我名下的训练营
    public function myCamp(){
        $member_id = $this->memberInfo['id'];
        $type = input('param.type', 4);
        $campList = db('camp_member')->where(['member_id' => $member_id, 'type' => $type, 'status' => 1])->select();
        switch ($type) {
            case "1": {
                $hasStudent = db('student')->where(['member_id' => $member_id])->select();
                $this->assign('hasStudent', $hasStudent);
                break;
            }
            case "2": {
                $hasCoach = $this->MemberService->hasCoach($this->memberInfo['id']);
                $this->assign('hasCoach', $hasCoach);
                break;
            }
            case "4": {
                $hasCamp = $this->MemberService->hasCamp($this->memberInfo['id']);
                $this->assign('hasCamp', $hasCamp);
                break;
            }
        }

        $this->assign('type',$type);
        $this->assign('campList',$campList);
        return view('Member/myCamp');
    }


    public function share(){
        $memberid = $this->memberInfo['id'];
        $callback = url('Frontend/Index/index', ['pid' => $memberid], '', true);
        $wechatS = new WechatService();
        $url = $wechatS->oauthredirect($callback);
        $qrcodeimg = buildqrcode($url) ;
        $member_name = !empty($this->memberInfo['nickname']) ? $this->memberInfo['nickname'] : $this->memberInfo['member'];


        $this->assign('qrcodeimg', $qrcodeimg);
        $this->assign('membername', $member_name);
        return view('Member/myShare');
    }

    // 用户协议说明页面
    public function userAgreement(){
        return view('Member/userAgreement');
    }

    public function bandWx(){
        $hot_id = input('hot_id');
        // 获取用户信息
        $member = db('member')->field('id,hot_id,member,telephone,openid')->where(['openid'=>session('memberInfo.openid')])->find();
        if(!$member){
            $memebr  = [
                'hot_id'=>'',
                'id'=>0,
                'member'=>'',
                'telephone'=>'',
                'openid' => 0
            ];
        }
        $this->assign('member',$member);
        return view('Member/bandWx');
    }

    // 收藏列表
    public function collectList(){
        return view('Member/collectList');
    }

}