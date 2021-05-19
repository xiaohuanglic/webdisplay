<?php
// include "serivce.php";
// include_once "newserivce.php";
//  header('Access-Control-Allow-Origin:*');
// header("Access-Control-Allow-Credentials:true");
// header("Access-Control-Allow-Methods:OPTION, POST, GET");
// header("Access-Control-Allow-Headers X-Requested-With, Content-Type");
class Chat{

	public function getotalchatnum($myid){
	// 得到userid ,根据userid更新chat的username


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

public function getchatperson($myid,$page,$totalnum,$displaynum){
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
public function getaddchatperson($userid,$myid){
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
  
    echo json_encode($array);
    return $array;
}
public function Getnum($data){
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

public function addchatmsg($data){
	
	$chat = [];
	$chatname = [];
	$a = 0;
	// $chatid = $data['chatid'];
	// $path="";
	// foreach ($data as $key => $value) {
			
	// 		if($key=='userid'||$key=='myid'){
	// 			$chat[$a] = $key;
	// 			$chatname[$a] ="'".$value."'";
						
	// 		}
	// 		$a++;
	// 	}
	// $getchatid = Select(array('chatid','usernum','mynum','chatmsg'),'chat',$chat,$chatname,function($result){
	// 		while($row = $result->fetch_assoc()) {
	// 			return $row;
  			 	
 //    		}
	// });
	// // var_dump($getchatid);
	// if($getchatid=="没有数据"){
	// 	// echo $getchatid;
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

	// 	$getchatid = Select(array('chatmsg','chatid'),'chat',$chat,$chatname,function($result){
	// 		while($row = $result->fetch_assoc()) {
	// 			return $row;
  			 	
 //    		}
	// 	});
		
	
		
	// }

	// if($getchatid=="没有数据"){
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

	// }


	
	
}
function checkchatmsg($data){
	$chat = ['chatid'];
	$chatname = ["'".$data['chatid']."'"];
	$a = 0;
	
	$getchatid = Select(array('chatmsg','chatid','usernum','mynum'),'chat',$chat,$chatname,function($result){
			while($row = $result->fetch_assoc()) {
				return $row;
  			 	
    		}
	});
	
	
	
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
public function savefile($data){

$fileid = 'file'.md5(uniqid(mt_rand(), true));
	

  $myfile = fopen("./tmp/".$fileid.".".getallheaders()["Content-Type"], "w") or die("Unable to open file!");
  $txt = $data;
  fwrite($myfile, $txt);
  fclose($myfile);
echo $fileid.".".getallheaders()["Content-Type"];
  // var_dump($data);
 
  // echo $_SESSION['fileid'];
}
}