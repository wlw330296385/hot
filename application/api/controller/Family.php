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
}

