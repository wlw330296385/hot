<?php 
namespace app\frontend\controller;
use think\Controller;
class Login extends Controller{
	
    public function index() {

        return view();
    }

    public function login(){
        
    	return view();
    }
    public function registerSuccess(){

    	return view();
    }
    public function loginSuccess(){
    	return view();
    }


    public function register(){
        $referer = input('param.referer');
        $pid = input('param.pid');
        $this->assign('pid',$pid);
        $this->assign('referer',$referer);
        return view();
    }
}