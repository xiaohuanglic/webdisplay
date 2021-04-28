<?php 
   session_start();
   require_once('ZhenziSmsClient.php');
   //生成指定位数随机数
   function randomkeys($length){
      $pattern='1234567890'; //字符池
      for($i=0;$i<$length;$i++){
         $key.=$pattern{mt_rand(0,9)};//生成php随机数
      }
      return $key;
   }
   
   $mobile = $_REQUEST["mobile"];
   $verifyCode = randomkeys(4);
   //发送短信，短信平台使用的是榛子云短信(http://smsow.zhenzikj.com)
   $client = new  ZhenziSmsClient("https://sms_developer.zhenzikj.com", "你的appId", "你的appSecret");
   $params = array();
   $params['number'] = $mobile;
   $params['templateId'] = '12';
   $params['templateParams'] = [$verifyCode, '15分钟'];

   $result = $client->send($params);
   $json = json_decode($result);
   if($json->code == 0){
   	  $arr = array(
         'mobile' => $mobile,
         'verifyCode' => $verifyCode
      );
      $_SESSION["verifyInfo"] = $arr;//存到session中
      echo 'success';
   	  return ;
   }
   echo '发送失败:'.$json->data;
   return;
?>