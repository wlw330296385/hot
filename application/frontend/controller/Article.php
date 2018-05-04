<?php 
namespace app\frontend\controller;
use app\frontend\controller\Base;
use app\service\ArticleService;
use app\service\WechatService;
class Article extends Base{
	protected $ArticleService;
	public function _initialize(){
		parent::_initialize();
        $this->ArticleService = new ArticleService;
	}

    public function index() {
    	
        return view();
    }

    //训练营查看会员文章
    public function articleInfoOfCamp(){
        $article_id = input('param.article_id');
       
        $articleInfo = $this->ArticleService->getArticleInfo(['id'=>$article_id]);
        
        if(!$articleInfo){
            $this->error('找不到文章信息');
        }
       
        // 判断权限
        $isPower = $this->ArticleService->isPower($articleInfo['organization_id'],$this->memberInfo['id']);
        $this->assign('power',$isPower);

        $this->assign('articleInfo',$articleInfo);
        return view('Article/articleInfoOfCamp');
    }

    // 训练营修改会员文章
    public function updateArticleInfoOfCamp(){
        $article_id = input('param.article_id');
        
        $articleInfo = $this->ArticleService->getArticleInfo(['id'=>$article_id]);
         if(!$articleInfo){
            $this->error('找不到文章信息');
        }
        // 判断权限
        $isPower = $this->ArticleService->isPower($articleInfo['organization_id'],$this->memberInfo['id']);
        if($isPower<3){
            $this->error('您没有权限');
        }
        
        $this->assign('articleInfo',$articleInfo);
        return view('Article/updateArticleInfoOfCamp');
    }




    // 会员查看自己的文章信息
    public function articleInfo(){
        $article_id = input('param.article_id');

        $articleInfo = $this->ArticleService->getArticleInfo(['id'=>$article_id]);
        if(!$articleInfo){
            $this->error('找不到文章信息');
        }
        //点击率+1;
        $this->ArticleService->incArticle(['id'=>$article_id],'hit');
        // 判断权限
        $isPower = $this->ArticleService->isPower($articleInfo['organization_id'],$this->memberInfo['id']);

        //收藏列表
        $isCollect = $this->ArticleService->getCollectInfo(['article_id'=>$article_id,'member_id'=>$this->memberInfo['id']]);

        $isLikes = $this->ArticleService->getLikesInfo(['article_id'=>$article_id,'member_id'=>$this->memberInfo['id']]);


        $this->assign('isPower',$isPower);
        $this->assign('isLikes',$isLikes);
        $this->assign('isCollect',$isCollect);
        $this->assign('articleInfo',$articleInfo);
        return view('Article/articleInfo');
    }




    // 获取会员文章列表
    public function articleList(){
    	$map = input('post.');
        $articleList = $this->ArticleService->getArticleList($map);


        $this->assign('articleList',$articleList);
		return view('Article/articleList');
    }

    // 获取操作指南列表
    public function articleListOfSystem(){
    	$map = input('post.');
        $articleList = $this->ArticleService->getArticleList($map);


        $this->assign('articleList',$articleList);
		return view('Article/articleListOfSystem');
    }


    // 文章管理列表
    public function articleListOfCamp(){

        $camp_id = input('param.camp_id');

        $campInfo = db('camp')->where(['id'=>$camp_id])->find();
        
        $this->assign('campInfo',$campInfo);
		return view('Article/articleListOfCamp');
    }

    // 发布文章
    public function createArticle(){
        $camp_id = input('param.camp_id');
        $campInfo = db('camp')->where(['id'=>$camp_id])->find();
        $isPower = $this->ArticleService->isPower($camp_id,$this->memberInfo['id']);
        if($isPower<3){
            $this->error('权限不足');
        }
        

        $this->assign('campInfo',$campInfo);
        return view('Article/createArticle');
    }

    // 编辑文章
    public function updateArticle(){
        $article_id = input('param.article_id');
        $camp_id = input('param.camp_id');
        $articleInfo = $this->ArticleService->getArticleInfo(['id'=>$article_id]);
        $isPower = $this->ArticleService->isPower($articleInfo['organization_id'],$this->memberInfo['id']);
        if($isPower<3){
            $this->error('权限不足');
        }
            
        if(!$articleInfo){
            $this->error('找不到文章信息');
        }
        $this->assign('articleInfo',$articleInfo);
        return view('Article/updateArticle');
    }




    public function articleInfoOfLifeStyle(){
        $article_id = input('param.article_id');
        $articleInfo = $this->ArticleService->getArticleInfo(['id'=>$article_id]);
        if(!$articleInfo){
            $this->error('找不到文章信息');
        }
        //点击率+1;
        $this->ArticleService->incArticle(['id'=>$article_id],'hit');
        //收藏列表
        $isCollect = $this->ArticleService->getCollectInfo(['article_id'=>$article_id,'member_id'=>$this->memberInfo['id']]);

        $isLikes = $this->ArticleService->getLikesInfo(['article_id'=>$article_id,'member_id'=>$this->memberInfo['id']]);

        //礼包列表
        $ItemCouponList = db('item_coupon')->where(['target_type'=>4,'target_id'=>$article_id])->select();
        
        $this->assign('ItemCouponList',$ItemCouponList);
        $this->assign('isLikes',$isLikes);
        $this->assign('isCollect',$isCollect);
        $this->assign('articleInfo',$articleInfo);
        return view('Article/articleInfoOfLifeStyle');
    }
   
}