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

    /**
    * 开启奖金池,每日凌晨0:00;
    * @param 作者:woo
    */
    public function startPool(){
        try{
            $data = ['crontab'=>'每日擂台开启'];
            db('pool')->where(['status'=>1,'start'=>['elt',time()]])->update(['status'=>2]);
            $this->record($data);
        }catch(Exception $e){
            $data = ['crontab'=>'每日擂台开启','status'=>0,'callback_str'=>$e->getMessage()];
            $this->record($data);
            trace($e->getMessage(), 'error');
        }
    }
   /**
    * find winner每日晚上22点;
    * @param 作者:woo
    */
    public function lottery(){
    	try{
            $date_str = date('Ymd',time());
            $poolList = db('pool')->where(['end_str'=>$date_str,'status'=>2])->select();
            $model = new \app\model\PoolWinner;
            // dump($poolList);
            foreach ($poolList as $key => $value) {
          
                $memberList = db('group_punch')->field('count(id) as c_id,member_id,member,pool,pool_id')->where(['pool_id'=>$value['id']])->group('member_id')->select();
                if(empty($memberList)){
                    continue;
                }
                $c_ids = [];
                //将得分转化为简单的1维数组;
                foreach ($memberList as $k => $val) {
                    $c_ids[$k] = $val['c_id'];
                }
                // 获得最高分的值
                $max = max($c_ids);
                //将最高分的值对应的原数组下标key的值存为数组,即获奖者数组
                $winners = [];
                foreach ($memberList as $k => $val) {
                    if($val['c_id'] == $max){
                        $winners[] = [
                                        'member'    =>$val['member'],
                                        'member_id' =>$val['member_id'],
                                        'punchs'    =>$max,
                                        'pool'      =>$val['pool'],
                                        'pool_id'   =>$val['pool_id'],
                                        'bonus'     =>$value['bonus'],
                                     ];
                    }
                }
                // 更新奖金池
                $result = db('pool')->where(['end_str'=>$date_str])->update(['status'=>-1,'winner_list'=>json_encode($winners)]);
                // 奖金得主诞生
                $model->saveAll($winners);
                //奖金打入个人热币?还是自己领取奖品?
                $bonus = ceil(($value['bonus']/count($winners)));
                $this->updateMembersHotcoin($winners,$bonus);
            }
	    	$data = ['crontab'=>'每日擂台开奖'];
            $this->record($data);
    	}catch(Exception $e){
    		$data = ['crontab'=>'每日擂台开奖','status'=>0,'callback_str'=>$e->getMessage()];
            $this->record($data);
            trace($e->getMessage(), 'error');
    	}
    	
    }

    /**
     * 热币更新
     *@param memberList,bonus;
     */
    private function updateMembersHotcoin($memberList,$bonus){
        $ids = [];
        foreach ($memberList as $key => $value) {
            $ids[] = $value['member_id'];
        }
        db('member')->where(['id'=>['in',$ids]])->inc('hot_coin',$bonus)->update();
    }
    /**
     * 测试用数据插入
     */
    public function test(){
        // $Group = new \app\model\Group;
        // $group = db('group')->find();
        // $gourp['group'] = rand(10000,99999);
        // $group['member_id'] = rand(1,99);
        // unset($group['id']);
        // $Group->isUpdate(false)->save($group);


        $GroupMember = new \app\model\GroupMember;
        $group_member = db('group_member')->find();
        $group_member['group_id'] = rand(1,30);
        $group_member['member_id'] = rand(1,99);
        unset($group_member['id']);
        $GroupMember->isUpdate(false)->save($group_member);


        // $Pool = new \app\model\Pool;
        // $pool = db('pool')->find();
        // $pool['group_id'] = rand(1,30);
        // $pool['bonus'] = rand(999,9999);
        // $pool['end_str'] = 20180531;
        // $pool['status'] = 1;
        // unset($pool['id']);
        // $Pool->isUpdate(false)->save($pool);

        $GroupPunch = new \app\model\GroupPunch;         
        $group_punch = db('group_punch')->find();
        $group_punch['group_id'] = rand(1,30);
        $group_punch['pool_id'] = rand(1,30);
        $group_punch['member_id'] = rand(1,99);
        unset($group_punch['id']);
        $GroupPunch->isUpdate(false)->save($group_punch);


    }
}