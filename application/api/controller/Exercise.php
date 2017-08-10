<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\ExerciseService;
class Exercise extends Base{
	protected $ExerciseService;
    
	public function _initialize(){
		parent::_initialize();
		$this->ExerciseService = new ExerciseService;
	}



    public function exerciseListApi(){
        try{
            $result = $this->ExerciseService->getExerciseList();
            if($result){
                return json(['data'=>$result,'code'=>100,'msg'=>'OK']);
            }else{
                return json(['code'=>200,'msg'=>'未获取到数据']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }

        
    }



}