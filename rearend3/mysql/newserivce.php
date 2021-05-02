<?php
// include "./function/mysql.php";
// include "./function/phonecode.php";
// include "./function/email.php";
// include "serivce.php";
function newPushpersonalinfo($person){
	if(empty($person)){
		return '没有数据输入';
	}else{
		// echo $person['personmoney']['one'];
		// $json_string = json_encode($person['personmoney'],JSON_FORCE_OBJECT);
		
		$avatarpath = saveimgpath($person)[0];
		$addimgpath = saveimgpath($person)[1];
		$getkey = [];
		$getvalue = [];
		$i = 0;
		foreach ($person as $key => $value) {
			if($addimgpath!=""){
				if($key!="flag"&&$key!="imagenum"&&$key!="method"&&$key!="deleteimgid"&&$key!="listindex"&&$key!="addnum"){
					if($key=="avatar"){
						$getvalue[$i] = "'".$avatarpath."'";
					}else if($key=="proimage"){
						$getvalue[$i] = "'".$addimgpath."'";
					}else{
					
						$getvalue[$i] = "'".$value."'";
					}
					$getkey[$i] =$key;
				}
				
			}else{
				if($key!="flag"&&$key!="imagenum"&&$key!="method"&&$key!="deleteimgid"&&$key!="listindex"&&$key!="addnum"&&$key!="proimage"){
					if($key=="avatar"){
						$getvalue[$i] = "'".$avatarpath."'";
					}else{
					
						$getvalue[$i] = "'".$value."'";
					}
					$getkey[$i] = $key;
				}
				
			}
			$i++;
		}
		$i = 0;

		
		Adddata('person',$getkey,$getvalue);
		
		

	}
}
function newPushtaskinfo($task){
	if(empty($task)){
		return '没有数据输入';
	}else{
		// echo $person['personmoney']['one'];
		// $json_string = json_encode($person['personmoney'],JSON_FORCE_OBJECT);
		
		$avatarpath = saveimgpath($task)[0];
		$addimgpath = saveimgpath($task)[1];
		$getkey = [];
		$getvalue = [];
		$i = 0;
		foreach ($task as $key => $value) {
			if($addimgpath!=""){
				if($key!="flag"&&$key!="imagenum"&&$key!="method"&&$key!="deleteimgid"&&$key!="listindex"&&$key!="addnum"){
					if($key=="avatar"){
						$getvalue[$i] = "'".$avatarpath."'";
					}else if($key=="proimage"){
						$getvalue[$i] = "'".$addimgpath."'";
					}else{
					
						$getvalue[$i] = "'".$value."'";
					}
					$getkey[$i] =$key;
				}
				
			}else{
				if($key!="flag"&&$key!="imagenum"&&$key!="method"&&$key!="deleteimgid"&&$key!="listindex"&&$key!="addnum"&&$key!="proimage"){
					if($key=="avatar"){
						$getvalue[$i] = "'".$avatarpath."'";
					}else{
					
						$getvalue[$i] = "'".$value."'";
					}
					$getkey[$i] = $key;
				}
				
			}
			$i++;
		}
		$i = 0;

		
		Adddata('task',$getkey,$getvalue);
		
		

	}
}
function saveimgpath($person){
	$imgpath = "";
		if(!empty($person['taskid'])){
			$path = './image/'.$person['userid'].'/'.$person['taskid'];
		}else if(!empty($person['personid'])){
			$path = './image/'.$person['userid'].'/'.$person['personid'];
		}
		
		$avatarpath = "";
		$subpath = substr($path,1,mb_strlen($path,'utf8'));
		if (!is_dir($path)) {
        	mkdir($path, 0755, true);
    	}
    	// 头像迟一点修改
    	if(strstr($person['avatar'],'base64,')){
    		file_put_contents($path.'/avatar.jpg',file_get_contents($person['avatar']));
    		$avatarpath = 'http://'.$_SERVER['HTTP_HOST'].$subpath.'/avatar.jpg';
    	}else{
    		$avatarpath = $person['avatar'];
    	}
    	// 添加的图片要进行时间戳
    	$addimgpath = "";
    	if(count($person['proimage'])>0){
    		for ($i=0; $i < count($person['proimage']); $i++) {
			$saveimagepath = $path.'/'.($i+1).'+'.time().'.jpg'; 
			file_put_contents($saveimagepath,file_get_contents($person['proimage'][$i]));
			$imgpath.='http://'.$_SERVER['HTTP_HOST'].substr($saveimagepath,1,mb_strlen($saveimagepath,'utf8')).',';
			}
			$addimgpath = substr($imgpath,0,mb_strlen($imgpath,'utf8')-1);
    	}
		
		return [$avatarpath,$addimgpath];

}


