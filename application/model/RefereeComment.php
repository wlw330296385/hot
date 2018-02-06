<?php
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class RefereeComment extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;
    protected $readonly = [
                            'create_time',
                            'update_time',
                            ];


    

    
}