<?php 
namespace app\service;
use app\model\Camp;
use app\model\CampMember;
use app\model\Coach;
use app\model\Member;
use app\common\validate\MemberVal;
use app\model\MemberComment;
use app\model\MemberHonor;
use app\model\StudyInterion;

class MemberService{
	private $memberModel;	
	public function __construct(){
		$this->memberModel = new Member();
	}
	// 获取会员
	public function getMemberInfo($map){
		$result = $this->memberModel->where($map)->find();
		
        return $result;
	}

	// 会员列表
	public function getMemberList($map = [], $order='id desc',$page=1, $limit=10){
	    $model = new Member();
        $query = $model->where($map)->order($order)->page($page)->limit($limit)->select();
        if ($query) {
            return $query->toArray();
        } else {
            return $query;
        }
	}

	// 会员列表（分页）
	public function getMemberPaginator($map = [], $order='id desc',$paginate = 10) {
        $model = new Member();
        $query = $model->where($map)->order($order)->paginate($paginate);
        if ($query) {
            return $query->toArray();
        } else {
            return $query;
        }
    }

	// 会员（关联学员）列表（分页）
	public function getMemberListByPage($map = [],$order = '',$paginate = 10){
		$result = $this->memberModel->with('student')->where($map)->order($order)->paginate($paginate);
		// echo $this->memberModel->getlastsql();die;
		// if($result){
		// 	$res = $result->toArray();
		// 	return $res;
		// }
		return $result;
	}

	//修改会员资料
	public function updateMemberInfo($data,$map){
		
		$result = $this->memberModel->save($data,$map);
		
		if($result ===false){
			return ['msg'=>$this->memberModel->getError(),'code'=>100];
		}else{
			$memberInfo = $this->getMemberInfo($map);
			session('memberInfo',$memberInfo,'think');
			cookie('mid',$memberInfo['id']);
			// 修改成功返回会员最新信息
			return ['msg'=>__lang('MSG_200'),'code'=>200,'data'=>$memberInfo];
		}	
	}

	//新建会员
	public function saveMemberInfo($request){
		// 生成一个随机id
		$hot_id = $this->getHotID();
		$MemberModel = new Member();
		if(isset($request['password'])){
			$request['password'] = passwd($request['password']);
        	$request['repassword'] = passwd($request['repassword']);
		}else{
			$request['password'] = passwd(123456);
        	$request['repassword'] = passwd(123456);
		}
        
        $request['hot_id'] = $hot_id;
        if (!isset($request['avatar'])) {
            $request['avatar'] = '/static/default/avatar.png';
        }

        //验证规则
		$res = $MemberModel->validate('MemberVal')->save($request);
		if ($res === false) {
            return [ 'code' => 100, 'msg' => $MemberModel->getError()];
        } else {
            //记录积分
            db('score')->insert(
                [
                    'ccore'=>$request['score'],
                    'member_id'=>$MemberModel->id,
                    'member'=>$request['member'],
                    'create_time'=>time(),
                    'score_des'=>'注册送积分'
                ]
            );
	        return ['code' => 200, 'msg' => __lang('MSG_200'), 'data'=>$MemberModel->id,'id'=>$MemberModel->id];
        }
	}

	// 生成一个随机id
	private function getHotID(){
		$hot_id = 10000000+rand(00000001,99999999);
		$MemberModel = new Member();
		$is_hot = $MemberModel->where(['hot_id'=>$hot_id])->find();
		if($is_hot){
			$this->getHotID();
		}else{
			return $hot_id;
		}
	}


	// 会员登录
	public function login($username,$password){

		$result = $this->memberModel
				->where(['password'=> passwd($password) ])
				->where(function($query) use ($username){
						$query->where('member',$username)->whereOr('telephone',$username);
					})
				->find();
		return $result['id'];
	}
	// 会员登录状态
	public function saveLogin($id){
		$member = $this->getMemberInfo(['id'=>$id]);
        unset($member['password']);
        cookie('mid', $member['id']);
        cookie('openid', $member['openid']);
        cookie('member',md5($member['id'].$member['member'].config('salekey')));
        session('memberInfo',$member,'think');
        if ( session('memberInfo', '', 'think') ) {
            return true;
        } else {
            return false;
        }
	}

