<?php 
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\service\MemberService;
class Member extends Backend{
	public $MemberService;
	public function _initialize(){
		parent::_initialize();
		$this->MemberService = new MemberService;
	}


	public function memberlist(){
		$field = '请选择搜索关键词';
		$map = [];

		$field = input('param.field');
		$keyword = input('param.keyword');
		if($keyword==''){
			$map = [];
			$field = '请选择搜索关键词';
		}else{
			if($field){
				$map = [$field=>['like',"%$keyword%"]];
			}else{
				$field = '请选择搜索关键词';
				$map = function($query) use ($keyword){
					$query->where(['member'=>['like',"%$keyword%"]])->whereOr(['telephone'=>['like',"%$keyword%"]])->whereOr(['nickname'=>['like',"%$keyword%"]])->whereOr(['hot_id'=>['like',"%$keyword%"]]);
				};
			}
		}
			
		

		// 模板变量赋值
        $model = new \app\model\Member();
		$memberList = $model->with('student')->where($map)->order('id desc')->paginate(10)->each(function($item, $key) {
		    // 显示推荐人
            $item['refer1_member'] = '';
            $item['refer1_avatar'] = '';
            $item['refer2_member'] = '';
            $item['refer2_avatar'] = '';
		    if ($item['pid'] > 0) {
                // 一层推荐人
                $refer1member = db('member')->where(['id' => $item['pid']])->find();
                if ($refer1member) {
                    // 推荐人信息返回到结果集
                    $item['refer1_member'] = $refer1member['member'];
                    $item['refer1_avatar'] = $refer1member['avatar'];
                    // 二层推荐人
                    if ($refer1member['pid'] > 0) {
                        $refer2member = db('member')->where(['id' => $refer1member['pid']])->find();
                        if ($refer2member) {
                            $item['refer2_member'] = $refer2member['member'];
                            $item['refer2_avatar'] = $refer2member['avatar'];
                        }
                    }
                }

            }
        });
        //dump($memberList);
		$this->assign('field',$field);
		$this->assign('memberList', $memberList);
		return view('member/memberList');
	}

	public function memberInfo(){
		$member_id = input('param.member_id');
		$memberInfo = $this->MemberService->getMemberInfo(['id'=>$member_id]);
		// 教练信息
		$Coach = new \app\model\Coach;
		$coachInfo = $Coach->where(['member_id'=>$member_id])->find();
		// 证书
		$certList = db('cert')->where(['member_id'=>$member_id])->select();
		// 学生档案
		$studentList = db('student')->where(['member_id'=>$member_id])->select();
		// 推荐人
		$referer = $this->MemberService->getMemberInfo(['id'=>$memberInfo['pid']]);

		$this->assign('referer',$referer);
		$this->assign('studentList',$studentList);
		$this->assign('certList',$certList);
		$this->assign('coachInfo',$coachInfo);
		$this->assign('memberInfo',$memberInfo);
		return view('member/memberInfo');
	}

	public function createMember(){

		if(request()->isPost()){
			$data = input('post.');
			$data['password'] = $data['repassword'] = $data['system_remarks'] = rand(100000,999999);
			$result = $this->MemberService->saveMemberInfo($data);
			if($result['code'] == 100){
				echo '<script type="text/javascript">alert("'.$result["msg"].'")</script>';
			}else{
				// 判断是否有添加学生
				if($data['student']){
					$data['member_id'] = $result['data'];
					$Student = new \app\model\Student;
					$Student->save($data);
				}
				echo '<script type="text/javascript">alert("'.$result["msg"].'")</script>';
			}
		}

		return	$this->fetch('member/createMember');
	}




	public function addReferer(){

		$field = '请选择搜索关键词';
		$map = [];
		$member_id = input('param.member_id');
		$field = input('param.field');
		$keyword = input('param.keyword');
		if($keyword==''){
			$map = [];
			$field = '请选择搜索关键词';
		}else{
			if($field){
				$map = [$field=>['like',"%$keyword%"]];
			}else{
				$field = '请选择搜索关键词';
				$map = function($query) use ($keyword){
					$query->where(['member|telephone|nickname|hot_id'=>['like',"%$keyword%"]]);
				};
			}
		}

		$model = new \app\model\Member();
		$memberList = $model->where($map)->order('id desc')->paginate(10);

		if(request()->isPost()){
			$telephone = input('post.telephone');
			$memberInfo = db('member')->where(['id'=>$member_id])->find();
			if(!$memberInfo) {
				$this->error('操作错误');
			}
			if($memberInfo['pid']<>0){
				$this->error('改用户已存在推荐人,不允许修改');
			}
			$PmemberInfo = db('member')->where(['telephone'=>$telephone])->find();
			if(!$PmemberInfo) {
				$this->error('不存在该推荐人');
			}

			$result = db('member')->where(['id'=>$member_id])->update(['pid'=>$PmemberInfo['id']]);
			if($result){
				echo "<script>alert('操作成功');var index = parent.layer.getFrameIndex(window.name); parent.layer.close(index);</script>";
			}else{
				$this->error('操作失败');
			}
		}


		$this->assign('field',$field);
		$this->assign('member_id', $member_id);
		$this->assign('memberList', $memberList);
		return	$this->fetch('member/addReferer');
	}
}