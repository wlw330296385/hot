<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class CampMember extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    protected $readonly = [
                            'create_time',
                            'status',
                            'type',
                            ];


    public function getStatusAttr($value){
        $status = [0=>'待审核',1=>'正常',2=>'退出',-1=>'被辞退',3=>'已毕业'];
        return $status[$value];
    }
}