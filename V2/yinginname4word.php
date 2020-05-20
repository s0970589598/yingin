<?php

include('./connection/connection.php');

$fir = 16;

$sec = 0;

$thir = 0;

$fore = 0;


$chaga    = '';
$chapair  = '';
$kunga    = '';
$kunpair  = '';
$kunga2   = '';
$kunpair2 = '';
$allga    = '';


$key =0 ;
for($sec=1;$sec<=32;$sec++){
	$addstr = '';
	$chaga  = '';
	$chapair= '';
	$chagaint ='';


	if (strlen((string)$fir) < 2 && strlen((string)$sec) < 2) {
    	$chapair = (string)'00'.$fir.$sec;
    	$fir1 = $fir;
    	$sec1 = $sec;
	}else{
		if(strlen((string)$fir) < 2){ $fir1 = (string)('0'.$fir);}else {
			$fir1 = $fir;
		}
		if(strlen((string)$sec) < 2){ $sec1 =(string)('0'.$sec);}else {
			$sec1 = $sec;
		}
		$chapair = (string)$fir1.$sec1;
	}

	if(strlen($chapair) == 3){ $chapair = '0'.$chapair;}

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

    if (($row32['goodorbad'] == '上上' or $row32['goodorbad'] == '上中' or $row32['goodorbad'] == '中中' ) and ($row33['goodorbad'] == '上上' or $row33['goodorbad'] == '上中' or $row33['goodorbad'] == '中中' )  ) {
    		$json[$key]['fir'] = (int)$fir;
    		$json[$key]['sec'] = (int)$sec;
    		$json[$key]['chapair']['num'] = $chapair;
    		$json[$key]['chapair']['yingin192_id'] = $row33['yingin192_id'];
    		$json[$key]['chapair']['goodorbad'] = $row33['goodorbad'];
    		$json[$key]['chapair']['mean'] = $row33['mean'];
			$json[$key]['chaga']['num'] = $chaga;
    		$json[$key]['chaga']['yingin192_id'] = $row32['yingin192_id'];
    		$json[$key]['chaga']['goodorbad'] = $row32['goodorbad'];
    		$json[$key]['chaga']['mean'] = $row32['mean'];

    		$key += 1;
    }

}

//echo json_encode($json).'//////////////';

$key2 = 0;

