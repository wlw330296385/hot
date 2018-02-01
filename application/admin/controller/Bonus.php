<?php 
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\admin\service\BonusService;
class Bonus extends Backend{
	protected $BonusService;
	public function _initialize(){
		parent::_initialize();
		$this->BonusService = new BonusService;
	}

    public function index() {

        return view('Bonus/index');
    }


    public function BonusInfo(){
    	$Bonus_id = input('param.bonus_id');
        $BonusInfo = $this->BonusService->getBonusInfo(['id'=>$Bonus_id]);
        $BonusMemberInfo = $this->BonusService->getBonusMemberInfo(['bonus_id'=>$Bonus_id,'member_id'=>$this->memberInfo['id']]);
        // dump($BonusMemberInfo);die;
        $this->assign('BonusMemberInfo',$BonusMemberInfo);
        $this->assign('BonusInfo',$BonusInfo);
    	return view('Bonus/BonusInfo');
    }

    public function BonusList(){
        

        $field = '请选择搜索关键词';
        $map = [];

        $field = input('param.field');
        $keyword = input('param.keyword');
        if($keyword==''){
            $map = [];
            $field = '请选择搜索关键词';
        }else{
            if($field){
                $map = [$field=>['like',"%$keyword%"]];
            }else{
                $field = '请选择搜索关键词';
                $map = function($query) use ($keyword){
                    $query->where(['coupon'=>['like',"%$keyword%"]])
                    // ->whereOr(['telephone'=>['like',"%$keyword%"]])
                    // ->whereOr(['nickname'=>['like',"%$keyword%"]])
                    // ->whereOr(['hot_id'=>['like',"%$keyword%"]])
                    ;
                };
            }
        }
            
        $BonusList = $this->BonusService->getBonusListByPage($map);
        $this->assign('field',$field);

        // dump($BonusList->toArray());die;
        $this->assign('BonusList',$BonusList);
        return view('Bonus/bonusList');
    }

    public function updateBonus(){   	
    	$Bonus_id = input('param.bonus_id');
        $bonusInfo = $this->BonusService->getBonusInfo(['id'=>$Bonus_id]);
        if(request()->isPost()){
            $data = input('post.');
            $result = $this->BonusService->updateBonus($data,['id'=>$Bonus_id]);
            if($result['code'] == 200){
                $this->success($result['msg']);
            }else{
                $this->success($result['msg']);
            }
        }
		$this->assign('bonusInfo',$bonusInfo);
    	return view('Bonus/updateBonus');
    }

    public function createBonus(){

        if(request()->isPost()){
            $data = input('post.');
            $result = $this->BonusService->createBonus($data);
            if($result['code'] == 200){
                $this->success($result['msg']);
            }else{
                $this->success($result['msg']);
            }
        }
        return view('Bonus/createBonus');
    }
    // 分页获取数据
    public function BonusListApi(){
    	$camp_id = input('param.camp_id');
        $condition = input('post.');
        $where = ['status'=>['or',[1,$camp_id]]];
        $map = array_merge($condition,$where);
    	$BonusList = $this->BonusService->getBonusPage($map,10);
    	return json($result);
    }

    public function searchBonusList(){
        $camp_id = input('param.camp_id');
        $this->assign('camp_id',$camp_id);
        return view('Bonus/searchBonusList');
    }
}