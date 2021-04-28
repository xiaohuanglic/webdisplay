<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
header('Access-Control-Allow-Headers:x-requested-with, content-type');
include "./mysql/serivce.php";
include "./mysql/function/mysql.php";
$data = "";
 if($_SERVER["REQUEST_METHOD"] == "GET"){
		$page = $_GET["page"];
		$size = $_GET["size"];
		$totalnum = $_GET["totalnum"];
		$show = $_GET["show"];
		if(empty($page)&&empty($size)&&empty($totalnum)){
			echo "没有数据";
		}else{
			// echo $show;
			getJumpPage($show,$page,$totalnum,$size);
		}
	}
?>