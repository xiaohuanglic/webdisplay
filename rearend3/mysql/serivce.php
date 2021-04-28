<?php
include "./function/mysql.php";
include "./function/phonecode.php";
include "./function/email.php";

// require './function/PHPMailer-master/src/Exception.php'; //文件相对路径
// require './function/PHPMailer-master/src/PHPMailer.php'; 
// require './function/PHPMailer-master/src/SMTP.php';
// session_start();
function Registered($data){

	if(empty($data)){
		echo "没有数据传入";
		return;
	}else{
		$usernamemsg = Select(array('*'),'User',array('username'),array("'".$data['username']."'"),
			function($result){
				// while($row = $result->fetch_assoc()) {
  			 	return  "你的用户名已经注册";

    		// }
		
		});
		if($usernamemsg=="你的用户名已经注册"){
			echo $usernamemsg;
			return; 
		}
		$emailmsg = Select(array('*'),'User',array('email'),array("'".$data['email']."'"),
			function($result){
			
  			 	return "你的邮箱已经注册";
    		
		
		});
		if($emailmsg=="你的邮箱已经注册"){
			echo $emailmsg;
			return; 
		}

		$id = md5(uniqid(mt_rand(), true));
		$activecode = md5(uniqid(mt_rand(), true));
		Adddata('User',['id','username',"password","email","active","activecode"],["'".$id."'","'".$data['username']."'","'".$data['password']."'","'".$data['email']."'",'0',"'".$activecode."'"]);
		echo $data['email'];
		

	}
		
}

function Login($data){
	if(empty($data)){
		echo "没有数据传入";
		return;
	}else{
		$sendname = Select(array('*'),'User',array('username'),array("'".$data['username']."'"),
			function($result){
				while($row = $result->fetch_assoc()) {
					if($row['active']=='1'){
						return "邮箱已激活";
					}else{
						return "请去激活邮箱";
					}
    			}
		
		});

		if($sendname=="没有数据"){
			echo "邮箱或者密码错误";
		}
		if($sendname=="请去激活邮箱"){
			echo "请去激活邮箱";
		}
		if($sendname=="邮箱已激活"){
			$sendactive = Select(array('*'),'User',array('password'),array("'".$data['password']."'"),
			function($result){
				while($row = $result->fetch_assoc()) {
					
  			 	echo "登录成功,".$row['id'].",".$row['username'];

    		}
		
			});

			if($sendactive=="没有数据"){
				echo "用户与密码错误";
				return;
			}
		}
		
	}	
}


function Sendemail($email){
	if(empty($email)){
		echo "没有数据传入";
		return;
	}else{
		Select(array('activecode','email'),'User',array('email'),array("'".$email['email']."'"),
		function($result){
		while($row = $result->fetch_assoc()) {
			 
			sendmessage($row['activecode'],$row['email'],"active");
			echo "发送邮箱成功";
			return;					
		}
		}
		);
	}
		
	
			
}



function Active($activecode){
	if(empty($activecode)){
		return '没有数据输入';
	}else{
		$activedata = Select(array('active'),'User',array('activecode'),array("'".$activecode."'"),
		function($result){
		while($row = $result->fetch_assoc()) {
			if($row['active']=='0'){
				global $activecode;
				UpdateData('User',array('active'),array('1'),array('activecode'),array("'".$activecode."'"));
				return "账号激活成功";
			}else{
				return '账号已经激活了';
			}			
		}
		}
		);

		return $activedata;
	}

}
function sendforgetemail($data){
	var_dump($data);
	if(empty($data['email'])){
		echo "没有该邮箱";
		return;
	}

	// 先查询有没有相关的邮箱
	$email = Select(array('email'),'user',array('email'),array("'".$data['email']."'"),function($result){
			// while($row = $result->fetch_assoc()) {
				return $result;
  			 	
    		// }
    	}
    );
    while($row = $email->fetch_assoc()) {
		$getemail = $row['email'];	
	}
	if(empty($getemail)){
		echo "没有该邮箱";
		return;
	}
	$resetcode = "reset".md5(uniqid(mt_rand(), true));
	UpdateData('User',array('resetcode'),array("'".$resetcode."'"),array('email'),array("'".$getemail."'"));
	sendmessage($resetcode,$getemail,'resetpaw');
	// var_dump($getemail);

}
function resetpassword($data){
	// 先判断resetcode
	$userid = Select(array('id'),'user',array('resetcode'),array("'".$data['resetcode']."'"),function($result){
			// while($row = $result->fetch_assoc()) {
				return $result;
  			 	
    		// }
    	}
    );
    while($row = $userid->fetch_assoc()) {
		$getuserid = $row['id'];	
	}
	if(empty($getuserid)){
		echo "没有该用户";
		return;
	}
	// 更新密码
	UpdateData('User',array('password','resetcode'),array("'".$data['password']."'","''"),array('id'),array("'".$getuserid."'"));
	// var_dump($data);
}
function Publishproject($project){
	if(empty($project)){
		return '没有数据输入';
	}else{
		Adddata('task',['taskid','taskname',"taskprice","taskintro","userid"],["'".$project['taskid']."'","'".$project['projectname']."'","'".$project['projectmoney']."'","'".$project['projectintro']."'","'".$project['userid']."'"]);

	}

}


// 可以合并为一个函数
function getBossData(){


	getTableData("*","task",[0,2]);
	

}

function getFreeData(){


	getTableData("*","person",[0,2]);
	

}



function getpageData($table,$num){
	SelectLimit($table,function($result){
			while($row = $result->fetch_assoc()) {

				$data=  str_replace(",","*",$row['personmoney']);
  			 	echo $row['personid'].",".$row['personname'].",".$row['personinfo'].",".$row['personintro'].",".$data.",".$row['userid']."-";
    		}
		
		},$num);
}


function getpicture(){
	// echo 'http://localhost:5001/image/default.png';
	echo 'http://'.$_SERVER['HTTP_HOST'].'/image/default.png';
}

