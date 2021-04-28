<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
header('Access-Control-Allow-Headers:x-requested-with, content-type');
include "./mysql/savedisplaymodel.php";
include "./mysql/function/mysql.php";
$data = "";
 if($_SERVER["REQUEST_METHOD"] == "GET"){
		
		// $personid = $_GET['personid'];
		
		// $isdisplay = $_GET['isdisplay'];
		// echo $isdisplay;
		// if(empty($personid)){
		// 	echo "没有数据";
		// }else{
		// 	savedisplatmodel($personid,$isdisplay);
		// }
	}
?>