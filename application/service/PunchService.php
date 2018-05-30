<?php
// 证件 service
namespace app\service;

use app\model\Punch;
use app\model\PunchComment;
use app\model\PunchLikes;
use think\Db;
class PunchService {
    protected $Punch;
    public function __construct(){
        $this->Punch = new Punch;
        $this->PunchLikesModel = new PunchLikes;
        $this->PunchCommentModel = new PunchComment;
    }

    public function getPunchInfo($map) {
        $result = $this->Punch->where($map)->find();
        return $result;
    }

    public function getPunchList($map,$page = 1,$p= 10){
    	$result = $this->Punch->where($map)->page($page,$p)->select();
    	return $result;
    }


    public function getPunchListByPage($map,$paginate = 10){
        $result = $this->Punch->where($map)->paginate($paginate);
        return $result;
    }

    // 新增打卡
    public function createPunch($data){
        $stakes = ceil($data['stakes']);
        if($stakes < $this->memberInfo['hot_coin']){
            return json(['code'=>100,'msg'=>'热币不足']);
        }
        $res = db('member')->where(['id'=>$data['member_id']])->dec('hot_coin',$stakes)->update();
        if(!$res){
            return ['code'=>100,'msg'=>'热币扣除失败,请重试'];
        }

        $result = $this->Punch->save($data);
        if($result){
            db('hotcoin_finance')->insert(
                [
                    'member_id' =>$data['member_id'],
                    'member'    =>$data['member'],
                    'member'    =>$data['member'],
                    'hot_coin'  =>-$stakes,
                    'type'      =>-1,
                    'status'    =>1,
                    'f_id'      =>$this->Punch->id,
                    'create_time'=>time(),
                ]
            );
            return ['code'=>200,'msg'=>'创建成功','data'=>$this->Punch->id];
        }else{
            return ['code'=>100,'msg'=>'创建失败'];
        }

    }



    public function getGroupPunchListByPage($map,$paginate = 10){
        $GroupPunch = new \app\model\GroupPunch;
        $result = $GroupPunch->with('punch')->where($map)->paginate($paginate);
        return $result;
    }







    // 新建评论
    public function createComment($data){
        $result = $this->PunchCommentModel->save($data);
        if($result){
            $this->incPunch(['id'=>$data['punch_id']],'comments');    
            return ['msg' => '操作成功', 'code' => 200, 'data' => $this->PunchCommentModel->id];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }


    // 修改评论
    public function updateComment($data,$map){
        $result = $this->PunchCommentModel->save($data,$map);
        if($result){
            return ['msg' => '操作成功', 'code' => 200];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }



    // 文章字段加加减减
    public function incPunch($map,$field){
        $this->Punch->where($map)->setInc($field);
    }

    // 文章字段加加减减
    public function decPunch($map,$field){
        $this->Punch->where($map)->setDec($field);
    }

    public function getCommentList($map,$paginate= 10,$order = 'id desc'){
        $result = $this->PunchCommentModel->where($map)->order($order)->page($paginate)->select();
        return $result;
        
    }


    public function getCommentListByPage($map,$paginate= 10,$order = 'id desc'){
        $result = $this->PunchCommentModel->where($map)->order($order)->paginate($paginate);
        return $result;
        
    }



    // 新建点赞
    public function createLikes($data){
        $result = $this->PunchLikesModel->save($data);
        if($result){
            $this->incPunch(['id'=>$data['punch_id']],'likes');    
            return ['msg' => '点赞成功', 'code' => 200, 'data' => $this->PunchLikesModel->id];
        }else{
            return ['msg'=>'点赞失败', 'code' => 100];
        }
    }


    // 修改点赞
    public function updateLikes($data,$map){
        $result = $this->PunchLikesModel->save($data,$map);
        if($result){
            if($data['status'] == -1){
                $this->decPunch(['id'=>$data['punch_id']],'likes');  
            }else{
                $this->incPunch(['id'=>$data['punch_id']],'likes');   
            }
            return ['msg' => '操作成功', 'code' => 200];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }

}