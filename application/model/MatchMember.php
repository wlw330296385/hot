<?php
// 联赛-工作人员(会员)关系
namespace app\model;
use think\Model;
use traits\model\SoftDelete;

class MatchMember extends Model
{
    // 时间戳
    protected $autoWriteTimestamp = true;
    // 软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    // type字段内容列表
    public function getTypes() {
        return [
            //10 => '负责人',
            9 => '管理员',
            8 => '记分员',
            7 => '裁判员',
            0 => '工作人员'
        ];
    }

    // type字段文字获取器
    public function getTypeTextAttr($value, $data) {
        $type = [
            10 => '负责人',
            9 => '管理员',
            8 => '记分员',
            7 => '裁判员',
            0 => '工作人员'
        ];
        return $type[$data['type']];
    }


}