<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
header('Access-Control-Allow-Headers:x-requested-with, content-type');
include "./mysql/serivce.php";
include "./mysql/function/mysql.php";
$data = "";
 if($_SERVER["REQUEST_METHOD"] == "GET"){
		$flag = $_GET["flag"];
		$show = $_GET["show"];
		$userid = $_GET["userid"];
		if(!empty($userid)&&!empty($flag)&&!empty($show)){
			getpersontablenum($userid,$flag,$show);
			// echo $userid;
			
		} else{
			echo "没有数据";
		}
	}
?>