// 对文件进行删除处理
function deleteexitfile($dir,$callback,$data1,$name){
	// $dir = dirname(dirname(__FILE__)).$filepath;
	$handler = opendir($dir);
	while (($filename = readdir($handler)) !== false) {//务必使用!==，防止目录下出现类似文件名“0”等情况
        if ($filename != "." && $filename != "..") {
                $files[] = $filename ;

        		// echo $filename;
           }
       }
    closedir($handler);
    // 对数据进行处理;
    $data = $callback($data1);
   	// echo $data[$name];

    for($i = 0;$i<sizeof($files);$i++) {
    	// 对相关的图片名称进行比较
    	// var_dump($files);
    	if(is_array($data[$name])){

    		for ($j=0; $j < sizeof($data[$name]); $j++) { 
    		if(strstr($files[$i],$data[$name][$j])){
    		// 删除相关的图片
    			
    			if(!is_dir($dir.'\\'.$files[$i])){
    				if(!unlink($dir.'\\'.$files[$i])){
    					echo "delete file failure";
    				}else{
    					echo "delete file success";
    				}
    			// return;
    			}else{
    				// 获取当前文件夹的内容
    				
    				deleteDir($dir.'\\'.$files[$i]);
    			

    			}	
    			// return;
    		}
    		}
    	}else{

    		if(strstr($files[$i],$data[$name])){
    		// 删除相关的图片
    			
    			if(!is_dir($dir.'\\'.$files[$i])){
    				if(!unlink($dir.'\\'.$files[$i])){
    					echo "delete file failure";
    				}else{
    					echo "delete file success";
    				}
    			// return;
    			}else{
    				// 获取当前文件夹的内容
    				// echo "test2";
    				deleteDir($dir.'\\'.$files[$i]);
    			

    			}	


    				
    			
    			
    		}
    	}
    	
    }
}
function deleteDir($dir)
{
    if (!$handle = opendir($dir)) {
        return false;
    }
    while (false !== ($file = readdir($handle))) {
        if ($file !== "." && $file !== "..") {       //排除当前目录与父级目录
            $file = $dir . '/' . $file;
            if (is_dir($file)) {
                deleteDir($file);
            } else {

                if(unlink($file)){
                	echo $file;
                	echo "删除文件成功";
                }else{
                	echo "删除文件失败";
                }
            }
        }

    }
    if(rmdir($dir)){
    	echo "删除文件夹成功";
    }else{
    	echo "删除文件夹失败";
    }
}

function deleteNotexitfile($dir,$callback,$data1){
	// $dir = dirname(dirname(__FILE__)).$filepath;
	$handler = opendir($dir);
	while (($filename = readdir($handler)) !== false) {//务必使用!==，防止目录下出现类似文件名“0”等情况
        if ($filename != "." && $filename != "..") {
                $files[] = $filename ;

        		// echo $filename;
           }
       }
    closedir($handler);

    // 对数据进行处理;
    $data = $callback($data1);
   
    for($i = 0;$i<sizeof($files);$i++) {
    	// 对相关的图片名称进行比较
    		$j = 0;
    		while ($j<sizeof($data)) {
    			if(strstr($files[$i],$data[$j])){
    				// echo $files[$i]."=".$data[$j];
    				break;
    			}
    			$j++;

    			# code...
    		}
    	
    		if($j==sizeof($data)){
    			if(!unlink($dir.'\\'.$files[$i])){
    				echo "delete file failure";
    			}else{

    				echo "delete file success";
    			}
    		}
    		
    		
    			
    // 	// }
    }
   	
   }


function deleteAllfile($dir){
	// $dir = dirname(dirname(__FILE__)).$filepath;
	$handler = opendir($dir);
	while (($filename = readdir($handler)) !== false) {//务必使用!==，防止目录下出现类似文件名“0”等情况
        if ($filename != "." && $filename != "..") {
                $files[] = $filename ;

        		// echo $filename;
           }
       }
    closedir($handler);

    // 对数据进行处理;
     for($i = 0;$i<sizeof($files);$i++) {
    
    			
    		if(!unlink($dir.'\\'.$files[$i])){
    				echo "delete file failure";
    		}else{
    				echo "delete file success";
    		}
    	
    		
    	
   	}
   }
