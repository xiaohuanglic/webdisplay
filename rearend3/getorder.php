<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
header('Access-Control-Allow-Headers:x-requested-with, content-type');
include "./mysql/serivce.php";
include "./mysql/function/mysql.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//   // collect value of input field
  $data = file_get_contents('php://input');
  $data = json_decode($data, true);
  	if(!empty($data)){
      // my是买家,userid是卖家
  	  if(empty($data['taskid'])&&!empty($data['personid'])){
  			getorder($data);
  		}else if(!empty($data['taskid'])&&empty($data['personid'])){
  			echo "迟一点在写";
  		}
      
  	}


}
?>