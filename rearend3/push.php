<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
header('Access-Control-Allow-Headers:x-requested-with, content-type');

require './mysql/function/PHPMailer-master/src/Exception.php'; //文件相对路径
require './mysql/function/PHPMailer-master/src/PHPMailer.php'; 
require './mysql/function/PHPMailer-master/src/SMTP.php';

include "./mysql/function/email.php";
include "./mysql/serivce.php";
// include "./mysql/newserivce.php";
include "./mysql/function/mysql.php";
$data = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//   // collect value of input field
  $project = file_get_contents('php://input');
  if (empty($project)) {
    echo "data error";
  } else {
    $GLOBALS['data'] = json_decode($project, true);
    if($data['flag']=='task'){
    	Publishproject($data);
    }else if($data['flag']=='order'){
        getbuyorder($data);
    }else if($data['flag']=='personinfo'){
        getbuyperson($data);
    }else if($data['flag']=='taskinfo'){
        getbuytask($data);
    }else if($data['flag']=='sellerorder'){
        getsellerorder($data);
    }else if($data['flag']=='ordership'){
        getshiporder($data);
    }else if($data['flag']=='completeorder'){
        completeorder($data);
        // var_dump($data);
    }else if($data['flag']=="receiptorder"){
        receiptorder($data);
    }else if($data['flag']=='buyerrefund'){
        buyerrefundorder($data);
    }else if($data['flag']=="sellersurerefunk"){
        sellersurerefunk($data);
    }else if($data['flag']=='buyersurerefunk'){
        buyersurerefunk($data);
    }else if($data['flag']=="forgetpaw"){
        sendforgetemail($data);
    }else if($data['flag']=="resetpaw"){
        resetpassword($data);
    }else if($data['flag']=="persontable"){
        getpersontable($data);
    }
  
    
  }

  }
?>