function deleteperson($id,$userid,$method,$idname){
	// 对文件进行删除
	// 拼接字符串

	$filepath = '\\image\\'.$userid;
	$dir = dirname(dirname(__FILE__)).$filepath;
	deleteexitfile($dir,function($data1){
		$array = array("idname"=>$data1);
		// var_dump($array);
		return $array;
	},$id,"idname");
	if($idname=='personid'){
	

	if($method=='delete'){

		DeleteData('person',[$idname],["'".$id."'"]);
		DeleteData('perjob',[$idname],["'".$id."'"]);
		DeleteData('peredc',[$idname],["'".$id."'"]);
		// 还有
	}
	}else if($idname=='taskid'){
		if($method=='delete'){

		DeleteData('task',[$idname],["'".$id."'"]);
		
		// 还有
		}

	}
	
	
}
function checkchatmsg($data){
	$chat = ['chatid'];
	$chatname = ["'".$data['chatid']."'"];
	$a = 0;
	// foreach ($data as $key => $value) {
			
	// 		if($key=='userid'||$key=='myid'){
	// 			$chat[$a] = $key;
	// 			$chatname[$a] ="'".$value."'";
						
	// 		}
	// 		$a++;
	// 	}
	$getchatid = Select(array('chatmsg','chatid','usernum','mynum'),'chat',$chat,$chatname,function($result){
			while($row = $result->fetch_assoc()) {
				return $row;
  			 	
    		}
	});
	
	
	// if($getchatid=="没有数据"){
	// 	$a = 0;
	// 	foreach ($data as $key => $value) {
			
	// 		if($key=='userid'){
	// 			$chat[$a] = $key;
	// 			$chatname[$a] ="'".$data["myid"]."'";
						
	// 		}else if($key=='myid'){
	// 			$chat[$a] = $key;
	// 			$chatname[$a] ="'".$data["userid"]."'";
	// 		}
	// 		$a++;
	// 	}

	// 	$getchatid = Select(array('chatmsg','chatid','usernum','mynum'),'chat',$chat,$chatname,function($result){
	// 		while($row = $result->fetch_assoc()) {
	// 			return $row;
  			 	
 //    		}
	// 	});
		
	// 	if($getchatid=="没有数据"){
	// 		echo $getchatid;
	// 		return;
	// 	}
	
		
	// }
	if($getchatid['usernum']!=0){
		UpdateData('chat',["usernum"],[0],["chatid"],["'".$getchatid['chatid']."'"]);
	}else if($getchatid['mynum']!=0){
		UpdateData('chat',["mynum"],[0],["chatid"],["'".$getchatid['chatid']."'"]);
	}		
	
	
	echo $getchatid["chatmsg"];
	
}
function savechatmsg($data){
		$imgpath = "./chat/".$data['chatid'];
		 $saveimgpath = "";
		 if (!is_dir($imgpath.'/userimg')) {
  // dir doesn't exist, make it
  			mkdir($imgpath.'/userimg',0777,true);
		}
		 if(!empty($data['userimg'])){
		 	for ($i=0; $i < sizeof($data['userimg']); $i++) {
		 		$imgid = $i.md5(uniqid(mt_rand(), true)); 
		 		file_put_contents($imgpath.'/userimg/'.$imgid.'.jpg',file_get_contents($data['userimg'][$i]['imgsrc']));
		 		$saveimgpath.='http://'.$_SERVER['HTTP_HOST'].substr($imgpath,1).'/userimg/'.$imgid.'.jpg'.",";

		 	}
		 	
		 	
		 }else{
		 	$saveimgpath.=',';
		 }
		 if(!empty($data['userfile'])){
				$urllist= explode(",", $data['userfile'][0]);
				for ($i=0; $i < count($urllist); $i++) { 
					rename("./tmp/".$urllist[$i],$imgpath.'/userfile/'.$urllist[$i]);
					$savefilepath.='http://'.$_SERVER['HTTP_HOST'].substr($imgpath,1).'/userfile/'.$urllist[$i].","; 			
				}
					
		}else{
			$savefilepath.=",";
		}

		$path = "./chat/".$data['chatid']."/".$data['chatid'].".php";
		$subpath = substr($path,1,mb_strlen($path,'utf8'));
		$name = '';
		$arr = array('context' => $data['chatmsg'], 'imgpath' =>$saveimgpath, 'filepath' => $savefilepath);
		if(file_exists($path)){
        	$myfile = fopen($path, "a") or die("Unable to open file!");
			$htmldata = "echo '".json_encode($arr).",-';";
			fwrite($myfile, $htmldata);
			fclose($path);
    	}else{
        	$myfile = fopen($path, "w") or die("Unable to open file!");
			$htmldata = "<?php
				header('Access-Control-Allow-Origin:*');
				header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
				header('Access-Control-Allow-Headers:x-requested-with, content-type'); 
				echo '".json_encode($arr).",-';";
			fwrite($myfile, $htmldata);
			fclose($path);
    	}
		
		
	// 	// 根据myid实在userid里面，还是myid里面
	// 	// 如果是在userid里面，usernum+1;mynum = 0;
	// 	// 如果是在myid里面，munum+1;usernum = 0;

		$nameid = Select(array('usernum','userid','myid','mynum'),'chat',array('chatid'),array("'".$data['chatid']."'"),
		function($result){
				
			return $result;
		});
		$getchatid = [];
		while($row = $nameid->fetch_assoc()) {

				if($row['userid']==$data["flag"]){
					$usernum = (int)$row['usernum']+1;
					$getchatid['usernum'] =  $usernum;
					$getchatid['mynum'] = $usernum = (int)$row['mynum'];

				}else if($row['myid']==$data["flag"]){
					$mynum = (int)$row['mynum']+1;
					$getchatid['mynum'] =  $mynum;
					$getchatid['usernum'] = $usernum = (int)$row['usernum'];
				}
    	}

	// 	// 要优化一下才行
		 UpdateData('chat',["usernum","mynum","userimg","userfile"],["'".$getchatid['usernum']."'","'".$getchatid['mynum']."'","'".$saveimgpath."'","'".$savefilepath."'"],["chatid"],["'".$data['chatid']."'"]);
		echo $data['chatid'].','.'http://'.$_SERVER['HTTP_HOST'].$subpath;

}
// 上面与下面的函数可以进行简化提取
function addchatmsg($data){
	
	$chat = [];
	$chatname = [];
	$a = 0;
	$chatid = $data['chatid'];
	$path="";
	foreach ($data as $key => $value) {
			
			if($key=='userid'||$key=='myid'){
				$chat[$a] = $key;
				$chatname[$a] ="'".$value."'";
						
			}
			$a++;
		}
	$getchatid = Select(array('chatid','usernum','mynum','chatmsg'),'chat',$chat,$chatname,function($result){
			while($row = $result->fetch_assoc()) {
				return $row;
  			 	
    		}
	});
	// var_dump($getchatid);
	if($getchatid=="没有数据"){
		// echo $getchatid;
		$a = 0;
		foreach ($data as $key => $value) {
			
			if($key=='userid'){
				$chat[$a] = $key;
				$chatname[$a] ="'".$data["myid"]."'";
						
			}else if($key=='myid'){
				$chat[$a] = $key;
				$chatname[$a] ="'".$data["userid"]."'";
			}
			$a++;
		}

		$getchatid = Select(array('chatmsg','chatid'),'chat',$chat,$chatname,function($result){
			while($row = $result->fetch_assoc()) {
				return $row;
  			 	
    		}
		});
		
	
		
	}

	if($getchatid=="没有数据"){
		 $chatid = 'chat'.md5(uniqid(mt_rand(), true));
	// 	//  // echo $chatid;
		 $imgpath = "./chat/".$chatid;
		 $saveimgpath = "";
		 $savefilepath = "";
		 if (!is_dir($imgpath.'/userimg')) {
  // dir doesn't exist, make it
  			mkdir($imgpath.'/userimg',0777,true);
		}
		
		 if (!is_dir($imgpath.'/userfile')) {
  // dir doesn't exist, make it
  			mkdir($imgpath.'/userfile',0777,true);
		}
		if(!empty($data['userfile'])){
				$urllist= explode(",", $data['userfile'][0]);
				for ($i=0; $i < count($urllist); $i++) { 
					rename("./tmp/".$urllist[$i],$imgpath.'/userfile/'.$urllist[$i]);
					$savefilepath.='http://'.$_SERVER['HTTP_HOST'].substr($imgpath,1).'/userfile/'.$urllist[$i].","; 			
				}
					
		}else{
			$savefilepath.=",";
		}
	
		 if(!empty($data['userimg'])){
		 	for ($i=0; $i < sizeof($data['userimg']); $i++) { 
		 		$imgid = $i.md5(uniqid(mt_rand(), true)); 
		 		file_put_contents($imgpath.'/userimg/'.$imgid.'.jpg',file_get_contents($data['userimg'][$i]['imgsrc']));
		 		$saveimgpath.='http://'.$_SERVER['HTTP_HOST'].substr($imgpath,1).'/userimg/'.$imgid.'.jpg'.",";
		 	}
		 	
		 }else{
		 	$saveimgpath.=',';
		 }
		
		
		 // 对这里进行下次修改，改成json格式
		 $path = "./chat/".$chatid."/".$chatid.".php";
		 $subpath = substr($path,1,mb_strlen($path,'utf8'));
	// // 	//  // 可以提取一下
		 $chat[0] = 'chatid';
		$chatname[0] = "'".$chatid."'";
		
	// 	// echo $path;
		// $file = 'test.txt';
		$arr = array('context' => $data['chatmsg'], 'imgpath' =>$saveimgpath, 'filepath' => $savefilepath);
    	if(file_exists($path)){
        	$myfile = fopen($path, "a") or die("Unable to open file!");
			$htmldata = "echo '".json_encode($arr).",-';";
			fwrite($myfile, $htmldata);
    	}else{
        	$myfile = fopen($path, "w") or die("Unable to open file!");
			$htmldata = "<?php
				header('Access-Control-Allow-Origin:*');
				header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
				header('Access-Control-Allow-Headers:x-requested-with, content-type'); 
				echo '".json_encode($arr).",-';";
	
			fwrite($myfile, $htmldata);
    	}
		
	// // 存数据
		$a =1;
		unset($data['flag']);
		foreach ($data as $key => $value) {
			$chat[$a] = $key;
			if($key!='chatmsg'){
				
				$chatname[$a] ="'".$value."'";
						
			}else if($key=='chatmsg'){
				$chatname[$a] = "'".'http://'.$_SERVER['HTTP_HOST'].$subpath."'";
			}else if($key=='userimg'){
				$chatname[$a] = $saveimgpath;
			}else if($key=='userfile'){
				$chatname[$a] = $savefilepath;
			}
			$a++;
		}

		$a = 1;
		Adddata('chat',$chat,$chatname);
		echo $chatid.','.$data['username'].','.$data['userid'].','.$data['usernum'].','.'http://'.$_SERVER['HTTP_HOST'].$subpath;

	}
	// else{
	// 	// echo $chatid;
	// 	// 更新数据
	// 	$imgpath = "./chat/".$getchatid['chatid'];
	// 	 $saveimgpath = "";
	// 	 if (!is_dir($imgpath.'/userimg')) {
 //  // dir doesn't exist, make it
 //  			mkdir($imgpath.'/userimg',0777,true);
	// 	}
	// 	 if(!empty($data['userimg'])){
	// 	 	for ($i=0; $i < sizeof($data['userimg']); $i++) {
	// 	 		$imgid = $i.md5(uniqid(mt_rand(), true)); 
	// 	 		file_put_contents($imgpath.'/userimg/'.$imgid.'.jpg',file_get_contents($data['userimg'][$i]['imgsrc']));
	// 	 		$saveimgpath.='http://'.$_SERVER['HTTP_HOST'].substr($imgpath,1).'/userimg/'.$imgid.'.jpg'.",";

	// 	 	}
		 	
		 	
	// 	 }else{
	// 	 	$saveimgpath.=',';
	// 	 }
	// 	 if(!empty($data['userfile'])){
	// 			$urllist= explode(",", $data['userfile'][0]);
	// 			for ($i=0; $i < count($urllist); $i++) { 
	// 				rename("./tmp/".$urllist[$i],$imgpath.'/userfile/'.$urllist[$i]);
	// 				$savefilepath.='http://'.$_SERVER['HTTP_HOST'].substr($imgpath,1).'/userfile/'.$urllist[$i].","; 			
	// 			}
					
	// 	}else{
	// 		$savefilepath.=",";
	// 	}

	// 	$path = "./chat/".$getchatid['chatid']."/".$getchatid['chatid'].".php";
	// 	$subpath = substr($path,1,mb_strlen($path,'utf8'));
	// 	$name = '';
	// 	$arr = array('context' => $data['chatmsg'], 'imgpath' =>$saveimgpath, 'filepath' => $savefilepath);
	// 	if(file_exists($path)){
 //        	$myfile = fopen($path, "a") or die("Unable to open file!");
	// 		$htmldata = "echo '".json_encode($arr).",-';";
	// 		fwrite($myfile, $htmldata);
	// 		fclose($path);
 //    	}else{
 //        	$myfile = fopen($path, "w") or die("Unable to open file!");
	// 		$htmldata = "<?php
	// 			header('Access-Control-Allow-Origin:*');
	// 			header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
	// 			header('Access-Control-Allow-Headers:x-requested-with, content-type'); 
	// 			echo '".json_encode($arr).",-';";
	// 		fwrite($myfile, $htmldata);
	// 		fclose($path);
 //    	}
		
		
	// 	// 根据myid实在userid里面，还是myid里面
	// 	// 如果是在userid里面，usernum+1;mynum = 0;
	// 	// 如果是在myid里面，munum+1;usernum = 0;

	// 	$nameid = Select(array('usernum','userid','myid','mynum'),'chat',array('chatid'),array("'".$getchatid['chatid']."'"),
	// 	function($result){
				
	// 		return $result;
	// 	});
	// 	while($row = $nameid->fetch_assoc()) {

	// 			if($row['userid']==$data["flag"]){
	// 				$usernum = (int)$row['usernum']+1;
	// 				$getchatid['usernum'] =  $usernum;
					

	// 			}else if($row['myid']==$data["flag"]){
	// 				$mynum = (int)$row['mynum']+1;
	// 				$getchatid['mynum'] =  $mynum;
					
	// 			}
 //    	}

	// 	// 要优化一下才行
	// 	 UpdateData('chat',["usernum","mynum","userimg","userfile"],["'".$getchatid['usernum']."'","'".$getchatid['mynum']."'","'".$saveimgpath."'","'".$savefilepath."'"],["chatid"],["'".$getchatid['chatid']."'"]);
		
		
	// 	echo $getchatid['chatid'].','.'http://'.$_SERVER['HTTP_HOST'].$subpath;
	// }

	
	
}
function Getnum($data){
	// or
	Selectmorecon(['usernum','mynum','userid','myid'],'chat',['myid','userid'],["'".$data."'","'".$data."'"],function($result){
		$a = 0;
		$array = [];
		while($row = $result->fetch_assoc()) {

			$array[$a] =array("mynum"=>$row['mynum'],"usernum"=>$row['usernum'],"userid"=>$row['userid'],"myid"=>$row['myid']) ;
    		// 
  			 	$a++;
    		}
    		echo json_encode($array);	

	});
}
function Getusermsg($data){
	// 根据传过来的数据传承相应的数字
	$usernum = Select(array('usernum','myid','myname'),'chat',array('userid'),array("'".$data['userid']."'"),function($result){
			// while($row = $result->fetch_assoc()) {
				return $result;
  			 	
    		// }
    	}
    );

	if($usernum=="没有数据"){
		$usernum = Select(array('mynum','userid','username'),'chat',array('myid'),array("'".$data['userid']."'"),function($result){
			// while($row = $result->fetch_assoc()) {
				return $result;
  			 	
    		// }
    	}
    	);
    	if($usernum=="没有数据"){
    		echo "没有数据";
    		return;
    	}else{
    		while($row = $usernum->fetch_assoc()) {
    			$row["num"]="mynum";
				$row["name"]="username";
				echo json_encode($row).'-';
  			 	
    		}	
    	}
    	// echo $usernum['mynum'].','.$usernum['userid'].','.$usernum['username'].',mynum,username';
    	
    	// var_dump($usernum);
	}else{
			while($row = $usernum->fetch_assoc()) {
				$row["num"]="usernum";
				$row["name"]="myname";
				 echo json_encode($row).'-';
  			 	
    		}
		// var_dump($usernum);
		// echo $usernum['usernum'].','.$usernum['myid'].','.$usernum['myname'].',usernum,myname';
	}

	

	// echo 1;
}