function getsendarray($equealdata,$equealid,$getarray){
	$secondequeal = $equealdata;
	$secondunequeal = [];
	$getseconddata = [];
	for($i = 0;$i<sizeof($getarray);$i++){
		foreach ($getarray[$i] as $key => $value) {
			for($j=0;$j<sizeof($secondequeal);$j++){
				if($key==$secondequeal[$j]){
					$getseconddata[$key] = $value;
				}
			}

			$secondunequeal[$i]=$getseconddata;
				
		}
	}
	// 去重

	$secondlength = sizeof($secondunequeal);
	for($i=0;$i<$secondlength;$i++){
		for($j=$i+1;$j<$secondlength;$j++){
			if($secondunequeal[$i][$equealid]==$secondunequeal[$j][$equealid]){

				array_splice($secondunequeal,$j,1);
				$j--;
				$secondlength = sizeof($secondunequeal);
			}
		}
		$secondlength = sizeof($secondunequeal);
		
	}

	return $secondunequeal;
}
function newUpdatepersoninfo($data){
	// 进行修改
	$person = [];
	$upperson = [];
	$a = 0;
	$newdata  = imgdealwith($data);
   	foreach ($newdata as $key => $value) {
		if($key!='flag'&&$key!='method'&&$key!='personid'&&$key!='imagenum'&&$key!='deleteimgid'&&$key!='listindex'&&$key!='addnum'){
			$person[$a] = $key;
			$upperson[$a] ="'".$value."'";
			$a++;
		}
	}
		$a = 0;
		$imagenum = 0;
    	$$addnum = 0;
    
	UpdateData('person',$person,$upperson,["personid"],["'".$newdata['personid']."'"]);

 }
   
	


function newUpdatetaskinfo($task){
	$person = [];
	$upperson = [];
	$a = 0;
	$newdata  = imgdealwith($task);
   	foreach ($newdata as $key => $value) {
		if($key!='flag'&&$key!='method'&&$key!='taskid'&&$key!='imagenum'&&$key!='deleteimgid'&&$key!='listindex'&&$key!='addnum'){
			$person[$a] = $key;
			$upperson[$a] ="'".$value."'";
			$a++;
		}
	}
		$a = 0;
		$imagenum = 0;
    	$$addnum = 0;
    
	UpdateData('task',$person,$upperson,["taskid"],["'".$newdata['taskid']."'"]);

 }



