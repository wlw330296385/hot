<?php 
namespace app\model;
use think\Model;

class MemberModel extends Model{

	protected $readonly = ['create_time','openid','member'];

}