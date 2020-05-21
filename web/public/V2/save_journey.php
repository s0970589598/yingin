<?php
    date_default_timezone_set("Asia/Taipei");
    $datatime=data(Y-m-d H:i:s);
	require '/class/class_connection.php';
	$cookie_name='choice';
	$conn= new SqlTool;
	$cookie_name='choice';
	$mid=1;
	$sql="select * from journey where mid='$mid' and choicejourney='$_COOKIE[$cookie_name]'"
	if(comfirm_repeat_journey($sql)>=1){
		$sql="INSERT INTO `journey`(`mid`,`choicejourney`,`checkchoice`,`updatetime`) VALUES ('$mid','$_COOKIE[$cookie_name]','0','$datetime')";
		$re=$conn->execute_dml($sql);
		echo 'true';
	}else{
		$sql="INSERT INTO `journey`(`mid`,`choicejourney`,`checkchoice`,`updatetime`) VALUES ('$mid','$_COOKIE[$cookie_name]','0','$datetime')";
		$re=$conn->execute_dml($sql);
		echo 'true';
	}

    

	function comfirm_repeat_journey($sql){
		return Mysqli_num_rows($conn->execute_dql($sql));
	}
?>