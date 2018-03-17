<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\CampService;
use app\service\RecruitmentService;
use app\service\GradeService;
use think\Exception;

class Recruitment extends Base{
	protected $RecruitmentService;
	protected $GradeService;
	public function _initialize(){
		$this->RecruitmentService = new RecruitmentService;
		$this->GradeService = new GradeService;
		parent::_initialize();
	}

    public function index() {
    	
       
    }

    // 搜索招募
    public function searchRecruitmentApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            $province = input('param.province');
            $page = input('param.page')?input('param.page'):1;
            $order = input('param.order','id desc');
            $city = input('param.city');
            $area = input('param.area');
            $map['province']=$province;
            $map['city']=$city;
            $map['area']=$area;
            foreach ($map as $key => $value) {
                if($value == ''|| empty($value) || $value==' '){
                    unset($map[$key]);
                }
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['recruitment'] = ['LIKE','%'.$keyword.'%'];
            }

            if( isset($map['order']) ){
                unset($map['order']);
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if( isset($map['page']) ){
                unset($map['page']);
            }
            $result = $this->RecruitmentService->getRecruitmentList($map,$page,$order);
            if($result){
               return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'ok']);
            }
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }       
    }

    // 搜索招募
    public function getRecruitmentListByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            $order = input('param.order','id desc');
            if( isset($map['order']) ){
                unset($map['order']);
            }
            foreach ($map as $key => $value) {
                if($value == ''|| empty($value) || $value==' '){
                    unset($map[$key]);
                }
            }
            if( isset($map['order']) ){
                unset($map['order']);
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['recruitment'] = ['LIKE','%'.$keyword.'%'];
            }
            $result = $this->RecruitmentService->getRecruitmentListByPage($map,$order);
            if($result){
               return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'ok']);
            }
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }       
    }
    
    //翻页获取招募接口
    public function getRecruitmentListApi(){
        try{
            $map = input('post.');
            $page = input('param.page', 1);
            $order = input('param.order','id desc');
            if( isset($map['order']) ){
                unset($map['order']);
            }
            $result =  $this->getRecruitmentList($map, $page,$order);
            if($result){
               return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'ok']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
		    	
    }

    //编辑|添加招募接口
    public function updateRecruitmentApi(){
        try{
            $recruitment_id = input('param.recruitment_id');
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            if(isset($data['address'])){
                $address = explode(' ', $data['address']);
                $data['province'] = $address[0];
                $data['city'] = $address[1];
                if($address[2]){
                    $data['area'] = $address[2];
                }else{
                    $data['area'] = $address[1];
                }             
            }
            if(isset($data['deadlines'])){
                $data['deadline'] = strtotime($data['deadlines'])+86399;
            }
            if($recruitment_id){
                $result = $this->RecruitmentService->updateRecruitment($data,$recruitment_id);
            }else{
                $result = $this->RecruitmentService->createRecruitment($data);
            }

            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    	
    }

    


    // 审核招募
    public function checkRecruitmentApi(){
        try{
            $organization_id = input('param.organization_id');
            if(!$organization_id){
                return json(['code'=>100,'msg'=>'organization_id未传参']);
            }
            $isPower = $this->RecruitmentService->isPower($organization_id,$memberInfo['id']);

            if($isPower>2){
                $recruitment_id = input('post.recruitment_id');
                $status = input('post.status');
                $result = db('recruitment')->save(['status'=>$status],$recruitment_id);
                if($result){
                    return json(['code'=>200,'msg'=>__lang('MSG_200')]);
                }else{
                    return json(['code'=>100,'msg'=>__lang('MSG_400')]);
                } 
            }else{
                return json(['code'=>100,'msg'=>__lang('MSG_403')]);
            }
            
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }



    // 参加招募
    public function joinRecruitmentApi(){
        try{
            $recruitment_id = input('param.recruitment_id');
            $data = input('post.');
            $data['member'] = $this->memberInfo['member'];
            $data['member_id'] = $this->memberInfo['id'];
            $res = $this->RecruitmentService->joinRecruitment($recruitment_id,$data);
            
            return json($res);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 获取响应人名单
    public function getRecruitmentMemberListNoPageApi(){
        try{
            $map = input('post.');
            $result = $this->RecruitmentService->getRecruitmentMemberListNoPage($map);
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 获取响应人名单page
    public function getRecruitmentMemberListByPageApi(){
        try{
            $map = input('post.');
            $result = $this->RecruitmentService->getRecruitmentMemberListByPage($map);
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 审核招募人员
    public function checkRecruitmentMemberApi(){
        try{
            
            $organization_id = input('param.organization_id');
            $member_id = input('param.member_id');
            $result = $this->RecruitmentService->checkRecruitmentMember($map);
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            } 
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }

    }

    // 2017-11-21 招募操作状态/软删除
    public function removerecruitment() {
        try {
            // 接收参数，检查参数是否符合
            $recruitment_id = input('recruitmentid');
            $action = input('action');
            if (!$recruitment_id || !$action) {
                return json(['code' => 100, 'msg' => __lang('MSG_402')]);
            }
            // 查询招募数据，不存在活动数据抛出提示
            $recruitmentS = new RecruitmentService();
            $recruitment = $recruitmentS->getRecruitmentInfo(['id' => $recruitment_id]);
            if (!$recruitment) {
                return json(['code' => 100, 'msg' => '招募'.__lang('MSG_401')]);
            }
            // 判断可操作会员身份 教练及以上才能操作
            $power = getCampPower($recruitment['organization_id'], $this->memberInfo['id']);
            if ($power < 2) {
                return json(['code' => 100, 'msg' => __lang('MSG_403')]);
            }
            // 根据活动当前状态(1上架,2下架)+不允许操作条件
            // 根据action参数 editstatus执行上下架/del删除操作
            // 更新数据 返回结果
            switch ( $recruitment['status_num'] ) {
                case 1 : {
                    if ($action == 'editstatus') {
                        $result = $recruitmentS->updateRecruitmentField($recruitment['id'], 'status', 2);
                        if (!$result) {
                            $response = ['code' => 100, 'msg' => __lang('MSG_400')];
                        } else {
                            $response = ['code' => 200, 'msg' => __lang('MSG_200')];
                        }
                    } else {
                        $result = $recruitmentS->softDeleteRecruitment($recruitment['id']);
                        if (!$result) {
                            $response = ['code' => 100, 'msg' => __lang('MSG_400')];
                        } else {
                            $response = ['code' => 200, 'msg' => __lang('MSG_200')];
                        }
                    }
                    return json($response);
                    break;
                }
                case 2 : {
                    if ($action == 'editstatus') {
                        $result = $recruitmentS->updateRecruitmentField($recruitment['id'], 'status', 1);
                        if (!$result) {
                            $response = ['code' => 100, 'msg' => __lang('MSG_400')];
                        } else {
                            $response = ['code' => 200, 'msg' => __lang('MSG_200')];
                        }
                    } else {
                        $result = $recruitmentS->softDeleteRecruitment($recruitment['id']);
                        if (!$result) {
                            $response = ['code' => 100, 'msg' => __lang('MSG_400')];
                        } else {
                            $response = ['code' => 200, 'msg' => __lang('MSG_200')];
                        }
                    }
                    return json($response);
                    break;
                }
            }
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}