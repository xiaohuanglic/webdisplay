<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
header('Access-Control-Allow-Headers:x-requested-with, content-type');
include "./mysql/serivce.php";
include "./mysql/boss.php";
include "./mysql/function/mysql.php";
$data = "";
 if($_SERVER["REQUEST_METHOD"] == "GET"){
		$page = $_GET["page"];
		$size = $_GET["size"];
		$totalnum = $_GET["totalnum"];
		$show = $_GET["show"];
		$userid = $_GET["userid"];
		if(empty($page)&&empty($size)&&empty($totalnum)){
			echo "没有数据";
		}else{
			$boss = new Boss;
			$getarray = array('table' => $show,'show' => $page,'totalnum' => $totalnum,'n' => $size,'userid' => $userid);
			$boss->setData($getarray);
			$boss->getJumpPagecon();
			// getJumpPagecon($show,$page,$totalnum,$size,$userid);
			
		}
	}
?>