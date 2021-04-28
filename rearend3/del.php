<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
header('Access-Control-Allow-Headers:x-requested-with, content-type');
include "./mysql/serivce.php";
include "./mysql/function/mysql.php";
$data = "";
 if($_SERVER["REQUEST_METHOD"] == "GET"){
		$method = $_GET["method"];
		$id = $_GET['personid'];
		$userid = $_GET['userid'];
		if(empty($method)){
			echo "没有方法";
			
		} else{
			if(!empty($id)&&!empty($userid)){
				deleteperson($id,$userid,$method,'personid');
			}else{
				$id = $_GET['taskid'];
				$userid = $_GET['userid'];
				deleteperson($id,$userid,$method,'taskid');
			}
		}
	}
?>