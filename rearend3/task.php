<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
header('Access-Control-Allow-Headers:x-requested-with, content-type');
include "./mysql/serivce.php";
include "./mysql/newserivce.php";
include "./mysql/boss.php";
include "./mysql/function/mysql.php";
$data = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//   // collect value of input field
      $project = file_get_contents('php://input');
      $GLOBALS['data'] = json_decode($project, true);
      $perbaseinfo = $data["perbaseinfo"];
   		$time = time(); 
     	
      $perbaseinfo['updatedate'] = date('Y-m-d H:i:s',$time);
      if($perbaseinfo['method']=='update'){
          $boss = new Boss();
          $getarray = array('task' =>$perbaseinfo );
          $boss->setData($getarray);
          $boss->testupdatetask();
         // testupdatetask($perbaseinfo);
      }else if($perbaseinfo['method']=='add'){
         $boss = new Boss();
          $getarray = array('task' =>$perbaseinfo );
          $boss->setData($getarray);
          $boss->testaddtask();
        // testaddtask($perbaseinfo);
        
      }
      
  }

  
?>