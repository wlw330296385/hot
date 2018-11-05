<?php
namespace app\admin\controller;

use app\admin\controller\base\Backend;
use app\model\Goods;
class Mall extends Backend {
	public function _initialize(){
		parent::_initialize();
	}
    public function goodsList() {
        $map = [];

        
        $keyword = input('param.keyword');
        if($keyword){
            $map = ['goods'=>['like',"%$keyword%"]];
        }
        $shop_id = input('param.shop_id');
        if($shop_id){
            $map['shop_id'] = $shop_id;
        }
        $Goods = new \app\model\Goods;
        $goodsList = $Goods->where($map)->paginate(20);
        // 商店列表
        $shopList = db('shop')->select();
        $this->assign('keyword',$keyword);
        $this->assign('goodsList',$goodsList);    
        return view('Mall/goodsList');
    	
    }

    public function goodsInfo(){
        $goods_id = input('param.goods_id');
        $map['id'] = $goods_id;
        $Goods = new \app\model\Goods;
        $goodsInfo = $Goods->where($map)->find();

        $this->assign('goodsInfo',$goodsInfo);
        return  view('Mall/goodsInfo');
    }

    public function createGoods(){
        $goods_type = input('param.goods_type',1);
        $skuTypeList = db('sku')->where(['goods_type'=>$goods_type])->select();
        $goodsCategoryList = db('goods_category')->select();
        $goodsCategoryListTree = getTree($goodsCategoryList);
        if(request()->isPost()){
            $data = input('post.');
            $Goods = new \app\model\Goods;
            $result = $Goods->save($data);
            if($result){
                $this->success("操作成功",'/admin/Goods/goodsList');
            }else{
                $this->error("操作失败");
            }
        }

        $this->assign('skuTypeList',$skuTypeList);
        $this->assign('goodsCategoryListTree',$goodsCategoryListTree);
        return view('Mall/createGoods');
    }


    public function updateGoods(){
        $goods_id = input('param.goods_id');
        $map['id'] = $goods_id;
        $Goods = new \app\model\Goods;
        $goodsInfo = $Goods->getGoodsInfo($map);


        if(request()->isPost()){
            $data = input('post.');
            $id = $data['id'];
            $result = $Goods->save($data,['id'=>$id]);
            if($result['code'] == 200){
                $this->success($result['msg'],url('admin/Mall/goodsInfo',['goods_id'=>$goods_id]));
            }else{
                $this->error($result['msg']);
            }
        }


        $this->assign('goodsInfo',$goodsInfo);

        return view('Mall/updateGoods');
    }

}
