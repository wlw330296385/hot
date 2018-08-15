<?php
namespace app\system\controller;
use app\model\Rebate as RebateModel;
use app\service\MemberService;
use think\Db;
use app\system\controller\Base;
/**
 * 课时结算
 * @param  正式
 */
class Rebate extends Base {
    public $setting;


    public function _initialize() {
        parent::_initialize();
        $this->setting = db('setting')->find();
    }

    // 结算上一个月收入 会员分成
    public function salaryinRebate(){
        try {
            $Time = new \think\helper\Time;
            list($start, $end) = $Time ::today();
            $map['salary_in.status'] = 1;
            $map['salary_in.has_rebate'] = 0;
            $map['salary_in.create_time'] = ['between', [$start, $end]];
            $map['salary|push_salary'] = ['>',0];
            $map['camp.schedule_rebate'] = 1;




            $salaryinList = DB::name('salary_in')
                        ->field(['salary_in.member_id','salary_in.id','salary_in.member','sum(salary_in.salary)+sum(salary_in.push_salary)'=>'total_salary','camp.rebate_type'])
                        ->join('camp','camp.id = salary_in.camp_id')
                        ->where($map)->group('salary_in.member_id')
                        ->where('salary_in.delete_time', null)
                        ->order('salary_in.id desc')
                        ->select();
            $datemonth = date('Ym', time());
            $date_str = date('Ymd', time());
            // dump($salaryinList);die;


            $s_ids = [];
            foreach ($salaryinList as $value) {
                if ($value['total_salary'] >0 ){
                    $res = $this->insertRebate($value['member_id'], $value['total_salary'], $datemonth,$date_str);
                    $s_ids[] = $value['id'];
                }
            }
            DB::name('salary_in')->where(['id'=>['in',$s_ids]])->update(['has_rebate' => 1]);
            $data = ['crontab'=>'每日会员推荐分成'];
            $this->record($data); 
        }catch (Exception $e) {
            // 记录日志：错误信息
            $data = ['crontab'=>'每日会员推荐分成','status'=>0,'callback_str'=>$e->getMessage()];
            $this->record($data); 
            throw new Exception("Error Processing Request", 1);
            trace($e->getMessage(), 'error');
        }
    }

    // 保存会员分成记录
    private function insertRebate($member_id, $total_salary, $datemonth,$date_str) {
        $memberS = new MemberService();
        $RebateModel = new RebateModel();
        $memberPiers = $memberS->getMemberTier($member_id);
        if (!empty($memberPiers)) {
            foreach ($memberPiers as $k => $val) {
                dump($val['tier']);
                if ($val['tier']==1) {
                    $memberPiers[$k]['salary'] = $total_salary*$this->setting['rebate'];
                } elseif ($val['tier']==2){
                    $memberPiers[$k]['salary'] = $total_salary*$this->setting['rebate2'];
                }
                $memberPiers[$k]['datemonth'] = $datemonth;
                $memberPiers[$k]['date_str'] = $date_str;
                $memberPiers[$k]['total_salary'] = $total_salary;
            }
            // dump($memberPiers);
            $execute = $RebateModel->allowField(true)->saveAll($memberPiers);
            if ($execute) {
                $memberDb = db('member');
                foreach ($memberPiers as $member) {
                    $memberDb->where('id', $member['member_id'])->setInc('balance', $member['salary']);
                }
                file_put_contents(ROOT_PATH.'data/rebate/'.date('Y-m-d',time()).'.txt',json_encode(['time'=>date('Y-m-d H:i:s',time()), 'success'=>$memberPiers], JSON_UNESCAPED_UNICODE).PHP_EOL, FILE_APPEND  );
                return true;
            } else {
                file_put_contents(ROOT_PATH.'data/rebate/'.date('Y-m-d',time()).'.txt',json_encode(['time'=>date('Y-m-d H:i:s',time()), 'error'=>$memberPiers], JSON_UNESCAPED_UNICODE).PHP_EOL, FILE_APPEND );
                return false;
            }
        }
    }

}