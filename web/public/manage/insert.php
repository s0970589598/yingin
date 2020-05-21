<?php
$connect = mysqli_connect("localhost", "root", "", "traveltw");
MySQLi_query($connect,"set names utf8");


      

if(isset($_POST["spotname"]))
{
 $city = mysqli_real_escape_string($connect, $_POST["city"]);
 $area = mysqli_real_escape_string($connect, $_POST["area"]);
 $address = mysqli_real_escape_string($connect, $_POST["address"]);
 $class1 = mysqli_real_escape_string($connect, $_POST["class1"]);
 $class2 = mysqli_real_escape_string($connect, $_POST["class2"]);
 $class3 = mysqli_real_escape_string($connect, $_POST["class3"]);
 $googlerating = mysqli_real_escape_string($connect, $_POST["googlerating"]);
 $spotname = mysqli_real_escape_string($connect, $_POST["spotname"]);
 $opentime = mysqli_real_escape_string($connect, $_POST["opentime"]);
 $info = mysqli_real_escape_string($connect, $_POST["info"]);
 $px = mysqli_real_escape_string($connect, $_POST["px"]);
 $py = mysqli_real_escape_string($connect, $_POST["py"]);
 $ticketinfo = mysqli_real_escape_string($connect, $_POST["ticketinfo"]);
 $toldescribe = mysqli_real_escape_string($connect, $_POST["toldescribe"]);
 $travellinginfo = mysqli_real_escape_string($connect, $_POST["travellinginfo"]);
 $source = mysqli_real_escape_string($connect, $_POST["source"]);
 $website = mysqli_real_escape_string($connect, $_POST["website"]);
 $cid = mysqli_real_escape_string($connect, $_POST["cid"]);
 $spottag = mysqli_real_escape_string($connect, $_POST["spottag"]);
 $description = mysqli_real_escape_string($connect, $_POST["description"]);

 $query = "INSERT INTO spot(city,area,address,class1,class2,class3,googlerating,spotname,opentime,info,px,py,ticketinfo,toldescribe,travellinginfo,source,website,cid) VALUES('$city', '$area','$address', '$class1','$class2', '$class3','$googlerating', '$spotname','$opentime', '$info','$px', '$py','$ticketinfo', '$toldescribe','$travellinginfo', '$source','$website', '$cid')";

 $query_spid="select spid from spot  order by spid desc";
 $row = mysqli_fetch_array(mysqli_query($connect, $query_spid));
 $spid=$row['spid']+1;

 $query_t = "INSERT INTO spot_tag(spid,spottag,description) VALUES('$spid','$spottag','$description')";
 mysqli_query($connect, $query_t);


 if(mysqli_query($connect, $query))
 {
  echo 'Data Inserted';
 }
}
?>
