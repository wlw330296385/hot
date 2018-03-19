<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class CampMember extends Model {
    use SoftDelete;
    protected $table = 'camp_member';
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    // protected $readonly = [
    //                         'create_time',
    //                         'status',
    //                         'type',
    //                         ];


    public function getStatusAttr($value){
        $status = [0=>'待审核',1=>'正常',2=>'退出',-1=>'被辞退',3=>'已毕业','-2'=>'被拒绝'];
        return $status[$value];
    }


    public function getTypeAttr($value){
         $status = [-1=>'其他',1=>'学生',2=>'教练',3=>'管理员',4=>'创建者'];
        return $status[$value];
    }

    public function camp(){
        return $this->hasOne('camp','id','camp_id',[],'LEFT');
    }

    public function coach(){
        return $this->hasOne('coach','member_id','member_id',[],'LEFT');
    }

    public function member(){
        return $this->hasOne('member','id','member_id',[],'LEFT');
    }

    public function student(){
        return $this->hasMany('student','member_id','member_id',[],'LEFT');
    }
}