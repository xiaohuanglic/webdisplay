<?php 
   session_start();
   $userId = $_REQUEST["userId"];
   $password = $_REQUEST["password"];
   $mobile = $_REQUEST["mobile"];
   $verifyCode = $_REQUEST["verifyCode"];
   $array = $_SESSION["verifyInfo"];
   if($array == null){
      echo '验证码错误';
      return ;
   }
   if($array['mobile'] != $mobile){
      echo '手机号错误';
      return ;
   }
   if($array['verifyCode'] != $verifyCode){
      echo '验证码错误';
      return ;
   }
   //其他业务代码

   echo 'success';
   return;
?>