    // 获取组织列表
    public function getMyGroup($map){
        $result = [];
        $result = $this->memberModel->where($map)->find();
        $arr = $result->toArray();
        $arr['groupList'] = [];
        $arr['count'] = 0;
        $arr = $this->getGroupTree($arr,0,0);  
        $arr['count'] = $this->count;
 		
        return $arr;
    }

    private $count = 0;
    private function getGroupTree($arr,$times,$count){
    	
        $times++;
        if($times < 3) {
        	$result = $this->memberModel->where(['pid'=>$arr['id']])->select()->toArray();     
        	if(!empty($result)){
	            foreach ($result as $key => $value) {
	            $count ++; 
	                    $this->count = $count;
	                    $arr['groupList'][$key]['count'] = count($result);
	                    $arr['groupList'][$key] = $this->getGroupTree($value,$times,$count);
	                    $arr['count'] = count($result);
	                }
            }else{
                	$arr['groupList'] = [];
	            	$arr['count'] = 0;
            }
            
        }
        
        return $arr;
    }


	public function isFieldRegister($field,$value){
		$result = $this->memberModel->where([$field=>$value])->find();
		return $result?1:0;
	}
	
	// 查询会员是否有教练身份数据
	public function hasCoach($memberid) {
	     $model = new Coach();
	     $res = $model::get(['member_id'=>$memberid]);
	     if ($res) {
             $return = $res->toArray();
             $return['check_status'] =  $model::get(['member_id'=>$memberid])->getData('status'); //审核状态
         } else {
	         $return = 0;
         }
	     return $return;
    }

    public function hasCamp($memberid) {
        $model = new Camp();
        $res = $model::get(['member_id' => $memberid]);
        if ($res) {
            $return = $res->toArray();
            $return['check_status'] = $model::get(['member_id' => $memberid])->getData('status'); //审核状态
        }else {
            $return = 0;
        }
        return $return;
    }
    
    // 会员在训练营的身份关联
    public function campmemberInfo($map) {
	    $campmember = CampMember::get($map);
	    if ($campmember) {
	        $res = $campmember->toArray();
	        $res['status_num'] = $campmember->getData('status');
	        $res['type_num'] = $campmember->getData('type');
	        return $res;
        } else {
	        return 0;
        }
    }

    // 获取会员下线层级
    public function getMemberTier($member_id) {
        $tree = [];
        $model = new Member();
        $field = ['id' => 'member_id','member','pid'];
        $member = $model->field($field)->where(['id' => $member_id])->find()->toArray();
        $parent_member = $model->field($field)->where(['id' => $member['pid']])->find();
        //dump($parent_member);
        if ($parent_member) {
            $parent_member = $parent_member->toArray();
            $parent_member['tier'] = 1;
            $parent_member['sid'] = $member['member_id'];
            $parent_member['s_member'] = $member['member'];
            array_push($tree, $parent_member);
            $parent_member2 = $model->field($field)->where('id', $parent_member['pid'])->find();
            if ($parent_member2) {
                $parent_member2 = $parent_member2->toArray();
                $parent_member2['tier'] =2;
                $parent_member2['sid'] = $parent_member['member_id'];
                $parent_member2['s_member'] = $parent_member['member'];
                array_push($tree, $parent_member2);
            }
        }
        return $tree;
    }

    // 提取微信受案信息头像 下载到本地
    public function downwxavatar($avatar) {
        //$avatar = str_replace("http://", "https://", $userinfo['headimgurl']);
        // 上传目录（绝对路径，用于保存文件）
        $dirName =  "uploads" . DS . "images". DS ."avatar";
        $saveDir = ROOT_PATH  . "public" . DS. $dirName . DS;
	    // 用户没有头像时该项为空 不操作
	    if (!empty($avatar)) {
            $savefilename = download($avatar, $saveDir);
            return DS.$dirName.DS.$savefilename;
        }
        return 0;
    }

