<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
header('Access-Control-Allow-Headers:x-requested-with, content-type');
include "./mysql/serivce.php";
include "./mysql/function/mysql.php";
$data = "";
 if($_SERVER["REQUEST_METHOD"] == "GET"){
		$picture = $_GET["picture"];
		if(empty($picture)){
			echo 'can not get picture';
		} else{
			getpicture();
		
		}
	}
?>