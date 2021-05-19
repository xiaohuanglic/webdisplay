<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST, GET, OPTIONS');//表示只允许POST请求
header('Access-Control-Allow-Headers:x-requested-with, content-type');
include "./mysql/serivce.php";
include "./mysql/chat.php";
include "./mysql/function/mysql.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//   // collect value of input field
  $data = file_get_contents('php://input');
  // $data = json_decode($data, true);
  	if(!empty($data)){
  		if(empty(json_decode($data, true))){
         $chat = new Chat();
          $chat->savefile($data);
  			
        // var_dump($data);
  		}else{
  			$data = json_decode($data, true);

  			if(empty($data['chatid'])){
  
    
     
          $chat = new Chat();
          $chat->addchatmsg($data);
          // 
          // 添加名单
          
        
  			}else{
          
  		
  			if(empty($data['chatmsg'])){
             $chat = new Chat();
            $chat->checkchatmsg($data);
            
          
    
     
        }else if (!empty($data['chatmsg'])) {
          // 添加内容
           $chat = new Chat();
            $chat-> savechatmsg($data);
         
          
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