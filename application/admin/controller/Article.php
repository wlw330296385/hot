<?php
namespace app\admin\controller;

use app\admin\controller\base\Backend;
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
        return view('article/articleList');
    	
    }

    public function articleInfo(){


        return  view('article/articleInfo');
    }

    public function createArticle(){


        return view('article/createArticle');
    }


    public function updateArticle(){


        return view('article/updateArticle');
    }

}
