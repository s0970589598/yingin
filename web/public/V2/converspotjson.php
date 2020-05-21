<?php
	
	require '/class/class_connection.php';
	$conn= new SqlTool;
	$sql2="SELECT * from spot";
		$result2=$conn->execute_dql($sql2);
		 while($row2=Mysqli_fetch_array($result2)){
	     	$row2['spid'];
	     	$jsdecode=json_decode($row2['info'],true);
	     	echo $jsdecode['description'];
	     	echo '<br/>';
		 }

		$result2->close();



?> 