for ($i = 0; $i < count($json); $i++) {
	for($thir=0;$thir<=32;$thir++){
		$addstr = '';
	    $chaga  = '';
	    $chapair= '';
	    $kungaint ='';
	    $sec = '';


	$sec = $json[$i]['sec'];

	if (strlen((string)$sec) < 2 && strlen((string)$thir) < 2) {
    	$kunpair = (string)'00'.$sec.$thir;
    	$sec1  = $sec;
    	$thir1 = $thir;
	}else{
		if(strlen((string)$sec) < 2){ $sec1 = (string)('0'.$sec);}else {
			$sec1 = $sec;
		}
		if(strlen((string)$thir) < 2){ $thir1 =(string)('0'.$thir);}else {
			$thir1 = $thir;
		}
		$kunpair = (string)$sec1.$thir1;
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

	if (($row34['goodorbad'] == '上上' or $row34['goodorbad'] == '上中' or $row34['goodorbad'] == '中中'  ) and ($row35['goodorbad'] == '上上' or $row35['goodorbad'] == '上中' or $row35['goodorbad'] == '中中' )) {
    		$json1[$key2]['fir'] = (int)$fir;
    		$json1[$key2]['sec'] = (int)$sec;
    		$json1[$key2]['thir'] = (int)$thir;
    		$json1[$key2]['chapair']['num']          = $json[$i]['chapair']['num'];
    		$json1[$key2]['chapair']['yingin192_id'] = $json[$i]['chapair']['yingin192_id'];
    		$json1[$key2]['chapair']['goodorbad']    = $json[$i]['chapair']['goodorbad'];
    		$json1[$key2]['chapair']['mean']         = $json[$i]['chapair']['mean'];
			$json1[$key2]['chaga']['num']            = $json[$i]['chaga']['num'];
    		$json1[$key2]['chaga']['yingin192_id']   = $json[$i]['chaga']['yingin192_id'];
    		$json1[$key2]['chaga']['goodorbad']      = $json[$i]['chaga']['goodorbad'];
    		$json1[$key2]['chaga']['mean']           = $json[$i]['chaga']['mean'];
    		$json1[$key2]['kunga']['num'] = $kunga;
    		$json1[$key2]['kunga']['yingin192_id'] = $row34['yingin192_id'];
    		$json1[$key2]['kunga']['goodorbad'] = $row34['goodorbad'];
    		$json1[$key2]['kunga']['mean'] = $row34['mean'];
			$json1[$key2]['kunpair']['num'] = $kunpair;
    		$json1[$key2]['kunpair']['yingin192_id'] = $row35['yingin192_id'];
    		$json1[$key2]['kunpair']['goodorbad'] = $row35['goodorbad'];
    		$json1[$key2]['kunpair']['mean'] = $row35['mean'];

    		$key2 += 1;
    }

	}
}
//echo json_encode($json1).'//////////////';

$key4 = 0;

for ($k = 0; $k < count($json1); $k++) {
	for($fore=0;$fore<=32;$fore++){
		$addstr = '';
	    $chaga  = '';
	    $chapair= '';
	    $kungaint ='';
	    $sec = '';


	$thir = $json1[$k]['thir'];

	if (strlen((string)$thir) < 2 && strlen((string)$fore) < 2) {
    	$kunpair2 = (string)'00'.$thir.$fore;
    	$thir1  = $thir;
    	$fore1 = $fore;
	}else{
		if(strlen((string)$thir) < 2){ $thir1 = (string)('0'.$thir);}else {
			$thir1 = $thir;
		}
		if(strlen((string)$fore) < 2){ $fore1 =(string)('0'.$fore);}else {
			$fore1 = $fore;
		}
		$kunpair2 = (string)$thir1.$fore1;
	}

	if(strlen($kunpair2) == 3){ $kunpair2 = '0'.$kunpair2;}

    $kungaint2 = (int)$fore1 + (int)$thir1;

	if(strlen((string)$kungaint2) == 4){ $kunga2 = $kungaint2;}
	if(strlen((string)$kungaint2) == 3){ $kunga2 = '0'.$kungaint2;}
	if(strlen((string)$kungaint2) == 2){ $kunga2 = '00'.$kungaint2;}
	if(strlen((string)$kungaint2) == 1){ $kunga2 = '000'.$kungaint2;}



	$sql37 = "SELECT * FROM `yingin10000` left join yingin192 on yingin192.yingin192_id = yingin10000.yingin192_id  WHERE yingin10000_num ='$kunga2'";
	$result37 = mysqli_query($database_link,$sql37) or die(mysqli_error());
	$row37 = mysqli_fetch_assoc($result37);

	$sql38 = "SELECT * FROM `yingin10000` left join yingin192 on yingin192.yingin192_id = yingin10000.yingin192_id  WHERE yingin10000_num ='$kunpair2'";
	$result38 = mysqli_query($database_link,$sql38) or die(mysqli_error());
	$row38 = mysqli_fetch_assoc($result38);

	if (($row37['goodorbad'] == '上上' or $row37['goodorbad'] == '上中' or $row37['goodorbad'] == '中中'  ) and ($row38['goodorbad'] == '上上' or $row38['goodorbad'] == '上中' or $row38['goodorbad'] == '中中' )) {
    		$json2[$key4]['fir'] = (int)$fir;
    		$json2[$key4]['sec'] = (int)$sec;
    		$json2[$key4]['thir'] = (int)$thir;
      		$json2[$key4]['fore'] = (int)$fore;  		
    		$json2[$key4]['chapair']['num']          = $json1[$i]['chapair']['num'];
    		$json2[$key4]['chapair']['yingin192_id'] = $json1[$i]['chapair']['yingin192_id'];
    		$json2[$key4]['chapair']['goodorbad']    = $json1[$i]['chapair']['goodorbad'];
    		$json2[$key4]['chapair']['mean']         = $json1[$i]['chapair']['mean'];
			$json2[$key4]['chaga']['num']            = $json1[$i]['chaga']['num'];
    		$json2[$key4]['chaga']['yingin192_id']   = $json1[$i]['chaga']['yingin192_id'];
    		$json2[$key4]['chaga']['goodorbad']      = $json1[$i]['chaga']['goodorbad'];
    		$json2[$key4]['chaga']['mean']           = $json1[$i]['chaga']['mean'];
    		$json2[$key4]['kunga']['num'] = $kunga;
    		$json2[$key4]['kunga']['yingin192_id'] = $row34['yingin192_id'];
    		$json2[$key4]['kunga']['goodorbad'] = $row34['goodorbad'];
    		$json2[$key4]['kunga']['mean'] = $row34['mean'];
			$json2[$key4]['kunpair']['num'] = $kunpair;
    		$json2[$key4]['kunpair']['yingin192_id'] = $row35['yingin192_id'];
    		$json2[$key4]['kunpair']['goodorbad'] = $row35['goodorbad'];
    		$json2[$key4]['kunpair']['mean'] = $row35['mean'];
    		$json2[$key4]['kunga2']['num'] = $kunga2;
    		$json2[$key4]['kunga2']['yingin192_id'] = $row37['yingin192_id'];
    		$json2[$key4]['kunga2']['goodorbad'] = $row37['goodorbad'];
    		$json2[$key4]['kunga2']['mean'] = $row37['mean'];
			$json2[$key4]['kunpair2']['num'] = $kunpair2;
    		$json2[$key4]['kunpair2']['yingin192_id'] = $row38['yingin192_id'];
    		$json2[$key4]['kunpair2']['goodorbad'] = $row38['goodorbad'];
    		$json2[$key4]['kunpair2']['mean'] = $row38['mean'];


    		$key4 += 1;
    }

	}
}
//echo json_encode($json1).'//////////////';



$key3 = 0;
for ($j = 0; $j < count($json2); $j++) {
	$addstr ='';
	$allga = '';
	$allgaint = (int)$json2[$j]['fir'] + (int)$json2[$j]['sec'] + (int)$json2[$j]['thir'] + (int)$json2[$j]['fore'];

	if(strlen((string)$allgaint) == 4){ $allga = $allgaint;}
	if(strlen((string)$allgaint) == 3){ $allga = '0'.$allgaint;}
	if(strlen((string)$allgaint) == 2){ $allga = '00'.$allgaint;}
	if(strlen((string)$allgaint) == 1){ $allga = '000'.$allgaint;}


	$sql36 = "SELECT * FROM `yingin10000` left join yingin192 on yingin192.yingin192_id = yingin10000.yingin192_id  WHERE yingin10000_num ='$allga'";
	$result36 = mysqli_query($database_link,$sql36) or die(mysqli_error());
	$row36 = mysqli_fetch_assoc($result36);

	if ($row36['goodorbad'] == '上上' or $row36['goodorbad'] == '上中' or $row36['goodorbad'] == '中中'  ) {
    		$json3[$key3]['fir'] = (int)$json2[$j]['fir'];
    		$json3[$key3]['sec'] = (int)$json2[$j]['sec'];
    		$json3[$key3]['thir'] = (int)$json2[$j]['thir'];
    		$json3[$key3]['fore'] = (int)$json2[$j]['fore'];

    		$json3[$key3]['chapair']['num']          = $json2[$j]['chapair']['num'];
    		$json3[$key3]['chapair']['yingin192_id'] = $json2[$j]['chapair']['yingin192_id'];
    		$json3[$key3]['chapair']['goodorbad']    = $json2[$j]['chapair']['goodorbad'];
    		$json3[$key3]['chapair']['mean']         = $json2[$j]['chapair']['mean'];
			$json3[$key3]['chaga']['num']            = $json2[$j]['chaga']['num'];
    		$json3[$key3]['chaga']['yingin192_id']   = $json2[$j]['chaga']['yingin192_id'];
    		$json3[$key3]['chaga']['goodorbad']      = $json2[$j]['chaga']['goodorbad'];
    		$json3[$key3]['chaga']['mean']           = $json2[$j]['chaga']['mean'];
    		$json3[$key3]['kunga']['num']            = $json2[$j]['kunga']['num'];
    		$json3[$key3]['kunga']['yingin192_id']   = $json2[$j]['kunga']['yingin192_id'];
    		$json3[$key3]['kunga']['goodorbad']      = $json2[$j]['kunga']['goodorbad'];
    		$json3[$key3]['kunga']['mean']           = $json2[$j]['kunga']['mean'];
			$json3[$key3]['kunpair']['num']          = $json2[$j]['kunpair']['num'];
    		$json3[$key3]['kunpair']['yingin192_id'] = $json2[$j]['kunpair']['yingin192_id'];
    		$json3[$key3]['kunpair']['goodorbad']    = $json2[$j]['kunpair']['goodorbad'];
    		$json3[$key3]['kunpair']['mean']         = $json2[$j]['kunpair']['mean'];
    		$json3[$key3]['kunga2']['num']            = $json2[$j]['kunga2']['num'];
    		$json3[$key3]['kunga2']['yingin192_id']   = $json2[$j]['kunga2']['yingin192_id'];
    		$json3[$key3]['kunga2']['goodorbad']      = $json2[$j]['kunga2']['goodorbad'];
    		$json3[$key3]['kunga2']['mean']           = $json2[$j]['kunga2']['mean'];
			$json3[$key3]['kunpair2']['num']          = $json2[$j]['kunpair2']['num'];
    		$json3[$key3]['kunpair2']['yingin192_id'] = $json2[$j]['kunpair2']['yingin192_id'];
    		$json3[$key3]['kunpair2']['goodorbad']    = $json2[$j]['kunpair2']['goodorbad'];
    		$json3[$key3]['kunpair2']['mean']         = $json2[$j]['kunpair2']['mean'];
			$json3[$key3]['allga']['num'] = $allga;
    		$json3[$key3]['allga']['yingin192_id'] = $row36['yingin192_id'];
    		$json3[$key3]['allga']['goodorbad'] = $row36['goodorbad'];
    		$json3[$key3]['allga']['mean'] = $row36['mean'];


    		$key3 += 1;
    }

	}

   //echo json_encode($json2);


foreach ($json3 as $va) {
	$name_score = nameScroe($va['chaga']['goodorbad']) + nameScroe($va['kunga2']['goodorbad']) + nameScroe($va['kunga']['goodorbad']) + nameScroe($va['chapair']['goodorbad']) + nameScroe($va['kunpair']['goodorbad']) + nameScroe($va['kunpair2']['goodorbad'])  + nameScroe($va['allga']['goodorbad']);

	$sqlsec = "SELECT * FROM kangxi where num = '$va[sec]'";
	$resultsec = mysqli_query($database_link,$sqlsec) or die(mysqli_error());

	$sqlthir = "SELECT * FROM kangxi where num = '$va[thir]'";
	$resultthir = mysqli_query($database_link,$sqlthir) or die(mysqli_error());

	$sqlfore = "SELECT * FROM kangxi where num = '$va[fore]'";
	$resultfore = mysqli_query($database_link,$sqlfore) or die(mysqli_error());

?>
<table border = "1" style="font-szie:20px" width="50%">
	<tr>
		<td colspan="2">姓名</td>
		<td colspan="3"><?php echo $name_score; ?> 分</td>
	</tr>
	<tr>
		<td >筆劃</td>
		<td><?php echo $va['fir']; ?></td>
		<td><?php echo $va['sec']; ?></td>
		<td><?php echo $va['thir']; ?></td>
		<td><?php echo $va['fore']; ?></td>
	</tr>
	<tr>
		<td rowspan="2">和數</td>
		<td>乾格</td>
		<td><?php echo $va['chaga']['num']; ?></td>
		<td><?php echo $va['chaga']['goodorbad']; ?></td>
		<td><?php echo $va['chaga']['mean']; ?></td>
	</tr>
	<tr>
		<td>坤格</td>
		<td><?php echo $va['kunga']['num']; ?></td>
		<td><?php echo $va['kunga']['goodorbad']; ?></td>
		<td><?php echo $va['kunga']['mean']; ?></td>
	</tr>
	<tr>
		<td>坤格2</td>
		<td><?php echo $va['kunga2']['num']; ?></td>
		<td><?php echo $va['kunga2']['goodorbad']; ?></td>
		<td><?php echo $va['kunga2']['mean']; ?></td>
	</tr>
	<tr>
		<td rowspan="2">配數</td>
		<td>乾格</td>
		<td><?php echo $va['chapair']['num']; ?></td>
		<td><?php echo $va['chapair']['goodorbad']; ?></td>
		<td><?php echo $va['chapair']['mean']; ?></td>
	</tr>
	<tr>
		<td>坤格</td>
		<td><?php echo $va['kunpair']['num']; ?></td>
		<td><?php echo $va['kunpair']['goodorbad']; ?></td>
		<td><?php echo $va['kunpair']['mean']; ?></td>
	</tr>
	<tr>
		<td>坤格2</td>
		<td><?php echo $va['kunpair2']['num']; ?></td>
		<td><?php echo $va['kunpair2']['goodorbad']; ?></td>
		<td><?php echo $va['kunpair2']['mean']; ?></td>
	</tr>
	<tr>
		<td colspan="2">總格</td>
		<td><?php echo $va['allga']['num']; ?></td>
		<td><?php echo $va['allga']['goodorbad']; ?></td>
		<td><?php echo $va['allga']['mean']; ?></td>
	</tr>
	<tr>
	<td colspan="5">
	<?php 
		echo	$va['sec'] . '</br>';
		while ($rowsec = mysqli_fetch_assoc($resultsec)) {
			echo	($rowsec['word'] != '??') ?  $rowsec['word'] . ' // ' : '';
		};
	?>	
	</td>
	</tr>
	<tr>
	<td colspan="5">
	<?php 
		echo	$va['thir'] . '</br>';
		while ($rowthir = mysqli_fetch_assoc($resultthir)) {
		    echo    ($rowthir['word'] != '??') ?  $rowthir['word'] . ' // ' : '';
		};
	?>	
	</td>
	</tr>
</table>

<br/>
<?php
}
?>

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