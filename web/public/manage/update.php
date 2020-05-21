<?php
$connect = mysqli_connect("localhost", "root", "", "traveltw");
MySQLi_query($connect,"set names utf8");
if(isset($_POST["spid"]))
{
 $value = mysqli_real_escape_string($connect, $_POST["value"]);
 if(Discrimination($_POST["column_name"])){
 	 $query = "UPDATE spot_tag SET ".$_POST["column_name"]."='".$value."' WHERE spid = '".$_POST["spid"]."'";
 }else{
 	 $query = "UPDATE spot SET ".$_POST["column_name"]."='".$value."' WHERE spid = '".$_POST["spid"]."'";
 }

 if(mysqli_query($connect, $query))
 {
  echo 'Data Updated';
 }
}

function Discrimination($column_name){
	switch ($column_name) {
		case 'spottag':
			return true;
			break;
		case 'description':
			return true;
			break;
		default:
			return false;
			break;
	}
}
?>