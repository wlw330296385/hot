<?php 
namespace app\keeper\controller;
use app\keeper\controller\Base;
use app\service\BannerService;
use think\Cookie;

class Find extends Base{
	
	public function _initialize(){
		parent::_initialize();
        Cookie::set('steward_type', 2);
	}

    public function index() {
        //$bannerList = db('banner')->where(['organization_type'=>0,'status'=>1, 'steward_type' => 2])->order('ord asc')->limit(3)->select();
        // 球队管家banner
        $bannerService = new BannerService();
        $bannerList = $bannerService->bannerList([
            'organization_type'=>0,
            'status'=>1,
            'steward_type' => cookie('steward_type')
        ], 'ord desc', 3);

        // 热门文章
        $ArticleService= new \app\service\ArticleService;
        $ArticleList = $ArticleService->getArticleList([],1,'hot DESC',4);
        //红包
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
            $this->assign('item_coupon_ids',json_encode($item_coupon_ids));
            $this->assign('couponList',$couponList);
            // return $this->fetch('Widget:bonus');
            // return $this->fetch('Widget/Bonus');
        }
        //平台礼包结束
        $this->assign('bannerList',$bannerList);
        $this->assign('lastBanner', end($bannerList));
        $this->assign('ArticleList',$ArticleList);
        $this->assign('bonusInfo',$bonusInfo);
        $this->assign('bonusInfo',$bonusInfo);
        return view('Find/index');
    }


    public function test1() {
  
        return view('Find/test1');
    }

    public function test2() {
  
        return view('Find/test2');
    }

    public function test3() {
  
        return view('Find/test3');
    }

    public function test4() {
  
        return view('Find/test4');
    }

    public function test5() {
  
        return view('Find/test5');
    }

}