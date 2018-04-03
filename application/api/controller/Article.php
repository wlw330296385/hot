<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\ArticleService;
class Article extends Base{
   protected $ArticleService;
 
    public function _initialize(){
        parent::_initialize();
       $this->ArticleService = new ArticleService;
    }
 
    public function getArticleListApi(){
         try{
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1; 
            $result = $this->ArticleService->getArticleList($map,$page);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  
            
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }
 
     public function getArticleListByPageApi(){
         try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['title'] = ['LIKE','%'.$keyword.'%'];
            }
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            if( isset($map['page']) ){
                unset($map['page']);
            }
            $result = $this->ArticleService->getArticleListByPage($map);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  
            
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }

    public function updateArticleApi(){
         try{
             $data = input('post.');
            $article_id = input('param.article_id');
             $data['member_id'] = $this->memberInfo['id'];
             $data['member'] = $this->memberInfo['member'];
            $result = $this->ArticleService->updateArticle($data,['id'=>$article_id]);
             return json($result);
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }
 
    public function createArticleApi(){
        try{
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $result = $this->ArticleService->createArticle($data);
            return json($result);   
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    public function commentApi(){
        try{
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['avatar'] = $this->memberInfo['avatar'];
            $comment_id = input('param.comment_id');
            if($comment_id){
                $result = $this->ArticleService->updateComment($data,['id'=>$comment_id]);
            }else{
                $result = $this->ArticleService->createComment($data);
            }
            return json($result);   
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }   
    }

    // 获取评论列表
    public function getCommentListApi(){
        try{
            $map = input('post.');
            $result = $this->ArticleService->getCommentList($map);
            if($result){
                return json(['msg' => '获取成功', 'code' => 200, 'data' => $result]);
            }else{
                return json(['msg'=>'获取失败', 'code' => 100]);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        } 
    }
    // 获取评论列表byPage
    public function getCommentListByPageApi(){
        try{
            $map = input('post.');
            $result = $this->ArticleService->getCommentListByPage($map);
            if($result){
                return json(['msg' => '获取成功', 'code' => 200, 'data' => $result]);
            }else{
                return json(['msg'=>'获取失败', 'code' => 100]);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        } 
    }
}