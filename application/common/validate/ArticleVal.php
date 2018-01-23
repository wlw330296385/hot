<?php 
namespace app\common\validate;
use think\Validate;
class ArticleVal extends Validate{


   protected $rule = [
        'title'        =>  'require',
        'content' => 'require',
        'member_id'=>'require'
    ];
    
    protected $message = [
        'title'        =>  '标题不能为空',
        'content'      =>  '内容不能为空',
        'member_id'     =>'作者不能为空',
    ];
   
    protected $scene = [
        'add'   =>  ['member_id','title','content'],
        'edit'  =>  ['member_id','title','content'],
    ];    

}
