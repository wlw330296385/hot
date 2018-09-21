<?php
namespace app\management\controller;

use app\management\controller\Camp;
use app\service\ArticleService;
class Article extends Camp {
    private $ArticleListService; 
	public function _initialize(){
		parent::_initialize();
        $this->ArticleService = new ArticleService();
	}
    public function articleList() {
        
        $map = ['organization_type'=>2,'organization_id'=>$this->campInfo['id']];

        $keyword = input('param.keyword');
        if($keyword){
            
            $map = ['title'=>['like',"%$keyword%"]];
            
        }
        $articleList = $this->ArticleService->getArticleListByPage($map);

        $this->assign('articleList',$articleList);    
        return view('Article/articleList');
    	
    }

    public function articleInfo(){
        $article_id = input('param.article_id');
        $map['id'] = $article_id;
        $articleInfo = $this->ArticleService->getArticleInfo($map);

        if ($articleInfo['organization_id']<>$this->campInfo['id']) {
            $this->error('非法操作');
        }
        $this->assign('articleInfo',$articleInfo);
        return  view('Article/articleInfo');
    }

    public function createArticle(){
        if(request()->isPost()){
            $data = input('post.');
            $data['member_id']=$this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['organization_type'] = 2;
            $data['organization'] = $this->campInfo['camp'];
            $data['organization_id'] = $this->campInfo['id'];
            $data['category'] = 3;
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

        if ($articleInfo['organization_id']<>$this->campInfo['id']) {
            $this->error('非法操作');
        }

        if(request()->isPost()){
            $data = input('post.');
            if ($articleInfo['organization_id']<>$this->campInfo['id']) {
                $this->error('非法操作');
            }
            $data['member_id']=$this->memberInfo['id'];
            $data['member'] = $this->memberInfo['member'];
            $data['organization_type'] = 2;
            $data['organization'] = $this->campInfo['camp'];
            $data['organization_id'] = $this->campInfo['id'];
            $data['category'] = 3;
            $result = $this->ArticleService->updateArticle($data,['id'=>$article_id]);
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
