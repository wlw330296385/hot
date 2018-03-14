<?php
// 训练营财务支出收入model
namespace app\model;

use think\Model;
use traits\model\SoftDelete;

class MemberFinance extends Model {
    protected $autoWriteTimestamp = true;

    use SoftDelete;
    protected $deleteTime = 'delete_time';
}