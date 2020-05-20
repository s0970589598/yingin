<?php
		require '/class/class_connection.php';
		$cookie_name2='choice';
		$conn= new SqlTool;
		$cookie_name='arrange';
		if(isset($_COOKIE[$cookie_name])){
			$arrange=json_decode($_COOKIE[$cookie_name],true);
			for($i=1;$i<count($arrange);$i++){
				$str='a'.$i;
			     $sql2="SELECT sp.spid,sp.spottoken,sp.spotname,st.description,sp.area FROM `spot` as sp left join  spot_tag as st on sp.spid=st.spid  where  sp.spottoken='$arrange[$str]' ";
						$result2=$conn->execute_dql($sql2);
						 while($row2=Mysqli_fetch_array($result2)){
					     	$spot[]=$row2;
						 }
						$result2->close();
			}		
		}
		//print_r($spot);






  if(isset($_COOKIE[$cookie_name2])){

			$choice=json_decode($_COOKIE[$cookie_name2],true);
			echo '地區:'.$arrange['city'].'<br/>';

			for($j=1;$j<count($choice);$j++){

				$str2='q'.$j;
			   	 $sql="SELECT q.qution1,r.reply FROM `reply` as r inner join qution as q on r.rid='$choice[$str2]'  and q.qid=r.qid order by q.qid asc";
			    $result=$conn->execute_dql($sql);
			   while($row=Mysqli_fetch_array($result)){
					     	$qution[]=$row;
				 }
		    $result->close();
			
			//var_dump($qution);
			echo $qution[$j-1][0];
			echo $qution[$j-1][1];
			echo '<br/>';

			if(isset($spot[$j-1]['spotname'])){echo  $spot[$j-1]['area'].$spot[$j-1]['spotname'];}else{echo 'NO DATA';}
			echo '<br/>';
			}
						//print_r($qution);

}
?>