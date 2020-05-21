<?php

ini_set('display_errors', 0);
require '/class/class_connection.php';
$cookie_name='choice';
$conn= new SqlTool;
$j1='';
$j2='';
$j3='';
$j4='';
$j5='';
$j6='';
$j7='';
$spot='';
$a1='';$a2='';$a3='';$a4='';$a5='';$a6='';$a7='';
$cookie_name2='arrange';

if(isset($_COOKIE[$cookie_name])){
	$decode=json_decode($_COOKIE[$cookie_name],true);
	$rid1=$decode['q1'];
	$rid2=$decode['q2'];
	$rid3=$decode['q3'];
	$rid4=$decode['q4'];
	$rid5=$decode['q5'];
	$rid6=$decode['q6'];
	$rid7=$decode['q7'];
	$city=$decode['city'];

    $j1=arrangetour($conn,$rid1,$city);
	$j2=arrangetour($conn,$rid2,$city);
	$j3=arrangetour($conn,$rid3,$city);
	$j4=arrangetour($conn,$rid4,$city);
	$j5=arrangetour($conn,$rid5,$city);
	$j6=arrangetour($conn,$rid6,$city);
	$j7=arrangetour($conn,$rid7,$city);
	$a1=$j1[random(count($j1))]['spottoken'];
	$a2=$j2[random(count($j2))]['spottoken'];
	$a3=$j3[random(count($j3))]['spottoken'];
	$a4=$j4[random(count($j4))]['spottoken'];
	$a5=$j5[random(count($j5))]['spottoken'];
	$a6=$j6[random(count($j6))]['spottoken'];
	$a7=$j7[random(count($j7))]['spottoken'];

	$arrange=array("city"=>$city,"a1"=>$a1,"a2"=>$a2,"a3"=>$a3,"a4"=>$a4,"a5"=>$a5,"a6"=>$a6,"a7"=>$a7);
	header('Content-Type: application/json; charset=utf-8');
    echo $json=json_encode($arrange);
    setcookie($cookie_name2, $json, time() + (86400 * 30), "/"); // 86400 = 1 day

}

function arrangetour($conn,$rid,$city){//未算到時間及距離
	$sql="SELECT reply,reply_tag FROM `reply` where  rid='$rid'";
	$result=$conn->execute_dql($sql);
	$reply=Mysqli_fetch_array($result);
	$result->close();
	$arr_replytag=explode(",", $reply['reply_tag']);
	$spot='';
	for($i=0;$i<count($arr_replytag);$i++){
		//sp.spotname like '%$arr_replytag[$i]%' or st.spottag  like '%$arr_replytag[$i]%' or
		$sql2="SELECT sp.spid,sp.spottoken FROM `spot` as sp left join  spot_tag as st on sp.spid=st.spid  where sp.city='$city' and st.description  like '%$arr_replytag[$i]%'";
		$result2=$conn->execute_dql($sql2);
		 while($row2=Mysqli_fetch_array($result2)){
	     	$spot[]=$row2;
		 }

		$result2->close();
	}
	//var_dump($spot);
	return $spot;

}
function random($max){
	return rand(0,$max);
}
    
    
?>