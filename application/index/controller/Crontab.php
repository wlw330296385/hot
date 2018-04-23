<?php 
namespace app\index\controller;
use think\Controller;
/**
* 
*/
class Crontab extends Controller
{
	
	function __construct()
	{
		
	}



	// 1 付款订单
    public function income(){
        $billList = db('bill')->where('delete_time',null)->where(['is_pay'=>1,'status'=>1])->select();
        $data = [];
        foreach ($billList as $key => &$value) {
            $campInfo = db('camp')->where(['id'=>$value['camp_id']])->find();
            $data['type'] = $value['goods_type'];
            $data['lesson_id'] = $value['goods_id'];
            $data['lesson'] = $value['goods'];
            $data['goods_id'] = $value['goods_id'];
            $data['goods'] = $value['goods'];
            $data['camp_id'] = $value['camp_id'];
            $data['camp'] = $value['camp'];
            $data['total'] = $value['total'];
            $data['member_id'] = $value['member_id'];
            $data['member'] = $value['member'];
            $data['price'] = $value['price'];
            $data['f_id'] = $value['id'];
            $data['student_id'] = $value['student_id'];
            $data['student'] = $value['student'];
            $data['balance_pay'] = $value['balance_pay'];
            $data['income'] = $value['balance_pay'];
            $data['create_time'] = $value['create_time'];
            $data2['type'] = 1;
            $data2['camp_id'] = $value['camp_id'];
            $data2['camp'] = $value['camp'];
            $data2['f_id'] = $value['id'];
            $data2['money'] = $value['balance_pay'];
            $data2['create_time'] = $value['create_time'];
            $data2['date_str'] = date('Ymd',$value['create_time']);
            $data2['datetime'] = $value['create_time'];
            if($campInfo['rebate_type'] == 2){
                $data['s_balance'] = $campInfo['balance'];
                $data['e_balance'] = $campInfo['balance'] + $value['balance_pay'];
                $data2['s_balance'] = $campInfo['balance'];
                $data2['e_balance'] = $campInfo['balance'] + $value['balance_pay'];
                db('camp')->where(['id'=>$value['camp_id']])->inc('balance',$value['balance_pay'])->update();
            }else{
                $data['s_balance'] = $campInfo['balance'];
                $data['e_balance'] = $campInfo['balance'];
                $data2['s_balance'] = $campInfo['balance'];
                $data2['e_balance'] = $campInfo['balance'];

            }
            db('income')->insert($data);
            db('camp_finance')->insert($data2);
            if($value['goods_type'] == 1){
                db('lesson_member')->where(['student_id'=>$value['student_id'],'lesson_id'=>$value['goods_id']])->inc('rest_schedule',$value['total'])->inc('total_schedule',$value['total'])->update();
                db('student')->where(['id'=>$value['student_id']])->inc('total_schedule',$value['total'])->update();
            }
        }
    }




