<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class ArticleLikes extends Model{
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = true;
    protected $readonly = [];

    
}