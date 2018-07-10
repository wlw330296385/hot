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
	        if($charge >=0){//测试的时候改为0,平时是1;
	        	if($member_id<1){
	        		return json(['code'=>100,'msg'=>'未注册平台会员,购买未到账,请联系平台客服']);
	        	}
	        	if(!$charge_order){
	        		return json(['code'=>100,'msg'=>'购买单号错误']);
	        	}

        		switch($type){
        			//个人余额充值
        			case 1:
	        			$Charge = new \app\model\Charge;
			        	$result = $Charge->save([
			        		'member'		=>$member,
			        		'member_id'		=>$member_id,
			        		'avatar'		=>$avatar,
			        		'charge'		=>$charge,
			        		'charge_order'	=>$charge_order,
			        		'status'		=>1
			        	]);

        				db('member')->where(['id'=>$member_id])->inc('balance',$charge)->update();
        				session('memberInfo.balance',($this->memberInfo['balance']+$charge));
        				$MemberFinance = new \app\model\MemberFinance;
        				$MemberFinance->save([
			        		'member'		=>$member,
			        		'member_id'		=>$member_id,
			        		// 'avatar'		=>$avatar,
			        		'f_id'			=>$Charge->id,
			        		'money'			=>$charge,
			        		'type'			=>2,
			        		's_balance'		=>$this->memberInfo['balance'],
			        		'e_balance'		=>($this->memberInfo['balance']+$charge),
			        		'date_str'		=>date('Ymd',time()),
			        		'datetime'		=>date('Ymd',time()),
			        		'system_remarks'		=>'余额充值',

			        	]);
        			break;
        			// 个人热币充值
        			case 2:
	        			$Charge = new \app\model\Charge;
			        	$result = $Charge->save([
			        		'member'		=>$member,
			        		'member_id'		=>$member_id,
			        		'avatar'		=>$avatar,
			        		'charge'		=>$charge,
			        		'charge_order'	=>$charge_order,
			        		'status'		=>1,
			        		'type'			=>2
			        	]);
        				db('member')->where(['id'=>$member_id])->inc('hot_coin',$charge)->update();
        				$Hotcoin = new \app\model\Hotcoin;
        				$Hotcoin->save([
			        		'member'		=>$member,
			        		'member_id'		=>$member_id,
			        		'avatar'		=>$avatar,
			        		'f_id'			=>$Charge->id,
			        		'hot_coin'		=>$charge,
			        		'type'			=>1,
			        		'status'		=>1
			        	]);
        				session('memberInfo.hot_coin',($this->memberInfo['hot_coin']+$charge));
        				
        			break;
        			// 训练营充值
        			case 3:
	        			$Charge = new \app\model\Charge;
			        	$result = $Charge->save([
			        		'member'		=>$member,
			        		'member_id'		=>$member_id,
			        		'avatar'		=>$avatar,
			        		'charge'		=>$charge,
			        		'charge_order'	=>$charge_order,
			        		'status'		=>1,
			        		'type'			=>3
			        	]);
        				db('camp')->where(['id'=>$camp_id])->inc('balance',$charge)->update();
        				
        			break;
        			//其他支付
        			case -1:
        				return json(['code'=>200,'msg'=>'操作成功']);
        			break;
        			default:   
        			return json(['code'=>100,'msg'=>'请指定购买的类型']); 
        		}
        		if($result){	
	        		return json(['code'=>200,'msg'=>'购买成功']);
	        	}else{
	        		return json(['code'=>100,'msg'=>'购买失败,请联系平台客服通过充值记录保证您自身的权益']);
	        	}
	        }else{
	        	return json(['code'=>100,'msg'=>'购买金额必须大于1']);
	        }    		
    	}catch(Exception $e){
    		return json(['code'=>100,'msg'=>$e->getMessage()]);
    	}

    }
    
    
    // 热币转余额
    public function hotcoinToBalance(){
    	try {
    		$total = input('param.total');
    		$l = 1;
    		$balance = $l *$total;
    		if ($this->memberInfo['id']<1) {
    			return json(['code'=>100,'msg'=>'请先登录']);
    		}
    		if($this->memberInfo['hot_coin'] < $total){
    			return json(['code'=>100,'msg'=>'热币不足']);
    		}
    		$result = db('member')->where(['id'=>$this->memberInfo['id']])->dec('hot_coin',$total)->inc('balance',$balance)->update();
    		if($result){
    			session('memberInfo.balance',($this->memberInfo['balance'] + $balance));
    			session('memberInfo.hot_coin',($this->memberInfo['hot_coin'] - $total));
    			$Charge = new \app\model\Charge;
	        	$result = $Charge->save([
	        		'member'		=>$this->memberInfo['member'],
	        		'member_id'		=>$this->memberInfo['id'],
	        		'avatar'		=>$this->memberInfo['avatar'],
	        		'charge'		=>$total,
	        		'charge_order'	=>getTID($this->memberInfo['id']),
	        		'status'		=>1,
	        		'type'			=>1
	        	]);
	        	$Hotcoin = new \app\model\Hotcoin;
				$Hotcoin->save([
	        		'member'		=>$this->memberInfo['member'],
	        		'member_id'		=>$this->memberInfo['id'],
	        		'avatar'		=>$this->memberInfo['avatar'],
	        		'f_id'			=>$Charge->id,
	        		'hot_coin'		=>-$total,
	        		'type'			=>-2,
	        		'status'		=>1
	        	]);
	        	$MemberFinance = new \app\model\MemberFinance;
	        	$MemberFinance->save([
	        		'member'		=>$this->memberInfo['member'],
	        		'member_id'		=>$this->memberInfo['id'],
	        		'avatar'		=>$this->memberInfo['avatar'],
	        		'f_id'			=>$Charge->id,
	        		'money'			=>$total,
	        		'type'			=>2,
	        		'status'		=>1,
	        		's_balance'		=>$this->memberInfo['balance'],
	        		'e_balance'		=>$this->memberInfo['balance']+$balance,
	        		'date_str'		=>date('Ymd',time()),
	        		'system_remarks'=>'热币转余额'
	        	]);
    			return json(['code'=>200,'msg'=>'操作成功']);
    		}else{
    			return json(['code'=>100,'msg'=>'操作失败']);
    		}
    	} catch (Exception $e) {
    		return json(['code'=>100,'msg'=>$e->getMessage()]);
    	}
    }




    // 余额转热币
    public function balanceToHotcoin(){
    	try {
    		$total = input('param.total');
    		$l = 1;
    		$balance = $l *$total;
    		if ($this->memberInfo['id']<1) {
    			return json(['code'=>100,'msg'=>'请先登录']);
    		}
    		if($this->memberInfo['balance'] < $balance){
    			return json(['code'=>100,'msg'=>'余额不足']);
    		}
    		$result = db('member')->where(['id'=>$this->memberInfo['id']])->dec('balance',$balance)->inc('hot_coin',$total)->update();
    		if($result){
    			session('memberInfo.balance',($this->memberInfo['balance'] - $balance));
    			session('memberInfo.hot_coin',($this->memberInfo['hot_coin'] + $total));
    			$Charge = new \app\model\Charge;
	        	$result = $Charge->save([
	        		'member'		=>$this->memberInfo['member'],
	        		'member_id'		=>$this->memberInfo['id'],
	        		'avatar'		=>$this->memberInfo['avatar'],
	        		'charge'		=>$total,
	        		'charge_order'	=>getTID($this->memberInfo['balance']),
	        		'status'		=>1,
	        		'type'			=>2
	        	]);
	        	$Hotcoin = new \app\model\Hotcoin;
				$Hotcoin->save([
	        		'member'		=>$this->memberInfo['member'],
	        		'member_id'		=>$this->memberInfo['id'],
	        		'avatar'		=>$this->memberInfo['avatar'],
	        		'f_id'			=>$Charge->id,
	        		'hot_coin'		=>$total,
	        		'type'			=>2,
	        		'status'		=>1
	        	]);
	        	$MemberFinance = new \app\model\MemberFinance;
	        	$MemberFinance->save([
	        		'member'		=>$this->memberInfo['member'],
	        		'member_id'		=>$this->memberInfo['id'],
	        		'avatar'		=>$this->memberInfo['avatar'],
	        		'f_id'			=>$Charge->id,
	        		'money'			=>$total,
	        		'type'			=>-2,
	        		'status'		=>1,
	        		's_balance'		=>$this->memberInfo['balance'],
	        		'e_balance'		=>$this->memberInfo['balance']-$total,
	        		'date_str'		=>date('Ymd',time()),
	        		'system_remarks'=>'余额转热币'
	        	]);
    			return json(['code'=>200,'msg'=>'操作成功']);
    		}else{
    			return json(['code'=>100,'msg'=>'操作失败']);
    		}
    	} catch (Exception $e) {
    		return json(['code'=>100,'msg'=>$e->getMessage()]);
    	}
    }
}