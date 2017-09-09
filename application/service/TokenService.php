<?php 
namespace app\service;


class TokenService{
	private $visit;
	private $num;



	// 搞不垫闭包函数
     // public function visitTimes(){

     // 	$this->visit = function($times){
	    //   	$this->num = $times++;
	    //   	return $this->num;
	    //   };
     // 	if(!$this->num){
     // 		$this->num = 0;
     // 	}
     // 	return $this->visit($this->num);
     // }

	public function visitTimes($limit = 30,$expire=300,$prefix = 'token'){
		session(['prefix'=>'token','expire'=>$expire]);
		$this->num = session('visittime','',$prefix);
		if(!$this->num){
			session('visittime',1,'token');
			return 1;
		}else{			
			if($this->num>$limit){
				session(null,$prefix);
				return false;
			}
			$this->num++;
			session('visittime',$this->num,$prefix);
			return $this->num++;
		}
	}


}