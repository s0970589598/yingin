
<?php
$block_arr[]['name'] = '台北市';$block_arr[]['name'] = '新北市';$block_arr[]['name'] = '台中市';$block_arr[]['name'] = '台南市';
$block_arr[]['name'] = '高雄市';$block_arr[]['name'] = '基隆市';$block_arr[]['name'] = '嘉義市';$block_arr[]['name'] = '桃園市';
$block_arr[]['name'] = '新竹縣';$block_arr[]['name'] = '新竹市';$block_arr[]['name'] = '苗栗縣';$block_arr[]['name'] = '彰化縣';
$block_arr[]['name'] = '雲林縣';$block_arr[]['name'] = '嘉義縣';$block_arr[]['name'] = '屏東縣';$block_arr[]['name'] = '宜蘭縣';
$block_arr[]['name'] = '花蓮縣';$block_arr[]['name'] = '台東縣';$block_arr[]['name'] = '澎湖縣';$block_arr[]['name'] = '連江縣';
$block_arr[]['name'] = '南投縣';$block_arr[]['name'] = '金門縣';

	require '/class/class_connection.php';
	$cookie_name='choice';
	$conn= new SqlTool;
	$sql="SELECT * FROM `qution` as q inner join reply as r on q.qid=r.qid order by q.qid asc";
	$result=$conn->execute_dql($sql);
	     while($row=Mysqli_fetch_array($result)){
	     	$qution[]=$row;
		 }
    $result->close();

	$j=0;
	$temtitle='';
	?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="/travel/js/tw-city-selector.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">


		<style type="text/css">
        .abgne-menu input[type="radio"] {
            display: none;
        }
        .abgne-menu input[type="radio"] + label {
            display: inline-block;
            background-color: #ccc;
            cursor: pointer;
            margin: 4px;
            padding: 5px 10px;
   	}
        .abgne-menu input[type="radio"]:checked + label {
            background-color: #f3d42e;
        }
        .two{
            width:49%;
            line-height:80px;
            text-align:center;
            height:50px;
        }
        .three{
            width:30%;
            line-height:80px;
            text-align:center;
        }
        .four{
            width:24.5%;
            line-height:80px;
            text-align:center;
        }
        
    </style>
    	<style>
  .my-selector-c select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    outline: none;
    border-color: #ffe76f;
    border-width: 3px;
    color: #ddd;
    line-height: 25px;
    font-size:30px;
  }
</style>
</head>
<body>
<div style="font-size:14px;width:100%; position:fixed; left:73%;bottom:0px; z-index:1000">
<img src="/travel/img/traveler.gif"  width="100px" height="100px"  style="margin-right: -5px" />
<img src="/travel/img/traveler.gif"  width="100px" height="100px" style="margin-right: -5px"/>
<img src="/travel/img/traveler.gif"  width="100px" height="100px" />
<a class="btn btn-primary" href="javascript:void(0);" onclick="arrange();">配對行程</a>
</div>
<div class="abgne-menu">

<!--<div class="my-selector-c">
  <div>
    <select class="country" ></select>
  </div>
</div>-->

<select id="city" class="city" >
	<option value="">清選擇縣市</option>
<?php for($ii=0;$ii<count($block_arr);$ii++){?>
	<option id="<?php echo $ii; ?>" value="<?php echo $block_arr[$ii]['name'] ;?>" ><?php echo $block_arr[$ii]['name'] ;?></option>
<?php }?>
</select>

<div class="col-md-12">
<?php
$decode=array();
$city='';
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
		}
echo '現在選的城市:<span id="showcity">'.$city.'</span>';
	for ($i=0;$i<count($qution);$i++){
		

		if($qution[$i]['qution1']!=$temtitle or $temtitle==''){
			
			$temtitle=$qution[$i]['qution1'];
			$j+=1;
			echo '<br/>';
			echo '<h3>'.$j.$temtitle.'</h3>';
			echo '<br/>';
		}
		if(@$decode['q'.$j]==$qution[$i]['rid']){ $checked="checked";}else{$checked="";}
		echo '<input type="radio" id="'.$qution[$i]['rid'].'" name="q'.$j.'" value="q'.$j.'" onClick="choicechoice(this)" '.$checked.'>';
				echo '<label for="'.$qution[$i]['rid'].'" class="three">'.$qution[$i]['reply'].'</label>';

		//print_r(explode(",", $string));
	}

?>
</div>

</body>


<script>
  //new TwCitySelector({
    //el: ".my-selector-c",
    //elCountry: ".country", // 在 el 裡查找 dom
    //elDistrict: ".district", // 在 el 裡查找 dom
    //elZipcode: ".zipcode" // 在 el 裡查找 dom
 // });
  
  $("#city").change(function(){
  	var cityval=$(this).val()
  	choicecity(cityval);
	});
  function choicecity(cityval){

  		$.ajax({
				type: 'POST', 
				url: 'save_choice.php',
				dataType: "json",
  				data: {
				sta:'add',
				rid:cityval,
				qid:'city'
				},
				success: function(data){ 
					var str=JSON.stringify(data);
					var obj=JSON.parse(str);
					$('#showcity').html(obj.city); 
				}, 
				error: function(xhr, options, error){ $('#error').text('Error: ' + xhr.status + ' error: ' + error); }
				});
  }

  function arrange(){
  	$.ajax({
				type: 'POST', 
				url: 'ArrangementJourney.php',
  				data: {
				sta:'add'
				},
				success: function(data){ 
					//$('#showcase').html(data); 
					window.location.href = "showArrangeJourney.php";
				}, 
				error: function(xhr, options, error){ $('#error').text('Error: ' + xhr.status + ' error: ' + error); }
				});
  }


</script>
<script type="text/javascript">
				function choicechoice(thisid)
			{
				
				var radio=document.getElementById(thisid.id);
				var qid=radio.value;
				var rid=radio.id;
				
				if (radio.tag==2){
					radio.checked=false;
					radio.tag=0;
					$.ajax({
							type: 'POST', 
							url: 'save_choice.php',
							data: {
									
									sta:'del',
									qid:qid,
									rid:rid
								},
								success: function(data){ 
								//$('#showcase').html(data); 
								}, 
								error: function(xhr, options, error){ $('#error').text('Error: ' + xhr.status + ' error: ' + error); }
							});
				}else{
					radio.checked=true;
					radio.tag=2;
					$.ajax({
							type: 'POST', 
							url: 'save_choice.php',
							data: {
									sta:'add',
									qid:qid,
									rid:rid
								},
								success: function(data){ 
								//$('#showcase').html(data); 
								}, 
								error: function(xhr, options, error){ $('#error').text('Error: ' + xhr.status + ' error: ' + error); }
							});
//									
											
				}
										
			}

</script>
</html>
