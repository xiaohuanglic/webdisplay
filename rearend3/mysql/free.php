<?php
// include "serivce.php";

//  header('Access-Control-Allow-Origin:*');
// header("Access-Control-Allow-Credentials:true");
// header("Access-Control-Allow-Methods:OPTION, POST, GET");
// header("Access-Control-Allow-Headers X-Requested-With, Content-Type");
class Free{
	private $person;
	private $perjob;
	private $peredc;
	private $personid;
	private $taskid;
	private $method;
	public function setData($getarray){
		foreach ($getarray as $key => $value) {
			// for($i = 0;$i<sizeof($array);$i++){
			if($key == 'person'){
					
					if(!empty($value)){
						$this->person = $value;
						
					}
					
				}
				if($key == 'perjob'){
					
					if(!empty($value)){
						$this->perjob = $value;
						
					}
					
				}
				if($key == 'peredc'){
					
					if(!empty($value)){
						$this->peredc = $value;
						
					}
					
				}
					if($key == 'userid'){
					
					if(!empty($value)){
						$this->userid = $value;
						
					}
					
				}
				if($key == 'personid'){
					
					if(!empty($value)){
						$this->personid = $value;
						
					}
					
				}
				if($key == 'method'){
					
					if(!empty($value)){
						$this->method = $value;
						
					}
					
				}
			
				
		}
	}
	public function testaddperson(){
		newPushpersonalinfo($this->person);
		addpersonwork($this->person,$this->perjob);
		addpersondec($this->person,$this->peredc);
	}

	public function testupdateperson(){
		updatepersonwork($this->person,$this->perjob,'perjob');
		updatepersondec($this->person,$this->peredc,'peredc');
		newUpdatepersoninfo($this->person);
	
	
	}
	public function deletePerson(){
		deleteperson($this->personid,$this->userid,$this->method,'personid');
	
	}


}