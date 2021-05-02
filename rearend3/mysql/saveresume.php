<?php
include "./function/mysql.php";
include "./function/phonecode.php";
include "./function/email.php";
include "newserivce.php";
class Resume{
	function saveresume($data){
		// 存储到数据库中
		$getkey = getupdatekeys($data,['']);
		$getvalue = getupdatevalue($data,$getkey);
		Adddata('resume',$getkey,$getvalue);
		// var_dump($getkey);
	}

	function checkpersonid($data){
		// 查询出personid,根据personid得到的person数据形成json数组后返回
		
		Select(['personid'],'resume',['taskid'],["'".$data."'"],function($result){
			$i = 0;
			$array = [];
			while($row = $result->fetch_assoc()) {
					// var_dump($row);
					
					$array[$i] = "'".$row['personid']."'";
					$i++;

    			}
    			$i = 0;
    			$forwardcondition = ['personid'];
    			Selectmorecon(['*'],'person',$forwardcondition,$array,function($result){
						$a = 0;
						$array1=[];
						while($row = $result->fetch_assoc()) {
							// echo json_encode($row);

							$array1[$a] = $row;
							$a++;
					

    					}

    					
    					 $obj =array('COUNT(*)' => $a);
    					
    					 $array1[$a] = $obj;
    					 // var_dump($array1);
    					echo json_encode($array1);
    					// echo json_decode($array1);
    			
					});

    			
    		
    			// echo json_encode($array);
		});
		
	}

}

?>