    // 保存学习意向登记
    public function savestudyinterion($data) {
        $model = new StudyInterion();
        if ( array_key_exists('id', $data) ) {
            // 更新数据
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res === false) {
                trace('error:'.$model->getError().'; \n sql:'.$model->getLastSql());
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            } else {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            }
        }
        // 插入数据
        $res = $model->allowField(true)->isUpdate(false)->save($data);
        if ($res) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
        } else {
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 保存会员荣誉记录
    public function saveMemberHonor($data) {
        $model = new MemberHonor();
        if ( array_key_exists('id', $data) ) {
            // 更新数据
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res === false) {
                trace('error:'.$model->getError().'; \n sql:'.$model->getLastSql());
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            } else {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            }
        }
        // 插入数据
        $res = $model->allowField(true)->isUpdate(false)->save($data);
        if ($res) {
            return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
        } else {
            return ['code' => 100, 'msg' => __lang('MSG_400')];
        }
    }

    // 会员荣誉详情
    public function getMemberHonor($map) {
        $model = new MemberHonor();
        $res = $model->where($map)->find();
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 会员荣誉列表（不分页）
    public function getMemberHonorAll($map, $order='id desc') {
        $model = new MemberHonor();
        $res = $model->where($map)->order($order)->select();
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 会员荣誉列表
    public function getMemberHonorList($map, $page=1, $order='id desc', $limit=10) {
        $model = new MemberHonor();
        $res = $model->where($map)->order($order)->page($page)->limit($limit)->select();
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 会员荣誉列表（页码）
    public function getMemberHonorPaginator($map, $order='id desc', $limit=10) {
        $model = new MemberHonor();
        $res = $model->where($map)->order($order)->paginate($limit);
        if (!$res) {
            return $res;
        }
        return $res->toArray();
    }

    // 删除会员荣誉
    public function delMemberHonor($id) {
        return MemberHonor::destroy($id);
    }

    // 球队模块评论列表分页
    public function getCommentPaginator($map, $order = 'id desc', $paginate = 10)
    {
        $model = new MemberComment();
        // 只列出有评论文字内容的数据
        $res = $model->where($map)->whereNotNull('comment')->order($order)->paginate($paginate);
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 球队模块评论列表
    public function getCommentList($map, $page = 1, $order = 'id desc', $limit = 10)
    {
        $model = new MemberComment();
        // 只列出有评论文字内容的数据
        $res = $model->where($map)->whereNotNull('comment')->order($order)->page($page, $limit)->select();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 球队模块点赞数统计
    public function getCommentThumbsCount($map)
    {
        $model = new MemberComment();
        $map['thumbsup'] = 1;
        $res = $model->where($map)->count();
        return $res;
    }

    // 保存球队模块评论、点赞数据
    public function saveComment($data)
    {
        $model = new MemberComment();
        // 根据传参 有id字段更新数据否则新增数据
        if (isset($data['id'])) {
            // 更新数据
            $res = $model->allowField(true)->isUpdate(true)->save($data);
            if ($res || ($res === 0)) {
                return ['code' => 200, 'msg' => __lang('MSG_200')];
            } else {
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        } else {
            // 新增数据
            $res = $model->allowField(true)->isUpdate(false)->save($data);
            if ($res) {
                return ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $model->id];
            } else {
                return ['code' => 100, 'msg' => __lang('MSG_400')];
            }
        }
    }

    // 获取球队模块评论详情
    public function getCommentInfo($map)
    {
        $model = new MemberComment();
        $res = $model->where($map)->find();
        if ($res) {
            return $res->toArray();
        } else {
            return $res;
        }
    }

    // 删除评论内容
    public function delComment($id) {
        $model = new MemberComment();
        // 清空comment comment_time内容
        $res = $model->isUpdate(true)->save([
            'id' => $id,
            'comment' => null,
            'comment_time' => null
        ]);
        if ($res == false) {
            trace('error message:'.$model->getError().'; \n sql:'.$model->getLastSql().'');
            return false;
        }
        return $res;
    }
}