<?php
namespace app\system\controller;
use app\system\controller\Base;
/**
 * 每日学生数\场地数
 * @param  
 */
class Pooltask extends Base{
 
    public function _initialize(){
    	parent::_initialize();
    }


    //开启奖金池,每日凌晨0:00;
    public function startPool(){
        try{
            $data = ['crontab'=>'每日擂台开启'];
            $this->record($data);
        }catch(Exception $e){
            $data = ['crontab'=>'每日擂台开启','status'=>0,'callback_str'=>$e->getMessage()];
            $this->record($data);
            trace($e->getMessage(), 'error');
        }
    }
   //find winner每日晚上22点;
    public function lottery(){
    	try{
    		
            $date_str = date('Ymd',time());
            $poolList = db('pool')->where(['status'=>2,'date_str'=>$date_str])->select();
            foreach ($poolList as $key => $value) {
                $memberList = db('group_punch')->field('count(id) as c_id,member_id,member,pool,pool_id')->where(['pool_id'=>$value['id']])->group('member_id')->select();
                $c_ids = [];
                //将得分转化为简单的1维数组;
                foreach ($memberList as $k => $val) {
                    $c_ids[$k] = $val['c_id'];
                }
                // 获得最高分的值
                $max = max($c_ids);
                //将最高分的值对应的原数组下标key的值存为数组
                $members = [];
                foreach ($memberList as $k => $val) {
                    if($val['c_id'] == $max){
                        $members[] = [
                                        'member'    =>$val['member'],
                                        'member_id' =>$val['member_id'],
                                        'punchs'    =>$max,
                                        'pool'      =>$val['pool'],
                                        'pool_id'   =>$val['pool_id'],
                                     ];
                    }
                }
                // 更新奖金池
                $result = db('pool')->where(['date_str'=>$date_str])->update(['status'=>-1]);
                // 奖金得主诞生
                $model = new \app\model\
            }
	    	$data = ['crontab'=>'每日擂台开奖'];
            $this->record($data);
    	}catch(Exception $e){
    		$data = ['crontab'=>'每日擂台开奖','status'=>0,'callback_str'=>$e->getMessage()];
            $this->record($data);
            trace($e->getMessage(), 'error');
    	}
    	
    }





    

    
}