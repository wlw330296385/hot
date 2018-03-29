<?php
namespace app\system\controller;
use app\system\controller\Base;

class Dailyfinance extends Base{
 
    public function _initialize() {
        parent::_initialize();
    }

    // 凌晨0:00跑
    public function weeTask(){
        try{
            $this->getMemberFinanceWee();
            $this->getCampFinanceWee();
            $data = ['crontab'=>'每日训练营余额1'];
            $this->record($data);
        }catch(Exception $e){
            $data = ['crontab'=>'每日训练营余额1','status'=>0,'callback_str'=>$e->getMessage()];
            $this->record($data);
            trace($e->getMessage(), 'error');
        }
        
    }

    private function getMemberFinanceWee(){
        $list = db('coach')->join('member','member.id=coach.member_id')->where(['coach.status'=>1])->where('coach.delete_time',null)->order('coach.id desc')->select();
        foreach ($list as $key => $value) {
            $data = [
                'member_id'=>$value['member_id'],
                'member'=>$value['member'],
                's_balance'=>$value['balance'],
                'create_time'=>time(),
                'date_str'=>date('Ymd'),
            ];
            db('daily_member_finance')->insert($data);
        }
    }

    private function getCampFinanceWee(){
        $list = db('camp')->where(['status'=>1])->where('delete_time',null)->select();
        foreach ($list as $key => $value) {
            $data = [
                'camp_id'=>$value['id'],
                'camp'=>$value['camp'],
                's_balance'=>$value['balance'],
                'create_time'=>time(),
                'date_str'=>date('Ymd'),
            ];
            db('daily_camp_finance')->insert($data);
        }
    }




    // 夜晚23:59跑
    public function midnightTask(){
        try{
            $this->getMemberFinanceMidnight();
            $this->getCampFinanceMidnight();
            $data = ['crontab'=>'每日训练营余额2'];
            $this->record($data);
        }catch(Exception $e){
            $data = ['crontab'=>'每日训练营余额2','status'=>0,'callback_str'=>$e->getMessage()];
            $this->record($data);
            trace($e->getMessage(), 'error');
        }
        
    }

    private function getMemberFinanceMidnight(){
        $data_str = date('Ymd');
        $list = db('coach')->join('member','member.id=coach.member_id')->where(['coach.status'=>1])->where('coach.delete_time',null)->order('coach.id desc')->select();
        foreach ($list as $key => $value) {
            $data = [
                'e_balance'=>$value['balance'],
                'update_time'=>time(),
            ];
            db('daily_member_finance')
            ->where(['member_id'=>$value['member_id'],'date_str'=>date('Ymd')])
            ->update($data);
        }
    }

    private function getCampFinanceMidnight(){
        $data_str = date('Ymd');
        $list = db('camp')->where(['status'=>1])->where('delete_time',null)->select();
        foreach ($list as $key => $value) {
            $data = [
                'e_balance'=>$value['balance'],
                'update_time'=>time(),
            ];
            db('daily_camp_finance')
            ->where(['camp_id'=>$value['id'],'date_str'=>date('Ymd')])
            ->update($data);
        }
    }

}