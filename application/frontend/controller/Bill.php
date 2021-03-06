<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\BillService;
class Bill extends Base{
	protected $BillService;
	public function _initialize(){
		parent::_initialize();
        $this->BillService = new BillService;
	}

    public function index() {
    	
        return view();
    }

    public function billInfo(){
    	$bill_id = input('param.bill_id');
    	$billInfo = $this->BillService->getBill(['id'=>$bill_id]);
        if($billInfo['goods_type']==1){
            $lessonInfo = db('lesson')->where(['id'=>$billInfo['lesson_id']])->find();
        }

        $this->assign('lessonInfo',$lessonInfo);
    	$this->assign('billInfo',$billInfo);
    	return view('Bill/billInfo');
    }

    // 获取会员订单列表
    public function billList(){
        $member_id = input('param.member_id')?input('param.member_id'):$this->memberInfo['id'];
    	$map = input('post.');
        $map['member_id'] = $member_id;
        $billList = $this->BillService->getBillList($map);
        // dump($billList);die;
        $billList['count'] = count($billList);
        $this->assign('billList',$billList);
		return view('Bill/billList');
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
    	$camp_id = input('param.camp_id');
    	$coachList = db('grade_member')->where(['type'=>4,'camp_id'=>$camp_id,'status'=>1])->select();
    	$assitantList = db('grade_member')->where(['type'=>8,'camp_id'=>$camp_id,'status'=>1])->select();
    	$this->assign('coachList',$coachList);
    	$this->assign('assitantList',$assitantList);
    	return view('Bill/createBill');
    }
    //编辑|添加订单接口
    public function updateBillApi(){
    	$id = input('param.id');
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
        return view('Bill/createBill');
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
        return view('Bill/finishBill');
    }

    public function finishBookBill(){
        
        return view('Bill/finishBookBill');
    }
}