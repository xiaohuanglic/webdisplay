<?php
$servername = "localhost:3306";
$username = "root";
$password = "123456";
$db = "newfreelancedisplay";
 
// 创建连接

$conn = mysqli_connect($servername, $username, $password,$db);

// 检测连接
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());

}

 
function Getdata($sql,$conn,$callback){
  $result = mysqli_query($conn,$sql);
  if ($result->num_rows > 0) {
    
    return $callback($result);


  }else{
    return "没有数据";
  }
  // 

}
function moretableleftjuin($table,$condition3){
  $string3 = $table[0];
  if(!is_array($table)) { 
    if(is_string($table)){
        return $table;
    }
  }
  $i = 1;
  while ( $i < sizeof($table)) {
    $string3 = $string3." left join ".$table[$i]." on ".$condition3[$i-1];
    $i++;
    # code...
  }
  return $string3;
  // for($i=0;$i<sizeof($table);$i++){
  //   $string3 = $string3.
  // }


}

function operateData($sql,$conn){

  if (mysqli_query($conn, $sql)) {
    return "操作成功";
  } else {
    return  "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
 
  mysqli_close($conn);
}

function datafor($array){
   $string = ""; 

  if(!is_array($array)) { 
    if(is_string($array)){
        return $array;
    }
  }
  foreach($array as $value){
    $string = $string.$value.","." ";
  }
  $index = strripos($string,",");
  // return $index;
  return  substr($string,0,$index);
  // $string = ""; 

  // if(!is_array($array)) { 
  //   if(is_string($array)){
  //       return $array;
  //   }
  // }
  // foreach($array as $value){
  //   $string = $string.$value.","." ";
  // }
  // return  substr($string,0,mb_strlen($string,"utf8")-2);
}


function tablefor($table){
   $string = ""; 

  if(!is_array($table)) { 
    if(is_string($table)){
        return $array;
    }
  }
  foreach($table as $value){
    $string = $string.$value.","." ";
  }
  $index = strripos($string,",");
  // return $index;
  return  substr($string,0,$index);

}
function equealdata($condition,$data){
  $string2 = "";
  if(sizeof($condition)==0){
      return "没有数据";
  }
  if(sizeof($data)==0){
        for ($i=0; $i<count($condition); $i++)
    {
      $string2 = $string2.$condition[$i]."=".'NULL'.", ";
   
    }

  }else{
     for ($i=0; $i<count($condition); $i++)
    {
      $string2 = $string2.$condition[$i]."=".$data[$i].", ";
   
    }

  }
  // return substr($string2,0,mb_strlen($string2,"utf8")-2);
  $index = strripos($string2,",");
  // return $index;
  return  substr($string2,0,$index);


}
function selectdata($condition,$data){
  $string2 = "";
   for ($i=0; $i<count($condition); $i++)
  {
    $string2 = $string2.$condition[$i]."=".$data[$i]."AND ";
   
  }
   $index = strripos($string2,"AND");
  // return substr($string2,0,mb_strlen($string2,"utf8")-4);
  return  substr($string2,0,$index);

}
function moreselectdata($condition,$data){
  $string2 = "";
 
  if(sizeof($condition)==1){
  for ($i=0; $i<count($data); $i++)
  {
    $string2 = $string2.$condition[0]."=".$data[$i]."OR ";
   
  }
   $index = strripos($string2,"OR");
  
  return  substr($string2,0,$index);
 

  }else{
      for ($i=0; $i<count($condition); $i++)
  {
    $string2 = $string2.$condition[$i]."=".$data[$i]."OR ";
   
  }
  $index = strripos($string2,"OR");

  return  substr($string2,0,$index);

  }


}
function onselectdata($condition,$data){
  $string2 = [];

   for ($i=0; $i<count($condition); $i++)
  {
    // $string2 = $string2.$condition[$i]."=".$data[$i]."AND ";
    $string2[$i] = $condition[$i]."=".$data[$i];
   
  }
  // 返回一个数组
  return $string2;
  // return substr($string2,0,mb_strlen($string2,"utf8")-4);


}
function limitdata($num){
  if(sizeof($num)==1){
    return $num[0];
  }
  for($i = 0;$i<sizeof($num);$i++){
    $addnum .= $num[$i].","; 
  }

  return substr($addnum,0,mb_strlen($string2,"utf8")-1);
}
function SelectAll($table,$callback) {
  global $conn;
  $sql = "SELECT * FROM ".$table;
  
  return Getdata($sql,$conn,$callback);

}
function SelectLimit($array,$table,$num,$callback){
  // SELECT * FROM table LIMIT 5,10;
  global $conn;
  $str1 = datafor($array);
  $str2 = limitdata($num);
  $sql = "SELECT ".$str1." "."FROM ".$table." LIMIT ".$str2;
  // echo $sql;
  return Getdata($sql,$conn,$callback);
  

}

function SelectTotalNum($table,$callback){
  global $conn;
   $sql = "SELECT COUNT(*) FROM ".$table;
   // echo $sql;
   return Getdata($sql,$conn,$callback);
}

function SelectNum($table,$condition,$data,$callback){
   global $conn;
   $str2 = selectdata($condition,$data);
   $sql = "SELECT COUNT(*) FROM ".$table." WHERE ".$str2;;
   // echo $sql; 
   return Getdata($sql,$conn,$callback);
}
function Select($array,$table,$condition,$data,$callback){
  global $conn;
  $string2 = "";
  $str1 = datafor($array);
  $str2 = selectdata($condition,$data);
  $sql = "SELECT ".$str1." "."FROM ".$table." WHERE ".$str2;
  // echo $sql;
  return Getdata($sql,$conn,$callback);
}
function Selecttest1($array,$table,$condition,$data,$callback){
  global $conn;
  $string2 = "";
  $str1 = datafor($array);
  $str2 = selectdata($condition,$data);
  $sql = "SELECT ".$str1." "."FROM ".$table." WHERE ".$str2;
  echo $sql;
  // return Getdata($sql,$conn,$callback);
}
function Selectmorecon($array,$table,$condition,$data,$callback){
  global $conn;
  $string2 = "";
  $str1 = datafor($array);
  $str2 = moreselectdata($condition,$data);
  $sql = "SELECT ".$str1." "."FROM ".$table." WHERE ".$str2;
  
  return Getdata($sql,$conn,$callback);
}
function Selectmorecontest($array,$table,$condition,$data,$callback){
  global $conn;
  $string2 = "";
  $str1 = datafor($array);
  $str2 = moreselectdata($condition,$data);
  $sql = "SELECT ".$str1." "."FROM ".$table." WHERE ".$str2;
  echo $sql;
  // return Getdata($sql,$conn,$callback);
}
function Selecttest($array,$table,$condition,$data,$callback){
  global $conn;
  $string2 = "";
  $str1 = datafor($array);
  $str2 = selectdata($condition,$data);
  $sql = "SELECT ".$str1." "."FROM ".$table." WHERE ".$str2;
  echo $sql;
  // return Getdata($sql,$conn,$callback);
}
function SelectLimitcon($array,$table,$condition,$data,$num,$callback){
  global $conn;
  $string2 = "";
  $str1 = datafor($array);
  $str2 = selectdata($condition,$data);
  $str3 = limitdata($num);
  $sql = "SELECT ".$str1." "."FROM ".$table." WHERE ".$str2." LIMIT ".$str3;

  return Getdata($sql,$conn,$callback);
}
function SelectLimitcontest($array,$table,$condition,$data,$num,$callback){
  global $conn;
  $string2 = "";
  $str1 = datafor($array);
  $str2 = selectdata($condition,$data);
  $str3 = limitdata($num);
  $sql = "SELECT ".$str1." "."FROM ".$table." WHERE ".$str2." LIMIT ".$str3;
  echo $sql;
  // return Getdata($sql,$conn,$callback);
}
function Selectmorelimitcon($array,$table,$condition,$data,$num,$callback){
  global $conn;
  $string2 = "";
  $str1 = datafor($array);
  $str2 = moreselectdata($condition,$data);
  $str3 = limitdata($num);
  $sql = "SELECT ".$str1." "."FROM ".$table." WHERE ".$str2." LIMIT ".$str3;
  // echo $sql;
  return Getdata($sql,$conn,$callback);
}
function SelectLimitmoretable($array,$table,$condition,$data,$callback){
   global $conn;
   $string2 = "";
   $str1 = datafor($array);
   $str2 = selectdata($condition,$data);
   $str3 = tablefor($table);
   $sql = "SELECT ".$str1." "."FROM ".$str3." WHERE ".$str2;
   
  return Getdata($sql,$conn,$callback);

}
function Selectleftjiontable($array,$table,$condition1,$data1,$condition,$data,$callback){
  // select *  from  (person  left join peredc on person.personid = peredc.personid LEFT JOIN perjob on person.personid = perjob.personid) where person.personid = 'personalkmuoim5d' 
//   select * from A
// left join B 
// on A.aID = B.bID
   global $conn;
   $string2 = "";
   $str1 = datafor($array);
   $str2 = selectdata($condition,$data);
   $str3 = onselectdata($condition1,$data1);
   $str4 = moretableleftjuin($table,$str3);
   // 1.首先要判断表的数量
   // $str3 = tablefor($table);
   $sql = "SELECT ".$str1." "."FROM ".$str4." WHERE ".$str2;
   return Getdata($sql,$conn,$callback);
}

function Selectleftjiontabletest($array,$table,$condition1,$data1,$condition,$data,$callback){
  // select *  from  (person  left join peredc on person.personid = peredc.personid LEFT JOIN perjob on person.personid = perjob.personid) where person.personid = 'personalkmuoim5d' 
//   select * from A
// left join B 
// on A.aID = B.bID
   global $conn;
   $string2 = "";
   $str1 = datafor($array);
   $str2 = selectdata($condition,$data);
   $str3 = onselectdata($condition1,$data1);
   $str4 = moretableleftjuin($table,$str3);
   // 1.首先要判断表的数量
   // $str3 = tablefor($table);
   $sql = "SELECT ".$str1." "."FROM ".$str4." WHERE ".$str2;
   echo $sql;
   // return Getdata($sql,$conn,$callback);
}


function Adddata($table,$condition,$data){
  global $conn;
  $str1 = datafor($condition);
  $str2 = datafor($data);
  $sql = "INSERT INTO ".$table." (".$str1.") VALUES (".$str2.")";
  // echo $sql;
  return operateData($sql,$conn);
}
function Adddatatest($table,$condition,$data){
  global $conn;
  $str1 = datafor($condition);
  $str2 = datafor($data);
  $sql = "INSERT INTO ".$table." (".$str1.") VALUES (".$str2.")";
  echo $sql;
  // return operateData($sql,$conn);
}

function DeleteData($table,$condition,$data){
  global $conn;
  $str2 = equealdata($condition,$data);
  $sql = "delete from ".$table." where ".$str2;
  return operateData($sql,$conn);
}
function DeleteDatatest($table,$condition,$data){
  global $conn;
  $str2 = equealdata($condition,$data);
  $sql = "delete from ".$table." where ".$str2;
  echo $sql;
  // return operateData($sql,$conn);
}
function UpdateData($table,$olddata,$newdata,$condition,$data){
  global $conn;
  $str1 = equealdata($olddata,$newdata); 
  $str2 = equealdata($condition,$data);
  $sql = "update ".$table." set ".$str1." where ".$str2;
 
  return operateData($sql,$conn);
 
}
function UpdateDatatest($table,$olddata,$newdata,$condition,$data){
  global $conn;
  $str1 = equealdata($olddata,$newdata); 
  $str2 = equealdata($condition,$data);
  $sql = "update ".$table." set ".$str1." where ".$str2;
  echo $sql;
  // return operateData($sql,$conn);
 
}
?>