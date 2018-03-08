<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\CertService;
use app\service\MatchService;
use app\service\RefereeService;
use think\Exception;

class Referee extends Base{
	protected $refereeService;
	public function _initialize(){
		parent::_initialize();
		$this->refereeService = new RefereeService();

	}

    // 裁判员列表（分页）
    public function refereeListPage() {
	    try {
	        $map = input('param.');
            // 关键字搜索
            $keyword = input('keyword');
            if (input('?param.keyword')) {
                unset($map['keyword']);
                // 关键字内容
                if ($keyword != null) {
                    if (!empty($keyword) || !ctype_space($keyword)) {
                        $map['referee'] = ['like', "%$keyword%"];
                    }
                }
            }
            // 关键字null情况处理
            if ($keyword == null) {
                unset($map['keyword']);
            }
            // 默认区为空
            if (input('?param.area')) {
                if (empty($map['area'])) {
                    unset($map['area']);
                }
            }
            // 默认等级为空
            if (input('?param.level')) {
                if (empty($map['level'])) {
                    unset($map['level']);
                }
            }
            if (input('?param.page')) {
                unset($map['page']);
            }
            // 组合查询条件 end

	        $res = $this->refereeService->getRefereePaginator($map);
	        if ($res) {
	            $response = ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $res];
            } else {
	            $response = ['code' => 100, 'msg' => __lang('MSG_100')];
            }
            return json($response);
        } catch (Exception $e) {
	        return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }
    