function savefile($data){

$fileid = 'file'.md5(uniqid(mt_rand(), true));
	

  $myfile = fopen("./tmp/".$fileid.".".getallheaders()["Content-Type"], "w") or die("Unable to open file!");
  $txt = $data;
  fwrite($myfile, $txt);
  fclose($myfile);
echo $fileid.".".getallheaders()["Content-Type"];
  // var_dump($data);
 
  // echo $_SESSION['fileid'];
}
// 可以进行优化task与person差不多
function getorderid($data){
	if(empty($data['personid'])){
		echo "没有数据";
	}else{
		if(empty($data['myid'])){
			echo "没有数据";
		}else{
			// 查询有没有myid这个这个数据;
			// table的名称可以写成框架
			$myid  = Select(array('id'),'user',array('id'),array("'".$data['myid']."'"),function($result){
				return $result;
			});
			if($myid=="没有数据"){
				echo "没有这个用户";
				return;
			}else{
				// 对personid进行查询
				// 把相关内容转为json格式传回到vue中
				// 重构把想得到的数据
				$persondata  = Select(array('personname',"personinfo","personmoney"),'person',array('personid'),array("'".$data['personid']."'"),function($result){
					return $result;
				});
				if($persondata=="没有数据"){
					echo "没有这个订单";
					return;
				}else{
					while($row = $persondata->fetch_assoc()) {
					
				 		 echo json_encode($row);
  			 	
    			}
			}
				// echo $persondata;

			}

		}
	}
}

