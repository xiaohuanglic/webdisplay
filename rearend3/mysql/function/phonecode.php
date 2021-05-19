<?php

	require_once('ZhenziSmsClient.php');
	$client = new  ZhenziSmsClient("108217", "6137536d-29dc-43df-953e-647aef38a726");
	$result = $client->send("15118747494", "您的验证码为4534，有效时间为5分钟");
	echo $result;

	// function sendphonecode($phonenum,$sendcode){
	// 	echo 1;


	// }
	
?>
