<?php
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class GradeCategory extends Model {
    use SoftDelete;
    protected $table = 'grade_category';
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    protected $readonly = [
                            'create_time',
                            ];



}