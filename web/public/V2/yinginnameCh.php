<?php

include('../connection/connection.php');


$name     = '吳義倫';
$firname  = mb_substr( $name,0,1,"utf-8");
$secname  = mb_substr( $name,1,1,"utf-8");
$thirname = mb_substr( $name,2,1,"utf-8");


$sql20 = "SELECT * FROM `kangxi`  WHERE word ='$firname' ";
$result20 = mysqli_query($database_link,$sql20) or die(mysqli_error());
$row20 = mysqli_fetch_assoc($result20);
$sql21 = "SELECT * FROM `kangxi`  WHERE word ='$secname' ";
$result21 = mysqli_query($database_link,$sql21) or die(mysqli_error());
$row21 = mysqli_fetch_assoc($result21);
$sql22 = "SELECT * FROM `kangxi`  WHERE word ='$thirname' ";
$result22 = mysqli_query($database_link,$sql22) or die(mysqli_error());
$row22 = mysqli_fetch_assoc($result22);

$fir = $row20['num'];

$sec = $row21['num'];

$thir =$row22['num'];


$key =0 ;


	$addstr = '';
	$chaga  = '';
	$chapair= '';
	$chagaint ='';


	if (strlen((string)$fir) < 2 && strlen((string)$sec) < 2) {
    	$chapair = (string)'00'.$fir.$sec;
    	$fir1 = $fir;
    	$sec1 = $sec;
	}else{
		if(strlen((string)$fir) < 2) {
		    $fir1 = (string)('0'.$fir);
		    $selfir = 24 + (int)$fir;
	    }else {
			$fir1 = $fir;
			$selfir = $fir;
		}
		if(strlen((string)$sec) < 2){ $sec1 =(string)('0'.$sec);}else {
			$sec1 = $sec;
		}
		$chapair = (string)$selfir . $sec1;

	}

	if(strlen($chapair) == 3){
		$chapair = '0'.$chapair;
	}

    $chagaint = (int)$fir1 + (int)$sec1;

	if(strlen((string)$chagaint) == 4){ $chaga = $chagaint;}
	if(strlen((string)$chagaint) == 3){ $chaga = '0'.$chagaint;}
	if(strlen((string)$chagaint) == 2){ $chaga = '00'.$chagaint;}
	if(strlen((string)$chagaint) == 1){ $chaga = '000'.$chagaint;}


	$sql32 = "SELECT * FROM `yingin10000` left join yingin192 on yingin192.yingin192_id = yingin10000.yingin192_id WHERE yingin10000_num ='$chaga' ";
	$result32 = mysqli_query($database_link,$sql32) or die(mysqli_error());
	$row32 = mysqli_fetch_assoc($result32);

	$sql33 = "SELECT * FROM `yingin10000` left join yingin192 on yingin192.yingin192_id = yingin10000.yingin192_id  WHERE yingin10000_num ='$chapair'";
	$result33 = mysqli_query($database_link,$sql33) or die(mysqli_error());
	$row33 = mysqli_fetch_assoc($result33);


//echo json_encode($json).'//////////////';

$key2 = 0;

		$addstr = '';

	    $kungaint ='';

	if (strlen((string)$sec) < 2 && strlen((string)$thir) < 2) {
    	$kunpair = (string)'00'.$sec.$thir;
    	$sec1  = $sec;
    	$thir1 = $thir;
	}else{
		if(strlen((string)$sec) < 2){
			$sec1 = (string)('0'.$sec);
			$selsec = 24 + (int)$sec;
		}else {
			$sec1 = $sec;
			$selsec = $sec;
		}
		if(strlen((string)$thir) < 2){ $thir1 =(string)('0'.$thir);}else {
			$thir1 = $thir;
		}
		$kunpair = (string)$selsec.$thir1;
	}

	if(strlen($kunpair) == 3){ $kunpair = '0'.$kunpair;}

    $kungaint = (int)$sec1 + (int)$thir1;

	if(strlen((string)$kungaint) == 4){ $kunga = $kungaint;}
	if(strlen((string)$kungaint) == 3){ $kunga = '0'.$kungaint;}
	if(strlen((string)$kungaint) == 2){ $kunga = '00'.$kungaint;}
	if(strlen((string)$kungaint) == 1){ $kunga = '000'.$kungaint;}

	$sql34 = "SELECT * FROM `yingin10000` left join yingin192 on yingin192.yingin192_id = yingin10000.yingin192_id  WHERE yingin10000_num ='$kunga'";
	$result34 = mysqli_query($database_link,$sql34) or die(mysqli_error());
	$row34 = mysqli_fetch_assoc($result34);

	$sql35 = "SELECT * FROM `yingin10000` left join yingin192 on yingin192.yingin192_id = yingin10000.yingin192_id  WHERE yingin10000_num ='$kunpair'";
	$result35 = mysqli_query($database_link,$sql35) or die(mysqli_error());
	$row35 = mysqli_fetch_assoc($result35);


