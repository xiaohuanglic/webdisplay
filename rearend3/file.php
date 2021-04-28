<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
header('Access-Control-Allow-Headers:x-requested-with, content-type');
include "./mysql/serivce.php";
include "./mysql/function/mysql.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//   // collect value of input field
  $data = file_get_contents('php://input');
  // var_dump($data);
  // $fileid = 'file'.md5(uniqid(mt_rand(), true));
  // $myfile = fopen($fileid.".".getallheaders()["Content-Type"], "w") or die("Unable to open file!");
  // $txt = $data;
  // fwrite($myfile, $txt);
  // fclose($myfile);
  // var_dump($data);
 
  echo $fileid;

 }

  