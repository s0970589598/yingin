<?php
	require './class/class_crawler.php' ;
	$crawler=new crawler;
	$city='';
	$area='';
	$class='';
    $search=array();
	
		@$city=$_GET['city'];
		@$search['city']=$city;
		@$choicecity=$crawler->Rspotdata('choicecity',$search);
	

	if(isset($_GET['area'])){
	   $area=$_GET['area'];
	   $search['area']=$area;
	   $choicearea=$crawler->Rspotdata('choicearea',$search);
	}

	if(isset($_GET['class'])){
	    $class=$_GET['class'];
	    $search['class']=$class;

	}

	
	

	$showall=$crawler->Rspotdata('allspot',$search);

	

	

	if(isset($search['city'])){
		$showall=$crawler->Rspotdata('cityspot',$search);
	}
	if(isset($search['area'])){
		$showall=$crawler->Rspotdata('areaspot',$search);
	}

	if(isset($search['city'])){
		$choicearea=$crawler->Rspotdata('choicearea',$search);
	}
?>


    縣市:<select name="city" onchange="self.location.href=this.value" style="height: 50px;width: 100px;font-size:30px">
<option><?php echo $city; ?></option>
<?php
	for($j=0;$j<count($choicecity);$j++){
		echo '<option value="?city='.$choicecity[$j]['city'].'">'.$choicecity[$j]['city'].'</option>';
	} 
?>
    </select>


    鄉鎮區:<select name="area" onchange="self.location.href=this.value" style="height: 50px;width: 100px;font-size:30px">
<?php
	for($k=0;$k<count($choicearea);$k++){
		echo '<option value="?city='.$choicearea[$k]['city'].'&area='.$choicearea[$k]['area'].'">'.$choicearea[$k]['area'].'</option>';
	} 
?>
    </select>


<?php
	echo '<br/>';
	echo '<br/>';
	echo '<br/>';
	//var_dump($showall);

	for($i=0;$i<count($showall);$i++){
		echo $showall[$i]['spid'];
		echo $showall[$i]['city'];
		echo $showall[$i]['address'];
		echo $showall[$i]['class1'];
		echo $showall[$i]['class2'];
		echo $showall[$i]['class3'];
		echo $showall[$i]['googlerating'];
		echo $showall[$i]['spotname'];
		echo $showall[$i]['opentime'];
		echo $showall[$i]['info'];
		echo $showall[$i]['px'];
		echo $showall[$i]['py'];
		echo $showall[$i]['ticketinfo'];
		echo $showall[$i]['toldescribe'];
		echo $showall[$i]['travellinginfo'];
		echo $showall[$i]['source'];
		echo $showall[$i]['website'];
		echo 'http://maps.google.com/maps/place?cid='.$showall[$i]['cid'];

        echo $showall[$i]['spottag'];
        echo $showall[$i]['description'];
		echo '<br>';echo '<br>';echo '<br>';
	}



?>