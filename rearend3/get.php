<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');//表示只允许POST请求
header('Access-Control-Allow-Headers:x-requested-with, content-type');
include "./mysql/main.php";
include "./mysql/detail.php";

include "./mysql/newserivce.php";
include "./mysql/function/mysql.php";
$data = "";
 if($_SERVER["REQUEST_METHOD"] == "GET"){
		$show = $_GET["show"];
		if(empty($show)){
			$show=$_GET["personid"];
			if(!empty($show)){
				$userid =$_GET["userid"];
				$detail = new Detail;
				$getarray = array('id' =>"person:personid:".$show,'userid' => $userid);
				$detail->setData($getarray);
				$detail->getDetialdisplayData();
				// getdisplayData("person:personid:".$show,$userid);
			}else{
				$show=$_GET["taskid"];
				if(!empty($show)){
					$userid =$_GET["userid"];
				
				$detail = new Detail;
				$getarray = array('id' =>"task:taskid:".$show,'userid' => $userid);
				$detail->setData($getarray);
				$detail->getDetialdisplayData();
					// getdisplayData("task:taskid:".$show,$userid);
				}else{
					$show=$_GET["myid"];
					$page = $_GET["page"];
					$totalnum = $_GET["totalnum"];
					$displaynum = $_GET["displaynum"];
					if(!empty($show)&&!empty($page)){
						getchatperson($show,$page,$totalnum,$displaynum);
					}else{
						$show = $_GET["chatname"];
						if(!empty($show)){
							getUserid($show);
						}else{
							$show=$_GET["userid"];
							$page = $_GET["page"];
							$totalnum = $_GET["totalnum"];
							$displaynum = $_GET["displaynum"];
							if(!empty($show)&&!empty($page)){
								
								getchatuserperson($show,$page,$totalnum,$displaynum);
							}
						}
					}

				}
			}
			
		} else{
			if($show=='Free'){
				$experiencerequirement = $_GET["experiencerequirement"];
				$education = $_GET["education"];
				$salary = $_GET["salary"];
				if(!empty($salary)||!empty($education)||!empty($experiencerequirement)){
					// getBossDataCon($experiencerequirement,$education,$salary);
					$main = new Main;
					
					$getarray = array('experiencerequirement' => $experiencerequirement,'education' => $education,'salary' => $salary );
					$main->setData($getarray);
					$main->getBossDataCon();
				}else{
					// getBossData();
					$main = new Main;
					$main->getBossData();	
				}
				
			}
			if($show=='Boss'){
				// getFreeData();
				$main = new Main;

				$main->getFreeData();
			}
			
		
		}
	}
?>