<?php 
namespace app\model;
use think\Model;
use app\validate\CampVal;
use traits\model\SoftDelete;
class CampComment extends Model{
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = true;
    protected $readonly = [];

    
}