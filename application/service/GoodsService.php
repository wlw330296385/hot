<?php
namespace app\service;
use app\model\Goods;
use think\Db;
use app\common\GoodsVal;
use app\model\\app\model\GoodsCart;
class GoodsService{

    private $GoodsModel;

    public function __construct(){
        $this->GoodsModel = new Goods;

    }


    // 商品列表
    public function getGoodsList($map=[],$page = 1, $order='id desc',$p=10) {
        $res = $this->GoodsModel->where($map)->order($order)->page($page,$p)->select();
        return $res;
    }

    // 获取商品列表（关联课程信息、无分页)
    public function getGoodsAllWithLesson($map , $order='id desc') {
        $result = $this->GoodsModel->where($map)->order($order)->select();
        return $result;
        
    }

    // 商品分页
    public function getGoodsListByPage($map , $order='id desc', $paginate=10) {
        $result =  $this->GoodsModel
                ->where($map)
                ->order($order)
                ->paginate($paginate);
        return $result;
        
        
    }

    // 商品分页
    public function getGoodsListNoPage($map , $order='id desc') {
        $result =  $this->GoodsModel
                ->where($map)
                ->order($order)
                ->select();
        return $result;
        
        
    }


    // 一个商品
    public function getGoodsInfo($map=[]) {
        $res = $this->GoodsModel->where($map)->find();
        
        return $res;
    }

    // 获取商品分类 $tree传1 返回树状列表，不传就返回查询结果集数组
    public function getGoodsCategory($tree=0) {
        $res = db('goods_category')->field(['id', 'name', 'pid'])->select();
        
        return $res;
       
    }


    // 返回商品数量统计
    public function countGoodss($map){
        $result = $this->GoodsModel->where($map)->count();
        return $result?$result:0;
    }

    // 新增商品
    public function createGoods($data){
        $validate = validate('GoodsVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        $result = $this->GoodsModel->allowField(true)->save($data);
         if (!$result) {
            return [ 'msg' => __lang('MSG_400'), 'code' => 100 ];
        }else{
            db('camp')->where(['id'=>$data['camp_id']])->setInc('total_goods');
            return [ 'msg' => __lang('MSG_200'), 'code' => 200, 'data' => $this->GoodsModel->id];
        }
    }

    // 编辑商品
    public function updateGoods($data,$id){
        $validate = validate('GoodsVal');
        if(!$validate->scene('edit')->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        $result = $this->GoodsModel->allowField(true)->save($data,['id'=>$id]);
         if (!$result) {
            return [ 'msg' =>'商品信息更新失败', 'code' =>100 ];
        }else{
             return [ 'msg' => '操作成功', 'code' => 200, 'data' => $result];
        }
    }
   


     // 获取属性列表
     public function getGoodsCartList($map,$page = 1,$paginate = 10){
        $result = \app\model\GoodsCart::where($map)
                ->select();
        return $result;
        
    }


    // 修改商品status字段 2017/10/2
    public function updateGoodsStatus($goods_id, $status=0) {

        $result = $this->GoodsModel->save([ 'status' => $status],['id' => $goods_id]);

        return $result;
    }

    // (软)删除商品 2017/10/2
    public function delGoods($id) {
        $result = $this->GoodsModel->destroy($id);
        return $result;
    }

    // 批量更新商品-属性goods_member数据
    public function createGoodsCart($data) {
        $GoodsCart = new \app\model\GoodsCart();
        $is = $GoodsCart->where(['goods_sku_id'=>$data['gooods_sku_id'],'goods_id'=>4data['goods_id'],'member_id'=>$data['member_id'],'status'=>1])->find();
        if(!$is){
            $res = $GoodsCart->isUpdate(false)->save($data);  
        }else{
            $res = $GoodsCart->where(['goods_sku_id'=>$data['gooods_sku_id'],'goods_id'=>4data['goods_id'],'member_id'=>$data['member_id'],'status'=>1])->setInc('total',$data['total']);  
        }
        if ($res) {
            return ['code' => 200, 'msg' => '加入购物车成功'];
        } else {
            return ['code' => 100, 'msg' => '加入购物车失败'];
        }
    }

    // 获取商品的属性列表数据
    public function getGoodsCart($map=[], $order=['id' => 'desc']) {
        $GoodsCart = new \app\model\GoodsCart();
        $res = $GoodsCart->where($map)->order($order)->select();
        return $result;
    }

















}