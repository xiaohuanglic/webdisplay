<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
header('Access-Control-Allow-Headers:x-requested-with, content-type');
include "./mysql/serivce.php";
include "./mysql/function/mysql.php";
$data = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//   // collect value of input field
  $name = file_get_contents('php://input');
  if (empty($name)) {
    echo "data error";
  } else {
    $GLOBALS['data'] = json_decode($name, true);
    Registered( $GLOBALS['data']);
  }

  }
?>