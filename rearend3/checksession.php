<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
header('Access-Control-Allow-Headers:x-requested-with, content-type');

require_once "./mysql/savesession.php";
require_once "./mysql/function/mysql.php";

// include_once "./mysql/function/phonecode.php";
// include_once "./mysql/function/email.php";
$data = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//   // collect value of input field
	 $project = file_get_contents('php://input');
     $GLOBALS['data'] = json_decode($project, true);
   	$sessionid = $data;
   	
  	checksessionid($sessionid);
   // 储存在session.json中
   // var_dump($session);
   // savesession($session);
      
  }

  
?>