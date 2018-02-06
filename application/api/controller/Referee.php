<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\RefereeService;

class Referee extends Base{
	protected $RefereeService;
	public function _initialize(){
		parent::_initialize();
		$this->RefereeService = new RefereeService;

	}

    // 搜索教练
    public function searchRefereeListApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            $referee_province = input('param.referee_province');
            $referee_city = input('param.referee_city');
            $referee_area = input('param.referee_area');
            $page = input('param.page')?input('param.page'):1;
            $map['referee_province']=$referee_province;
            $map['referee_city']=$referee_city;
            $map['referee_area']=$referee_area;
            foreach ($map as $key => $value) {
                if($value == ''|| empty($value) || $value==' '){
                    unset($map[$key]);
                }
            }
            if(!empty($sex)&&$sex!=''){
                $map['sex'] = $sex;
            }
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['referee'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if( isset($map['page']) ){
                unset($map['page']);
            }
            $refereeList = $this->RefereeService->getRefereeList($map,$page);
            if($refereeList){
                return json(['code'=>200,'msg'=>'OK','data'=>$refereeList]);
            }else{
                return json(['code'=>100,'msg'=>'OK','data'=>'']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 获取教练分页(有页码)
    public function getRefereeListByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            $referee_province = input('param.referee_province');
            $referee_city = input('param.referee_city');
            $referee_area = input('param.referee_area');
            $sex = input('param.sex');
            $map['referee_province']=$referee_province;
            $map['referee_city']=$referee_city;
            $map['referee_area']=$referee_area;
            foreach ($map as $key => $value) {
                if($value == ''|| empty($value) || $value==' '){
                    unset($map[$key]);
                }
            }
            if(!empty($sex)&&$sex!=''){
                $map['sex'] = $sex;
            }
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['referee'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if( isset($map['page']) ){
                unset($map['page']);
            }
            $refereeList = $this->RefereeService->getRefereeListByPage($map);
            if($refereeList){
                return json(['code'=>200,'msg'=>'OK','data'=>$refereeList]);
            }else{
                return json(['code'=>100,'msg'=>'OK','data'=>'']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    //获取教练列表（没分页、没查询）
    public function getRefereeListApi(){
        try{
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1;
            $result = $this->RefereeService->getRefereeList($map,$page);
             if($result){
               return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'ok']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function createRefereeApi(){
        try{
            $referee = input('post.realname');
            $member_id = $this->memberInfo['id'];
            // 教练数据
            $refereedata = [
                'referee'  => $referee,
                'realname' => input('post.realname'),
                'member_id' => $member_id,
                'referee_year' => input('post.referee_year'),
                'experience' => input('post.experience'),
                'introduction' => input('post.introduction'),
                'portraits' => input('post.portraits'),
                'description' => input('post.description')
            ];
            // 地区input 拆分成省 市 区 3个字段
            $locationStr = input('post.locationStr');
            if ($locationStr) {
                $locationArr = explode('|', $locationStr);
                $refereedata['referee_province'] = $locationArr[0];
                $refereedata['referee_city'] = $locationArr[1];
                $refereedata['referee_area'] = $locationArr[2];
            }
            $refereeS = new RefereeService();
            $result = $refereeS->createReferee($refereedata);

            if($result['code'] == 200 ){
                $certS = new \app\service\CertService();
                
                
                
                // 资质证书
                $certdata = [
                    'camp_id' => 0,
                    'member_id' => $member_id,
                    'cert_no' => 0,
                    'cert_type' => 5,
                    'photo_positive' => input('post.cert')
                ];
              
                
                $cert2 = $certS->saveCert($certdata);
                if ($cert1['code'] == 100) {
                    return json([ 'msg' => '裁判证件信息保存出错,请重试', 'code' => 100]);
                }

                if($input('post.idno')){
                    // 实名数据
                    $realnamedata = [
                        'camp_id' => 0,
                        'member_id' => $member_id,
                        'cert_no' => input('post.idno'),
                        'cert_type' => 1,
                        'photo_positive' => input('post.photo_positive'),
                        'photo_back' => input('post.photo_back'),
                    ];
                    $cert1 = $certS->saveCert($realnamedata);
                    if ($cert2['code'] == 100) {
                        return json([ 'msg' => '身份证证件信息保存出错,请重试', 'code' => 100]);
                    }
                }
                
            }
            
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function updateRefereeApi(){
        try{
            $referee_id = input('post.refereeid') ? input('post.refereeid') : input('param.referee_id');
            if(!$referee_id){
                return ['code'=>100,'msg'=>'找不到教练信息'];
            }

            $member_id = input('post.member_id');
            // 教练数据
            $refereedata = [
                'referee' => input('post.referee'),
                'member_id' => $member_id,
                'referee_year' => input('post.referee_year'),
                'experience' => input('post.experience'),
                'introduction' => input('post.introduction'),
                'portraits' => input('post.portraits'),
                'description' => input('post.description')
            ];
            // 地区input 拆分成省 市 区 3个字段
            $locationStr = input('post.locationStr');
            if ($locationStr) {
                $locationArr = explode('|', $locationStr);
                $refereedata['referee_province'] = $locationArr[0];
                $refereedata['referee_city'] = $locationArr[1];
                $refereedata['referee_area'] = $locationArr[2];
            }
            $refereeS = new RefereeService();
            $referee = $refereeS->updateReferee($refereedata, $referee_id);

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

            return json($referee);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 用户是否拥有教练身份
    public function isReferee(){
        try{
            $member_id = input('param.member_id')? input('param.member_id'):$this->memberInfo['id'];
            $result = $this->RefereeService->getRefereeInfo(['member_id'=>$member_id,'status'=>1]);
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
    public function createRefereeCommentApi(){
        try{
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['avatar'] = $this->memberInfo['avatar'];
            $result = $this->RefereeService->createRefereeComment($data);
            return json($result);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 获取教练所在班级列表（包括主教、助教）
    public function getRefereeGradeList() {
        try {
            // 接收参数referee_id
            $referee_id = input('referee_id');
            if (!$referee_id) {
                return json(['code' => 100, 'msg' => __lang('MSG_402').'需要教练信息']);
            }
            // 查询教练所在班级
            $refereeS = new RefereeService();
            $res = $refereeS->ingradelistPage($referee_id);
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