function getorder($data){
	// var_dump($data);
	$userdata  = Select(array('account'),'User',array('id'),array("'".$data['buyerid']."'"),function($result){
					// echo $result;
						return $result;
				});
	while($row = $userdata->fetch_assoc()) {
					
				 		 $buyaccount = json_encode($row);
  			 	
    			}

    $userdata  = Select(array('account'),'User',array('id'),array("'".$data['sellerid']."'"),function($result){
					// echo $result;
						return $result;
				});
	while($row = $userdata->fetch_assoc()) {
					
				 		 $sellerccount = json_encode($row);
  			 	
    			}

    if(!empty($buyaccount)&&!empty($sellerccount)){
    	if(json_decode($buyaccount, true)['account']==""&&json_decode($sellerccount, true)['account']==""){
    		echo "没有该用户账号信息";
    		return;
    	}else{
    		// 把得到的用户账号存进去
    		$data['buyeraccout'] = json_decode($buyaccount, true)['account'];
    		$data['selleraccout'] = json_decode($sellerccount, true)['account'];
    		saveorderdata($data);
    		
    	}
    }else{
    	echo "没该用户信息";
    	return;
    }
   
	// echo $userdata;
	// 先查询有没有改userid,myid
	// 在查询相关的的用户有没有填写账户名
	// 存储数据
		// 1.价格，天数从personid 或者 taskid 里面取

}
function getbuyorder($data){
	// 查询所有buyer order信息
	// 判断有没buyerid
	if(!empty($data['buyerid'])){
		$orderdata = Select(array('*'),'product',array('buyerid'),array("'".$data['buyerid']."'"),function($result){
		return $result;
		});
	}
	
	// $i = 0;
	if($orderdata=="没有数据"){
		echo "没有数据";
		return; 
	}
	// 查看state是否为6
	while($row = $orderdata->fetch_assoc()) {
		if($row['state']=='6'){
			// 判断当前时间是大于7天时间
			if(!empty($row['sevendate'])){
				if(strtotime($data['sevendays'])>=strtotime($row['sevendate'])){
					UpdateData('product',["state","refunddate"],["7","'".$data['sevendays']."'"],["orderid"],["'".$row['orderid']."'"]);
				}
				// echo strtotime($data['sevendays']).",".strtotime($row['sevendate']).",";
			}
			
			
		}
		// $allbuyerorder[$i] = json_encode($row);
		// $i++;
  		echo json_encode($row).'&'; 
   }
   // $i=0;
   // 根据任务id获取任务的基本信息
 
  	// var_dump($allbuyerorder[0]);

}
function getbuyperson($data){
    	if(!empty($data['personid'])){
    		$persondata = Select(array('*'),'person',array('personid'),array("'".$data['personid']."'"),function($result){
				return $result;
			});
			while($row = $persondata->fetch_assoc()) {
				
		
  				echo json_encode($row); 	
   			}
    	}else if(!empty($data['taskid'])){
    		// 迟一点在写;
    	}else{
    		echo "输出的数据不对";
    		return;
    	}

    	
    }

function getsellerorder($data){
		if(!empty($data['sellerid'])){
		$orderdata = Select(array('*'),'product',array('sellerid'),array("'".$data['sellerid']."'"),function($result){
		return $result;
		});
	}
	
	// $i = 0;
	if($orderdata=="没有数据"){
		echo "没有数据";
		return; 
	}
	while($row = $orderdata->fetch_assoc()) {
				
		// $allbuyerorder[$i] = json_encode($row);
		// $i++;
  		echo json_encode($row).'&'; 	
   }
  }

 function getshiporder($data){
 	// 修改商品的状态
 	// 判断商品的状态是否为为1
 	// var_dump($data);
 	if(empty($data['orderid'])){
 		echo "没有传入数据";
 		return;
 	}
 	$shipstate = Select(array('state'),'product',array('orderid'),array("'".$data['orderid']."'"),function($result){
 		return $result;
 	});
 	if($receiptdate=="没有数据"){
		echo "没有数据";
		return; 
	}
	while($row = $shipstate->fetch_assoc()) {
			
  		$state = json_encode($row); 	
   	}
   	if(empty(json_decode($state,true)['state'])){
   		echo "顾客还没付款";
   		return; 
   	}
   	if(json_decode($state,true)['state']==1){
   		UpdateData('product',["state","shipdate"],["2","'".$data['shipdate']."'"],["orderid"],["'".$data['orderid']."'"]);
   	}else{
   		echo "已经发货";
   	}
 	// if(empty($data)){

 	// }
 	  // UpdateData('product',["state","shipdate"],["2","'".$data['shipdate']."'"],["orderid"],["'".$data['orderid']."'"]);
 	  // echo 2;


 }	

 function completeorder($data){
 	// 首席先判断有没有收货时间，如果没有，就return

 	if(empty($data['orderid'])){
 		echo "没有传入数据";
 		return;
 	}
 	$state = Select(array('state'),'product',array('orderid'),array("'".$data['orderid']."'"),function($result){
 		return $result;
 	});
 	if($state=="没有数据"){
		echo "没有数据";
		return; 
	}
	while($row = $state->fetch_assoc()) {
			
  		$getstate = json_encode($row); 	
   }
   // echo $retdate;
   if(json_decode($getstate,true)['state']==3){
   		// echo "顾客还没收货";
   	 UpdateData('product',["state","completedate"],["5","'".$data['completedate']."'"],["orderid"],["'".$data['orderid']."'"]);
   		// return; 
   }
   // // 修改state的状态
   // if(!empty(json_decode($retdate,true)['receiptdate'])){

   		
   // }

 }
 function receiptorder($data){
 	// 先查看有没有发，如果已经发货了，就可以完成确认收货，更新时间，
 	// 如果没有就return

 	if(empty($data['orderid'])){
 		echo "没有传入数据";
 		return;
 	}
 		$state = Select(array('state'),'product',array('orderid'),array("'".$data['orderid']."'"),function($result){
 		return $result;
 	});
 	if($state=="没有数据"){
		echo "没有数据";
		return; 
	}
	while($row = $state->fetch_assoc()) {
			
  		$getstate = json_encode($row); 	
   }
   // echo $retdate;
   if(json_decode($getstate,true)['state']==2){
   		// echo "顾客还没收货";
   	 UpdateData('product',["state","receiptdate"],["3","'".$data['receiptdate']."'"],["orderid"],["'".$data['orderid']."'"]);
   		// return; 
   }
 	// $shiptdate = Select(array('shipdate','completedate'),'product',array('orderid'),array("'".$data['orderid']."'"),function($result){
 	// 	return $result;
 	// });
 	// while($row = $shiptdate->fetch_assoc()) {
			
  // 		$shdate = json_encode($row); 	
  //  }
  //  // echo $shdate;
  // 	if(empty(json_decode($shdate,true)['shipdate'])){
  // 		echo "客户还没有发货";
  //  		return;
  // 	}
  // 	if(!empty(json_decode($completedate,true)['completedate'])){
  // 		echo "已完成订单";
  //  		return;
  // 	}
  //  if(!empty(json_decode($shdate,true)['shipdate'])&&!empty(json_decode($completedate,true)['shipdate'])){
  //  		 UpdateData('product',["state","receiptdate"],["3","'".$data['receiptdate']."'"],["orderid"],["'".$data['orderid']."'"]);
  //  }
 }

 function buyerrefundorder($data){
 	// 判断订单有没有完成
 	// 如果完成了，就售后，如果没完成就退款
 	if(empty($data['orderid'])){
 		echo "没有传入数据";
 		return;
 	}
 	$state = Select(array('state'),'product',array('orderid'),array("'".$data['orderid']."'"),function($result){
 		return $result;
 	});
 	while($row = $state->fetch_assoc()) {
			
  		$getstate = json_encode($row); 	
   }
   if(empty(json_decode($getstate,true)['state'])){
  		echo "没有状态";
   		return;
  	}
  	if(json_decode($getstate,true)['state']==5){
  		echo "售后";
  		return;
  	}
  	if(json_decode($getstate,true)['state']==6){
  		echo "已经在退款中";
  		return;
  	}
  	if(json_decode($getstate,true)['state']==7){
  		echo "已经退款成功";
  	}
  	UpdateData('product',["state","rerefunddate","sevendate"],["6","'".$data['rerefunddate']."'","'".$data['sevendate']."'"],["orderid"],["'".$data['orderid']."'"]);
 	// echo $getstate;
 }
 function sellersurerefunk($data){
 	// var_dump($data);
 	if(empty($data['orderid'])){
 		echo "没有传送数据";
 		return;
 	}

 	$state = Select(array('state'),'product',array('orderid'),array("'".$data['orderid']."'"),function($result){
 		return $result;
 	});
 	while($row = $state->fetch_assoc()) {
			
  		$getstate = json_encode($row); 	
   }
   if(json_decode($getstate,true)['state']==6){
   		UpdateData('product',["state","refunddate"],["7","'".$data['refunddate']."'"],["orderid"],["'".$data['orderid']."'"]);

   }
   // echo $getstate;

 }
 function buyersurerefunk($data){
 	// 直接把相关的订单退款
 	if(empty($data['orderid'])){
 		echo "没有订单数据";
 		return;
 	}
 	$state = Select(array('state'),'product',array('orderid'),array("'".$data['orderid']."'"),function($result){
 		return $result;
 	});
 	while($row = $state->fetch_assoc()) {
			
  		$getstate = json_encode($row); 	
   }
   if(json_decode($getstate,true)['state']!=7){

   		UpdateData('product',["state","rerefunddate","refunddate"],["7","'".$data['refunddate']."'","'".$data['refunddate']."'"],["orderid"],["'".$data['orderid']."'"]);

   }
 	// var_dump($data);
 }
