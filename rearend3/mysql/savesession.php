<?php

// include "./function/mysql.php";
// include "./function/phonecode.php";
// include "./function/email.php";
	function savesession($session){
		// 更新数据
		
		$path = "./session/session.json";
		$array = [];
		if(file_exists($path)){
			$json_string = file_get_contents($path);
			$data = json_decode($json_string, true);
			for($i=0;$i<sizeof($data);$i++){
				if($data[$i]['userid']==$session['userid']){
					array_splice($data,$i,1);
				}
			}
			$length = sizeof($data);
			$data[$length] = $session;
			var_dump($data);
			$myfile = fopen($path, "w") or die("Unable to open file!");
			fwrite($myfile,json_encode($data));
			fclose($myfile);	
		}else{
			$myfile = fopen($path, "a") or die("Unable to open file!");
			$array[0] = $session;
			fwrite($myfile,json_encode($array));
			fclose($myfile);	
		}
		
	}

	function checksessionid($sessionid){
		$path = "./session/session.json";
		$json_string = file_get_contents($path);
		$data = json_decode($json_string, true);
		for($i = 0;$i<sizeof($data);$i++){
			if($sessionid['sessionid']==$data[$i]['sessionid']){
			$array = array('userid'=>$data[$i]['userid'],'username'=>$data[$i]['username']);
			echo json_encode($array);
			}

		}
	
		
	}
?>