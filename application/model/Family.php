<?php
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class Family extends Model {
    protected $autoWriteTimestamp = true;
    use SoftDelete;
    protected $deleteTime = 'delete_time';


    public function getTypeAttr($value){
    	$type = [1=>'爸爸',2=>'妈妈',3=>'儿子',4=>'女儿',5=>'爷爷',6=>'奶奶',7=>'姥姥',8=>'姥爷',9=>'叔叔',9=>'伯伯'];
    	return $type[$value];
    }
}