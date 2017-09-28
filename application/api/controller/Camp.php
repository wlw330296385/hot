<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\CampService;
use app\service\CertService;

class Camp extends Base{
    protected $CampService;
	public function _initialize(){
        $this->CampService = new CampService;
		parent::_initialize();
	}

    // 搜索训练营
    public function searchCampApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            $province = input('param.province');
            $page = input('param.page')?input('param.page'):1;
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
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['camp'] = ['LIKE','%'.$keyword.'%'];
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if( isset($map['page']) ){
                unset($map['page']);
            }
            $campList = $this->CampService->getCampList($map,$page);
            return json(['code'=>200,'msg'=>'OK','data'=>$campList]);
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }       
    }

    // 搜索训练营
    public function searchCampApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            $province = input('param.province');
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
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['camp'] = ['LIKE','%'.$keyword.'%'];
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if( isset($map['page']) ){
                unset($map['page']);
            }
            $campList = $this->CampService->getCampListByPage($map);
            return json(['code'=>200,'msg'=>'OK','data'=>$campList]);
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }       
    }

    public function getCampListApi(){
        try{
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1;
            $campList = $this->CampService->getCampList($map,$page);

            return json(['code'=>200,'msg'=>'OK','data'=>$campList]);

        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }  
    }


    public function updateCamp(){
        try{
            /* $data = input('post.');
            $id = input('get.camp_id');
            $result = $this->CampService->updateCamp($data,$id);
            return json($result);*/
            //dump(input('post.'));
            $campid = input('post.camp_id') ? input('post.camp_id') : input('param.camp_id');
            // 训练营信息
            $campData = [
                'id' => $campid,
                'logo' => input('post.logo'),
                'banner' => input('post.banner'),
                'company' => input('post.company'),
                'location' => input('post.location'),
                'camp_introduction' => input('post.intro')
            ];

            // 地区input 拆分成省 市 区 3个字段
            $locationStr = input('post.locationStr');
            if ($locationStr) {
                $locationArr = explode('|', $locationStr);
                $campData['province'] = $locationArr[0];
                $campData['city'] = $locationArr[1];
                $campData['area'] = $locationArr[2];
            }

            //dump($data);
            $campS = new CampService();
            return $campS->updateCamp($campData);
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function updatecampcert() {
        $campid = input('post.camp_id') ? input('post.camp_id') : input('param.camp_id');
        // 证书信息
        $certS = new CertService();
        // 营业执照
        if ( input('?post.cert') ) {
            $cert1 = $certS->saveCert([ 'camp_id' => $campid, 'member_id' => 0, 'cert_type' => 4, 'photo_positive' => input('post.cert')]);
            if ($cert1['code'] != 200) {
                return ['code' => 100, 'msg' => '营业执照保存失败,请重试'];
            }
        }
        // 法人
        if ( input('?post.fr_idno') || input('?post.fr_idcard') ) {
            $cert2 = $certS->saveCert([ 'camp_id' => $campid, 'member_id' => 0, 'cert_type' => 1,
                'cert_no' => input('post.fr_idno'), 'photo_positive' => input('post.fr_idcard')]);
            if ($cert2['code'] != 200) {
                return ['code' => 100, 'msg' => '法人信息保存失败,请重试'];
            }
        }
        // 创建人
        if ( input('?post.cjz_idno') || input('?post.cjz_idcard') ) {
            $cert3 = $certS->saveCert([ 'camp_id' => $campid, 'member_id' => $this->memberInfo['id'], 'cert_type' => 1,
                'cert_no' => input('post.cjz_idno'), 'photo_positive' => input('post.cjz_idcard') ]);
            if ($cert3['code'] != 200) {
                return ['code' => 100, 'msg' => '创建人信息保存失败'];
            }
        }
        // 其他证明
        if ( input('?post.other_cert') ) {
            $cert4 = $certS->saveCert([ 'camp_id' => $campid, 'member_id' => 0, 'cert_type' => 0, 'photo_positive' => input('post.other_cert')]);
            if ($cert4['code'] != 200) {
                return ['code' => 100, 'msg' => '其他证明保存失败'];
            }
        }

        db('camp')->where('id', $campid)->setField('status', 0);

        return ['code' => 200, 'msg' => __lang('MSG_200')];
    }

    public function createCamp(){
        try{
            $telephone = input('post.camp_telephone') ? input('post.camp_telephone') : $this->memberInfo['telephone'];
            $data = [
                'camp' => input('post.campname'),
                'member_id' => $this->memberInfo['id'],
                'type' => input('post.camptype'),
                'realname' => input('post.creator'),
                'camp_telephone' => $telephone
            ];
            $campS = new CampService();
            return $campS->createCamp($data);
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    } 

    // 是否以创建训练营
    public function isCreateCampApi(){
        try{ 
            $member_id = input('member_id')?input('member_id'):$this->memberInfo['id'];
            $result = $this->CampService->hasCreateCamp($member_id);
            if($result){
                return json(['code'=>200,'msg'=>'已有训练营','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'没有训练营','data'=>'']);
            }
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 训练营评论
    public function createCampCommentApi(){
        try{ 
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['avatar'] = $this->memberInfo['avatar'];

            $result = $this->CampService->createCampComment($data);
            return json($result);
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 获取评论列表
    public function getCampCommentListByPage(){
        try{ 
            $map = input('post.');
            $result = $this->CampService->getCampCommentListByPage($map);
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'传参错误']);
            }
        }catch(Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}
