<?php 
namespace app\service;
class TestService{
	private $option;
 	public function __construct($option){
 		$this->option = $option;

 	}

 	public function test(){
 		echo 222;
 		dump($this->option);
 	}

}