<?php

class Berger{
	
	private static $battle = array();
    //数组首尾互换
	private function resets($arrays,$len){
		$temp = $arrays[$len -1];  
		$arrays[$len-1] = $arrays[0];  
		$arrays[0] = $temp;  
		return $arrays;  
	}
	
	//将数组重新整合
	private function moveByWalk($arrays,$walk,$flag,$len){
		$begin=$len-$flag-1;
		$index=$begin;
		$temp=0;
		$lasttemp=$arrays[$index];
		$mod=$len-1;
		for($i=0;$i<$len-2;$i++){
			$nextpos=($index+$walk)%$mod;
			$temp = $arrays[$nextpos];
			$arrays[$nextpos]= $lasttemp;  
			$index = $nextpos;
			$lasttemp = $temp;
		}
		$arrays[$begin] = $lasttemp;  
		return $arrays;
	}
	
	//单循环贝格尔算法
	public function singleCycle($arrays){
	    // len: 球队数量
		$len=count($arrays);
		if($len%2!=0){
			$arrays[]=0;
			$len++;
		}
		$flag=$len-1;//比赛轮数
		$walk=$len/2-1;//移动步伐数
		for($i=1;$i<=$flag;$i++){
			if($i>1){	//第一轮直接显示 
				$arrays=$this->resets($arrays,$len);//数组收尾互相调换
				$arrays=$this->moveByWalk($arrays,$walk,($i%2),$len);//将数组重新整合
			}
			$temparray=array();
			for($m=0;$m<$len/2;$m++){
				$ls['home_team_id']=$arrays[$m]['team_id'];
                $ls['home_team']=$arrays[$m]['team'];
                $ls['home_team_logo']=$arrays[$m]['team_logo'];
                $ls['home_team_alias'] = $arrays[$m]['group_name'].$arrays[$m]['group_number'];
				$ls['away_team_id']=$arrays[$len-$m-1]['team_id'];
                $ls['away_team']=$arrays[$len-$m-1]['team'];
                $ls['away_team_logo']=$arrays[$len-$m-1]['team_logo'];
                $ls['away_team_alias']=$arrays[$len-$m-1]['group_name'].$arrays[$len-$m-1]['group_number'];
				$temparray[]=$ls;unset($ls);
			}
			$battle[$i]=$temparray;
		}
		return $battle;
		
	}
	
	//双循环贝格尔算法
	public function doubleCycle($arrays){
		$battle=$this->singleCycle($arrays);
		//单循环数据互换
		foreach($battle as $val){
			foreach($val as $k=>$v){
				$val[$k]['home_team_id']=$v['away_team_id'];
				$val[$k]['away_team_id']=$v['home_team_id'];
			}
			$battle[]=$val;
		}
		return $battle;
	}
}
?>