<?php
namespace app\admin\controller;
use app\admin\controller\base\Backend;
use app\service\LessonService;
use app\service\AuthService;
use think\Db;
use app\model\Lesson as LessonModel;

class Lesson extends Backend {
    // 列表
    public function index() {
        $map = [];
        if ($cur_camp = $this->cur_camp) {
            $map['camp_id'] = $cur_camp['camp_id'];
        }
        $camp = input('camp');
        if ($camp) {
            $map['camp'] = ['like', '%'. $camp .'%'];
        }
        $lesson = input('lesson');
        if ($lesson) {
            $map['lesson'] = ['like', '%'. $lesson .'%'];
        }
        $coach = input('coach');
        if ($coach) {
            $map['coach'] = ['like', '%'. $coach .'%'];
        }

        $list = LessonModel::where($map)->paginate(15);
        
        $breadcrumb = ['title' => '课程管理', 'ptitle' => '训练营'];
        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('list', $list);
        return $this->fetch();
    }

    // 详情
    public function detail() {
        $id = input('id');

        $lesson = LessonModel::where([ 'id' => $id ])->find()->toArray();

        $breadcrumb = [ 'ptitle' => '课程管理' , 'title' => '课程详细' ];
        $this->assign( 'breadcrumb', $breadcrumb );
        $this->assign('lesson', $lesson);
        return view();
    }

    // 审核
    public function audit() {
        if ( request()->isAjax() ) {
            $id = input('lesson');
            $status = input('code');
            $data = [
                'id' => $id,
                'status' => $status
            ];
            $execute = Db::name('lesson')->update($data);
            $Auth = new AuthService();
            if ($execute) {
                $no = '';
                if ($status == 2) {
                    $no = '不';
                }
                $doing = '审核课程id: '. $id .' 审核'. $no .'通过 成功';
                $Auth->record($doing);
                $response = [ 'status' => 1, 'msg' => __lang('MSG_100_SUCCESS'), 'goto' => url('lesson/index') ];
            } else {
                $doing = '审核课程id: '. $id .' 审核操作 失败';
                $Auth->record($doing);
                $response = [ 'status' => 0, 'msg' => __lang('MSG_200_ERROR') ];
            }
            return $response;
        }
    }

    // 软删除
    public function sdel() {
        $id = input('id');
        $LessonS = new LessonService();
        $result = $LessonS->SoftDeleteLesson($id);
        $Auth = new AuthService();
        if ( $result['code'] == 100 ) {
            $Auth->record('课程id:'. $id .' 软删除 成功');
            $this->success($result['msg'], 'lesson/index');
        } else {
            $Auth->record('课程id:'. $id .' 软删除 失败');
            $this->error($result['msg']);
        }
    }



    // 购买课程
    public function buyLesson(){
        $LessonService = new LessonService;
        $lessonList = $LessonService->getLessonList();
        $breadcrumb = ['ptitle' => '课程管理', 'title' => '帮购买课程'];
        $this->assign('breadcrumb',$breadcrumb);
        $member_id = input('param.member_id');
        $memebrInfo = db('member')->where(['id'=>$member_id])->find();
        if(!$memebrInfo){
            echo '找不到用户信息';die;
        }
        // 学生列表
        $StudentModel = new \app\model\Student;
        $studentList = $StudentModel->where(['member_id'=>$member_id])->select();

        //训练营列表
        $CampModel = new \app\model\Camp;
        $campList = $CampModel->select();
        if(request()->isPost()){
            try{
                $postData = input('post.');
                $lessonInfo = db('lesson')->where(['id'=>$postData['lesson_id']])->find();

                // 生成订单号
                $billOrder = '1'.date('YmdHis',time()).rand(0000,9999);
                $billInfo = [
                    'bill_order'=>$billOrder,
                    'goods'=>$lessonInfo['lesson'],
                    'goods_id'=>$lessonInfo['id'],
                    'goods_des'=>"{$studentList[$postData['studentIndex']]['student']}购买{$lessonInfo['lesson']}",
                    'camp_id'=>$lessonInfo['camp_id'],
                    'camp'=>$lessonInfo['camp'],
                    'price'=>$lessonInfo['cost'],
                    'score_pay'=>$lessonInfo['score'],
                    'goods_type'=>1,
                    'pay_type'=>"system",
                    'member'=>$memebrInfo['member'],
                    'member_id'=>$memebrInfo['id'],
                    'student'=>$studentList[$postData['studentIndex']]['student'],
                    'student_id'=>$studentList[$postData['studentIndex']]['id'],
                    'total'=>$postData['total'],
                    'sys_remarks'=>"system:{$this->admin['username']},id:{$this->admin['id']}",
                    'bill_type'=>1
                ];
                $BillService = new \app\service\BillService;
                $result = $BillService->updateBill($billInfo);
                if($result['code']==200){
                    $res = $BillService->pay(['pay_time'=>time(),'expire'=>0],['bill_order'=>$billOrder]);
                    if($res){
                        $this->success('操作成功');
                    }else{
                        $this->error('订单订单后续操作失败,请联系woo');
                    }
                }else{
                    $this->error('订单生成失败');
                }
            }catch (Exception $e){
                $this->error($e->getMessage());
            }
            
        }
        

        $this->assign('campList',$campList);
        $this->assign('studentList',$studentList);
        return $this->fetch('lesson/buyLesson');
    }

}