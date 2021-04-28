<?php
include "./function/mysql.php";
include "./function/phonecode.php";
include "./function/email.php";
	function savedisplatmodel($personid,$isdisplay){
		// 更新数据
		UpdateData('person',['isdisplay'],["'".$isdisplay."'"],["personid"],["'".$personid."'"]);
		
	}
?>