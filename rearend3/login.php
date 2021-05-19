<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
header('Access-Control-Allow-Headers:x-requested-with, content-type');
require_once "./mysql/serivce.php";
require_once "./mysql/function/mysql.php";

require_once "./mysql/function/email.php";

$data = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//   // collect value of input field
  $name = file_get_contents('php://input');
  if (empty($name)) {
    echo "data error";
  } else {
    $GLOBALS['data'] = json_decode($name, true);
    Login( $GLOBALS['data']);
  }

  }
?>