<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
header('Access-Control-Allow-Headers:x-requested-with, content-type');
include "./mysql/serivce.php";
include "./mysql/chat.php";
include "./mysql/function/mysql.php";
$data = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//   // collect value of input field
	 $project = file_get_contents('php://input');
     $GLOBALS['data'] = json_decode($project, true);
  		if(!empty($data['userid'])){
  			// Getnum($data['userid']);
  			$chat = new Chat;
  			$chat->Getnum($data['userid']);
  		}else{
  			echo "没有数据";
  		}	
      
  }

  
?>