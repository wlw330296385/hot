<?php

namespace app\service;

use app\model\CampBankcard;
use think\Db;
use app\common\validate\CampBankcardVal;
class CampBankcardService {
    private $CampBankcardModel;
    private $CampBankcardMemberModel;
    public function __construct(){
        $this->CampBankcardModel = new CampBankcard;
    }



 

    // 软删除
    public function SoftDeleteCampBankcard($id) {
        $result = $this->CampBankcardModel->destroy($id);
        if (!$result) {
            return [ 'msg' => __lang('MSG_400'), 'code' => 100 ];
        } else {
            return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }
    }

    // 获取一个银行卡
    public function getCampBankcardInfo($map) {
        $result = $this->CampBankcardModel->where($map)->find();
        
        return $result;
        
    }




    // 编辑银行卡
    public function updateCampBankcard($data,$map){
        
        $validate = validate('CampBankcardVal');
        if(!$validate->scene('edit')->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        
        $result = $this->CampBankcardModel->allowField(true)->save($data,$map);
        if($result){
            return ['msg' => '操作成功', 'code' => 200];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }

    // 新增银行卡
    public function createCampBankcard($data){
        $bankcardInfo = $this->getCampBankcardInfo(['camp_id'=>$data['camp_id']]);
        if($bankcardInfo){
            return ['msg'=>'已有账户,不允许重复添加', 'code' => 100];
        }
        $data['status'] = 1;
        $validate = validate('CampBankcardVal');
        if(!$validate->scene('add')->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        $result = $this->CampBankcardModel->allowField(true)->save($data);
        if($result){
            return ['msg' => '操作成功', 'code' => 200, 'data' => $this->CampBankcardModel->id];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }


    public function isPower($camp_id,$member_id){
        $is_power = db('camp_member')
                    ->where([
                        'camp_id'   =>$camp_id,
                        'status'    =>1,
                        'member_id'  =>$member_id,
                        ])
                    ->value('type');

        return $is_power?$is_power:0;
    }



}

