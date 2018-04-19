<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\model\MatchRefereeApply;
use app\service\CertService;
use app\service\MatchService;
use app\service\MessageService;
use app\service\RefereeService;
use think\Exception;
use think\Db;

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

	        $res = $this->refereeService->getRefereeWithMemberPaginator($map);
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
            $request['status'] = 0;
            $request['portraits'] = empty($request['portraits']) ? $this->memberInfo['avatar'] : $request['portraits'];

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
    

    // 裁判申请|受邀比赛列表（分页）
    public function matchapplypage(){
        try{
            $map = input('param.');

            // 获取受邀列表 自动补上查询裁判条件
            if (input('?apply_type') && input('apply_type') == 2) {
                // 无传入referee_id 根据当前会员查询裁判员信息
                $refereeId = input('param.referee_id');
                if (!$refereeId) {
                    $refereeInfo = $this->refereeService->getRefereeInfo(['member_id' => $this->memberInfo['id']]);
                } else {
                    // 查询裁判员数据
                    $refereeInfo = $this->refereeService->getRefereeInfo(['id' => $refereeId]);
                }
                if ($refereeInfo) {
                    $map['referee_id'] = $refereeInfo['id'];
                }
            }

            // 关键字搜索:裁判名字
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

            if ( isset($map['page']) ) {
                unset($map['page']);
            }

            // 查询申请|受邀比赛列表（分页）
            $matchService = new MatchService();
            $result = $matchService->getMatchRefereeApplyPaginator($map);
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

            // 获取受邀列表 自动补上查询裁判条件
            if (input('?apply_type') && input('apply_type') == 2) {
                // 无传入referee_id 根据当前会员查询裁判员信息
                $refereeId = input('param.referee_id');
                if (!$refereeId) {
                    $refereeInfo = $this->refereeService->getRefereeInfo(['member_id' => $this->memberInfo['id']]);
                } else {
                    // 查询裁判员数据
                    $refereeInfo = $this->refereeService->getRefereeInfo(['id' => $refereeId]);
                }
                if ($refereeInfo) {
                    $map['referee_id'] = $refereeInfo['id'];
                }
            }

            // 关键字搜索:裁判名字
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

            if ( isset($map['page']) ) {
                unset($map['page']);
            }

            // 查询申请|受邀比赛列表
            $matchService = new MatchService();
            $result = $matchService->getMatchRefereeApplyList($map, $page);
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

    // 获取比赛-裁判申请|邀请详情
    public function getmatchrefereeapply() {
        try {
            $map = input('param.');
            $matchS = new MatchService();
            $applyInfo = $matchS->getMatchRerfereeApply($map);
            if($applyInfo){
                return json(['code'=>200,'msg'=>__lang('MSG_201'),'data'=>$applyInfo]);
            }else{
                return json(['code'=>100,'msg'=>__lang('MSG_000')]);
            }
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 获取裁判列表与裁判-比赛申请|邀请关系数据（分页）
    public function getrefereepagewithmatchapply() {
        try {
            // 请求参数作查询条件（match_referee_apply）
            $map = input('param.');
            // 必须传入match_id
            if (!isset($map['match_id'])) {
                return json(['code' => 100, 'msg' => __lang('MSG_402').'，请选择比赛id']);
            }
            $refereeService = new RefereeService();
            $matchService = new MatchService();

            // 平台正式裁判员列表
            $refereeMap['status'] = 1;
            // 关键字搜索:裁判名字
            $keyword = input('keyword');
            if (input('?param.keyword')) {
                unset($map['keyword']);
                // 关键字内容
                if ($keyword != null) {
                    if (!empty($keyword) || !ctype_space($keyword)) {
                        $refereeMap['referee'] = ['like', "%$keyword%"];
                    }
                }
            }
            // 关键字null情况处理
            if ($keyword == null) {
                unset($map['keyword']);
            }
            $refereeList = $refereeService->getRefereePaginator($refereeMap);

            if ( isset($map['page']) ) {
                unset($map['page']);
            }

            if ($refereeList) {
                // 遍历获取裁判与比赛申请|邀请关系
                foreach ($refereeList['data'] as $k => $val) {
                    $map['referee_id'] = $val['id'];
                    $matchRefereeApply = $matchService->getMatchRerfereeApply($map);
                    $refereeList['data'][$k]['match_apply'] = ($matchRefereeApply) ? $matchRefereeApply : [];
                }
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $refereeList];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_000')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 获取裁判列表与裁判-比赛申请|邀请关系数据
    public function getrefereelistwithmatchapply() {
        try {
            // 请求参数作查询条件（match_referee_apply）
            $map = input('param.');
            $page = input('page', 1);
            // 必须传入match_id
            if (!isset($map['match_id'])) {
                return json(['code' => 100, 'msg' => __lang('MSG_402').'，请选择比赛id']);
            }
            $refereeService = new RefereeService();
            $matchService = new MatchService();
            // 平台正式裁判员列表
            $refereeMap['status'] = 1;
            // 关键字搜索:裁判名字
            $keyword = input('keyword');
            if (input('?param.keyword')) {
                unset($map['keyword']);
                // 关键字内容
                if ($keyword != null) {
                    if (!empty($keyword) || !ctype_space($keyword)) {
                        $refereeMap['referee'] = ['like', "%$keyword%"];
                    }
                }
            }
            // 关键字null情况处理
            if ($keyword == null) {
                unset($map['keyword']);
            }
            $refereeList = $refereeService->getRefereeList($refereeMap, $page);

            if ( isset($map['page']) ) {
                unset($map['page']);
            }

            if ($refereeList) {
                // 遍历获取裁判与比赛申请|邀请关系
                foreach ($refereeList as $k => $val) {
                    $map['referee_id'] = $val['id'];
                    $matchRefereeApply = $matchService->getMatchRerfereeApply($map);
                    $refereeList[$k]['match_apply'] = ($matchRefereeApply) ? $matchRefereeApply : [];
                }
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $refereeList];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_000')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 裁判申请执裁比赛
    public function applymatchreferee()
    {
        $post = input('post.');
        // 验证必传字段
        if (!isset($post['match_id']) || !isset($post['match_record_id'])) {
            return json(['code' => 100, 'msg' => __lang('MSG_402') . '，缺少比赛信息']);
        }
        if (!isset($post['referee_id'])) {
            return json(['code' => 100, 'msg' => __lang('MSG_402') . '，缺少裁判员信息']);
        }
        // 验证会员登录
        if ($this->memberInfo['id'] === 0) {
            return json(['code' => 100, 'msg' => '请先登录或注册会员']);
        }
        $matchService = new MatchService();
        $refereeService = new RefereeService();
        $messageService = new MessageService();
        // 查询比赛信息
        $matchInfo = $matchService->getMatch(['id' => $post['match_id']]);
        if (!$matchInfo) {
            return json(['code' => 100, 'msg' => __lang('MSG_404') . '，请选择其他比赛']);
        }
        if ($matchInfo['is_finished_num'] == 1) {
            return json(['code' => 100, 'msg' => '此比赛' . $matchInfo['is_finished'] . '，请选择其他比赛']);
        }
        // 查询比赛战绩信息
        $matchRecordInfo = $matchService->getMatchRecord(['id' => $post['match_record_id']]);
        $matchInfo['record'] = $matchRecordInfo;
        // 判断比赛是否有裁判信息，没有当做不需要裁判
        if (empty($matchRecordInfo['referee1']) && empty($matchRecordInfo['referee2']) && empty($matchRecordInfo['referee3'])) {
            return json(['code' => 100, 'msg' => '此比赛不需要裁判，请选择其他比赛']);
        }
        // 获取裁判员信息
        $refereeInfo = $refereeService->getRefereeInfo(['id' => $post['referee_id']]);
        if (!$refereeInfo || $refereeInfo['status_num'] != 1) {
            return json(['code' => 100, 'msg' => '请先注册成为正式裁判员']);
        }

        // 查询裁判执裁比赛(match_referee) 有无裁判-比赛数据，有数据就不需操作了
        $matchRefereeInfo = $matchService->getMatchReferee([
            'match_id' => $matchInfo['id'],
            'match_record_id' => $matchInfo['record']['id'],
            'referee_id' => $refereeInfo['id'],
            'status' => 1
        ]);
        if ($matchRefereeInfo) {
            return json(['code' => 100, 'msg' => '您已是此比赛的裁判员，无需再次操作']);
        }

        // 保存裁判申请执裁比赛数据
        $data = [
            'apply_type' => 1,
            'match_id' => $matchInfo['id'],
            'match' => $matchInfo['name'],
            'match_record_id' => $matchInfo['record']['id'],
            'team_id' => $matchInfo['team_id'],
            'team' => $matchInfo['team'],
            'referee_id' => $refereeInfo['id'],
            'referee' => $refereeInfo['referee'],
            'referee_avatar' => $refereeInfo['portraits'],
            'referee_cost' => $refereeInfo['appearance_fee'],
            'member_id' => $this->memberInfo['id'],
            'member' => $this->memberInfo['member'],
            'member_avatar' => $this->memberInfo['avatar'],
            'status' => 1
        ];
        // 查询有无申请记录 有则更新数据
        $hasApply = $matchService->getMatchRerfereeApply([
            'apply_type' => 1,
            'match_id' => $matchInfo['id'],
            'match_record_id' => $matchInfo['record']['id'],
            'referee_id' => $refereeInfo['id'],
        ]);
        if ($hasApply) {
            $data['id'] = $hasApply['id'];
        }
        // 保存比赛-裁判申请数据
        try {
            $res = $matchService->saveMatchRerfereeApply($data);
        } catch (Exception $e) {
            return json(['code' => 100, 'msg' => __lang('MSG_400')]);
        }
        if ($res['code'] == 200) {
            $applyId = $hasApply ? $hasApply['id'] : $res['data'];
            // 发送消息给比赛创建人
            $messageData = [
                'title' => '您好，裁判员' . $refereeInfo['referee'] . '申请执裁' .  $matchInfo['name'] . '比赛',
                'content' => '您好，裁判员' . $refereeInfo['referee'] . '申请执裁' .  $matchInfo['name'] . '比赛',
                'keyword1' => '裁判员申请执裁比赛',
                'keyword2' => $refereeInfo['referee'],
                'keyword3' =>  date('Y年m月d日 H:i', time()),
                'url' => url('keeper/team/matchrefereeapply', ['apply_id' => $applyId, 'team_id' => $matchInfo['team_id']], '', true),
                'remark' => '点击查看',
                'steward_type' => 2
            ];
            $messageService->sendMessageToMember($matchInfo['member_id'], $messageData, config('wxTemplateID.checkPend'),3600);

            // 匹配比赛裁判价格与裁判出场费符合的数据字段位置
            $updateMatchRecordData = [];
            if ($matchRecordInfo['referee1']['referee_cost'] == $refereeInfo['appearance_fee']) {
                $updateMatchRecordData['referee1'] = json_encode([
                    'referee' => $refereeInfo['referee'],
                    'referee_id' => $refereeInfo['id'],
                    'referee_cost' => $refereeInfo['appearance_fee']
                ], JSON_UNESCAPED_UNICODE);
            } elseif ($matchRecordInfo['referee2']['referee_cost'] == $refereeInfo['appearance_fee']) {
                $updateMatchRecordData['referee2'] = json_encode([
                    'referee' => $refereeInfo['referee'],
                    'referee_id' => $refereeInfo['id'],
                    'referee_cost' => $refereeInfo['appearance_fee']
                ], JSON_UNESCAPED_UNICODE);
            } elseif ($matchRecordInfo['referee3']['referee_cost'] == $refereeInfo['appearance_fee']) {
                $updateMatchRecordData['referee3'] =  json_encode([
                    'referee' => $refereeInfo['referee'],
                    'referee_id' => $refereeInfo['id'],
                    'referee_cost' => $refereeInfo['appearance_fee']
                ], JSON_UNESCAPED_UNICODE);
            }
            if (!empty( $updateMatchRecordData )) {
                $updateMatchRecordData['id'] = $matchInfo['record']['id'];
                $matchService->saveMatchRecord($updateMatchRecordData);
            }
        }
        return json($res);
    }

    // 回复裁判申请比赛
    public function replymatchapply() {
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
            // 验证会员登录
            if ($this->memberInfo['id'] ===0 ) {
                return json(['code' => 100, 'msg' => '请先登录或注册会员']);
            }
            $matchS = new MatchService();
            // 查询申请数据
            $applyInfo = $matchS->getMatchRerfereeApply(['id' => $applyId]);
            if (!$applyInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404')]);
            }
            // 获取比赛信息
            $matchInfo = $matchS->getMatch(['id' => $applyInfo['match_id']]);
            if (!$matchInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404').'比赛信息不存在']);
            }
            // 获取申请数据裁判信息
            $refereeInfo = $this->refereeService->getRefereeInfo(['id' => $applyInfo['referee_id']]);

            // 更新邀请数据
            $resSaveApply = $matchS->saveMatchRerfereeApply([
                'id' => $applyInfo['id'],
                'status' => $status,
                'reply' => $reply
            ]);
            if ($resSaveApply['code'] == 100) {
                return json($resSaveApply);
            }
            $replyStr = '';
            if (!empty($reply)) {
                $replyStr = '对方回复：'.$reply;
            }
            $messageService = new MessageService();

            // 查询有无原数据 有则更新数据
            $matchReferee = $matchS->getMatchReferee([
                'match_id' => $applyInfo['match_id'],
                'match_record_id' => $applyInfo['match_record_id'],
                'referee_id' => $refereeInfo['id']
            ]);
            if ($status == 2) {
                //同意
                // 组合最新的比赛referee_str字段：将裁判员信息插入
                //$matchS->setMatchRefereeStr($matchInfo, $refereeInfo, 1);

                // 保存比赛-裁判关系
                $dataMatchReferee = [
                    'match_id' => $applyInfo['match_id'],
                    'match' => $applyInfo['match']['name'],
                    'match_record_id' => $applyInfo['match_record_id'],
                    'referee_id' => $refereeInfo['id'],
                    'referee' => $refereeInfo['referee'],
                    'member_id' => $refereeInfo['member_id'],
                    'member' => $refereeInfo['member']['member'],
                    'referee_type' => 1,
                    'appearance_fee' => $refereeInfo['appearance_fee'],
                ];
                if ($matchReferee) {
                    $dataMatchReferee['id'] = $matchReferee['id'];
                }
                $matchS->saveMatchReferee($dataMatchReferee);

                // 发送通知给邀请人
                $wxTemplateID = config('wxTemplateID.refereeTask');
                $messageData = [
                    'title' => '您好，您的"'. $applyInfo['match']['name'] .'" 执裁比赛申请已被同意。',
                    'content' => '您好，您的"'. $applyInfo['match']['name'] .'" 执裁比赛申请已被同意。'.$replyStr,
                    'keyword1' => $matchInfo['match_time'],
                    'keyword2' => $matchInfo['court'],
                    'remark' => '点击查看更多',
                    'steward_type' => 2,
                    'url' => url('keeper/team/matchInfo', ['match_id' => $applyInfo['match_id']], '', true)
                ];
            } else {
                // 拒绝
                if ($matchReferee) {
                    $matchS->saveMatchReferee([
                        'id' => $matchReferee['id'],
                        'status' => -1
                    ]);
                }
                // 发送通知给邀请人
                $wxTemplateID = config('wxTemplateID.applyResult');
                $messageData = [
                    'title' => '您好，您的"'. $applyInfo['match']['name'] .'" 执裁比赛申请已被拒绝。',
                    'content' => '您好，您的"'. $applyInfo['match']['name'] .'" 执裁比赛申请已被拒绝。'.$replyStr,
                    'keyword1' => '执裁比赛申请',
                    'keyword2' => '被拒绝',
                    'remark' => '点击查看更多',
                    'steward_type' => 2,
                    'url' => url('keeper/team/matchInfo', ['match_id' => $applyInfo['match_id']], '', true)
                ];
            }
            // 发送通知给邀请人
            $messageService->sendMessageToMember($applyInfo['member_id'], $messageData, $wxTemplateID,3600);

            return json($resSaveApply);
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
            // 验证会员登录
            if ($this->memberInfo['id'] ===0 ) {
                return json(['code' => 100, 'msg' => '请先登录或注册会员']);
            }
            $matchS = new MatchService();
            // 查询邀请数据
            $applyInfo = $matchS->getMatchRerfereeApply(['id' => $applyId]);
            if (!$applyInfo) {
                return json(['code' => 100, 'msg' => __lang('MSG_404')]);
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
            $resSaveApply = $matchS->saveMatchRerfereeApply([
                'id' => $applyInfo['id'],
                'status' => $status,
                'reply' => $reply
            ]);
            if ($resSaveApply['code'] == 100) {
                return json($resSaveApply);
            }
            $replyStr = '';
            if (!empty($reply)) {
                $replyStr = '对方回复：'.$reply;
            }
            $messageService = new MessageService();
            // 查询有无原数据 有则更新数据
            $matchReferee = $matchS->getMatchReferee([
                'match_id' => $applyInfo['match_id'],
                'match_record_id' => $applyInfo['match_record_id'],
                'referee_id' => $refereeInfo['id']
            ]);
            if ($status == 2) {
                //同意
                // 保存比赛-裁判关系
                $dataMatchReferee = [
                    'match_id' => $applyInfo['match_id'],
                    'match' => $applyInfo['match']['name'],
                    'match_record_id' => $applyInfo['match_record_id'],
                    'referee_id' => $refereeInfo['id'],
                    'referee' => $refereeInfo['referee'],
                    'referee_avatar' => $refereeInfo['portraits'],
                    'member_id' => $refereeInfo['member_id'],
                    'member' => $refereeInfo['member']['member'],
                    'referee_type' => 1,
                    'appearance_fee' => $refereeInfo['appearance_fee'],
                ];

                if ($matchReferee) {
                    $dataMatchReferee['id'] = $matchReferee['id'];
                }
                $matchS->saveMatchReferee($dataMatchReferee);

                // 发送通知给邀请人
                $wxTemplateID = config('wxTemplateID.receviceInvitaion');
                $messageData = [
                    'title' => '裁判'. $applyInfo['referee'] . '接受比赛' . $applyInfo['match']['name'] . '执裁邀请',
                    'content' => '裁判'. $applyInfo['referee'] . '接受比赛' . $applyInfo['match']['name'] . '执裁邀请' . $replyStr,
                    'keyword1' => $applyInfo['referee'],
                    'keyword2' => date('Y年m月d日 H:i', time()),
                    'remark' => '点击查看更多',
                    'steward_type' => 2,
                    'url' => url('keeper/team/matchInfo', ['match_id' => $applyInfo['match_id'], 'team_id' => $applyInfo['match']['team_id']], '', true)
                ];
            } else {
                // 拒绝
                if ($matchReferee) {
                    $matchS->saveMatchReferee([
                        'id' => $matchReferee['id'],
                        'status' => -1
                    ]);
                }
                // 发送通知给邀请人
                $wxTemplateID = config('wxTemplateID.refuseInvitaion');
                $messageData = [
                    'title' => '裁判'. $applyInfo['referee'] . '拒绝比赛' . $applyInfo['match']['name'] . '执裁邀请',
                    'content' => '裁判'. $applyInfo['referee'] . '拒绝比赛' . $applyInfo['match']['name'] . '执裁邀请' . $replyStr,
                    'keyword1' => $applyInfo['referee'],
                    'keyword2' => empty($reply) ? '拒绝邀请' : $reply,
                    'keyword3' => date('Y年m月d日 H:i', time()),
                    'remark' => '点击查看更多',
                    'steward_type' => 2,
                    'url' => url('keeper/team/matchInfo', ['match_id' => $applyInfo['match_id'], 'team_id' => $applyInfo['match']['team_id']], '', true)
                ];
            }
            // 发送通知给邀请人
            $messageService->sendMessageToMember($applyInfo['member_id'], $messageData, $wxTemplateID, 3600);

            return json($resSaveApply);
        } catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 裁判执裁比赛列表（分页）
    public function getmatchrefereepage(){
        try{
            $map = input('param.');

           /* 无传入referee_id 根据当前会员查询裁判员信息
            $refereeId = input('param.referee_id');
            if (!$refereeId) {
                $refereeInfo = $this->refereeService->getRefereeInfo(['member_id' => $this->memberInfo['id']]);
            } else {
                // 查询裁判员数据
                $refereeInfo = $this->refereeService->getRefereeInfo(['id' => $refereeId]);
            }
            if ($refereeInfo) {
                $map['referee_id'] = $refereeInfo['id'];
            }*/

            if (input('page')) {
                unset($map['page']);
            }

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

    // 裁判执裁比赛列表（分页）
    public function getmatchrefereelist(){
        try{
            $map = input('param.');
            $page = input('page', 1);

            /*无传入referee_id 根据当前会员查询裁判员信息
            $refereeId = input('param.referee_id');
            if (!$refereeId) {
                $refereeInfo = $this->refereeService->getRefereeInfo(['member_id' => $this->memberInfo['id']]);
            } else {
                // 查询裁判员数据
                $refereeInfo = $this->refereeService->getRefereeInfo(['id' => $refereeId]);
            }
            if ($refereeInfo) {
                $map['referee_id'] = $refereeInfo['id'];
            }*/

            if (input('page')) {
                unset($map['page']);
            }

            $matchS = new MatchService();
            $result = $matchS->getMatchRefereeList($map, $page);
            if($result){
                return json(['code'=>200,'msg'=> __lang('MSG_201'),'data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=> __lang('MSG_000')]);
            }
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 裁判最近比赛关系列表
    public function refereelastmatch() {
        // 裁判-比赛申请|邀请+比赛裁判关联，未完成的比赛先列出
        try {
            $map = input('param.');
            $page = input('page', 1);
            $size = input('size', 10);

            // 查询条件组合
            // 默认查询比赛-裁判申请|邀请 status>0的数据
            $map['match_referee_apply.status'] = ['gt', 0];

            if (input('page')) {
                unset($map['page']);
            }
            $matchService = new MatchService();
            // 视图查询 裁判比赛申请|邀请与比赛信息，以比赛（match）表is_finished（比赛完成状态）升序排序，将未完成比赛先列出
            $list = Db::view('match_referee_apply')
                ->view('match', ['id' => 'match_id', 'name' => 'match'], 'match.id=match_referee_apply.match_id', 'left')
                ->where($map)
                ->whereNull('match_referee_apply.delete_time')
                ->whereNull('match.delete_time')
                ->order([
                    'match.is_finished' => 'asc',
                    'match.id' => 'desc'
                ])
                ->page($page)
                ->limit($size)
                ->select();

            if ($list) {
                foreach ($list as $k => $val) {
                    // 遍历查询比赛信息详细数据
                    $match = $matchService->getMatch(['id' => $val['match_id']]);
                    if ($match) {
                        $list[$k]['match'] = $match;
                    }
                    // 遍历查询比赛战绩详细数据
                    $matchRecord = $matchService->getMatchRecord(['id' => $val['match_record_id'], 'match_id' => $val['match_id']]);
                    if ($matchRecord) {
                        $list[$k]['record'] = $matchRecord;
                    }
                }
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $list];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_000')];
            }

            return json($response);
        } catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}