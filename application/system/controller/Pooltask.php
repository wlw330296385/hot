<?php
namespace app\system\controller;
use app\system\controller\Base;
use app\model\Pool;
/**
 * 每日学生数\场地数
 * @param  
 */
class Pooltask extends Base{
    public $Pool;
    public function _initialize(){
    	parent::_initialize();
        $this->Pool = new Pool;
    }

    /**
    * 开启奖金池,每日凌晨0:00;
    * @param 作者:woo
    */
    public function startPool(){
        try{
            $data = ['crontab'=>'每日擂台开启'];
            $this->Pool->where(['status'=>1,'start'=>['elt',time()]])->update(['status'=>2]);
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
    public function lotteryOLD(){
    	try{
            $date_str = date('Ymd',time());
            // $date_str = 20180611;
            $poolList = db('pool')->where([
                    'end_str'=>$date_str,
                    'status'=>2
                ])->select();
            $model = new \app\model\PoolWinner;
            // dump($poolList);
            foreach ($poolList as $key => $value) {
          
                $memberList = db('group_punch')->field('count(id) as c_id,member_id,member,avatar,pool,pool_id')->where(['pool_id'=>$value['id']])->group('member_id')->select();
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
                // dump($memberList);
                foreach ($memberList as $k => $val) {
                    if($val['c_id'] == $max){
                        $winners[] = [
                                        'member'    =>$val['member'],
                                        'member_id' =>$val['member_id'],
                                        'avatar'    =>$val['avatar'],
                                        'punchs'    =>$max,
                                        'pool'      =>$val['pool'],
                                        'pool_id'   =>$val['pool_id'],
                                        'bonus'     =>$value['bonus'],
                                     ];
                    }
                }
                // dump($winners);
                // 更新奖金池
                $result = db('pool')->where(['id'=>$value['id']])->update(['status'=>-1,'winner_list'=>json_encode($winners)]);
                // 奖金得主诞生
                $model->saveAll($winners);
                // 奖金打入个人热币?还是自己领取奖品?
                $bonus = ceil(($value['bonus']/count($winners)));
                $this->updateMembersHotcoin($winners,$bonus);
                //die;
            }
	    	$data = ['crontab'=>'每日擂台开奖'];
            $this->record($data);
    	}catch(Exception $e){
    		$data = ['crontab'=>'每日擂台开奖','status'=>0,'callback_str'=>$e->getMessage()];
            $this->record($data);
            trace($e->getMessage(), 'error');
    	}
    	
    }

    public function lottery(){
        $date_str = date('Ymd',time());
        $poolList_3 = db('pool')->where([
                    'end_str'=>['elt',$date_str],
                    'status'=>2,
                    'type'  =>3
                ])->select();
        $this->lottery2($poolList_3);
        $this->lottery1($poolList_3);

        $poolList_2 = db('pool')->where([
                    'end_str'=>['elt',$date_str],
                    'status'=>2,
                    'type'  =>2
                ])->select();
        $this->lottery2($poolList_2);

        $poolList_1 = db('pool')->where([
                    'end_str'=>['elt',$date_str],
                    'status'=>2,
                    'type'  =>1
                ])->select();
        $this->lottery1($poolList_1);
        dump($poolList_1);
        $this->Pool->isUpdate(true)->save(['status'=>-1],['end_str'=>['elt',$date_str],'status'=>2]);
        $data = ['crontab'=>'每日擂台开奖'];
        $this->record($data);
    }

    /**
    * find winner每日晚上22点,仅仅是奖金池开奖的热币排名;
    * @param 作者:woo
    */
    private function lottery1($poolList){
        try{
            $model = new \app\model\PoolWinner;
            dump($poolList);die;
            foreach ($poolList as $key => $value) {
                $memberList = db('group_punch')->field('count(id) as c_id,member_id,member,avatar,pool,pool_id,group_id,group')->where(['pool_id'=>$value['id']])->group('member_id')->select();
                if(empty($memberList)){
                    continue;
                }
                $c_ids = [];//打卡总数数组
                //将得分转化为简单的1维数组;
                foreach ($memberList as $k => $val) {
                    $c_ids[$k] = $val['c_id'];
                }
                
                array_multisort($c_ids,SORT_DESC ,SORT_NUMERIC );
                // 比例
                $F = $value['first_scale'];$S = $value['second_scale'];$T = $value['third_scale'];
                //奖金池总奖金
                $P = $value['bonus'];

                //第一名打卡总数
                $theFirst = 0;
                $theFirst = $c_ids[0];
                //第二名打卡总数
                $theSecond = 0;
                //第三名打卡总数
                $theThird = 0;
                $C = 1;//名次等级阶级
                foreach ($c_ids as $k => $val) {
                    if($C == 1){
                        if($val<$theFirst){
                            $theSecond = $val;
                            $C++;
                        }
                    }elseif($C == 2){
                        if($val<$theSecond){
                            $theThird = $val;
                            $C++;
                        }
                    }else{
                        continue;
                    }
                    
                }
                // 余数存入奖金池
                $c_f_m = [];//第一名会员数组;
                $c_s_m = [];//第二名会员数组;
                $c_t_m = [];//第三名会员数组;
                foreach ($memberList as $k => $val) {
                    if($val['c_id'] == $theFirst){
                        $memberList[$k]['ranking'] = 1;
                        $memberList[$k]['bonus'] = $value['bonus'];
                        $memberList[$k]['punchs'] = $val['c_id'];
                        $c_f_m[] = $memberList[$k];
                    }
                    if($val['c_id'] == $theSecond){
                        $memberList[$k]['ranking'] = 2;
                        $memberList[$k]['bonus'] = $value['bonus'];
                        $memberList[$k]['punchs'] = $val['c_id'];
                        $c_s_m[] = $val;
                    }
                    if($val['c_id'] == $theThird){
                        $memberList[$k]['ranking'] = 3;
                        $memberList[$k]['bonus'] = $value['bonus'];
                        $memberList[$k]['punchs'] = $val['c_id'];
                        $c_t_m[] = $memberList[$k];
                    }
                }
                
                // dump($P);
                // 余数
                $M = $P%((count($c_f_m)*$F)+(count($c_s_m)*$S)+(count($c_t_m)*$T));
                // dump($M);
                //基数
                $R = ($P-$M)/((count($c_f_m)*$F)+(count($c_s_m)*$S)+(count($c_t_m)*$T));
                // dump($R);
                // 第一名奖金;第二名奖金;第三名奖金
                $theFirstReward = $R*$F;$theSecondReward = $R*$S;$theThirdReward = $R*$T;
                // dump($theFirstReward*count($c_f_m));
                // dump($theSecondReward*count($c_s_m));
                // dump($theThirdReward*count($c_t_m));
                foreach ($c_f_m as $k => $val) {
                    $c_f_m[$k]['winner_bonus'] = $theFirstReward;  
                }
                foreach ($c_s_m as $k => $val) {
                    $c_f_m[$k]['winner_bonus'] = $theSecondReward;  
                }
                foreach ($c_t_m as $k => $val) {
                    $c_f_m[$k]['winner_bonus'] = $theThirdReward;  
                }
                // dump($theFirstReward);
                // dump($theSecondReward);
                // dump($theThirdReward);

                // 更新奖金池
                $result = $this->Pool->isUpdate(true)->save(['winner_list'=>json_encode([$c_f_m,$c_s_m,$c_t_m]),'mod'=>$M,'rate'=>$R,'c_f_m'=>count($c_f_m),'c_s_m'=>count($c_s_m),'c_t_m'=>count($c_t_m),'status'=>-1],['id'=>$value['id']]);
                // 奖金得主诞生
                $winners = array_merge($c_f_m,$c_s_m,$c_t_m);
                $model->saveAll($winners);
                $this->updateMembersHotcoin($winners);

            }
        }catch(Exception $e){
            $data = ['crontab'=>'每日擂台开奖(热币)','status'=>0,'callback_str'=>$e->getMessage()];
            $this->record($data);
            trace($e->getMessage(), 'error');
        }
        
    }




    /**
    * find winner每日晚上22点,仅仅是卡券奖品单排名名次;
    * @param 作者:woo
    */
    public function lottery2($poolList){
        try {
            $model = new \app\model\PoolWinnerS;
            foreach ($poolList as $key => $value) {
                $memberList = db('group_punch')->field('count(id) as c_id,member_id,member,avatar,pool,pool_id,group_id,group')->where(['pool_id'=>$value['id']])->group('member_id')->order('c_id desc')->limit($value['the_first_winners']+$value['the_second_winners']+$value['the_third_winners'])->select();
         
                if(empty($memberList)){
                    continue;
                }
                // dump($memberList);
                // $totalWinners = $value['the_first_winners'] + $value['the_second_winners'] + $value['the_third_winners'] - 1;//一共有几个奖品,包括123...789等奖
                $totalWinners = 3;
                $the_first_winner_list = array_slice($memberList,0,$value['the_first_winners']);
                $the_second_winner_list = array_slice($memberList,$value['the_first_winners'],$value['the_second_winners']);
                $the_third_winner_list = array_slice($memberList,$value['the_second_winners']+$value['the_first_winners'],$value['the_third_winners']);
                $winner_list = [];
                foreach ($the_first_winner_list as $k => &$val) {
                    $val['award_id'] = $value['the_first_award_id'];
                    $val['award_id'] = $value['the_first_award'];
                    $val['ranking'] = 1;
                    $val['bonus'] = $value['bonus'];
                    $val['punchs'] = $val['c_id'];
                }
                // dump($the_first_winner_list);
                foreach ($the_second_winner_list as $k => &$val) {
                    $val['award_id'] = $value['the_first_award_id'];
                    $val['award_id'] = $value['the_first_award'];
                    $val['ranking'] = 2;
                    $val['bonus'] = $value['bonus'];
                    $val['punchs'] = $val['c_id'];
                }
                // dump($the_second_winner_list);
                foreach ($the_third_winner_list as $k => &$val) {
                    $val['award_id'] = $value['the_first_award_id'];
                    $val['award_id'] = $value['the_first_award'];
                    $val['ranking'] = 3;
                    $val['bonus'] = $value['bonus'];
                    $val['punchs'] = $val['c_id'];
                }
                // dump($the_third_winner_list);
                $winner_list = array_merge($the_first_winner_list,$the_second_winner_list,$the_third_winner_list);
                // 更新奖金池
                $result = $this->Pool->isUpdate(true)->save(['winner_list_s'=>json_encode([$the_first_winner_list,$the_second_winner_list,$the_third_winner_list])],['id'=>$value['id']]);
                // 奖金得主诞生
                $model->saveAll($winner_list);
            }
            
        } catch (Exception $e) {
            $data = ['crontab'=>'每日擂台开奖(卡券)','status'=>0,'callback_str'=>$e->getMessage()];
            $this->record($data);
            trace($e->getMessage(), 'error');
        }
    }

    /**
     * 热币更新
     *@param memberList,bonus;
     */
    private function updateMembersHotcoin($memberList){

        foreach ($memberList as $key => $value) {
            db('member')->where(['id'=>$value['member_id']])->inc('hot_coin',$value['winner_bonus'])->update();
        }
        
    }

    /**
     * 发送模板消息
     */
    public function sendMessage(){
        $list = db('pool_winner')->field('member.openid,member.member,pool_winner.winner_bonus,pool_winner.create_time,pool_winner.pool,pool_winner.ranking,pool_winner.group_id')->join('member','member.id = pool_winner.member_id')->join('pool','pool.id=pool_winner.pool_id')->where(['pool_winner.is_message'=>-1,'pool_winner.winner_bonus'=>['gt',0]])->order('pool_winner.id desc')->select();
        // $list = [['member_id'=>8,'winner_bonus'=>999,'create_time'=>1531404000,'openid'=>'o83291CzkRqonKdTVSJLGhYoU98Q']];

        $WechatService = new \app\service\WechatService();
        //给获奖名单发消息
        foreach ($list as $key => $value) {
            $messageData = [
                "touser" => $value['openid'],
                "template_id" => "pZCJbOXrNQXkH5zWwghEMP5WK0ejENN-l3F_qUbeABU",
                "url" => "https://m.hot-basketball.com/keeper/group/poolWinnerList/group_id/{$value['group_id']}",
                "topcolor"=>"#FF0000",
                "data" => [
                    'first' => ['value' => '尊敬的会员，您参与的运动打卡擂台擂主已出结果'],
                    'keyword1' => ['value' => "{$value['member']}"],
                    'keyword2' => ['value' => "{$value['pool']}"],
                    'keyword3' => ['value' => "您获得第{$value['ranking']}名,奖品为{$value['winner_bonus']}热币"],
                    'remark' => ['value' => '篮球管家祝您身体健康'],
                ],
            ];
            $WechatService->sendTemplate($messageData);
        }
        db('pool_winner')->where(['is_message'=>-1])->update(['is_message'=>1]);
        $data = ['crontab'=>'每日发送擂台台主模板消息'];
        $this->record($data);
    }

    /**
     * 发送模板消息//给擂主的
     */
    public function sendMessage2($pool_id){
        $info = db('pool')->field('group.member_id,pool.group_id,pool.group')->join('group','group.id = pool.group_id')->where(['pool.id'=>$pool_id])->order('pool.id desc')->find();
        $openid = db('member')->where(['id'=>$info['member_id']])->value('openid');
        $WechatService = new \app\service\WechatService();
        //给获奖名单发消息
        $messageData = [
            "touser" => $openid,
            "template_id" => "pZCJbOXrNQXkH5zWwghEMP5WK0ejENN-l3F_qUbeABU",
            "url" => "https://m.hot-basketball.com/keeper/group/poolWinnerList/group_id/{$info['group_id']}",
            "topcolor"=>"#FF0000",
            "data" => [
                'first' => ['value' => '尊敬的会员，您发起的运动打卡擂台擂主已出结果'],
                'keyword1' => ['value' => "{$info['group']}"],//参赛者
                'keyword2' => ['value' => "{$info['pool']}"],//期数
                'keyword3' => ['value' => "具体奖品请进入页面查看"],//结果
                'remark' => ['value' => '篮球管家祝您身体健康'],
            ],
        ];
        $WechatService->sendTemplate($messageData);
        db('pool_winner')->where(['is_message'=>-1])->update(['is_message'=>1]);
        $data = ['crontab'=>'每日发送擂台获奖者模板消息'];
        $this->record($data);
    }

}