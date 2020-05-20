<?php

    include('./connection/connection.php');

	for ($i = 1; $i <= 9999; $i++) {
		$addstr = '';
	
	
    $str   = (string)$i;

	$strlen = strlen( $str );
	(int)$strlen % 2 == 0 ? $gioro = 'o' : $gioro = 'gi';
    
    $ginum = (int) $strlen / 2 + 1;

    (int)$strlen == 1 ? $onum = (int) $strlen / 2 + 1 : $onum = (int) floor($strlen / 2);
    
    if($gioro == 'gi'){
    	if((int)$strlen == 1){
    		$before = 10;
    	}else{
    		$before =substr($str,0,$ginum);
    	}
    }else{
    	$before =substr($str,0,$onum);
    }

    if((int) substr($str, -($onum)) == 0){
    	$after = pow(10,$onum);
    }else {
    	$after = substr($str, -$onum);
    }

    echo $i.':'.$before.';;'.$after.'dd' .(int) substr($str, -($onum)) . '+' .$onum;
    echo '<br>';
    $after   == '00' ? $firnum = 0 : $firnum = (int)$after;
    $before  == '00' ? $secnum = 0 : $secnum = (int)$before;
 
    $firnum % 8 == 0 ? $firnumga = 8 : $firnumga = $firnum % 8;
    $secnum % 8 == 0 ? $secnumga = 8 : $secnumga = $secnum % 8;
    ($firnum + $secnum) % 6 == 0 ? $thirga = 6 : $thirga = ($firnum + $secnum) % 6;

	$ga =  $firnumga.$secnumga.$thirga;

    $str.':'.$ga;
	$sql32 = "SELECT * FROM `yingin192` WHERE thousand_num ='$ga'";
	$result32 = mysqli_query($database_link,$sql32) or die(mysqli_error());
	$row32 = mysqli_fetch_assoc($result32);

	echo $row32['goodorbad'];


	if($i < 10 ){
		$addstr='000';
	}

    if($i >= 10 and $i < 100 ){
		$addstr='00';
	}

	if($i >= 100 and $i < 1000 ){
		$addstr='0';
	}

 	$str2   = (string)$addstr.$i;

    $sqla62 = "INSERT INTO `yingin10000`(`yingin10000_num`,`goodorbad`,`yingin192_id`) VALUES('$str2','$row32[goodorbad]','$row32[yingin192_id]')";
	// mysqli_query($database_link,$sqla62);

    $sql33 = "SELECT * FROM `yingin10000` WHERE yingin10000_num = '$str2' and yingin192_id <> '$row32[yingin192_id]' ";
	$result33 = mysqli_query($database_link,$sql33) or die(mysqli_error());
	$row33 = mysqli_fetch_assoc($result33);

	if(count($row33) > 0){
		echo $sqla63 = "update `yingin10000` set `goodorbad` = '$row32[goodorbad]' , `yingin192_id` = '$row32[yingin192_id]' where `yingin10000_num` = '$str2'";
		    // mysqli_query($database_link,$sqla63);

	}

	}


?>