
<?php
	require '/class/class_connection.php';
	$conn= new SqlTool;
	$sql="SELECT * FROM `qution` as q inner join reply as r on q.qid=r.qid order by q.qid asc";
	$result=$conn->execute_dql($sql);
	     while($row=Mysqli_fetch_array($result)){
	     	$qution[]=$row;
		 }
    $result->close();

	$j=0;
	$temtitle='';
	for ($i=0;$i<count($qution);$i++){
		if($qution[$i]['qution1']!=$temtitle or $temtitle==''){
			$temtitle=$qution[$i]['qution1'];
			$j+=1;
			echo '<br/>';
			echo $j.$temtitle;
			echo '<br/>';
		}
		echo '<br>'.'<input type="radio" name="gender" value="'.$qution[$i]['rid'].'"> '.$qution[$i]['reply'].'<br/>'	;
		
		//print_r(explode(",", $string));
	}

?>