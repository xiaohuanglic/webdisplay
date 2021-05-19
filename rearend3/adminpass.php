<?php
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
	header('Access-Control-Allow-Headers:x-requested-with, content-type');
	include "./mysql/admin.php";
	include "./mysql/function/mysql.php";
	include "./mysql/chat.php";
	include "./mysql/serivce.php";
	
	$data = file_get_contents('php://input');
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
  		$task = json_decode($data, true);
  		if(!empty($task['task']['dispalyflag'])){
  				$admin = new Admin();
  				$admin->changDisplayFlag('task',$task['task']);
  		}else{
  				$admin = new Admin();
  				$admin->Unpass('task',$task['task']);
  		}
  	


  	}
  if($_SERVER["REQUEST_METHOD"] == "GET"){
		
	}
?>