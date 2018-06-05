<?php 
namespace app\api\controller;
use app\api\controller\Base;
class Charge extends Frontend{
	public function _initialize(){
		parent::_initialize();
	}

    //充值Api
    public function ChargeApi(){
    	try{
	        $member = $this->memberInfo['member'];
	        $member_id = $this->memberInfo['id'];
	        $avatar = $this->memberInfo['avatar'];
	        $charge = input('param.charge');
	        $charge_order = input('param.charge_order');
	        $type = input('param.type',1);
	        if($charge >1){
	        	if($member_id<1){
	        		return json(['code'=>100,'msg'=>'未注册平台会员,充值未到账,请联系平台客服']);
	        	}
	        	if(!$charge_order){
	        		return json(['code'=>100,'msg'=>'充值单号错误']);
	        	}
	        	$Charge = new \app\model\Charge;
	        	$result = $Charge->save([
	        		'member'		=>$member,
	        		'member_id'		=>$member_id,
	        		'avatar'		=>$avatar,
	        		'charge'		=>$charge,
	        		'charge_order'	=>$charge_order,
	        		'status'		=>1
	        	]);
	        	if($result){
	        		switch($type){
	        			case 1:
	        				db('member')->where(['id'=>$member_id])->inc('balance',$charge)->update();
	        			break;
	        			case 2:
	        				db('member')->where(['id'=>$member_id])->inc('hot_coin',$charge)->update();
	        			break;
	        			case 3:
	        				db('camp')->where(['id'=>$camp_id])->inc('balance',$charge)->update();
	        			break;
	        			default:   
	        			return json(['code'=>100,'msg'=>'请指定充值的类型']); 
	        		}
	        		
	        		return json(['code'=>200,'msg'=>'充值成功']);
	        	}else{
	        		return json(['code'=>100,'msg'=>'充值失败,请联系平台客服通过充值记录保证您自身的权益']);
	        	}
	        }else{
	        	return json(['code'=>100,'msg'=>'充值金额必须大于1']);
	        }    		
    	}catch(Exception $e){
    		return json(['code'=>100,'msg'=>$e->getMessage()]);
    	}

    }
    
    
    
}