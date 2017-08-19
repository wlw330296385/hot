<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\BillService;
class Bill extends Base{
	protected $BillService;
	public function _initialize(){
		parent::_initialize();
	}

    public function index() {
    	
        return view();
    }

    public function billInfo(){
    	$id = input('id');
    	$result = $this->BillService->getBill(['id'=>$id]);
    	$this->assign('billInfo',$result);
    	return view();
    }

    // 获取会员订单列表
    public function billList(){
        $member_id = $this->memberInfo['id'];
    	$map = input('post.');
        $map['member_id'] = $member_id;
        $result = $this->BillService->getBillList($map);
        $billList = $result['data'];
        $billList['count'] = count($billList);
        $this->assign('billList',$billList);
		return view();
    }

    //获取会员订单接口
    public function getBillListApi(){
    	$map = input('post.');
        $result = $this->BillService->getBillList($map);
        $billList = $result['data'];
        $billList['count'] = count($billList);
        return json(['code'=>100,'data'=>$billList,'msg'=>'OK']);    	
    }
    //编辑|添加订单
    public function createBill(){
    	//训练营主教练
    	$camp_id = input('get.camp_id');
    	$coachList = db('grade_member')->where(['type'=>4,'camp_id'=>$camp_id,'status'=>1])->select();
    	$assitantList = db('grade_member')->where(['type'=>8,'camp_id'=>$camp_id,'status'=>1])->select();
    	$this->assign('coachList',$coachList);
    	$this->assign('assitantList',$assitantList);
    	return view();
    }
    //编辑|添加订单接口
    public function updateBillApi(){
    	$id = input('get.id');
    	$data = input('post.');
        $billInfo = $this->BillService->getBill(['id'=>$id]);
        if($billInfo['is_pay']>0){
            return ['code'];
        }
    	if($id){
    		$result = $this->BillService->updateBill($data,$id);
    	}else{
    		$result = $this->BillService->pubBill($data);
    	}

    	return json($result);die;
    	
    }

    public function comfirmBill(){
        // 生成订单号
        $billOrder = '1'.date('YmdHis',time()).rand(0000,9999).$this->memberInfo['id'];
        // 生成微信参数
        // dump($billOrder);die;
        $this->assign('billOrder',$billOrder);
        return view();
    }

    
    public function finishBill(){
        //查询是否成功支付
        $billOrder = input('bill_order');
        if(!$billOrder){
            $billInfo = [];
        }else{
            $billInfo = $this->BillService->getBill(['bill_order'=>$billOrder]);
        }       
        $this->assign('billInfo',$billInfo);
        return view();
    }

    public function finishBookBill(){
        return view();
    }
}