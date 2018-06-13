<?php

namespace app\service;

use app\model\CampWithdraw;
use think\Db;
use app\common\validate\CampWithdrawVal;
class CampWithdrawService {
    private $CampWithdrawModel;
    private $CampWithdrawMemberModel;
    public function __construct(){
        $this->CampWithdrawModel = new CampWithdraw;
    }


    // 获取所有提现记录
    public function getCampWithdrawList($map=[],$page = 1,$order='',$paginate = 10) {
        $result = CampWithdraw::where($map)->order($order)->page($page,$paginate)->select();

        
        return $result;
    }

    // 分页获取提现记录
    public function getCampWithdrawListByPage($map=[], $order='',$paginate=10){
        $result = CampWithdraw::where($map)->order($order)->paginate($paginate);
        if($result){
            $res =  $result->toArray();
            return $res;
        }else{
            return $result;
        }
    }

    // 软删除
    public function SoftDeleteCampWithdraw($id) {
        $result = CampWithdraw::destroy($id);
        if (!$result) {
            return [ 'msg' => __lang('MSG_400'), 'code' => 100 ];
        } else {
            return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }
    }

    // 获取一个提现记录
    public function getCampWithdrawInfo($map) {
        $result = CampWithdraw::where($map)->find();
        
        return $result;
        
    }




    // 编辑提现记录
    public function updateCampWithdraw($data,$map){
        
        $validate = validate('CampWithdrawVal');
        if(!$validate->scene('edit')->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        
        $result = $this->CampWithdrawModel->allowField(true)->save($data,$map);
        if($result){
            return ['msg' => '操作成功', 'code' => 200, 'data' => $id];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }

    // 新增提现记录
    public function createCampWithdraw($data){
        Db::rollback();
        $data['status'] = 1;
        $validate = validate('CampWithdrawVal');
        if(!$validate->scene('add')->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        $result = $this->CampWithdrawModel->allowField(true)->save($data);
        if($result){
            $date_str = date('Ymd',time());
            if($data['rebate_type'] == 2){
                $res = db('output')->insert([
                    'output'        => $data['camp_withdraw_fee'],
                    'camp_id'       => $data['camp_id'],
                    'camp'          => $data['camp'],
                    'member_id'     => $data['member_id'],
                    'member'        => $data['member'],
                    'type'          => 4,
                    'e_balance'     =>$data['s_balance'] - $data['camp_withdraw_fee'],
                    's_balance'     =>$data['s_balance'],
                    'f_id'          =>$this->CampWithdrawModel->id,
                    'rebate_type'   =>$data['rebate_type'],
                    'schedule_rebate'   =>$data['schedule_rebate'],
                    'date_str'      =>$date_str,
                    
                    'create_time'   => time(),
                    'update_time'   => time(),
                ]);
                $res = db('output')->insert([
                    'output'        => $data['withdraw'] - $data['camp_withdraw_fee'],
                    'camp_id'       => $data['camp_id'],
                    'camp'          => $data['camp'],
                    'member_id'     => $data['member_id'],
                    'member'        => $data['member'],
                    'type'          => -1,
                    'e_balance'     =>$data['s_balance'] - $data['withdraw'] + $data['camp_withdraw_fee'],
                    's_balance'     =>$data['s_balance'],
                    'f_id'          =>$this->CampWithdrawModel->id,
                    'rebate_type'   =>$data['rebate_type'],
                    'schedule_rebate'   =>$data['schedule_rebate'],
                    'date_str'      =>$date_str,
                    'create_time'   => time(),
                    'update_time'   => time(),
                ]);
            }else{
                $res = db('output')->insert([
                    'output'        => $data['withdraw'],
                    'camp_id'       => $data['camp_id'],
                    'camp'          => $data['camp'],
                    'member_id'     => $data['member_id'],
                    'member'        => $data['member'],
                    'type'          => -1,
                    'e_balance'     =>($data['e_balance']),
                    's_balance'     =>($data['s_balance']),
                    'f_id'          =>$this->CampWithdrawModel->id,
                    'rebate_type'   =>$data['rebate_type'],
                    'schedule_rebate'   =>$data['schedule_rebate'],
                    'date_str'      =>$date_str,
                    'create_time'   => time(),
                    'update_time'   => time(),
                ]);
            }
            if($res){
                db('camp_finance')->insert([
                    'money'        => ($data['buffer']),
                    'camp_id'       => $data['camp_id'],
                    'camp'          => $data['camp'],
                    'type'          => -4,
                    'e_balance'     =>($data['e_balance']),
                    's_balance'     =>($data['s_balance']),
                    'f_id'          =>$this->CampWithdrawModel->id,
                    'rebate_type'   =>$data['rebate_type'],
                    'schedule_rebate'   =>$data['schedule_rebate'],
                    'date_str'      =>$date_str,
                    'create_time'   => time(),
                    'update_time'   => time(),
                ]);
            }
            Db::commit();
            return ['msg' => '操作成功', 'code' => 200, 'data' => $this->CampWithdrawModel->id];
        }else{
            Db::rollback();
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

