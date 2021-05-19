<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
header('Access-Control-Allow-Headers:x-requested-with, content-type');
include "./mysql/function/mysql.php";
// include "./function/phonecode.php";
include "./mysql/function/email.php";
include "./mysql/serivce.php";
include "./mysql/newserivce.php";
include "./mysql/saveresume.php";


$data = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//   // collect value of input field
  $resume = file_get_contents('php://input');
  if (empty($resume)) {
    echo "data error";
  } else {

    $GLOBALS['data'] = json_decode($resume, true);
    if(!empty($GLOBALS['data']['resume']['personid'])&&!empty($GLOBALS['data']['resume']['taskid'])){
  		$GLOBALS['data']['resume']['resumeid'] = 'resume'.md5(uniqid(mt_rand(), true));
      $resume = new Resume();
      $resume->saveresume( $GLOBALS['data']['resume']);
   		
  	}else if(empty($GLOBALS['data']['resume']['personid'])&&!empty($GLOBALS['data']['resume']['taskid'])){
  	
  	
      $resume = new Resume();
      $resume->checkpersonid($GLOBALS['data']['resume']['taskid']);
  	}else if(!empty($GLOBALS['data']['deleteresume'])){
      // 删除resume
       $resume = new Resume();
      $resume->deleteResume($GLOBALS['data']['deleteresume']);
    }
  
  }

  }
?>