<?php 
namespace app\model;
use think\Model;
use traits\model\SoftDelete;
class MatchReferee extends Model {
    use SoftDelete;
    protected $deleteTime = 'delete_time';
	protected $autoWriteTimestamp = true;

	public function match(){
        return $this->hasOne('match','id','match_id',[],'left');
    }
    
}