function imgdealwith($data){
	$imgpath = "";
	if(!empty($data['personid'])){
		$path = './image/'.$data['userid'].'/'.$data['personid'];
		$filepath = '\\image\\'.$data['userid'].'\\'.$data['personid'];
	}else if(!empty($data['taskid'])){
		$path = './image/'.$data['userid'].'/'.$data['taskid'];
		$filepath = '\\image\\'.$data['userid'].'\\'.$data['taskid'];
	}
	
	$avatarpath = "";
	$subpath = substr($path,1,mb_strlen($path,'utf8'));
	
	$dir = dirname(dirname(__FILE__)).$filepath;
	$avatar ="";
	// // 迟一点修改头像

    if(strstr($data['avatar'],'base64,')){
    	$avatar = 'avatar'.time().'.jpg';
    	file_put_contents($path.'/'.$avatar,file_get_contents($data['avatar']));
    	$avatarpath = 'http://'.$_SERVER['HTTP_HOST'].$subpath.'/'.$avatar;
    }else{
    	$avatarposition = strpos($data['avatar'], 'avatar');
    	$avatar = substr($data['avatar'],$avatarposition);
    	echo $avatar;
    	$avatarpath = $data['avatar'];
    }
 //  	// 获得相关路径下的图片名称
 //    		// 对相关的图片名称进行比较
 //    		// 如果有删除相关的图片，然后添加对应的图片时间戳
 //    		// 如果没有添加图片加时间戳
 //    // 删除图片后修改图片的路径名称
    $imagenum = 0;
    $addnum =0;
    $mergenum = 0;
 //    	// 添加更新图片名称
    if(sizeof($data['deleteimgid'])>0&&sizeof($data['listindex'])==0){
    	// 删除所有图片，并且设置数据库的图片路径为空
    	deleteAllfile($dir);
    	if(!empty($data['personid'])){
    		UpdateData('person',['proimage'],[],["personid"],["'".$data['personid']."'"]);
    	}else if(!empty($data['taskid'])){
    		UpdateData('person',['proimage'],[],["taskid"],["'".$data['taskid']."'"]);
    	}
    	
    }else{
    	for ($i=0; $i < count($data['proimage']); $i++) {

    	if(strstr($data['proimage'][$i],'base64,')){

    		$saveimagepath = "";
    		$timepath ="";
    		if(sizeof($data['deleteimgid'])>0){
    			// 删除的图片名称
    			$timepath = '/'.$data['listindex'][$i]."+".time().'.jpg';
    			$saveimagepath = $path.$timepath;

    		}else{ 
    			if(sizeof($data['imagenum'])>0&&sizeof($data['addnum'])==0){
    			// 更新的数据图片名称
    				$timepath = '/'.$data['imagenum'][$imagenum]."+".time().'.jpg';
    				$saveimagepath = $path.$timepath;
				
				// $imgpath.='http://'.$_SERVER['HTTP_HOST'].$subpath.$timepath.',';
					$imagenum++;
    			}
    			if(sizeof($data['addnum'])>0&&sizeof($data['imagenum'])==0){
    			// 添加的文件名称
    				$timepath = '/'.$data['addnum'][$addnum]."+".time().'.jpg';
    				$saveimagepath = $path.$timepath;
    				$addnum++;
    				
    			}
    			// 添加和更新的文件名称
    			if(sizeof($data['addnum'])>0&&sizeof($data['imagenum'])>0){
    				$merge = array_unique(array_merge($data['addnum'],$data['imagenum']));
    				$timepath = '/'.$merge[$mergenum]."+".time().'.jpg';
    				$saveimagepath = $path.$timepath;
    				$mergenum++;
    			}
    		}
    		file_put_contents($saveimagepath,file_get_contents($data['proimage'][$i]));
    		$imgpath.='http://'.$_SERVER['HTTP_HOST'].$subpath.$timepath.',';
		}else{
			if(sizeof($data['deleteimgid'])>0){
    	// 删除修改图片名称
				// 找到+的位置
				$checksub = strpos($data['proimage'][$i], '+');

				if($checksub){
					// 获得相应的图片数字
					// 拿到本地地址的数字
					$subnum = substr($data['proimage'][$i],$checksub-1,1);
					$nowname ="";
					$lastindex = "";
					// if(intval($subnum)>$data['deleteimgid'][sizeof($data['deleteimgid'])-1]){
						$nowname = dirname(dirname(__FILE__)).$filepath.substr($data['proimage'][$i],strrpos($data['proimage'][$i],"/"));
						$data['proimage'][$i] = substr_replace($data['proimage'][$i],intval($data['listindex'][$i])."+".time().".jpg",($checksub)-1);
					
						$lastindex = strrpos($data['proimage'][$i],"/");
						// 修改文件名有问题
						
						if(rename($nowname,dirname(dirname(__FILE__)).$filepath.substr($data['proimage'][$i],$lastindex))){
							echo "成功";
						}else{
							echo "失败";
						}
						
					// }
					
				}
				

    		}
			$imgpath.=$data['proimage'][$i].',';
		}
	}
   	
  	}
    $data['proimage'] = substr($imgpath,0,mb_strlen($imgpath,'utf8')-1);
    $dataproimage = explode(",",$data['proimage']);
    for($i = 0;$i<sizeof($dataproimage);$i++){
    		$dataproimage[$i] = substr($dataproimage[$i],strrpos($dataproimage[$i],"/")+1);
    		
    }
    // if($avatar!=""){
    $dataproimage[sizeof($dataproimage)] = $avatar;
    // }
   	// 删除有问题
    deleteNotexitfile($dir,function($data1){
    	
    	$array = $data1;
    	
    	
    	return $array;
    },$dataproimage);
    // echo $data['proimage'];addnum
    $data['avatar'] = $avatarpath;
    return $data;

  
}
function addpersonwork($person,$perjob){
	// perjob
	// var_dump($perjob);
	// 判断是否为数组；
	if(is_array($perjob)){
		for($i = 0;$i<sizeof($perjob);$i++){
			adddataperson($person,$perjob[$i]['val'],'perjob','perjobid');
			// var_dump($perjob[$i]["val"]);
		}

	}
		


}

