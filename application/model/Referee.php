<?php
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class Referee extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    protected $readonly = [
                            'create_time',
                            ];


    // 裁判等级文字获取器
    public function getLevelTextAttr($value, $data) {
        $level = [
            1 => '国家级裁判员',
            2 => '国家A级裁判员',
            3 => '一级裁判员',
            4 => '二级裁判员',
            5 => '三级裁判员',
            0 => '暂无等级'
        ];
        return $level[$data['level']];
    }

    public function getStatusAttr($value){
    	$a = [-1=>'被禁用',1=>'正常',0=>'未审核',2=>'不通过'];
    	return $a[$value];
    }

    public function member(){
        return $this->hasOne('Member', 'id', 'member_id',[], 'left join');
    }
}