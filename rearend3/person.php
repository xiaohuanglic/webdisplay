<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
header('Access-Control-Allow-Headers:x-requested-with, content-type');
include "./mysql/newserivce.php";
include "./mysql/function/mysql.php";
$data = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//   // collect value of input field
      $project = file_get_contents('php://input');
      $GLOBALS['data'] = json_decode($project, true);
      // perbaseinfo
      $perbaseinfo = $data["perbaseinfo"];
      $perjob = $data["perjob"];
      $peredc = $data["peredc"];
      $perbaseinfo['updatedate'] = date('Y-m-d H:i:s', time());
      if($perbaseinfo['method']=='update'){
        
        testupdateperson($perbaseinfo,$perjob,$peredc);
       
      }else if($perbaseinfo['method']=='add'){
        
        testaddperson($perbaseinfo,$perjob,$peredc);
      }
      
  }

  
?>