function saveorderdata($data){
	// 1.先随机生成一个orderid
	$orderid = productid('orderid');
	$data["orderid"] = $orderid;
	$data["state"] = 1;
	$personmoney = "";
	// 2.先判断personid还是taskid
	if($data['personid']!=""){
		// 根据personid去寻找相关的价格,天数
		$personinfo  = Select(array('personmoney'),'person',array('personid'),array("'".$data['personid']."'"),function($result){
					// echo $result;
						return $result;
				});
		while($row = $personinfo->fetch_assoc()) {
						// 对数据进行拆分
							if(!empty($row['personmoney'])){
								$personmoney = json_decode(json_encode($row), true)['personmoney'];
								$personmoney = str_replace("{","", $personmoney);
								$personmoney = str_replace("}","", $personmoney);
								$personmoney = explode(",", $personmoney);
								
								
								
							}
				 		  
  			 	
    			}

    	
    for ($i=0; $i < count($personmoney); $i++) { 
    	if($data['payday']==90){
    		if(strstr($personmoney[$i],"three")!=false){
    			if(strstr($personmoney[$i],$data['paymoney'])!=false){
    				$personmoney[$i] = explode(":", $personmoney[$i]);
    				$data["price"] = $personmoney[$i][1];
    				$data["time"] = $data['payday'];
    			}else{
    				echo "没有该价格";
    				return;
    			}
    		}
    		}else if($data['payday']==30){
    			if(strstr($personmoney[$i],"one")!=false){
    			if(strstr($personmoney[$i],$data['paymoney'])!=false){
    				$personmoney[$i] = explode(":", $personmoney[$i]);
    				$data["price"] = $personmoney[$i][1];
    				$data["time"] = $data['payday'];
    			}else{
    				echo "没有该价格";
    			}
    		}
    		}else if($data['payday']==180){
    			if(strstr($personmoney[$i],"six")!=false){
    			if(strstr($personmoney[$i],$data['paymoney'])!=false){
    				$personmoney[$i] = explode(":", $personmoney[$i]);
    				$data["price"] = $personmoney[$i][1];
    				$data["time"] = $data['payday'];
    			}else{
    				echo "没有该价格";
    				return;
    			}
    		}
    		}else{
    			echo "没有该天数";
    			return;
    		}
    	
    }		
	unset($data["paymoney"]);

    unset($data["payday"]);							
    
	}else if($data['taskid']!=""){
		// 根据taskid去寻找相关的价格
		$taskinfo  = Select(array('taskprice'),'task',array('taskid'),array("'".$data['tskid']."'"),function($result){
					// echo $result;
						return $result;
				});
		while($row = $taskinfo->fetch_assoc()) {
					
				 		 // $sellerccount = json_encode($row);
  			 	
    			}

	}
	$key = getfordata($data,"key");
	$value = getfordata($data,"value");
	// var_dump($value);
	// 增加数据
	Adddata('product',$key,$value);
	// var_dump($data);

}

function productid($name){
	return  $name.md5(uniqid(mt_rand(), true));
}

