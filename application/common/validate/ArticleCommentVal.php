<?php 
namespace app\common\validate;
use think\Validate;
class ArticleCommentVal extends Validate{


	protected $rule = [
        'member_id'	=> 'require',
        'article_id' =>  'require',
    ];
    
    protected $message = [
        'article_id.require'  =>  '缺少文章id',
        'member_id.require'	=> '查不到会员信息',
    ];
    
    protected $scene = [
        'add'   =>  ['member_id','article_id'],
        'edit' => ['member_id','article_id'],
    ];    

}