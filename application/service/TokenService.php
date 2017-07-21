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

	public function visitTimes(){
		// Session::prefix('token');
		// session::expire(3600);
		session(['prefix'=>'token','expire'=>3600]);
		$this->num = session('visittime','','token');
		if(!$this->num){
			session('visittime',1,'token');
			return 1;
		}else{
			
			if($this->num>10){
				session(null,'token');
				return false;
			}
			$this->num++;
			session('visittime',$this->num,'token');
			return $this->num++;
		}


	}
}