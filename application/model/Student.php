<?php 
namespace app\model;
use think\Model;

class Student extends Model{

	 public function profile(){
    	// return $this->hasOne('member','member_id','id','memberinfo')->field('member,nickname,avatar,telephone,email');
    	return $this->hasOne('member','member_id','id','memberinfo');
    }
	
}