<?php 
namespace app\admin\controller;
use app\admin\controller\base\Backend;

class Output extends Backend{
	protected $BonusService;
	public function _initialize(){
		parent::_initialize();
	}

    public function index(){
        
       return view('Output/index');
    }



    public function demo(){
        
        return view();
    }
    
}