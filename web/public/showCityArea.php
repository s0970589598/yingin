<script src="/travel/js/tw-city-selector.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

<div role="tw-city-selector"></div>
<style>
  .my-selector-a select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    outline: none;
    border-color: #ffe76f;
    border-width: 3px;
    color: #ff8e52;
  }
</style>
<?php
require './class/class_crawler.php' ;
echo '<meta charset="UTF-8" />';

$getspot=new crawler;
$search=array();
if(isset($_GET['city'])){
	$city=urldecode($_GET['city']);
	$search['city']=$city;
}
if(isset($_GET['area'])){
	$area=urldecode($_GET['area']);
	$city=urldecode($_GET['city']);

	$search['area']=$area;
	$search['city']=$city;

}

$rowcity=$getspot->Rspotdata('Readcity','');
$rowarea=$getspot->Rspotdata('searcharea',$search);
$rowspot=$getspot->Rspotdata('searchspot',$search);

//var_dump($rowcity);
for($i=0;$i<count($rowcity);$i++){
	echo $i.'///';
	echo '<a href="?city='.@$rowcity[$i][city].'">'.@$rowcity[$i][city].'</a>';
	echo '<br>';
}
echo '-----------------------';
echo'<br>';

for($j=0;$j<count($rowarea);$j++){
	echo $j.'///bb';
	echo '<a href="?area='.@$rowarea[$j][area].'&city='.$city.'">'.@$rowarea[$j][area].'</a>';
	echo '<br>';
}

echo '-----------------------';
echo'<br>';
for($k=0;$k<count($rowspot);$k++){
	echo $k.'///cc';
	echo '<a href="?area='.@$rowspot[$k][spotname].'">'.@$rowspot[$k][spotname].'</a>';
	echo '<br>';
	echo '<a href="?area='.@$rowspot[$k][address].'">'.@$rowspot[$k][address].'</a>';

	echo '<br>';
}


?>



<div class="my-selector-c">
  <div>
    <select class="country" onChange="choice();" ></select>
  </div>
  <div>
    <select class="district" ></select>
  </div>
</div>

<script>
  new TwCitySelector({
    el: ".my-selector-c",
    elCountry: ".country", // 在 el 裡查找 dom
    elDistrict: ".district", // 在 el 裡查找 dom
    elZipcode: ".zipcode" // 在 el 裡查找 dom
  });
  
  function choice(){
  		alert($(".country").value);


  }




</script>