<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\GoodsService;
class Goods extends Base{
   protected $GoodsService;
 
    public function _initialize(){
        parent::_initialize();
        $this->GoodsService = new GoodsService;
    }
 
    // 获取商品列表
    public function getGoodsListApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            $page = input('param.page')?input('param.page'):1; 
            foreach ($map as $key => $value) {
                if($value == ''|| empty($value) || $value==' '){
                    unset($map[$key]);
                }
            }
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['goods|subtitle'] = ['LIKE','%'.$keyword.'%'];
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $result = $this->GoodsService->getGoodsList($map,$page);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  

        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
     // 获取商品列表 无page
    public function getGoodsListNoPageApi(){
        try{
            $map = input('post.');
            $result = $this->GoodsService->getGoodsListNoPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  
            
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
    // 获取商品列表带page
    public function getGoodsListByPageApi(){
        try{
            $map = input('post.');
            $result = $this->GoodsService->getGoodsListByPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  

        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 获取商品详情
    public function getGoodsInfoApi(){
        try{
            $map = input('post.');
            $result = $this->GoodsService->getGoodsInfo($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  

        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    


    // 获取用户的商品带page
    public function getGoodsCartListByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');

            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['goods'] = ['LIKE','%'.$keyword.'%'];
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }

            $result = $this->GoodsService->getGoodsCartListByPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }



    // 编辑商品
    public function updateGoodsApi(){
         try{
            $data = input('post.');
            $goods_id = input('param.goods_id');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $goodsInfo = $this->GoodsService->getGoodsInfo(['id'=>$goods_id]);
            if($goodsInfo['member_id']<>$this->memberInfo['id']){
                return json(['code'=>100,'msg'=>'权限不足']);
            }

            $result = $this->GoodsService->updateGoods($data,['id'=>$goods_id]);
            return json($result);
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }

    // 操作商品
    public function editGoodsApi(){
        try{
           $data = input('post.');
           $goods_id = input('param.goods_id');
           $goodsInfo = $this->GoodsService->getGoodsInfo(['id'=>$goods_id]);
        
           $data['member_id'] = $this->memberInfo['id'];
           $data['member'] = $this->memberInfo['member'];
           $result = db('goods')->where(['id'=>$goods_id])->update($data);
           if($result){
                return json(['code'=>200,'msg'=>'ok']);
            }
            return json(['code'=>100,'msg'=>'失败']);
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    //创建商品
    public function createGoodsApi(){
        try{
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];

            $result = $this->GoodsService->createGoods($data);
            if($result['code'] == 200){
                
            }
            return json($result);   
        }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


 
    //加入商品购物车
    public function createGoodsCartApi(){
        try{
            $data['goods_id'] = input('param.goods_id');
            $data['member_id'] = input('param.member_id',$this->memberInfo['id']);
            $data['member'] = input('param.member',$this->memberInfo['member']);
            $result = $this->GoodsService->createGoodsCart($data);
            return json($result);   
        }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }



    //退出商品/踢出商品
    public function dropGoods(){
        try{
            $id = input('param.id');
            $member_id = input('param.member_id',$this->memberInfo['id']);
            $goods_id = input('param.goods_id');
            $result = $this->GoodsService->dropGoods($member_id,$goods_id,$id);
            return json($result);   
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }




    //将多人批量踢出商品
    public function dropGoodss(){
        try{
            $idList = input('param.idList');
            $ids = json_decode($idList);
            $member_id = input('param.member_id',$this->memberInfo['id']);
            $goods_id = input('param.goods_id');
            $result = $this->GoodsService->dropGoodss($member_id,$goods_id,$ids);
            return json($result);   
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    //解散商品
    public function dissolveGoodsApi(){
        try {
            $member_id = input('param.member_id',$this->memberInfo['id']);
            $goods_id = input('param.goods_id');
            $goodsInfo = $this->GoodsService->getGoodsInfo(['id'=>$goods_id]);
            if($goodsInfo['member_id']<>$this->memberInfo['id']){
                return json(['code'=>100,'msg'=>'权限不足']);
            }
            if($goodsInfo['status']<>1){
                return json(['code'=>100,'msg'=>'商品已解散']);
            }
            $isPool = db('pool')->where(['goods_id'=>$goods_id,'status'=>['gt',0]])->find();
            if($isPool){
                return json(['code'=>100,'msg'=>'已有奖金池规则在进行中,不可解散']);
            }
            $result = $this->GoodsService->dissolveGoods($goods_id);
            if($result){
                return json(['code'=>200,'msg'=>'操作成功']);
            }else{
                return json(['code'=>100,'msg'=>'权限不足']);
            }
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }




    // 获取带本期打卡总数的商品群员列表
    public function getGoodsCartWithTotalPunchListApi(){
        try{
            $goods_id = input('param.goods_id');
            $status = input('param.status',1);
            $page = input('param.page',1);
            $goods_member = db('goods_member')->where(['goods_id'=>$goods_id,'status'=>$status])->where('delete_time',null)->page($page)->select();
            $poolInfo = db('pool')->where(['goods_id'=>$goods_id,'status'=>2])->where('delete_time',null)->find();
            foreach ($goods_member as $key => $value) {
                    $goods_member[$key]['c_p'] = 0;
                }
            if($poolInfo){
                $memberIDs = [];
                foreach ($goods_member as $key => $value) {
                    $memberIDs[] = $value['member_id'];
                }
                $punchs = db('goods_punch')->field('count(id) as c_id,member_id,member')->where(['member_id'=>['in',$memberIDs],'pool_id'=>$poolInfo['id']])->where('delete_time',null)->goods('member_id')->select();
                foreach ($goods_member as $key => $value) {
                    foreach ($punchs as $k => $val) {
                        if($val['member_id'] == $value['member_id']){
                            $goods_member[$key]['c_p'] = $val['c_id'];
                        }
                    }
                }
            }

            
            return json(['code'=>200,'msg'=>'获取成功','data'=>$goods_member]);   
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 获取带奖金池的goodsList不分页
    public function getGoodsListJoinPoolApi(){
        try {
            // 获取开启奖金池规则的商品
            $goodsList = [];
            $punch_time = input('param.punch_time');
            if ($punch_time) {
                $punchTime_start = strtotime($punch_time);
                $punchTime_end = $punchTime_start+86399;
            }else{
                return json(['code'=>100,'msg'=>'请选择时间']);
            }
            $goodsList = db('pool')
                ->field('goods_member.*,pool.stake,pool.pool,(pool.status) as p_status,(pool.id) as p_id,pool.times,pool.create_time')
                ->join('goods_member','pool.goods_id = goods_member.goods_id','left')
                ->where(['goods_member.member_id'=>$this->memberInfo['id'],'goods_member.status'=>1])
                // ->where(['pool.status'=>2])
                // ->goods('pool.goods_id')
                ->where('goods_member.delete_time',null)
                ->where('pool.delete_time',null)
                ->order('pool.create_time desc')
                ->select();

            //如果某人当天已在奖金池里打卡超过times(不允许打卡)
            $pool_ids = [];
            if(!empty($goodsList)){
                foreach ($goodsList as $key => $value) {
                    //只有进行中的奖金池才统计打卡次数
                    if($value['status'] == 2){
                        $pool_ids[] = $value['p_id'];
                    }
                    $goodsList[$key]['punchs'] = 0;
                }
                $punchList = db('goods_punch')->field('count(id) as c_id,pool_id')->where(['pool_id'=>['in',$pool_ids]])->where(['member_id'=>$this->memberInfo['id']])->where(['create_time'=>['between',[$punchTime_start,$punchTime_end]]])->where('delete_time',null)->goods('pool_id')->select();
                foreach ($goodsList as $key => $value) {
                    foreach ($punchList as $k => $val) {
                        if($val['pool_id'] == $value['p_id']){
                            // unset($goodsList[$key]);
                            $goodsList[$key]['punchs'] = $val['c_id'];
                        }
                    }
                }
            }
            return json(['code'=>200,'msg'=>'获取成功','data'=>$goodsList]);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }




    // 获取带总打卡数并且是否关注的群员
    public function getGoodsCartWithFollowApi(){
        try {
            $goods_id = input('param.goods_id');
            $member_id = $this->memberInfo['id'];
            $page = input('param.page',1);
            $status = input('param',1);
            $sql = "SELECT
                    `goods_member`.*
                    , gp.c_punch
                    ,follow.STATUS AS f_status 
                FROM
                    `goods_member`
                    LEFT JOIN (
                    SELECT count(id) as c_punch,member_id FROM goods_punch where goods_id = {$goods_id} AND delete_time is NULL GROUP BY member_id
                    ) as gp 
                    on gp.member_id = goods_member.member_id
                    LEFT JOIN `follow` `follow` ON `follow`.`follow_id` = goods_member.member_id 
                    AND follow.member_id = {$member_id} 
                WHERE
                    `goods_member`.`goods_id` = {$goods_id}
                    AND goods_member.delete_time is null
                    AND goods_member.status = {$status}
                ORDER BY
                    `gp`.c_punch desc
                    LIMIT
                    :s,
                    :e"
                    ;
        $Db = new \think\Db;
        $result = $Db::query($sql,['s'=>($page-1)*20,'e'=>$page*20]);
        return json(['msg'=>'获取成功','code'=>200,'data'=>$result]);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);   
        }
    }


    
    public function getGoodsCartNoPageApi(){
        try {
            $map = input('post.');
            $GoodsCart = new \app\model\GoodsCart;
            $result = $GoodsCart->where($map)->select();
            return json(['msg'=>'获取成功','code'=>200,'data'=>$result]);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);   
        }
    }
}