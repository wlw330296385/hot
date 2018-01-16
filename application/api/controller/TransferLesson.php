<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\model\TransferLesson as TransferLessonModel;
class TransferLesson extends Base{
   protected $TransferLesson;
 
    public function _initialize(){
        parent::_initialize();
       $this->TransferLesson = new TransferLessonModel;
    }
 
    public function getTransferLessonListApi(){
         try{
            $map = input('post.');
            $page = input('param.page')?input('param.page'):1; 
            $result = $this->TransferLesson->where($map)->page($page)->select();  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  
            
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
    }

    public function getTransferLessonListByPageApi(){
         try{
            $map = input('post.');
            $paginate = input('param.paginate')?input('param.paginate'):10; 
            $result = $this->TransferLesson->where($map)->paginate($paginate);  
            if($result){
                return json(['code'=>200,'msg'=>'获取成功','data'=>$result->toArray()]);
            }else{
                return json(['code'=>100,'msg'=>'无数据']);
            }  
            
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
    }

 
    public function updateTransferLessonApi(){
         try{
             $data = input('post.');
            $bankcard_id = input('param.bankcard_id');
             $data['member_id'] = $this->memberInfo['id'];
             $data['member'] = $this->memberInfo['member'];
            $result = $this->TransferLesson->save($data,['id'=>$bankcard_id]);
             return json($result);
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
         }
     }
 
    public function createTransferLessonApi(){
         try{
            $data = input('post.');
            $result = $this->TransferLesson->save($data);
            return json($result);   
         }catch (Exception $e){
             return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}