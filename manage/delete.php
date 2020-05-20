<?php
$connect = mysqli_connect("localhost", "root", "", "traveltw");
if(isset($_POST["spid"]))
{
 $query = "DELETE FROM spot WHERE spid = '".$_POST["spid"]."'";
 $query2 = "DELETE FROM spot_tag WHERE spid = '".$_POST["spid"]."'";

 if(mysqli_query($connect, $query) and mysqli_query($connect, $query2) )
 {
  echo 'Data Deleted';
 }
}
?>