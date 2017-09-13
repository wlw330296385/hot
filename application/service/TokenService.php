<?php 
namespace app\service;


class TokenService{
	private $visit;
	private $data;



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

	public function visitTimes($limit = 100,$expire=300,$prefix = 'token'){
		session(['prefix'=>'token','expire'=>$expire]);
		$this->data = session('visittime','',$prefix);
		if(!$this->data){
			$this->data = ['times'=>1,'time'=>time()];
			session('visittime',$this->data,'token');
			return 1;
		}else{

			if($this->data['times'] > $limit && (time() - $this->data['time'])>6){
				session(null,$prefix);
				dump($this->data['times']);
				return false;die;
			}
			$times = $this->data['times'];
			// dump($times);
			$times ++;
			// dump($this->data);
			// dump($times);die;
			$this->data['times'] = $times;

			session('visittime',$this->data,$prefix);
			return $this->data['times'];
		}
	}


}