function getfordata($array,$k){
	$getdata = [];
	$i = 0;
	if($k=="key"){
		foreach ($array as $key => $value)
		{	
    		$getdata[$i] =  $key;
    		$i++;
		}

		$i = 0;
		return $getdata;
	}

	if($k=="value"){
		foreach ($array as $key => $value)
		{	
    		$getdata[$i] =  "'".$value."'";
    		$i++;
		}

		$i = 0;
		return $getdata;
	}
	

}
function getpersontable($data){
	if($data['show']=='Boss'){
		$conperson = SelectLimitcon("*",'person',['userid'],["'".$data['userid']."'"],[0,2],function($result){
				$i = 0;
				$a = [];
				while($row = $result->fetch_assoc()) {
					$a[$i] = json_encode($row);
					$i++;
					
    			}
    			return $a;
    			
		});

		echo json_encode($conperson);
	}
	
	
}
function getpersontablenum($userid,$flag,$show){

	if($show=='Boss'){
		getTableDatacon("*","person",['userid'],["'".$userid."'"],[0,2]);
	}else{
		getTableDatacon("*","task",['userid'],["'".$userid."'"],[0,2]);
	}
	
}
function SendephoneCode($phone){
	// 1.得到手机号
	// 2.自动生成验证码
	// 存储手机号以及验证码
	// 发送信息
	// echo "测试这个函数有没有用";
	// sendphonecode('15118747494','1234');
	// sendphonecode('15118747494','1245');
}
function getJumpPage($table,$show,$totalnum,$n){
	// 显示的条数n
	// 得到的初始数据为($show-1)*n
	// 得到的终条数为(($show-1)*n)+(n-1)
	// 得到的终条数要进行判断（($show-1)*n)+(n-1)是否大于总条数
	// 如果大于则终条数显示为总条数
	$strat = ($show-1)*$n;
	$end = (($show-1)*$n)+($n-1);
	if($end>($totalnum-1)){
		$end = $totalnum-1;
	}
	// 如果$table为Boss,表为person
	// 反而为表为task

	if($table=="Boss"){
		$flagtable = "person";
	}else{
		$flagtable = "task";
	}
	// if($strat==0){
	// 	$end = $end+1;
	// }
	if($strat!=$end){
		// $limit = ($strat,$end);
		// 提取方法;
		chatPageLimit('*',$flagtable,[$strat,2]);
	
	}else{
		// 进行单条数据提取;
		chatPageLimit('*',$flagtable,[$strat,1]);
	}
	// echo $strat." ".$end;
}
function getJumpPagecon($table,$show,$totalnum,$n,$userid){
	// 显示的条数n
	// 得到的初始数据为($show-1)*n
	// 得到的终条数为(($show-1)*n)+(n-1)
	// 得到的终条数要进行判断（($show-1)*n)+(n-1)是否大于总条数
	// 如果大于则终条数显示为总条数
	;
	$strat = ($show-1)*$n;
	$end = (($show-1)*$n)+($n-1);
	if($end>($totalnum-1)){
		$end = $totalnum-1;
	}
	// 如果$table为Boss,表为person
	// 反而为表为task

	if($table=="Boss"){
		$flagtable = "person";
	}else{
		$flagtable = "task";
	}
	// if($strat==0){
	// 	$end = $end+1;
	// }

	if($strat!=$end){
		// $limit = ($strat,$end);
		// 提取方法;
		chatPageLimitCon('*',$flagtable,['userid'],["'".$userid."'"],[$strat,2]);
	
	}else{
		// 进行单条数据提取;
		chatPageLimitCon('*',$flagtable,['userid'],["'".$userid."'"],[$strat,1]);
	}
	// echo $strat." ".$end;
}
function chatPageLimit($data,$table,$condition){

	$limitdata = getTableLimitData($data,$table,$condition);
	echo json_encode($limitdata);
}
function chatPageLimitCon($array,$table,$condition,$data,$num){

	$limitdata = getTableLimitDatacon($array,$table,$condition,$data,$num);
	echo json_encode($limitdata);
	
}
function chatPageLimitContset($array,$table,$condition,$data,$num){

	 getTableLimitDatacontest($array,$table,$condition,$data,$num);
	
	
}
function getTableData($data,$table,$condition){
	
	// echo $totalnum;
	// $i=0;
		$totalnum = getTablenum($table);
		$totaldata = getTableLimitData($data,$table,$condition);
		$totaldata[count($totaldata)] = $totalnum;

		echo json_encode($totaldata);
}
function getTableDatacon($array,$table,$condition,$data,$num){
	
	// echo $totalnum;
	// $i=0;
		$totalnum = getLimitTablenum($table,$condition,$data);
		$totaldata = getTableLimitDatacon($array,$table,$condition,$data,$num);
		$totaldata[count($totaldata)] = $totalnum;

		echo json_encode($totaldata);
}
function getTablenum($table){
	$totalnum = SelectTotalNum($table,function($result){
				while($row = $result->fetch_assoc()) {
					return json_encode($row);
  			 	 // echo $row['taskid'].",".$row['taskname'].",".$row['taskprice'].",".$row['taskintro']."-";
    			}
		
		});
	return $totalnum;
}
function getLimitTablenum($table,$condition,$data){
	$totalnum = SelectNum($table,$condition,$data,function($result){
				while($row = $result->fetch_assoc()) {
					return json_encode($row);
  			 	 // echo $row['taskid'].",".$row['taskname'].",".$row['taskprice'].",".$row['taskintro']."-";
    			}
		
		});
	return $totalnum;
}
function getTableLimitDatacon($array,$table,$condition,$data,$num){
	$totaldata = SelectLimitcon($array,$table,$condition,$data,$num,function($result){
				$i = 0;
				$a = [];
				while($row = $result->fetch_assoc()) {
					$a[$i] = json_encode($row);
					$i++;
					
    			}
    			return $a;
		
		});

	return $totaldata;
}
function getTableLimitDatacontest($array,$table,$condition,$data,$num){
	SelectLimitcontest($array,$table,$condition,$data,$num,function($result){
			
		
		});

	// return $totaldata;
}
function getTableLimitData($data,$table,$condition){
	$totaldata = SelectLimit($data,$table,$condition,function($result){
				$i = 0;
				$a = [];
				while($row = $result->fetch_assoc()) {
					$a[$i] = json_encode($row);
					$i++;
					
    			}
    			return $a;
		
		});

	return $totaldata;
}
// function getTableLimitDatacon($array,$table,$condition,$data){
// 	$totaldata = SelectLimit($data,$table,$condition,function($result){
// 				$i = 0;
// 				$a = [];
// 				while($row = $result->fetch_assoc()) {
// 					$a[$i] = json_encode($row);
// 					$i++;
					
//     			}
//     			return $a;
		
// 		});

// 	return $totaldata;
// }
function getchatperson($myid,$page,$totalnum,$displaynum){
	// 先显示10个
	if(($totalnum%$displaynum)!=0){
		if($page==(floor($totalnum/$displaynum)+1)){
			$page = floor($totalnum%$displaynum);	
		}else{
			$page = ($page-1)*1;
		}
	}else{
		$page = ($page-1)*1;
	}
	
	Selectmorelimitcon(array("chatid","userid","myid","usernum","mynum"),'chat',['myid','userid'],["'".$myid."'","'".$myid."'"],[$page,$displaynum],function($result){
				$usernames = [];
				$i = 0;
    			while($row = $result->fetch_assoc()) {
				// // 拿到userid,去查询名字，进行添加
				$username = getusername($row['userid']);
				$myname = getusername($row['myid']);
				// array("a"=>"red","b"=>"green")
				$array = array('userid'=>$row['userid'],"username"=>$username,"usernum"=>$row['usernum'],'myid'=>$row['myid'],"myname"=>$myname,"mynum"=>$row['mynum'],"chatid"=>$row['chatid']);
				$usernames[$i] = $array;
				$i++;
    		}
    // 		// var_dump($usernames);
    		echo json_encode($usernames);
    			
		});

	
}
// function getchatuserperson($userid,$page,$totalnum,$displaynum){
// 	if(($totalnum%$displaynum)!=0){
// 		if($page==(floor($totalnum/$displaynum)+1)){
// 			$page = floor($totalnum%$displaynum);	
// 		}else{
// 			$page = ($page-1)*1;
// 		}
// 	}else{
// 		$page = ($page-1)*1;
// 	}
// 	$conperson = SelectLimitcon(["myid","mynum"],'chat',['userid'],["'".$userid."'"],[$page,$displaynum],function($result){
		
