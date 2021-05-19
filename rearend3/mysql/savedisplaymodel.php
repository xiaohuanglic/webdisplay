<?php
//  header('Access-Control-Allow-Origin:*');
// header("Access-Control-Allow-Credentials:true");
// header("Access-Control-Allow-Methods:OPTION, POST, GET");
// header("Access-Control-Allow-Headers X-Requested-With, Content-Type");
// include "./function/mysql.php";
// // include "./function/phonecode.php";
// include "./function/email.php";
	function savedisplatmodel($personid,$isdisplay){
		// 更新数据
		UpdateData('person',['isdisplay'],["'".$isdisplay."'"],["personid"],["'".$personid."'"]);
		
	}
?>