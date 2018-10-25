<?php 
namespace app\service;
use think\Db;

class CommonService{

    public function getAge($birthday){
        //格式化出生时间年月日
        $temp = strtotime($birthday);
        if ( $temp < 0 ) {
            return 0;
        }
        $byear = date('Y',$temp);
        $bmonth = date('m',$temp);
        $bday = date('d',$temp);

        // 格式化当前时间年月日
        $tyear = date('Y');
        $tmonth = date('m');
        $tday = date('d');

        //开始计算年龄
        $age = $tyear-$byear;
        if($bmonth > $tmonth || $bmonth == $tmonth && $bday > $tday){
            $age--;
        }
        return $age;
    }

}