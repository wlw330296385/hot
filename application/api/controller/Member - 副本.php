<?php
namespace app\api\controller;
use app\api\controller\Base;
use think\Request;
use app\service\MemberService;
class Member extends Base{

    protected $memberService;

    public function _initialize() {   
        parent::_initialize();  
        $this->memberService = new MemberService;
    }


    public function getMemberInfo(){
        $map = Request::instance()->param();
        $result = $this->memberService->getMemberInfo($map);
        return json($result);
    }

    public function getMemberInfoAll(){
        $result = Db::view('member','id,name')
                ->view('student','truename,phone,email','student.member_id=member.id')
                ->view('coach','score','Score.member_id=student.id')
                ->where('id','>',1)
                ->select();

    }
}
