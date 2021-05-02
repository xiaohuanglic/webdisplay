<?php
// include "serivce.php";
class Detail{
	private $userid;
	private $id;
	public function setData($getarray){
		foreach ($getarray as $key => $value) {
			// for($i = 0;$i<sizeof($array);$i++){

				if($key == 'userid'){
					
					if(!empty($value)){
						$this->userid = $value;
						
					}
					
				}
				if($key == 'id'){
					
					if(!empty($value)){
						$this->id = $value;
						
					}
					
				}
					
			
			
			
				
					

			// }
			# code...
		}
	}
	public function getDetialdisplayData(){
		getdisplayData($this->id,$this->userid);
	}
}