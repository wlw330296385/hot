<?php
namespace app\management\controller;

use app\management\controller\base\Backend;
use app\service\ArticleService;
class Article extends Backend {
    private $ArticleListService; 
	public function _initialize(){
		parent::_initialize();
        $this->ArticleService = new ArticleService();
	}
    public function articleList() {
        $field = '请选择搜索关键词';
        $map = [];

        $field = input('param.field');
        $keyword = input('param.keyword');
        if($keyword==''){
            $map = [];
            $field = '请选择搜索关键词';
        }else{
            if($field){
                $map = [$field=>['like',"%$keyword%"]];
            }else{
                $field = '请选择搜索关键词';
                $map = function($query) use ($keyword){
                    $query->where(['title'=>['like',"%$keyword%"]]);
                };
            }
        }
        $articleList = $this->ArticleService->getArticleListByPage($map);
        $this->assign('field',$field);
        $this->assign('articleList',$articleList);    
        return view('Article/articleList');
    	
    }

    public function articleInfo(){
        $article_id = input('param.article_id');
        $map['id'] = $article_id;
        $articleInfo = $this->ArticleService->getArticleInfo($map);

        $this->assign('articleInfo',$articleInfo);
        return  view('Article/articleInfo');
    }

    public function createArticle(){
        if(request()->isPost()){
            $data = input('post.');
            $data['member_id']=$this->management['id'];
            $data['member'] = $this->management['username'];
            $result = $this->ArticleService->createArticle($data);
            if($result['code'] == 200){
                $this->success($result['msg'],'/management/Article/articleList');
            }else{
                $this->error($result['msg']);
            }
        }

        return view('Article/createArticle');
    }


    public function updateArticle(){
        $article_id = input('param.article_id');
        $map['id'] = $article_id;
        $articleInfo = $this->ArticleService->getArticleInfo($map);


        if(request()->isPost()){
            $data = input('post.');
            $id = $data['id'];

            $data['member_id']=$this->management['id'];
            $data['member'] = $this->management['username'];
            $result = $this->ArticleService->updateArticle($data,['id'=>$id]);
            if($result['code'] == 200){
                $this->success($result['msg'],url('management/Article/articleInfo',['article_id'=>$article_id]));
            }else{
                $this->error($result['msg']);
            }
        }


        $this->assign('articleInfo',$articleInfo);

        return view('Article/updateArticle');
    }

}
