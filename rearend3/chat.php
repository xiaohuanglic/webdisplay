<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
header('Access-Control-Allow-Headers:x-requested-with, content-type');
include "./mysql/serivce.php";
include "./mysql/function/mysql.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//   // collect value of input field
  $data = file_get_contents('php://input');
  // $data = json_decode($data, true);
  	if(!empty($data)){
  		if(empty(json_decode($data, true))){
  			savefile($data);
        // var_dump($data);
  		}else{
  			$data = json_decode($data, true);

  			if(empty($data['chatid'])){
  
    
     
         
          addchatmsg($data);
          // 添加名单
          
        
  			}else{
          
  		
  			if(empty($data['chatmsg'])){
         
            checkchatmsg($data);
          
    
     
        }else if (!empty($data['chatmsg'])) {
          // 添加内容

          savechatmsg($data);
          
        }
         
  				
  	


        }
  		}
  		
  	}else{
  		echo "没有数据";
  	}
 
 
  
 
  // file_put_contents('img.jpg',$project);
      // if(empty($data['chatid'])){
      //     echo "用户名为空";
      //   }else{
          
      //   if(empty($data['chatmsg'])){
      //    // if(empty($data['username'])){
      //       checkchatmsg($data);
          
      //    // }else if(!empty($data['username'])){
      //     //   Getusermsg($data);
          
      //    // }
     
      //   }else if (!empty($data['chatmsg'])) {
      //     savechatmsg($data);
          
      //   }

}
?>