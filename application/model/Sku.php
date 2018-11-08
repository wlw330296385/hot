<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Sku extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    // protected $readonly = [
    //                         'create_time',
    //                         'status',
    //                         'type',
    //                         ];




    // public function getSkuTypeAttr($value){
    //     $list = [1=>'color',2=>'size'];
    //     return $list[$value];
    // }



}