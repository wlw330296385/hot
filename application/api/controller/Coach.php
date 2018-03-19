<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\CoachService;
use app\service\CertService;
use think\Exception;

class Coach extends Base{
	protected $CoachService;
	public function _initialize(){
		parent::_initialize();
		$this->CoachService = new CoachService;

	}

    // 搜索教练
    public function searchCoachListApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            $province = input('param.province');
            $page = input('param.page')?input('param.page'):1;
            $city = input('param.city');
            $area = input('param.area');
            $sex = input('param.sex');
            $orderby = input('param.orderby','id desc');
            $map['province']=$province;
            $map['city']=$city;
            $map['area']=$area;
            foreach ($map as $key => $value) {
                if($value == ''|| empty($value) || $value==' '){
                    unset($map[$key]);
                }
            }
            if(!empty($sex)&&$sex!=''){
                $map['sex'] = $sex;
            }
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['coach'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if( isset($map['page']) ){
                unset($map['page']);
            }
            if( isset($map['page']) ){
                unset($map['page']);
            }
            if( isset($map['orderby']) ){
                unset($map['orderby']);
            }
            $coachList = $this->CoachService->getCoachList($map,$page,$orderby);
            if($coachList){
                return json(['code'=>200,'msg'=>'OK','data'=>$coachList]);
            }else{
                return json(['code'=>100,'msg'=>'OK','data'=>'']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 搜索全部教练(一页全部)
    public function searchCoachListAllApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            $province = input('param.province');
            $page = input('param.page')?input('param.page'):1;
            $city = input('param.city');
            $area = input('param.area');
            $sex = input('param.sex');
            $orderby = input('param.orderby','id desc');
            $map['province']=$province;
            $map['city']=$city;
            $map['area']=$area;
            foreach ($map as $key => $value) {
                if($value == ''|| empty($value) || $value==' '){
                    unset($map[$key]);
                }
            }
            if(!empty($sex)&&$sex!=''){
                $map['sex'] = $sex;
            }
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['coach'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if( isset($map['page']) ){
                unset($map['page']);
            }
            if( isset($map['page']) ){
                unset($map['page']);
            }
            if( isset($map['orderby']) ){
                unset($map['orderby']);
            }
            $coachList = db('coach')->where($map)->order($orderby)->select();
            if($coachList){
                return json(['code'=>200,'msg'=>'OK','data'=>$coachList]);
            }else{
                return json(['code'=>100,'msg'=>'OK','data'=>'']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }



    // 获取教练分页(有页码)
    public function getCoachListByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            $province = input('param.province');
            $city = input('param.city');
            $area = input('param.area');
            $sex = input('param.sex');
            $map['province']=$province;
            $map['city']=$city;
            $map['area']=$area;
            foreach ($map as $key => $value) {
                if($value == ''|| empty($value) || $value==' '){
                    unset($map[$key]);
                }
            }
            if(!empty($sex)&&$sex!=''){
                $map['sex'] = $sex;
            }
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['coach'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if( isset($map['page']) ){
                unset($map['page']);
            }
            $coachList = $this->CoachService->getCoachListByPage($map);
            if($coachList){
                return json(['code'=>200,'msg'=>'OK','data'=>$coachList]);
            }else{
                return json(['code'=>100,'msg'=>'OK','data'=>'']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    //获取教练列表（没分页、没查询）
    public function getCoachListApi(){
        try{
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1;
            $result = $this->CoachService->getCoachList($map,$page);
             if($result){
               return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'ok']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function createCoachApi(){
        try{
            $data['coach'] = input('post.coach');
            $data['member_id'] = $this->memberInfo['id'];
            $member_id = input('post.member_id');
            // 教练数据
            $coachdata = [
                'coach' => input('post.coach'),
                'member_id' => $member_id,
                'coach_year' => input('post.coach_year'),
                'experience' => input('post.experience'),
                'introduction' => input('post.introduction'),
                'portraits' => input('post.portraits'),
                'description' => input('post.description'),
                'is_open' => input('post.is_open', 1)
            ];
            // 地区input 拆分成省 市 区 3个字段
            $locationStr = input('post.locationStr');
            if ($locationStr) {
                $locationArr = explode('|', $locationStr);
                $coachdata['province'] = $locationArr[0];
                $coachdata['city'] = $locationArr[1];
                $coachdata['area'] = $locationArr[2];
            }
            $coachS = new CoachService();
            $coach = $coachS->createCoach($coachdata);

            // 实名数据
            $realnamedata = [
                'camp_id' => 0,
                'member_id' => $member_id,
                'cert_no' => input('post.idno'),
                'cert_type' => 1,
                'photo_positive' => input('post.photo_positive'),
                'photo_back' => input('post.photo_back'),
            ];
            // 资质证书
            $certdata = [
                'camp_id' => 0,
                'member_id' => $member_id,
                'cert_no' => 0,
                'cert_type' => 3,
                'photo_positive' => input('post.cert')
            ];

            $certS = new CertService();
            $cert1 = $certS->saveCert($realnamedata);
            $cert2 = $certS->saveCert($certdata);
            if ($cert1['code'] == 100 || $cert2['code'] == 100) {
                return json([ 'msg' => '证件信息保存出错,请重试', 'code' => 100]);
            }
            return $coach;
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function updateCoachApi(){
        try{
            $coach_id = input('post.coachid') ? input('post.coachid') : input('param.coach_id');
            if(!$coach_id){
                return ['code'=>100,'msg'=>'找不到教练信息'];
            }

            $member_id = input('post.member_id');
            // 教练数据
            $coachdata = [
                'coach' => input('post.coach'),
                'member_id' => $member_id,
                'coach_year' => input('post.coach_year'),
                'experience' => input('post.experience'),
                'introduction' => input('post.introduction'),
                'portraits' => input('post.portraits'),
                'description' => input('post.description'),
                'is_open' => input('post.is_open', 1)
            ];
            // 地区input 拆分成省 市 区 3个字段
            $locationStr = input('post.locationStr');
            if ($locationStr) {
                $locationArr = explode('|', $locationStr);
                $coachdata['province'] = $locationArr[0];
                $coachdata['city'] = $locationArr[1];
                $coachdata['area'] = $locationArr[2];
            }
            $coachS = new CoachService();
            $coach = $coachS->updateCoach($coachdata, $coach_id);

            // 实名数据
            $realnamedata = [
                'camp_id' => 0,
                'member_id' => $member_id,
                'cert_no' => input('post.idno'),
                'cert_type' => 1,
                'photo_positive' => input('post.photo_positive'),
                'photo_back' => input('post.photo_back'),
            ];
            // 资质证书
            $certdata = [
                'camp_id' => 0,
                'member_id' => $member_id,
                'cert_no' => "",
                'cert_type' => 3,
                'photo_positive' => input('post.cert')
            ];

            $certS = new CertService();
            $cert1 = $certS->saveCert($realnamedata);
            $cert2 = $certS->saveCert($certdata);
            if ($cert1['code'] == 100 || $cert2['code'] == 100) {
                return json([ 'msg' => '证件信息保存出错,请重试', 'code' => 100]);
            }

            return json($coach);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 用户是否拥有教练身份
    public function isCoach(){
        try{
            $member_id = input('param.member_id')? input('param.member_id'):$this->memberInfo['id'];
            $result = $this->CoachService->getCoachInfo(['member_id'=>$member_id,'status'=>1]);
            if($result){
                return json(['code'=>200,'msg'=>'OK','data'=>$result]);    
            }else{
                return json(['code'=>200,'msg'=>'OK','data'=>'']);    
            }
                
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 评论教练
    public function createCoachCommentApi(){
        try{
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['avatar'] = $this->memberInfo['avatar'];
            $result = $this->CoachService->createCoachComment($data);
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 获取教练所在班级列表（包括主教、助教）
    public function getCoachGradeList() {
        try {
            // 接收参数coach_id
            $coach_id = input('coach_id');
            if (!$coach_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402').'需要教练信息']);
            }
            // 查询教练所在班级
            $coachS = new CoachService();
            $res = $coachS->ingradelistPage($coach_id);
            // 返回结果
            if ($res) {
                $response = ['code' => 200, 'msg' => __lang('MSG_201'), 'data' => $res];
            } else {
                $response = ['code' => 100, 'msg' => __lang('MSG_000')];
            }
            return json($response);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}