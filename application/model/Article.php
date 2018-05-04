<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Article extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    // protected $readonly = [
    //                         'create_time',
    //                         'status',
    //                         'type',
    //                         ];

	public function getCategoryAttr($value){
		$status = [0=>'其他',1=>'平台手册',2=>'单独页面',3=>'新闻','4'=>'Life Style'];
        return $status[$value];
	}
}