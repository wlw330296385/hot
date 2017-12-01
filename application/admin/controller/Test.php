<?php
namespace app\admin\controller;

use app\admin\controller\base\Backend;

class Test extends Backend {
    public function index() {
       
    	dump(cache());
    	dump($_SESSION);die;
    }
}