    // 2 退费订单
    public function output(){
        $billList = db('bill')->where('delete_time',null)->where(['is_pay'=>1,'status'=>-2])->select();
        $data = [];
        foreach ($billList as $key => &$value) {
            $campInfo = db('camp')->where(['id'=>$value['camp_id']])->find();
            $data['type'] = 2;
            $data['s_balance'] = $campInfo['balance'];
            $data['e_balance'] = $campInfo['balance'];
            $data['member_id'] = $value['member_id'];
            $data['member'] = $value['member'];
            $data['camp_id'] = $value['camp_id'];
            $data['camp'] = $value['camp'];
            $data['f_id'] = $value['id'];
            $data['output'] = $value['refundamount'];
            $data['create_time'] = $value['create_time'];
            
            $data2['type'] = -3;
            $data['camp_id'] = $value['camp_id'];
            $data['camp'] = $value['camp'];
            $data['f_id'] = $value['id'];
            $data['output'] = $value['refundamount'];
            $data['create_time'] = $value['create_time'];    
            $data2['money'] = $value['balance_pay'];
            if($campInfo['rebate_type'] == 2){
                $data['s_balance'] = $campInfo['balance'];
                $data['e_balance'] = $campInfo['balance'] + $value['balance_pay'];
                $data2['s_balance'] = $campInfo['balance'];
                $data2['e_balance'] = $campInfo['balance'] + $value['balance_pay'];
                db('camp')->where(['id'=>$value['camp_id']])->dec('balance',$value['refundamount'])->update();
            }else{
                $data['s_balance'] = $campInfo['balance'];
                $data['e_balance'] = $campInfo['balance']; 
                $data2['s_balance'] = $campInfo['balance'];
                $data2['e_balance'] = $campInfo['balance'];
            }
            db('output')->insert($data);
            db('camp_finance')->insert($data2);
            if($value['goods_type'] == 1){
                db('lesson_member')->where(['student_id'=>$value['student_id'],'lesson_id'=>$value['goods_id']])->dec('rest_schedule',($value['refundamount']/$value['price']))->dec('total_schedule',($value['refundamount']/$value['price']))->update();
                db('student')->where(['id'=>$value['student_id']])->dec('total_schedule',($value['refundamount']/$value['price']))->update();
            }
        }
    }



    // 3
    public function gift1(){
        $giftList = db('schedule_giftrecord')->field('schedule_giftrecord.*,lesson.cost')->join('lesson','lesson.id=schedule_giftrecord.lesson_id')->where('schedule_giftrecord.delete_time',null)->select();      
        $data = [];
        foreach ($giftList as $key => $value) {
            $campInfo = db('camp')->where(['id'=>$value['camp_id']])->find();
            $data['type'] = 1;
            $data['member_id'] = $value['member_id'];
            $data['member'] = $value['member'];
            $data['camp_id'] = $value['camp_id'];
            $data['camp'] = $value['camp'];
            $data['f_id'] = $value['id'];
            $data['output'] = $value['student_num']*$value['gift_schedule']*$value['cost'];
            $data['create_time'] = $value['create_time'];
            $data['s_balance'] = $campInfo['balance'];
            $data['e_balance'] = $campInfo['balance'] - $data['output'];
            db('output')->insert($data);
            db('camp')->where(['id'=>$value['camp_id']])->dec('balance',$data['output'])->update();
        }
    }

    //4 
    public function gift2(){
        $giftList = db('schedule_gift_student')->select();      
        $data = [];
        foreach ($giftList as $key => $value) {
            db('lesson_member')->where(['student_id'=>$value['student_id'],'lesson_id'=>$value['lesson_id']])->inc('rest_schedule',$value['gift_schedule'])->inc('total_schedule',$value['gift_schedule'])->update();
            db('student')->where(['id'=>$value['student_id']])->inc('total_schedule',$value['gift_schedule'])->update();
        }
    }



    // 5 修复grade_member状态
    public function repairGradeMemberStatus(){
        $list = db('lesson_member')->where(['status'=>1])->select();
        foreach ($list as $key => $value) {
            db('grade_member')->where(['lesson_id'=>$value['lesson_id'],'student_id'=>$value['student_id']])->update(['status'=>1]);    
        }

    }


    // 5 修复lesson_member状态
    public function repairLessonMemberStatus(){
       db('grade_member')->where(['rest_schedule'=>['gt',0]])->update(['status'=>1]);    
    }



    // 修复schedule_member的status
    public function repairScheduleMemberStatus(){
    	$ids = db('schedule')->where(['status'=>-1])->where('delete_time',null)->column('id');
    	db('schedule_member')->where(['schedule_id'=>['in',$ids]])->update(['status'=>-1]);
    	$ids2 = db('schedule')->where(['status'=>-1])->where('delete_time','not null')->column('id');
    	db('schedule_member')->where(['schedule_id'=>['in',$ids2]])->delete();

    }
}