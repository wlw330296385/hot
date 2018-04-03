<?php

namespace app\service;

use app\model\Article;
use app\model\ArticleComment;
use app\model\ArticleLikes;
use app\model\ArticleCollect;
use think\Db;
use app\common\validate\ArticleVal;
use app\common\validate\ArticleCommentVal;
class ArticleService {
    private $ArticleModel;
    private $ArticleCommentModel;
    private $ArticleLikesModel;
    private $ArticleCollectModel;
    public function __construct(){
        $this->ArticleModel = new Article;
        $this->ArticleLikesModel = new ArticleLikes;
        $this->ArticleCommentModel = new ArticleComment;
        $this->ArticleCollectModel = new ArticleCollect;
    }


    // 获取所有文章
    public function getArticleList($map=[],$page = 1,$order='',$paginate = 10) {
        $result = Article::where($map)->order($order)->page($page,$paginate)->select();

        return $result;
    }

    // 分页获取文章
    public function getArticleListByPage($map=[], $order='',$paginate=10){
        $result = Article::where($map)->order($order)->paginate($paginate);
        return $result;
    }

    // 软删除
    public function SoftDeleteArticle($id) {
        $result = Article::destroy($id);
        if (!$result) {
            return [ 'msg' => __lang('MSG_400'), 'code' => 100 ];
        } else {
            return ['msg' => __lang('MSG_200'), 'code' => 200, 'data' => $result];
        }
    }

    // 获取一个文章
    public function getArticleInfo($map) {
        $result = Article::where($map)->find();
        return $result;
    }




    // 编辑文章
    public function updateArticle($data,$map){
        
        $validate = validate('ArticleVal');
        if(!$validate->scene('edit')->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        
        $result = $this->ArticleModel->allowField(true)->save($data,$map);
        if($result){
            return ['msg' => '操作成功', 'code' => 200, 'data' => $map];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }

    // 新增文章
    public function createArticle($data){
        
        $validate = validate('ArticleVal');
        if(!$validate->scene('add')->check($data)){
            return ['msg' => $validate->getError(), 'code' => 100];
        }
        $result = $this->ArticleModel->allowField(true)->save($data);
        if($result){
            return ['msg' => '操作成功', 'code' => 200, 'data' => $this->ArticleModel->id];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }


    /**
     * 获取会员在训练营角色
     */
    public function isPower($camp_id,$member_id){
        $is_power = db('camp_member')
                    ->where(['member_id'=>$member_id,'camp_id'=>$camp_id,'status'=>1])
                    ->whereNull('delete_time')
                    ->value('type');
        return $is_power?$is_power:0;
    }

    // 新建评论
    public function createComment($data){
        $validate = validate('ArticleCommentVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        $result = $this->ArticleCommentModel->save($data);
        if($result){
            $this->incArticle(['id'=>$data['article_id']],'comments');    
            return ['msg' => '操作成功', 'code' => 200, 'data' => $this->ArticleCommentModel->id];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }


    // 修改评论
    public function updateComment($data,$map){
        $validate = validate('ArticleCommentVal');
        if(!$validate->check($data)){
            return ['msg' => $validate->getError(), 'code' => 200];
        }
        $result = $this->ArticleCommentModel->save($data,$map);
        if($result){
            return ['msg' => '操作成功', 'code' => 200];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }

    // 文章字段加加减减
    public function incArticle($map,$field){
        $this->ArticleModel->where($map)->setInc($field);
    }

    // 文章字段加加减减
    public function decArticle($map,$field){
        $this->ArticleModel->where($map)->setDec($field);
    }

    public function getCommentList($map,$paginate= 10,$order = 'id desc'){
        $result = $this->ArticleCommentModel->where($map)->order($order)->page($paginate)->select();
        if($result){ 

            return $result->toArray();    
        }else{
            return $result;
        }
    }


    public function getCommentListByPage($map,$paginate= 10,$order = 'id desc'){
        $result = $this->ArticleCommentModel->where($map)->order($order)->paginate($paginate);
        if($result){ 
            return $result->toArray();    
        }else{
            return $result;
        }
    }

    // 获取点赞
    public function getLikesInfo($map){
        $result = $this->ArticleLikesModel->where($map)->find();
        if($result){ 
            return $result->toArray();
        }else{
            return $result;
        }
    }

    // 新建点赞
    public function createLikes($data){
        $result = $this->ArticleLikesModel->save($data);
        if($result){
            $this->incArticle(['id'=>$data['article_id']],'likes');    
            return ['msg' => '点赞成功', 'code' => 200, 'data' => $this->ArticleLikesModel->id];
        }else{
            return ['msg'=>'点赞失败', 'code' => 100];
        }
    }


    // 修改点赞
    public function updateLikes($data,$map){
        $result = $this->ArticleLikesModel->save($data,$map);
        if($result){
            if($data['status'] == -1){
                $this->decArticle(['id'=>$data['article_id']],'likes');  
            }
            return ['msg' => '操作成功', 'code' => 200];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }


    // 获取点赞
    public function getCollectInfo($map){
        $result = $this->ArticleCollectModel->where($map)->find();
        if($result){ 
            return $result->toArray();
        }else{
            return $result;
        }
    }

    // 新建收藏
    public function createCollect($data){
        $result = $this->ArticleCollectModel->save($data);
        if($result){
            $this->incArticle(['id'=>$data['article_id']],'collects');    
            return ['msg' => '点赞成功', 'code' => 200, 'data' => $this->ArticleCollectModel->id];
        }else{
            return ['msg'=>'点赞失败', 'code' => 100];
        }
    }


    // 修改收藏
    public function updateCollect($data,$map){
        $result = $this->ArticleCollectModel->save($data,$map);
        if($result){
            if($data['status'] == -1){
                $this->decArticle(['id'=>$data['article_id']],'collects');  
            }
            return ['msg' => '操作成功', 'code' => 200];
        }else{
            return ['msg'=>'操作失败', 'code' => 100];
        }
    }
}