//echo json_encode($json1).'//////////////';
$key3 = 0;

	$addstr ='';
	$allga = '';
	$allgaint = (int)$fir + (int)$sec + (int)$thir;

	if(strlen((string)$allgaint) == 4){ $allga = $allgaint;}
	if(strlen((string)$allgaint) == 3){ $allga = '0'.$allgaint;}
	if(strlen((string)$allgaint) == 2){ $allga = '00'.$allgaint;}
	if(strlen((string)$allgaint) == 1){ $allga = '000'.$allgaint;}


	$sql36 = "SELECT * FROM `yingin10000` left join yingin192 on yingin192.yingin192_id = yingin10000.yingin192_id  WHERE yingin10000_num ='$allga'";
	$result36 = mysqli_query($database_link,$sql36) or die(mysqli_error());
	$row36 = mysqli_fetch_assoc($result36);

    		$json2[$key3]['fir'] = (int)$fir;
    		$json2[$key3]['sec'] = (int)$sec;
    		$json2[$key3]['thir'] = (int)$thir;
    		$json2[$key3]['name'] = $firname . $secname . $thirname;

			$json2[$key3]['chaga']['num'] = $chaga;
    		$json2[$key3]['chaga']['yingin192_id'] = $row32['yingin192_id'];
    		$json2[$key3]['chaga']['goodorbad'] = $row32['goodorbad'];
    		$json2[$key3]['chaga']['mean'] = $row32['mean'];

			$json2[$key3]['kunga']['num'] = $kunga;
    		$json2[$key3]['kunga']['yingin192_id'] = $row34['yingin192_id'];
    		$json2[$key3]['kunga']['goodorbad'] = $row34['goodorbad'];
    		$json2[$key3]['kunga']['mean'] = $row34['mean'];

    		$json2[$key3]['chapair']['num'] = $chapair;
    		$json2[$key3]['chapair']['yingin192_id'] = $row33['yingin192_id'];
    		$json2[$key3]['chapair']['goodorbad'] = $row33['goodorbad'];
    		$json2[$key3]['chapair']['mean'] = $row33['mean'];

			$json2[$key3]['kunpair']['num'] = $kunpair;
    		$json2[$key3]['kunpair']['yingin192_id'] = $row35['yingin192_id'];
    		$json2[$key3]['kunpair']['goodorbad'] = $row35['goodorbad'];
    		$json2[$key3]['kunpair']['mean'] = $row35['mean'];

			$json2[$key3]['allga']['num'] = $allga;
    		$json2[$key3]['allga']['yingin192_id'] = $row36['yingin192_id'];
    		$json2[$key3]['allga']['goodorbad'] = $row36['goodorbad'];
    		$json2[$key3]['allga']['mean'] = $row36['mean'];

   //print_r($json2);
   //echo json_encode($json2);





?>

<table border = "1" style="font-szie:20px">
	<tr>
		<td colspan="2">姓名
		 	<?php
		 		$name_score = nameScroe($json2[0]['chaga']['goodorbad']) + nameScroe($json2[0]['kunga']['goodorbad']) + nameScroe($json2[0]['chapair']['goodorbad']) + nameScroe($json2[0]['kunpair']['goodorbad']) + nameScroe($json2[0]['allga']['goodorbad']);
		 		echo '( ' . $name_score . ' ) 分 ';
			?>

		</td>
		<td colspan="3"><?php echo $json2[0]['name']; ?></td>
	</tr>
	<tr>
		<td colspan="2">筆劃</td>
		<td><?php echo $json2[0]['fir']; ?></td>
		<td><?php echo $json2[0]['sec']; ?></td>
		<td><?php echo $json2[0]['thir']; ?></td>
	</tr>
	<tr>
		<td rowspan="2">和數</td>
		<td>乾格</td>
		<td><?php echo $json2[0]['chaga']['num']; ?></td>
		<td><?php echo $json2[0]['chaga']['goodorbad']; ?></td>
		<td><?php echo $json2[0]['chaga']['mean']; ?></td>
	</tr>
	<tr>
		<td>坤格</td>
		<td><?php echo $json2[0]['kunga']['num']; ?></td>
		<td><?php echo $json2[0]['kunga']['goodorbad']; ?></td>
		<td><?php echo $json2[0]['kunga']['mean']; ?></td>
	</tr>
	<tr>
		<td rowspan="2">配數</td>
		<td>乾格</td>
		<td><?php echo $json2[0]['chapair']['num']; ?></td>
		<td><?php echo $json2[0]['chapair']['goodorbad']; ?></td>
		<td><?php echo $json2[0]['chapair']['mean']; ?></td>
	</tr>
	<tr>
		<td>坤格</td>
		<td><?php echo $json2[0]['kunpair']['num']; ?></td>
		<td><?php echo $json2[0]['kunpair']['goodorbad']; ?></td>
		<td><?php echo $json2[0]['kunpair']['mean']; ?></td>
	</tr>
	<tr>
		<td colspan="2">總格</td>
		<td><?php echo $json2[0]['allga']['num']; ?></td>
		<td><?php echo $json2[0]['allga']['goodorbad']; ?></td>
		<td><?php echo $json2[0]['allga']['mean']; ?></td>
	</tr>


</table>
<?php

function nameScroe($goodorbad) {
	switch ($goodorbad) {
		case '上上':
			$score = 20;
			break;
		case '上中':
			$score = 15;
			break;
		case '中中':
		case '中平':
			$score = 10;
			break;
		case '中下':
			$score = 5;
			break;
		default:
			$score = 0;
			break;
	}
	return $score;
}

?>