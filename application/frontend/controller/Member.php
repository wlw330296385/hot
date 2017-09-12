<?php 
namespace app\frontend\controller;
use app\frontend\controller\Frontend;
use app\service\MemberService;
use app\service\StudentService;
use think\Db;
class Member extends Frontend{
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
        
        return view('Member/index');
    }

    // 会员设置页面
    public function memberSetup(){


        return view('Member/memberSetup');
    }

    // 登陆成功跳转的页面
    public function registerSuccess(){

        return view('Member/registerSuccess');
    }
    
    public function memberInfo(){
        $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
        $memberInfo = $this->MemberService->getMemberInfo(['id'=>$member_id]);
        $this->assign('memberInfo',$memberInfo);
    	return view('Member/memberInfo');
    }

    // 完善会员资料
    public function updateMember(){
        $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
        $memberInfo = $this->MemberService->getMemberInfo(['id'=>$member_id]);  
        $this->assign('memberInfo',$memberInfo);
        return view('Member/updateMember');
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
                // $coachScheduleIDs = db('schedule_member')
                //                     ->where(['type'=>1,'user_id'=>$coach_id])
                //                     ->column('schedule_id');
                // if($coachScheduleIDs){
                //     $coachAlbumList = db('schedule_media')
                //                 ->where('schedule_id','in',$coachScheduleIDs)
                //                 ->limit('10')
                //                 ->select();
                // }
                
                // $studentScheduleIDs = db('schedule_member')
                //                     ->where(['type'=>1])
                //                     ->where('user_id','IN',$student_id)
                //                     ->column('schedule_id');
                // if($studentScheduleIDs){
                //     $studentAlbumList = db('schedule_media')
                //                 // ->field("*,(create_time,'%Y%m') months")
                //                 ->where(['schedule_id','IN',$studentScheduleIDs])
                //                 ->limit('10')
                //                 ->select();
                // }                    
                $coachAlbumList = Db::view('schedule_member','schedule_id,schedule')
                                ->view('schedule_media','url,create_time','schedule_member.schedule_id = schedule_media.schedule_id')
                                ->where(['schedule_member.type'=>1,'schedule_member.user_id'=>$coach_id])
                                ->select();
                 $studentAlbumList = Db::view('schedule_member','schedule_id,schedule')    
                                   ->view('schedule_media','url,create_time','schedule_member.schedule_id = schedule_media.schedule_id')
                                    ->where(['schedule_member.type'=>0])
                                    ->where('schedule_member.user_id','IN',$student_id)
                                    ->select();            
                // dump($coachAlbumList);die;                
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
        $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
        $memberInfo = db('member')->find(['id'=>$member_id]);
        $myGroupList = $this->MemberService->getMyGroup($member_id);
        // dump($myGroupList);die;
        $count = count($myGroupList,1);
        $this->assign('memberInfo',$memberInfo);
        $this->assign('count',$count);
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
        $tid = getTID($this->memberInfo['id']);
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
        }
        return view('Member/myWallet');
    }

    // 收支明细
    public function salaryDetail(){
        $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
        $SalaryInService = new \app\service\SalaryInService($member_id);
        $salaryinList = $SalaryInService->getSalaryInList(['member_id'=>$member_id]);
        $salaryoutList = db('salary_out')->where(['member_id'=>$member_id])->select();

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
        $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
        $type = input('param.type')?input('param.type'):4;
        if($type){
            $campList = db('camp_member')->where(['member_id'=>$member_id,'type'=>$type,'status'=>1])->select();
        }else{
            $campList = db('camp')->where(['member_id'=>$member_id,'status'=>1])->select();
        }
        $this->assign('type',$type);
        $this->assign('campList',$campList);
        return view('Member/myCamp');
    }


    public function myShare(){


        return view('Mmeber/myShare');
    }
}