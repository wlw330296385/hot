<?php 
namespace app\api\model;
use think\Model;

class Member extends Model{

	protected $readonly = ['create_time','openid','member'];

}