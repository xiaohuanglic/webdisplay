<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
header('Access-Control-Allow-Headers:x-requested-with, content-type');
include_once "./mysql/serivce.php";
include_once "./mysql/boss.php";
include_once "./mysql/free.php";
include_once "./mysql/function/mysql.php";
$data = "";
 if($_SERVER["REQUEST_METHOD"] == "GET"){
		$method = $_GET["method"];
		$id = $_GET['personid'];
		$userid = $_GET['userid'];
		if(empty($method)){
			echo "没有方法";
			
		} else{
			if(!empty($id)&&!empty($userid)){
				// deleteperson($id,$userid,$method,'personid');
				$id = $_GET['personid'];
				$userid = $_GET['userid'];
				$free =new Free;
				$getarray = array('personid' =>$id,'userid' =>$userid,'method' =>$method );
				$free->setData($getarray);
				$free->deletePerson();
			}else{
				$id = $_GET['taskid'];
				$userid = $_GET['userid'];
				$boss =new Boss;
				$getarray = array('taskid' =>$id,'userid' =>$userid,'method' =>$method );
				$boss->setData($getarray);
				$boss->deleteTask();
				// deleteperson($id,$userid,$method,'taskid');
			}
		}
	}
?>