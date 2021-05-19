<?php

//  header('Access-Control-Allow-Origin:*');
// header("Access-Control-Allow-Credentials:true");
// header("Access-Control-Allow-Methods:OPTION, POST, GET");
// header("Access-Control-Allow-Headers X-Requested-With, Content-Type");

class Main{
	private $experiencerequirement;
	private $education;
	private $salary;
	private $table;
	private $show;
	private $totalnum;
	private $n;
	private $userid;
	public function setData($getarray){
		// $array = ['experiencerequirement','education','salary','table','show','totalnum','n','userid'];
		foreach ($getarray as $key => $value) {
			// for($i = 0;$i<sizeof($array);$i++){

				if($key == 'experiencerequirement'){
					
					if(!empty($value)){
						$this->experiencerequirement = $value;
						
					}
					
				}
					if($key == 'education'){
					
					if(!empty($value)){
						$this->education = $value;
						;
					}
					
				}
					if($key == 'salary'){
					
					if(!empty($value)){
						$this->salary = $value;
						
					}
					
				}
				if($key == 'table'){
					
					if(!empty($value)){
						$this->table = $value;
						
					}
					
				}
				if($key == 'show'){
					
					if(!empty($value)){
						$this->show = $value;
						
					}
					
				}
				if($key == 'n'){
					
					if(!empty($value)){
						$this->n = $value;
						
					}
					
				}
				if($key == 'userid'){
					
					if(!empty($value)){
						$this->userid = $value;
						
					}
					
				}
					

			// }
			# code...
		}
		
	}
	public function getBossData(){


	getTableDatacon("*","task",['dispalyflag'],['1'],[0,2]);
	
	
	}
	public function getFreeData(){


	getTableData("*","person",[0,2]);
	

	}

	public function getBossDataCon(){
	
		$key=['experiencerequirement','education','salary'];
		$array=[$this->experiencerequirement,$this->education,$this->salary];
	
		$newkey = getnewkey($key,$array);
		$newarray =getnewvalue($key,$array);
		getTableBossDataCon("task",$newkey,$newarray,[0,2]);

	}




public function getJumpPage(){
	// 显示的条数n
	// 得到的初始数据为($show-1)*n
	// 得到的终条数为(($show-1)*n)+(n-1)
	// 得到的终条数要进行判断（($show-1)*n)+(n-1)是否大于总条数
	// 如果大于则终条数显示为总条数
	$strat = ($this->show-1)*$this->n;
	$end = (($this->show-1)*$this->n)+($this->n-1);
	if($end>($this->totalnum-1)){
		$end = $this->totalnum-1;
	}
	// 如果$table为Boss,表为person
	// 反而为表为task

	if($this->table=="Boss"){
		$flagtable = "person";
	}else{
		$flagtable = "task";
	}
	// if($strat==0){
	// 	$end = $end+1;
	// }
	if($strat!=$end){
		// $limit = ($strat,$end);
		// 提取方法;
		chatPageLimit('*',$flagtable,[$strat,$this->n]);
	
	}else{
		// 进行单条数据提取;
		chatPageLimit('*',$flagtable,[$strat,($this->totalnum%$this->n)]);
	}
	// echo $strat." ".$end;
}

public function getJumpPageMoreCon(){
	$key=['experiencerequirement','education','salary','dispalyflag'];
	$array=[$this->experiencerequirement,$this->education,$this->salary,'1'];
	
	$newkey = getnewkey($key,$array);
	$newarray =getnewvalue($key,$array);
	$strat = ($this->show-1)*$this->n;
	$end = (($this->show-1)*$this->n)+($this->n-1);
	if($end>($this->totalnum-1)){
		$end = $this->totalnum-1;
	}
	// 如果$table为Boss,表为person
	// 反而为表为task

	if($this->table=="Boss"){
		$flagtable = "person";
	}else{
		$flagtable = "task";
	}
	// if($strat==0){
	// 	$end = $end+1;
	// }
	if($strat!=$end){
		// $limit = ($strat,$end);
		// 提取方法;
		chatPageLimitCon('*',$flagtable,$newkey,$newarray,[$strat,$this->n]);
	
	}else{
		// 进行单条数据提取;
		chatPageLimitCon('*',$flagtable,$newkey,$newarray,[$strat,($this->totalnum%$this->n)]);
	}
}
public function getJumpDefinePageMoreCon($key,$array){

	
	// $newkey = getnewkey($key,$array);
	// $newarray =getnewvalue($key,$array);
	$strat = ($this->show-1)*$this->n;
	$end = (($this->show-1)*$this->n)+($this->n-1);
	if($end>($this->totalnum-1)){
		$end = $this->totalnum-1;
	}
	// 如果$table为Boss,表为person
	// 反而为表为task

	if($this->table=="Boss"){
		$flagtable = "person";
	}else{
		$flagtable = "task";
	}
	// if($strat==0){
	// 	$end = $end+1;
	// }
	if($strat!=$end){
		// $limit = ($strat,$end);
		// 提取方法;
		chatPageLimitCon('*',$flagtable,$key,$array,[$strat,$this->n]);
	
	}else{
		// 进行单条数据提取;
		chatPageLimitCon('*',$flagtable,$key,$array,[$strat,($this->totalnum%$this->n)]);
	}
}
}