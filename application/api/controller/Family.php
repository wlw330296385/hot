<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\model\Family as FamilyModel;

class Family extends Base{
    protected $FamilyModel;
    public function _initialize(){
        parent::_initialize();
        $this->FamilyModel = new FamilyModel;
    }


    public function getFamilyListNoPageApi(){
        try {
            $map = input('post.');
            $result = $this->FamilyModel->where($map)->select();

            return json(['code'=>200,'msg'=>'查询成功','data'=>$result]);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    //一页10条
    public function getFamilyListApi(){
        try {
            $map = input('post.');
            $page = input('param.page',1);
            $result = $this->FamilyModel->where($map)->page($page)->select();
            return json(['code'=>200,'msg'=>'查询成功','data'=>$result]);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    //新增一个邀请
    public function createFamilyApi(){
        try {
            $map = ['member_id'=>$this->memberInfo['id']];
            $data = input('post.');
            $telephone = input('param.telephone');
            if(!$telephone){
                return json(['code'=>100,'msg'=>'邀请人电话号码必须']);
            }
            $map['telephone'] = $telephone;
            $result = $this->FamilyModel->where($map)->find();
            if($result){
                if($result['status']<>-1){
                    $res = $this->FamilyModel->save(['status'=>-1],$map);
                }else{
                    return json(['code'=>100,'msg'=>'重复邀请']); 
                }
            }
            $data['avatar'] = $this->memberInfo['avatar'];
            $data['member_id'] = $this->memberInfo['id'];
            $res = $this->FamilyModel->save($data);
            if($res){
                return json(['code'=>100,'msg'=>'邀请成功','data'=>$this->FamilyModel->id]);
            }else{
                return json(['code'=>100,'msg'=>'邀请失败']);
            }
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}

