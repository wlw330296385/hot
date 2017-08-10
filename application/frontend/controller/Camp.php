<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\CampService;
class Camp extends Base{
    protected $CampService;
	public function _initialize(){
		parent::_initialize();
	}


    public function index() {
    	$a = input();
    	$b = ['b'=>123];
    	$c = array_merge($a,$b);
    	dump($c);
        return view();
    }

    public function createCamp(){
        return view();
    }

    public function campInfo(){
        $id = input('id');
        $result = $this->CampService->CampOneById($id);
        $this->assign('campInfo',$result);
        return view();
    }

    public function campList(){
        $map = input();
        $campList = $this->CampService->campListPage($map);
        $this->assign('campList',$campList);
        return view();
    }

    public function searchCamp(){
        $keyword = input('keyword');
        $province = input('province');
        $city = input('city');
        $area = input('area');
        $map = ['province'=>$province,'city'=>$city,'area'=>$area];
        foreach ($map as $key => $value) {
            if($value == ''){
                unset($map[$key])
            }
        }
        if($keyword){
            $map['camp'] = ['LIKE',$keyword];
        }
        $campList = $this->CampService->getCampList($map);
        $this->assign('campList',$campList);
        return view();
    }

    public function searchCampApi(){
        try{
             $keyword = input('keyword');
            $province = input('province');
            $city = input('city');
            $area = input('area');
            $map = ['province'=>$province,'city'=>$city,'area'=>$area];
            foreach ($map as $key => $value) {
                if($value == ''){
                    unset($map[$key])
                }
            }
            if($keyword){
                $map['camp'] = ['LIKE',$keyword];
            }
            $campList = $this->CampService->campListPage($map);
            return json(['code'=>100,'msg'=>'OK','data'=>$campList]);
        }catch(Exception $e){
            return json(['code'=>200,'msg'=>$e->getMessage()]);
        }       
    }


    // 邀请学生入驻
    public function inviteStudent(){
        $data = input('get.');
        $data['member'] = $this->memberInfo['member'];
        $data['member_id'] = $this->memberInfo['id'];
        $data['type'] = 1;
        $data['status'] = 1;
        $is_join = db('grade_member');
        return view();
    }



    // 邀请教练入驻
    public function inviteCoach(){
        return view();
    }
}
