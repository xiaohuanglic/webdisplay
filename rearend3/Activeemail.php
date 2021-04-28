<?php
	header('Access-Control-Allow-Origin:*');
	// header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
	header('Access-Control-Allow-Headers:x-requested-with, content-type');
	require './mysql/function/PHPMailer-master/src/Exception.php'; //文件相对路径
	require './mysql/function/PHPMailer-master/src/PHPMailer.php'; 
	require './mysql/function/PHPMailer-master/src/SMTP.php';
	include "./mysql/function/mysql.php";
	include "./mysql/function/email.php";
	include "./mysql/serivce.php";
	$data = "";
	$active = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // collect value of input field
  		$email = file_get_contents('php://input');
  	if (empty($email)) {
    	echo "data error";
  	} else {
  		
    	$GLOBALS['data'] = json_decode($email, true);
    	 
    	Sendemail($GLOBALS['data']);

  	}
  }
  if($_SERVER["REQUEST_METHOD"] == "GET"){
		$activecode = $_GET["Activecode"];
		if(empty($activecode)){
			echo "don't get data";
		} else{
			echo Active($activecode);
			
		}
	}
?>