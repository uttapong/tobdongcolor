<?php
require('config.php');

header('Content-Type: application/json,charset=utf-8');

$action=$_REQUEST['action'];
if($action=='getquota'){
  getquota($_REQUEST['rank']);
}
else if($action=='getinfo'){
  getInfo($_REQUEST['fbid']);
}
else if($action=='getall'){
  getAll();
}
else if($action=='random'){
  random($_REQUEST['rank'],$_REQUEST['fbid']);
}





/*$json=json_decode($jsonstr);
//print_r($json);
foreach ($json as $user) {
  $result = $conn->query("update member set response='{$user->rsvp_status}' where fbid='{$user->id}'");
    //mysqli_stmt_execute($stmt);
}*/
function getInfo($fbid){
  //echo $conn;
  global $conn;
  if(isset($_REQUEST['token'])){
    $result = $conn->query("select name,rank,color from member where fbid='{$_REQUEST['token']}' and color='N'");
  }
  else $result = $conn->query("select name,rank,color from member where fbid='{$fbid}'");
  $row = $result->fetch_assoc();
  if(!$row)echo 0;
  else echo json_encode($row);
}

function getquota($rank){
  global $conn;
  if($rank=='C'||$rank=='P')
    $arr_result=['G'=>8,'B'=>8,'P'=>8,'Y'=>8];
  else
    $arr_result=['G'=>4,'B'=>4,'P'=>4,'Y'=>4];


  $result = $conn->query("select color,count(id) as remain from member where player=1 and rank='{$rank}' group by color");
  while($row = $result->fetch_assoc())
  {
    if($rank=='C'||$rank=='P')
      $arr_result[$row[color]]=8-$row[remain];
    else{
      $arr_result[$row[color]]=4-$row[remain];
    }
  }
  /*foreach ($row as $user) {
    $result = $conn->query("update member set response='{$user->rsvp_status}' where fbid='{$user->id}'");
      //mysqli_stmt_execute($stmt);
  }*/
  echo json_encode($arr_result);
}

function updateUser($fbid,$rank,$color){
  global $conn;
  $result = $conn->query("update member set player=1,rank='{$rank}',color='{$color}' where fbid='{$fbid}'");
  echo json_encode($result);
}
function getAll(){
  global $conn;
  $result = $conn->query("select color,group_concat(name separator ', '),group_concat(fbid separator ', ')  from member where color<>'' group by color;");
  echo json_encode($result);
}
function random($rank,$fbid){
  global $conn;
  $ran_arr=[];
  $arr_result=['G'=>16,'B'=>16,'P'=>16,'Y'=>16];
  $result = $conn->query("select color,count(id) as remain from member where player=1 and rank='{$rank}' group by color");
  while($row = $result->fetch_assoc())
  {
    if($rank=='C'||$rank=='P')
      $arr_result[$row[color]]=8-$row[remain];
    else if($rank=='S')
      $arr_result[$row[color]]=4-$row[remain];
    else $arr_result[$row[color]]=10-$row[remain];
  }
//  print_r($arr_result);
  foreach($arr_result as $key => $value)
  {
    for($i=0;$i<$value;$i++){
      array_push($ran_arr,$key);
    }
  }
  $rand_key = array_rand($ran_arr);
  $color=$ran_arr[$rand_key];
  //print_r($ran_arr);
  //echo $ran_arr[$rand_key];
  $conn->query("update member set color='{$color}',player=1 where fbid='{$fbid}';");

  if($color=='P')$price=0;
  else if($color=='G')$price=1;
  else if($color=='Y')$price=2;
  else $price=3;
  echo $price;
  // echo 1;

}
