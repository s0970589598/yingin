<?php
	require '/class/class_connection.php';
	$conn= new SqlTool;

	
	for($i=1;$i<=3667;$i++){

		$json=Rspotdata($conn,'searchpxpyinfo',$i);
		$jsondecode=json_decode($json[$i-1]['info']);

		print_r($jsondecode);
		//$sql="UPDATE `spot` SET `spottoken`='$random'  where  spid='$i'";
		//$re=$conn->execute_dml($sql);
	}
	


    function Rspotdata($conn,$type,$search){
		$arr_row=array();
		switch ($type){
			case 'searchpxpyinfo':  $sql="select spid,info from spot where spid='$search'";break;
		}
		 $result=$conn->execute_dql($sql);
	     while($row=Mysqli_fetch_array($result)){
	     	$arr_row[]=$row;
		 }
		return $arr_row;
	}

?>