<?php 
namespace app\api\controller;
use app\api\controller\Base;
use app\service\GradeMemberService;
use think\Db;
use think\Exception;

class GradeMember extends Base{
    protected $GradeMemberService;
	public function _initialize(){
		parent::_initialize();
        $this->GradeMemberService = new GradeMemberService;
	}

    

    public function getGradeMemberListByPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['student'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $result = $this->GradeMemberService->getGradeMemberListByPage($map);    
            if($result){
                return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'检查你的参数']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

   
    // 获取与课程|班级|训练营相关的学生|体验生-不带page
    public function getGradeMemberListNoPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            if(!empty($keyword)&&$keyword != ' '&&$keyword != ''){
                $map['student'] = ['LIKE','%'.$keyword.'%'];
            } 
            if( isset($map['keyword']) ){
                unset($map['keyword']);
            }
            $GradeMember = new \app\model\GradeMember;
            $res = $GradeMember->where($map)->select();
            if($res){
                $result = $res->toArray();
                foreach ($result as $k => $val) {
                    $temp = $GradeMember->where(['id' => $val['id']])->find()->getData();
                    $result[$k]['status_num'] = $temp['status'];
                    $result[$k]['type_num'] = $temp['type'];
                }
                return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'检查你的参数']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }

    // 获取与课程|班级|训练营相关的学生|体验生-不带page
    public function getGradeMemberListWithGradeNoPageApi(){
        try{
            $map = input('post.');
            $keyword = input('param.keyword');
            $GradeMember = new \app\model\GradeMember;
            $res = $GradeMember->with('grade')->where(['grade_member.member_id'=>$map['member_id']])->select();

            if($res){
                $result = $res->toArray();
                // dump($result);die;
                return json(['code'=>200,'msg'=>'ok','data'=>$result]);
            }else{
                return json(['code'=>100,'msg'=>'检查你的参数']);
            }
        }catch (Exception $e){
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }


    // 获取拥有订单的GradeMember数据不分页
    public function getGradeMemberJoinBillListNoPageApi(){
        try {
            $grade_id = input('param.grade_id');
            // $lesson_id = input('param.lesson_id');
            $result = db('grade_member lm')
                    ->field('lm.*,b.id b_id,b.total_gift as b_total,b.status as b_status,b.bill_order,b.create_time as b_c')
                    ->join('bill b','b.goods_id = lm.lesson_id and b.student_id = lm.student_id')
                    ->where(['lm.grade_id'=>$grade_id])
                    ->where(['b.status'=>1])
                    ->where(['b.total_gift'=>0])
                    ->order('b.id desc')
                    ->select();
            return json(['code'=>200,'msg'=>'获取成功','data'=>$result]);
        } catch (Exception $e) {
            return json(['code'=>100,'msg'=>$e->getMessage()]);
        }
    }
}
