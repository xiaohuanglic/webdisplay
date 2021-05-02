<?php
// include "serivce.php";
include_once "newserivce.php";
class Boss{
	private $task;
	private $table;
	private $show;
	private $totalnum;
	private $n;
	private $userid;
	private $taskid;
	private $method;
	public function setData($getarray){
		foreach ($getarray as $key => $value) {
			// for($i = 0;$i<sizeof($array);$i++){

				if($key == 'task'){
					
					if(!empty($value)){
						$this->task = $value;
						
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
				if($key == 'taskid'){
					
					if(!empty($value)){
						$this->taskid = $value;
						
					}
					
				}
				if($key == 'method'){
					
					if(!empty($value)){
						$this->method = $value;
						
					}
					
				}
				
		}
	}
	public function testaddtask(){

		newPushtaskinfo($this->task);
	}
	public function testupdatetask(){
	

		newUpdatetaskinfo($this->task);
	
	}
	public function getpersontablenum(){

	if($this->table=='Boss'){

		getTableDatacon("*","person",['userid'],["'".$this->userid."'"],[0,2]);
	}else{
		getTableDatacon("*","task",['userid'],["'".$this->userid."'"],[0,2]);
	}
	
	}
	public function getJumpPagecon(){
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
		chatPageLimitCon('*',$flagtable,['userid'],["'".$this->userid."'"],[$strat,$this->n]);
	
	}else{
		// 进行单条数据提取;
		chatPageLimitCon('*',$flagtable,['userid'],["'".$this->userid."'"],[$strat,($this->totalnum%$this->n)]);
	}
	// echo $strat." ".$end;
}
	public function deleteTask(){
		deleteperson($this->taskid,$this->userid,$this->method,'taskid');
	
	}
}