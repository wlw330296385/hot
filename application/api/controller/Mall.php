<?php 
namespace app\api\controller;
use app\service\MessageService;
class Mall{
	private $MessageService;
	public function __construct(){
		$this->MessageService = new MessageService;
	}

    public function index() {
        
    }



    // 获取消息列表
    public function messageListApi(){
    	try{
    		$map = input()?input():[];
            $page = input('param.page')?input('param.page'):1;
	    	$messageList = $this->MessageService->getMessageList($map,$page);
	    	if($messageList){
	    		return json(['code'=>100,'msg'=>'OK','data'=>$messageList]);
	    	}else{
	    		return json(['code'=>200,'msg'=>'OK']);
	    	}
	    }catch(Exception $e){
	    	return json(['code'=>200,'msg'=>$e->getMassege()]);
	    }
    }







    // 获取最新消息
    public function messageInfoApi(){
    	try{
    		$message_id = input('message_id');
    		$messageInfo = $this->MessageService->getMessageInfo(['id'=>$message_id]);
    		if($messageInfo){
    			return json(['code'=>100,'msg'=>'','data'=>$messageInfo]);
    		}else{
    			return json(['code'=>200,'msg'=>'没有数据了']);
    		}
    	}catch (Exception $e){
    		return json(['code'=>200,'msg'=>$e->getMassege()]);
    	}
    }
}