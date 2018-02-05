<?php 
namespace app\frontend\Widget;
use Think\Controller;
use Think\Db;
class bonus extends Controller{
	public function bonus(){
        $bonus_type = input('param.bonus_type',1);
		//平台礼包
        $BonusService = new \app\admin\service\BonusService;
    	$bonusInfo = $BonusService->getBonusInfo(['bonus_type'=>1,'status'=>1]);

    	$couponList = [];
    	$item_coupon_ids = [];
    	if($bonusInfo){
    		$res = $bonusInfo->toArray();
    		$ItemCoupon = new \app\model\ItemCoupon;
    		$couponList = $ItemCoupon->where(['target_type'=>-1,'target_id'=>$bonusInfo['id'],'status'=>1])->select();
    		foreach ($couponList as $key => $value) {
    			$item_coupon_ids[] = $value['id'];
    		}
            dump($bonusInfo);die;
    		// $this->assign('isBonus',$isBonus);
    		$this->assign('item_coupon_ids',json_encode($item_coupon_ids));
	    	$this->assign('couponList',$couponList);
	        $this->assign('bonusInfo',$bonusInfo);
            // return $this->fetch('Widget:bonus');
			return $this->fetch('Widget/Bonus');
    	}
    	
	}
}
