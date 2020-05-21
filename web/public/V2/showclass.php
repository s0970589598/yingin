<?php
require './class/class_crawler.php' ;
  $crawler=new crawler;
if(isset($_POST["city"]) and isset($_POST["area"]))
{
	$search['city']=$_POST['city'];
	$search['area']=$_POST['area'];

	@$choiceclass[0]=$crawler->Rspotdata('choiceclass1a',$search);
    @$choiceclass[1]=$crawler->Rspotdata('choiceclass2a',$search);
    @$choiceclass[2]=$crawler->Rspotdata('choiceclass3a',$search);
	echo json_encode($choiceclass);
}

?>