    // 裁判员列表
    public function refereeList() {
        try {
            $map = input('param.');
            $page = input('param.page', 1);
            // 关键字搜索
            $keyword = input('keyword');
            if (input('?param.keyword')) {
                unset($map['keyword']);
                // 关键字内容
                if ($keyword != null) {
                    if (!empty($keyword) || !ctype_space($keyword)) {
                        $map['referee'] = ['like', "%$keyword%"];
                    }
                }
            }
            // 关键字null情况处理
            if ($keyword == null) {
                unset($map['keyword']);
            }
            // 默认区为空
            if (input('?param.area')) {
                if (empty($map['area'])) {
                    unset($map['area']);
                }
            }
            // 默认等级为空
            if (input('?param.level')) {
                if (empty($map['level'])) {
                    unset($map['level']);
                }
            }
            if (input('?param.page')) {
                unset($map['page']);
            }
            // 组合查询条件 end

            $res = $this->refereeService->getRefereeList($map, $page);
            if ($res) {
                $response = ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $res];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_100')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 裁判员列表（所有数据无分页）
    public function refereeListAll() {
        try {
            $map = input('param.');

            $res = $this->refereeService->getRefereeAll($map);
            if ($res) {
                $response = ['code' => 200, 'msg' => __lang('MSG_200'), 'data' => $res];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_100')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => $e->getMessage()]);
        }
    }

    // 注册裁判员信息
    public function createReferee(){
        try{
            // 检查会员是否有裁判员数据
            $hasReferee = $this->refereeService->getRefereeInfo(['member_id' => $this->memberInfo['id']]);
            if ($hasReferee) {
                return json(['code' => 100, 'msg' => '您已注册裁判员，无需重复注册']);
            }
            // 接收数据
            $request = $this->request->post();
            $request['member_id'] = $this->memberInfo['id'];
            $request['member'] = $this->memberInfo['member'];

            // 保存证件数据
            $certS = new CertService();
            if (!empty($request['cert'])) {
                $certdata = [
                    'camp_id' => 0,
                    'member_id' => $this->memberInfo['id'],
                    'cert_no' => 0,
                    'cert_type' => 5,
                    'photo_positive' => $request['cert']
                ];
                $cert = $certS->saveCert($certdata);
                if ($cert['code'] == 100) {
                    return json([ 'msg' => '裁判证件信息保存出错,请重试', 'code' => 100]);
                }
            }
            if ( !empty($request['idno']) || !empty($request['photo_positive']) || !empty($request['photo_back']) ) {
                $certdata1 = [
                    'camp_id' => 0,
                    'member_id' => $this->memberInfo['id'],
                    'cert_no' => $request['idno'],
                    'cert_type' => 1,
                    'photo_positive' => $request['photo_positive'],
                    'photo_back' => $request['photo_back']
                ];
                $cert1 = $certS->saveCert($certdata1);
                if ($cert1['code'] == 100) {
                    return json([ 'msg' => '身份证信息保存出错,请重试', 'code' => 100]);
                }
            }

            // 保存裁判员数据
            $result = $this->refereeService->createReferee($request);
            // 返回结果
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 修改裁判员信息
    public function updateReferee(){
        try{
            // 接收数据
            $request = $this->request->post();
            // 获取裁判员数据
            $id = $request['id'];
            $refereeInfo = $this->refereeService->getRefereeInfo(['id' => $id]);
            if (!$refereeInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404')]);
            }
            if ($refereeInfo['member_id'] != $this->memberInfo['id']) {
                return json(['code' => 100, 'msg' => '无权修改信息']);
            }

            // 修改了证件信息
            $idcard = $license = [];
            $certList = db('cert')->where(['member_id'=>$this->memberInfo['id']])->select();
            if ($certList) {
                foreach ($certList as $cert) {
                    // 资质证书
                    if ($cert['cert_type'] == 5) {
                        $license = $cert;
                    }
                    // 身份证
                    if ($cert['cert_type'] ==1) {
                        $idcard = $cert;
                    }
                }
            }
            $certS = new CertService();
            $certdata = [
                'camp_id' => 0,
                'member_id' => $this->memberInfo['id'],
                'cert_no' => 0,
                'cert_type' => 5,
                'photo_positive' => $request['cert'],
            ];
            if ( $license && ($request['cert'] != $license['photo_positive']) ) {
                $certdata['id'] = $license['id'];
                $certdata['status'] = 0;
                $request['status'] = 0;
            }
            $cert = $certS->saveCert($certdata);
            if ($cert['code'] == 100) {
                return json([ 'msg' => '裁判证件信息保存出错,请重试', 'code' => 100]);
            }

            $certdata1 = [
                'camp_id' => 0,
                'member_id' => $this->memberInfo['id'],
                'cert_no' => $request['idno'],
                'cert_type' => 1,
                'photo_positive' => $request['photo_positive'],
                'photo_back' => $request['photo_back']
            ];
            if ( $idcard &&
                ($request['idno'] != $idcard['cert_no'] || $request['photo_positive'] != $idcard['photo_positive'] || $request['photo_back'] != $idcard['photo_back'] )
            ) {
                $certdata1['id'] = $idcard['id'];
            }

            $cert1 = $certS->saveCert($certdata1);
            if ($cert1['code'] == 100) {
                return json([ 'msg' => '身份证信息保存出错,请重试', 'code' => 100]);
            }

            // 修改裁判员数据
            $request['member_id'] = $this->memberInfo['id'];
            $result = $this->refereeService->updateReferee($request);
            // 返回结果
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 获取会员的裁判员数据
    public function getMemberReferee(){
        try{
            $member_id = input('param.member_id')? input('param.member_id'):$this->memberInfo['id'];
            $result = $this->refereeService->getRefereeInfo(['member_id'=>$member_id]);
            if($result){
                return json(['code'=>200,'msg'=>__lang('MSG_201'),'data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>__lang('MSG_000')]);
            }
                
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 评论裁判
    public function createRefereeCommentApi(){
        try{
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['avatar'] = $this->memberInfo['avatar'];
            $result = $this->refereeService->createRefereeComment($data);
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    public function inviteRefereeApi(){
        try{
            $inviter = $this->memberInfo['member'];
            $inviter_id = $this->memberInfo['id'];
            $referee_id = input('param.referee_id');
            $referee = input('param.referee');
            $organization = input('param.organization');
            $type = input('param.type',6);
            $data = [
                'memebr'=>$referee,
                'member_id'=>$referee_id,
                'inviter'=>$inviter,
                'inviter_id'=>$inviter_id,
                'organization_type'=>4,//比赛
                'organization'=>$organization,
                'organization_id'=>input('param.organization_id'),
                'type'=>$type,//6是主裁判7是副裁判
                'apply_type'=>2,
                'remarks'=>input('param.remarks'),
            ];
            $ApplyService = new \app\service\ApplyService;
            $result = $ApplyService->createApply($data);
            return json($result);
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
        
    }

    // 裁判申请|受邀比赛列表（分页）
    public function matchapplypage(){
        try{
            $map = input('param.');
            // 验证必须输入变量
            $refereeId = input('param.referee_id');
            if (!isset($refereeId)) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            // 查询裁判员数据
            $refereeInfo = $this->refereeService->getRefereeInfo(['id' => $refereeId]);
            if (!$refereeInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404').',无此裁判员信息']);
            }
            if ( isset($map['page']) ) {
                unset($map['page']);
            }
            // 查询申请|受邀比赛列表（分页）
            $result = $this->refereeService->getMatchRefereeApplyPaginator($map);
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_000')];
            }
            return json($response);
        } catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 裁判申请|受邀比赛列表
    public function matchapplylist() {
        try {
            $map = input('param.');
            $page= input('param.page', 1);
            // 验证必须输入变量
            $refereeId = input('param.referee_id');
            if (!isset($refereeId)) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            // 查询裁判员数据
            $refereeInfo = $this->refereeService->getRefereeInfo(['id' => $refereeId]);
            if (!$refereeInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404').',无此裁判员信息']);
            }
            if ( isset($map['page']) ) {
                unset($map['page']);
            }
            // 查询申请|受邀比赛列表
            $result = $this->refereeService->getMatchRefereeApplyList($map, $page);
            if ($result) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $result];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_000')];
            }
            return json($response);
        } catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 裁判回复比赛邀请
    public function replymatchinvit() {
        try {
            // 接收参数 判断正确有无传参
            $applyId = input('apply_id');
            $status = input('status');
            $reply = input('reply');
            if (!$applyId || !$status) {
                return json(['code' => 100, 'msg' => __lang('MSG_402') . '，请正确传参']);
            }
            if (!in_array($status, [2, 3])) {
                return json(['code' => 100, 'msg' => __lang('MSG_402') . '，请正确传参']);
            }
            // 查询邀请数据
            $applyInfo = $this->refereeService->getMatchRefereeApply(['id' => $applyId]);
            if (!$applyInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404')]);
            }
            // 检测会员登录
            if ($this->memberInfo['id'] === 0) {
                return json(['code' => 100, 'msg' => '请先登录或注册会员']);
            }
            // 获取会员裁判数据
            $refereeInfo = $this->refereeService->getRefereeInfo(['member_id' => $this->memberInfo['id']]);
            if (!$refereeInfo || $refereeInfo['status_num'] != 1) {
                return json(['code' => 100, 'msg' => '您无裁判员信息或裁判员资格无效']);
            }
            if ($applyInfo['referee_id'] != $refereeInfo['id']) {
                return json(['code' => 100, 'msg' => '您无权操作此信息']);
            }
            // 更新邀请数据
            $resSaveApply = $this->refereeService->saveMatchRefereeApply([
                'id' => $applyInfo['id'],
                'status' => $status,
                'reply' => $reply
            ]);
            if ($resSaveApply['code'] == 100) {
                return json($resSaveApply);
            }

            // 保存比赛-裁判关系
            $matchS = new MatchService();
            $dataMatchReferee = [
                'match_id' => $applyInfo['match_id'],
                'match' => $applyInfo['match'],
                'match_record_id' => $applyInfo['match_record_id'],
                'referee_id' => $refereeInfo['id'],
                'referee' => $refereeInfo['referee'],
                'member_id' => $refereeInfo['member_id'],
                'member' => $refereeInfo['member']['member'],
                'referee_type' => 1,
                'appearance_fee' => $refereeInfo['appearance_fee']
            ];
            $matchS->saveMatchReferee($dataMatchReferee);
            // 发送通知给邀请人

            return json($resSaveApply);
        } catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 裁判执裁比赛列表（分页）
    public function getmatchrefereepage(){
        try{
            $map = input('param.');
            $matchS = new MatchService();
            $result = $matchS->getMatchRefereePaginator($map);
            if($result){
                return json(['code'=>200,'msg'=> __lang('MSG_201'),'data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=> __lang('MSG_000')]);
            }
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}