//     			return $result;
    			
// 		});

// 	if(!empty($conperson)){
// 		if($conperson!="没有数据"){
// 			$usernames = [];
// 			$i = 0;
// 			while($row = $conperson->fetch_assoc()) {
// 				// 拿到userid,去查询名字，进行添加
// 				$myname = getusername($row['myid']);
// 				// array("a"=>"red","b"=>"green")
// 				$array = array('id'=>$row['myid'],"username"=>$myname,"mynum"=>$row['mynum']);
// 				$usernames[$i] =$array;
// 				$i++;
//     		}
//     		echo json_encode($usernames);
// 		}else if($conperson=="没有数据"){
// 			echo "没有数据";
// 		}
		
// 	}else{
// 		echo "没有数据";
// 	}

// }
function getaddchatperson($userid,$myid){
	// 查看数据，有则显示该名字，没有就添加名字
	// 先判断有没有chatid
	$username = Select(array('chatid','userid','myid','usernum','mynum','username','myname'),'chat',array('userid','myid'),array("'".$userid."'","'".$myid."'"),
		function($result){
				
			return $result;
		});

	
	if($username=="没有数据"){
		$getchatid = Select(array('chatid','userid','myid','usernum','mynum','username','myname'),'chat',array('myid','userid'),array("'".$userid."'","'".$myid."'"),function($result){
				
			return $result;
		});
		
		// echo $getchatid;
		if($getchatid=="没有数据"){
			// 新增chat
			$getname = getusername($userid);
			$array =array('username'=>$getname);
		}else{
			while($row = $getchatid->fetch_assoc()) {
				// 拿到userid,去查询名字，进行添加
				$array =array('chatid'=>$row['chatid'],"userid"=>$row['userid'],"myid"=>$row['myid'],'usernum'=>$row['usernum'],"mynum"=>$row['mynum'],'username'=>$row['username'],"myname"=>$row['myname']);
			}
		}
	}else{
		while($row = $username->fetch_assoc()) {
				// 拿到userid,去查询名字，进行添加
		$array =array('chatid'=>$row['chatid'],"userid"=>$row['userid'],"myid"=>$row['myid'],'usernum'=>$row['usernum'],"mynum"=>$row['mynum'],'username'=>$row['username'],"myname"=>$row['myname']);

		}
	}
    // $username = getusername($userid);
    // $array= array("name"=>$username,"id"=>$userid);
    // // for($i = 0;$i<sizeof($username);$i++){
    // // 	echo $username[$i];
    // // }
    echo json_encode($array);
}


function getusername($userid){
		$username = Select(array('username','id'),'user',array('id'),array("'".$userid."'"),
		function($result){
				
			return $result;
		});
		// $i = 0;
		// $a = [];
		while($row = $username->fetch_assoc()) {
			// $a[$i] = $row["username"];
			// $i++;	
				return $row["username"];
    	}
    	// $i = 0;
    	// return $a;
}
function getUserid($show){
		Select(array('userid','myid'),'chat',['chatid'],["'".$show."'"],function($result){
			$array = [];
			$i = 0;
			while($row = $result->fetch_assoc()) {
				$array[$i] = array('userid'=>$row['userid'],'myid'=>$row['myid']);
				$i++;
			}
  			echo json_encode($array);	
    	});
	// 得到userid ,根据userid更新chat的username
	// $id = Select(array('id'),'user',array('username'),array("'".$show."'"),
	// 	function($result){
				
	// 		return $result;
	// 	});
	// while($row = $id->fetch_assoc()) {
	// 		// $a[$i] = $row["username"];
	// 		// $i++;	
	// 			$userid = $row["id"];
 //    	}
  //  	Selecttest(array('userid',""),'chat',array('chatid'),array("'".$show."'"),
		// function($result){
				
		// 	return $result;
		// });

  //  	if($getuserid=="没有数据"){
  //  		$getmyid = Select(array('myid'),'chat',array('myid'),array("'".$userid."'"),
		// function($result){
				
		// 	return $result;
		// });

		// if($getmyid!="没有数据"){
		// 	while($row = $getmyid->fetch_assoc()) {
		// 		UpdateData('chat',["myname"],["'".$show."'"],["myid"],["'".$userid."'"]);
		// 		$array=array("myid"=>$row["myid"]);
		// 		// echo $row["myid"];
		// 		echo json_encode($array);
		// 		return;
  //   		}
		// }
  //  	}else{
  //  		while($row = $getuserid->fetch_assoc()) {
		// 		UpdateData('chat',["username"],["'".$show."'"],["userid"],["'".$userid."'"]);
		// 		$array=array("userid"=>$row["userid"]);
		// 		echo json_encode($array);
		// 		return;
  //   	}
  //  	}


}

function getotalchatnum($myid){
	// 得到userid ,根据userid更新chat的username

	// $conperson = Select(['COUNT(*)'],'chat',['myid'],["'".$myid."'"],function($result){

 //    		return $result;
    			
	// });
	// Selectmorecon(['myid','userid'],'chat',['myid','userid'],["'".$myid."'","'".$myid."'"],function($result){
	// 		$array = [];
	// 		$a = 0;
	// 		while($row = $result->fetch_assoc()) {
	// 			$array[$a] = array('userid'=>$row['userid'],'myid'=>$row['myid']);

	// 			$a++;
				 
 //    		}
 //    		echo json_encode($array);
    			
	// });
	Selectmorecon(['*'],'chat',['myid','userid'],["'".$myid."'","'".$myid."'"],function($result){
				$array = [];
			$a = 0;
			while($row = $result->fetch_assoc()) {
				$array[$a] = $row;

				$a++;
				 
    		}
    		echo json_encode($array);
    			
    		
    			
	});


}

function getaddtotalchatnum($userid){
	$conperson = Select(['COUNT(*)'],'chat',['userid'],["'".$userid."'"],function($result){

    		return $result;
    			
		});
	if(!empty($conperson)){
		if($conperson!="没有数据"){
			
		$getUserid = Select(['myid'],'chat',['userid'],["'".$userid."'"],function($result){
			
					return $result;
			
		
				 
    		});
    		$array = [];
			$a = 0;
			while($row = $getUserid->fetch_assoc()) {
				$array[$a] = $row['myid'];

				$a++;
				 // echo json_encode();
    		}
			while($row = $conperson->fetch_assoc()) {
				$array[$a] = $row['COUNT(*)'];

				$a++;
			}
    		echo json_encode($array);
    		
		}else if($conperson=="没有数据"){
			echo "没有数据";
		}
		
	}else{
		echo "没有数据";
	}
}

// Sendemail('1');
// SelectAll('User');
// Select(array('id','username'),'User',array('id'),array('1'));
// Adddata('User',['id','username',"password"],["2","'xiaohaungli'","12356"]);
// DeleteData('User',["id"],["3"]);
// UpdateData('User',["username","password"],["'dahuang'","'123456aa'"],["id"],["2"]);
?>
