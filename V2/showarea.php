<?php
require './class/class_crawler.php' ;
  $crawler=new crawler;
if(isset($_POST["city"]))
{
	$search['city']=$_POST["city"];
	$choicearea=$crawler->Rspotdata('searcharea',$search);
	echo json_encode($choicearea);
}

?>