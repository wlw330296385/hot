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
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''&&$keyword){
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
                $result = $this->ArticleService->updateComment($data,['id'=>$comment_id,'member_id'=>$this->memberInfo['id']]);
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


    public function likesApi(){
        try{
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            
            $likesInfo = $this->ArticleService->getLikesInfo(['article_id'=>$data['article_id'],'member_id'=>$data['member_id']]);
            if($likesInfo){
                if($likesInfo['status'] == 1){
                    $result = $this->ArticleService->updateLikes(['status'=>-1,'article_id'=>$data['article_id']],['id'=>$likesInfo['id']]);
                }else{
                    $result = $this->ArticleService->updateLikes(['status'=>1,'article_id'=>$data['article_id']],['id'=>$likesInfo['id']]);
                }
            }else{
                $result = $this->ArticleService->createLikes($data);
            }
            return json($result);   
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }



    public function collectApi(){
        try{
            $data = input('post.');
            $data['member_id'] = $this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            
            $collectInfo = $this->ArticleService->getCollectInfo(['article_id'=>$data['article_id'],'member_id'=>$data['member_id']]);
            if($collectInfo){
                if($collectInfo['status'] == 1){
                    $result = $this->ArticleService->updateCollect(['status'=>-1,'article_id'=>$data['article_id']],['id'=>$collectInfo['id']]);
                }else{
                    $result = $this->ArticleService->updateCollect(['status'=>1,'article_id'=>$data['article_id']],['id'=>$collectInfo['id']]);
                }
            }else{
                $result = $this->ArticleService->createCollect($data);
            }
            return json($result);   
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    public function editArticleApi() {
        try {
            // 接收参数，检查参数是否符合
            $article_id = input('param.article_id');
            $articleInfo = db('article')->where(['id'=>$article_id])->find();
            if(!$articleInfo){
                return json(['code'=>100,'msg'=>'传参错误']);
            }
            if($articleInfo['organization_type'] == 2){
                $isPower = $this->ArticleService->isPower($articleInfo['organization_id'],$this->memberInfo['id']);
                if($isPower<2){
                    return json(['code'=>100,'msg'=>'权限不足']);
                }
            }elseif ($articleInfo['organization_type'] == 1) {
                return json(['code'=>100,'msg'=>'系统文章不允许操作']);
            }
            
            $data = input('post.');
            $result = db('article')->where(['id'=>$article_id])->update($data);
            if($result){
                return json(['code'=>200,'msg'=>'操作成功']);
            }else{
                return json(['code'=>100,'msg'=>'操作失败']);
            }
        } catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }



}