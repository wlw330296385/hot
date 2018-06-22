<?php 
namespace app\index\controller;
use think\Controller;
/**
* 
*/
class Index extends Controller
{
	
	function __construct()
	{
		
	}

    public function index1(){
    	$testService = new \app\service\TestService(['otion'=>'a']);
    	$testService->test();
    }

    public function index2(){

        
    }


}