function addpersondec($person,$peredc){
		if(is_array($peredc)){
		for($i = 0;$i<sizeof($peredc);$i++){
			adddataperson($person,$peredc[$i]['val'],'peredc','peredcid');
		}
	}
	
}
function adddataperson($person,$per,$table,$idname){
			if(!empty($per)){
			if($per[$idname]==""){
				$idvalue = $idname.md5(uniqid(mt_rand(), true));
			}else{
				$idvalue = $per[$idname];
			}
			
			$getkey = [];
			$getvalue = [];
			$getkey[0] = $idname;
			$getkey[1] = "userid";
			$getkey[2] = "personid";
			$getvalue[0] = "'".$idvalue."'";
			$getvalue[1] = "'".$person['userid']."'";
			$getvalue[2] = "'".$person['personid']."'";
			$i = 3;
			foreach ($per as $key => $value) {
				if($key!=$idname){
					$getkey[$i] = $key;
					$getvalue[$i] = "'".$value."'";
					$i++;
				}
				
			}
			$i = 3;

		Adddata($table,$getkey,$getvalue);
	}
		
}
function updatepersonwork($person,$perjob,$table){
	// if(!empty($perjob['perjobid'])){

	// 	$getkey = getupdatekeys($perjob,['perjobid']);
	// 	$getvalue = getupdatevalue($perjob,$getkey);
	// 	UpdateData($table,$getkey,$getvalue,['perjobid'],["'".$perjob['perjobid']."'"]);
	// }
	// UpdateDatatest($table,$olddata,$newdata,$condition,$data)
	if(empty($perjob)){
		DeleteData($table,['personid'],["'".$person['personid']."'"]);
	}
	if(!empty($perjob)){
			DeleteData($table,['personid'],["'".$person['personid']."'"]);
			if(is_array($perjob)){
				for($i=0;$i<sizeof($perjob);$i++){
					adddataperson($person,$perjob[$i]['val'],'perjob','perjobid');
				}

			}

		}
	// var_dump($getkey);
	// var_dump($getvalue);

}

function updatepersondec($person,$peredc,$table){
	// 先删除，后添加
	
	// 判断得到的id是否为空字符窜，如果为空字符串就添加id;
	// for(){

	// }
		if(empty($perjob)){
		DeleteData($table,['personid'],["'".$person['personid']."'"]);
		}
	// if(!empty($peredc['peredcid'])){
		if(!empty($peredc)){
			DeleteData($table,['personid'],["'".$person['personid']."'"]);
			if(is_array($peredc)){
				for($i=0;$i<sizeof($peredc);$i++){
					adddataperson($person,$peredc[$i]['val'],'peredc','peredcid');
				}

			}

		}
		
	// 	UpdateData($table,$getkey,$getvalue,['peredcid'],["'".$peredc['peredcid']."'"]);
	// }

}

function getupdatekeys($per,$uneqealdata){
	$array = [];
	$i =0;
	// $uneqealsize = 0;
	// $length = sizeof($uneqealdata);
	foreach ($per as $key => $value) {
		$array[$i] = $key;
		$i++;
		# code...
	}
	$i =0;
	if(!empty($uneqealdata)){
		for($a=0;$a<sizeof($uneqealdata);$a++){
		for($b=0;$b<sizeof($array);$b++){
			if($array[$b]==$uneqealdata[$a]){
				array_splice($array, $b, 1);
			}
		}
	}
	}
	

	return $array;

}

function getupdatevalue($per,$keydata){
	$array = [];
	$i =0;
	for($a= 0;$a<sizeof($keydata);$a++){
		foreach ($per as $key => $value) {
			if($key==$keydata[$a]){
				$array[$i] = "'".$value."'";
				$i++;
			}
			
		# code...
		}
	}
	
	$i =0;
	

	return $array;

}
// function testaddperson($person,$perjob,$peredc){
// 	newPushpersonalinfo($person);
// 	addpersonwork($person,$perjob);
// 	addpersondec($person,$peredc);
// }

// function testupdateperson($data,$perjob,$peredc){
// 	updatepersonwork($data,$perjob,'perjob');
// 	updatepersondec($data,$peredc,'peredc');
// 	newUpdatepersoninfo($data);
	
	
// }
// function testaddtask($task){
	
// 	newPushtaskinfo($task);
// }

// function testupdatetask($task){
	

// 	newUpdatetaskinfo($task);
	
// }
?>